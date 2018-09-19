<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Hotel;
use App\Http\Requests\RoomSelectRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\TourSearchRequest;
use App\Http\Requests\VehicleSearchRequest;
use App\Photo;
use App\Room;
use App\RoomGallery;
use App\RoomType;
use App\Search;
use App\TourGallery;
use App\TourPackage;
use App\TourSearch;
use App\Vehicle;
use App\VehicleSearch;
use Carbon\Carbon;

class FrontEndController extends Controller
{
    public function welcome()
    {
        
        $hotels = Hotel::inRandomOrder()->where('flag',true)->limit(4)->get();
        $vehicles = Vehicle::inRandomOrder()->where('flag',true)->limit(4)->get();
        $tours = TourPackage::inRandomOrder()->where('flag',true)->limit(4)->get();
        return view('welcome',['hotels'=>$hotels,'vehicles'=>$vehicles,'tours'=>$tours]);
    }

    public function searchHotel(SearchRequest $request)
    {
        $query = strtolower($request->destination);
        $search = new Search;
        $search->destination = $request->destination;
        $search->from_date = $request->from_date;
        $search->to_date = $request->till_date;
        $search->no_adults = $request->no_adults;
        $search->no_childs = $request->no_childs;

        $search->save();
        $search_id = $search->id;
        $request->session()->put('search_id', $search_id);
       
        
            $hotels = Hotel::where('address', 'like', '%' . $query . '%')->where('flag',true)->paginate(15);
       

        return view('search', ['hotels' => $hotels,'search'=>$search]);
    }

    public function bookHotelWithoutSession(SearchRequest $request) {
        $search = new Search;
        $search->destination = $request->destination;
        $search->from_date = $request->from_date;
        $search->to_date = $request->till_date;
        $search->no_adults = $request->no_adults;
        $search->no_childs = $request->no_childs;

        $search->save();
        $search_id = $search->id;
        $request->session()->put('search_id', $search_id);
        $hotel = Hotel::findorfail($request->hotel_id);
        return redirect()->route('hotel.show',$hotel->id);
    }

    public function bookTourWithoutSession(TourSearchRequest $request) {
        $search = new TourSearch;
        $search->destination = $request->destination;
        $search->from = $request->from;
        $search->to = $request->till;
        $search->people = $request->people;

        $search->save();
        $search_id = $search->id;
        session()->put('search_tour_id',$search_id);
        $tour = TourPackage::findorfail($request->tour_id);
        return redirect()->route('tour.show',$tour->id);

    }

    public function book(RoomSelectRequest $request)
    {
        // dd($request);
        $requestData = collect($request->only(
            'room',
            'no_rooms',
            'room_type',
            'plan'
        ));
        $roomdetails = $requestData->transpose()->map(function ($recieveData) {
            return $roomdetails = [
                'room' => $recieveData[0],
                'no_rooms' => $recieveData[1],
                'room_type' => $recieveData[2],
                'plan' => $recieveData[3]
            ];
        });
        $test = [];
        foreach ($roomdetails as $roomdetail) {
            if ($roomdetail['no_rooms'] != null) {
                $test[] = $roomdetail; 
            } 
        }
        if($test == null){
            return redirect()->back()->with('error','Please provide number of rooms');
        }
        $roomdetails = $test;
        $no_rooms = 0;
        foreach($roomdetails as $r){
            $no_rooms = $no_rooms+$r['no_rooms'];
        }
        $hotel = Hotel::findorfail($request->hotel_id);
        $rooms = Room::where('hotel_id',$hotel->id)->get();
        if ($request->session()->exists('search_id')) {
            $search_id = session()->get('search_id');
            $search = Search::where('id', '=', $search_id)->first();
            $start = Carbon::parse($search->from_date);
            $end = Carbon::parse($search->to_date);
            $days = $start->diffInDays($end);
            return view('book', ['room' => $roomdetails, 'hotel' => $hotel, 'search' => $search,'days'=>$days,'start'=>$start,'end'=>$end,'rooms'=>$rooms,'no_rooms'=>$no_rooms]);
        } else {
            return view('front', ['room' => $roomdetails, 'hotel' => $hotel]);
        }
    }

    public function viewHotelInvoice($id) {
        $booking = Booking::findorfail($id);
        return view('invoice',['booking'=>$booking]);
    }

    public function hotelList()
    {
        $hotels = Hotel::where('flag',true)->get();
        return view('hotellist', ['hotels' => $hotels]);
    }

    public function hotelShow($id)
    {
        $hotel = Hotel::findorfail($id);
        if(session()->has('search_id')) {
             $search_id = session()->get('search_id');
            $search = Search::where('id', '=', $search_id)->first();
             $from = Carbon::parse($search->from_date)->toFormattedDateString();
            $till = Carbon::parse($search->till_date)->toFormattedDateString();
            $photos = Photo::where('hotel_id', '=', $hotel->id)->get();
        $rooms = Room::where('hotel_id',$hotel->id)->get();
        $min = collect($rooms)->min('room_flat_cost');
            return view('hotelshow', ['hotel' => $hotel, 'photos' => $photos,'search'=>$search,'min'=>$min,'from'=>$from,'till'=>$till]);
        }
       
        $photos = Photo::where('hotel_id', '=', $hotel->id)->get();
        $rooms = Room::where('hotel_id',$hotel->id)->get();
         $min = collect($rooms)->min('room_flat_cost');
        
        return view('hotelshow', ['hotel' => $hotel, 'photos' => $photos,'min'=>$min]);
    }

    public function hotelRoom($id)
    {
        $hotel = Hotel::findorfail($id);
        $roomtypes = RoomType::all();
        $rooms = Room::where('hotel_id', '=', $hotel->id)->get();

        return view('room', ['hotel' => $hotel, 'rooms' => $rooms, 'roomtypes' => $roomtypes]);
    }

    public function roomShow($id)
    {
        $room = Room::findorfail($id);
        $hotel = Hotel::where('id', '=', $room->hotel_id)->first();
        $otherrooms = Room::where('hotel_id', '=', $hotel->id)->get();
        $roomgalleries = RoomGallery::where('room_id', '=', $room->id)->get();
        return view('roomview', ['room' => $room, 'roomgalleries' => $roomgalleries, 'hotel' => $hotel, 'otherrooms' => $otherrooms]);
    }

    public function listVehicle()
    {
        $vehicles = Vehicle::all()->where('flag',true);
        return view('vehiclelist', ['vehicles' => $vehicles]);
    }

    public function searchVehicle(VehicleSearchRequest $request)
    {
        $queryloc = $request->location;
        $querypas = $request->passenger;
        $search = new VehicleSearch;
        $search->location = $request->location;
        $search->destination = $request->destination;
        $search->from = $request->from_date;
        $search->pickup_time = $request->pickup_time;
        $search->dropoff_time = $request->dropoff_time;
        $search->till = $request->till_date;
        $search->passengers = $request->passenger;

        $search->save();
        $search_id = $search->id;
        $request->session()->put('search_vehicle_id', $search_id);
        $vehicles = Vehicle::where('location', 'like', '%' . $queryloc . '%')->where('no_of_people', '>', $querypas)->where('flag',true)->paginate(5);
        return view('searchvehicle', ['vehicles' => $vehicles,'search'=>$search]);

    }

    public function showVehicle($id)
    {
        $vehicle = Vehicle::findorfail($id);
        return view('viewvehicle', ['vehicle' => $vehicle]);
    }

    public function bookVehiclewithoutSession(VehicleSearchRequest $request) {
        $search = new VehicleSearch;
        $search->location = $request->location;
        $search->destination = $request->destination;
        $search->from = $request->from;
        $search->pickup_time = $request->pickup_time;
        $search->dropoff_time = $request->dropoff_time;
        $search->till = $request->till;
        $search->passengers = $request->passenger;
        $search->save();

        $from = Carbon::parse($search->from);
        $till = Carbon::parse($search->till);

         $days = $from->diffInDays($till);
       

        $vehicle = Vehicle::findorfail($request->vehicle_id);
        return view('reservevehicle',['search'=>$search,'vehicle'=>$vehicle,'from'=>$from,'till'=>$till,'days'=>$days]);
    }

    public function reserveVehicle($id)
    {
        $vehicle = Vehicle::findorfail($id);
        $search_id = session()->get('search_vehicle_id');
        $search = VehicleSearch::where('id', $search_id)->first();
         $from = Carbon::parse($search->from);
        $till = Carbon::parse($search->till);
         $days = $from->diffInDays($till);
        return view('reservevehicle', ['vehicle' => $vehicle, 'search' => $search,'from'=>$from,'till'=>$till,'days'=>$days]);
    }

    public function listTour() {
        $tours = TourPackage::all()->where('flag',true);
        return view('tourlist',['tours'=>$tours]);
    }

    public function searchTour(TourSearchRequest $request) {
        $search = new TourSearch;

        $search->destination = $request->destination;
        $search->from = $request->from;
        $search->to = $request->till;
        $search->people = $request->people;

        $search->save();
        $query = $request->destination;
        session()->put('search_tour_id',$search->id);

        $tours = TourPackage::where('location','like','%'.$query.'%')->where('flag',true)->get();
        return view('searchtour',['tours'=>$tours,'search'=>$search]);
    }

    public function showTour($id) {
        $tour = TourPackage::findorfail($id);
        $galleries = TourGallery::where('tour_package_id',$tour->id)->get();
        return view('viewtour',['tour'=>$tour,'galleries'=>$galleries]);
    }

    public function registerBusiness() {
        return view('auth.regbusiness');
    }

    public function registerAgent() {
        return view('auth.regagent');
    }

    
}
