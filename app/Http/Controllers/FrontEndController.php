<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Domestic\Request\SectorCode;
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
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function welcome()
    {
//        dd(phpinfo());
        $sector = new SectorCode();
        $sectors = $sector->doRequest();
//        dd($sectors);
        $hotels = Hotel::inRandomOrder()->where('flag',true)->limit(8)->get();
        $vehicles = Vehicle::inRandomOrder()->where('flag',true)->limit(4)->get();
        $tours = TourPackage::inRandomOrder()->where('flag',true)->limit(4)->get();
        return view('welcome',['hotels'=>$hotels,'vehicles'=>$vehicles,'tours'=>$tours,'sectors'=>$sectors]);
    }

    public function searchHotel(SearchRequest $request)
    {
        $query = strtolower($request->hoteldestination);
        $search = new Search;
        $search->destination = $request->hoteldestination;
        $search->from_date = $request->hotelfrom_date;
        $search->to_date = $request->hoteltill_date;
        $search->no_adults = $request->hotelno_adults;
        $search->no_childs = $request->hotelno_childs;

        $search->save();
        $search_id = $search->id;
        $request->session()->put('search_id', $search_id);


        $hotels = Hotel::where('address', 'like', '%' . $query . '%')
            ->orWhere('name','like','%'.$query.'%')
            ->orWhere('email','like','%'.$query.'%')
            ->where('flag',true)
            ->has('rooms','>',1)
            ->paginate(15);

        return view('search', ['hotels' => $hotels,'search'=>$search]);
    }

    public function bookHotelWithoutSession(SearchRequest $request) {
        $search = new Search;
        $search->destination = $request->hoteldestination;
        $search->from_date = $request->hotelfrom_date;
        $search->to_date = $request->hoteltill_date;
        $search->no_adults = $request->hotelno_adults;
        $search->no_childs = $request->hotelno_childs;

        $search->save();
        $search_id = $search->id;
        $request->session()->put('search_id', $search_id);
        $hotel = Hotel::findorfail($request->hotel_id);
        return redirect()->route('hotel.show',$hotel->id)->with('error','Provide number of rooms');
    }

    public function bookTourWithoutSession(TourSearchRequest $request) {
        $search = new TourSearch;
        $search->destination = $request->activitydestination;
        $search->from = $request->activityfrom;
        $search->to = $request->activitytill;
        $search->people = $request->activitypeople;

        $search->save();
        $search_id = $search->id;
        session()->put('search_tour_id',$search_id);
        $tour = TourPackage::findorfail($request->tour_id);
        $start = Carbon::parse($search->from);
        return redirect()->route('booktour',$tour->id);

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
        }
    }

    public function viewHotelInvoice($id) {
        $booking = Booking::findorfail($id);
        return view('invoice',['booking'=>$booking]);
    }

    public function hotelList()
    {
        $hotels = Hotel::where('flag',true)->has('rooms')->get();
        return view('hotellist', ['hotels' => $hotels]);
    }

    public function hotelShow($id)
    {
        $hotel = Hotel::findorfail($id);
        if(session()->has('search_id')) {
            $search_id = session()->get('search_id');
            $search = Search::where('id', '=', $search_id)->first();
            $from = Carbon::parse($search->from_date)->toFormattedDateString();
            $till = Carbon::parse($search->to_date)->toFormattedDateString();
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
        $queryloc = $request->vehiclelocation;

        $querypas = $request->vehiclepassenger;
        $search = new VehicleSearch;
        $search->location = $request->vehiclelocation;
        if($request->vehicledestination == null || empty($request->vehicledestination) ){
            $search->destination = "Same as Pickup Location";
        } else {
            $search->destination = $request->vehicledestination;
        }

        $search->from = $request->vehiclefrom_date;
        $search->pickup_time = $request->vehiclepickup_time;
        $search->dropoff_time = $request->vehicledropoff_time;
        $search->till = $request->vehicletill_date;
        $search->passengers = $request->vehiclepassenger;

        $search->save();
        $querydes = $search->destination;
        $search_id = $search->id;
        $request->session()->put('search_vehicle_id', $search_id);
        $vehicles = Vehicle::where('location', 'like', '%' . $queryloc . '%')
            ->orWhere('name','like','%'.$queryloc.'%')
            ->orWhere('name','like','%'.$querydes.'%')
            ->orWhere('vehicle_code','like','%'.$queryloc.'%')
            ->where('no_of_people', '>=', $querypas)
            ->where('flag',true)->paginate(5)
            ;
        return view('searchvehicle', ['vehicles' => $vehicles,'search'=>$search]);

    }

    public function showVehicle($id)
    {
        $vehicle = Vehicle::findorfail($id);
        if(session()->has('search_vehicle_id')){
            $search_id = session()->get('search_vehicle_id');
            $search = VehicleSearch::where('id', $search_id)->first();
            return view('viewvehicle', ['vehicle' => $vehicle,'search'=>$search]);
        }
        return view('viewvehicle', ['vehicle' => $vehicle]);
    }

    public function bookVehiclewithoutSession(VehicleSearchRequest $request) {
        $search = new VehicleSearch;
        $search->location = $request->vehiclelocation;
        if($request->vehicledestination == null) {
            $search->destination = $search->location;
        } else {
            $search->destination = $request->vehicledestination;
        }

        $search->from = $request->vehiclefrom_date;
        $search->pickup_time = $request->vehiclepickup_time;
        $search->dropoff_time = $request->vehicledropoff_time;
        $search->till = $request->vehicletill_date;
        $search->passengers = $request->vehiclepassenger;
        $search->save();


        $request->session()->put('search_vehicle_id', $search->id);


        $vehicle = Vehicle::findorfail($request->vehicle_id);
        return redirect()->route('reservevehicle',$vehicle->id);
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

        $search->destination = $request->activitydestination;
        $search->from = $request->activityfrom;
        $search->to = $request->activitytill;
        $search->people = $request->activitypeople;

        $search->save();
        $query = $request->activitydestination;
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

    public function ajaxSortHotel(Request $request) {
        $sort = $request->sort;
        $search = json_decode($request->search,true);
        if($request->ajax()) {
            $hotels = Hotel::query();
            if($sort == "price-low-high") {
                $hotels->with('rooms')

                    ->join('rooms','rooms.hotel_id','=','hotels.id')
                    ->whereExists(function ($query) {
                        $query->select("rooms.room_flat_cost")
                            ->from('rooms')
                            ->whereRaw('rooms.hotel_id = hotels.id');})

                    ->where('hotels.address','like','%'.$search['destination'].'%')
                    ->orWhere('hotels.name','like','%'.$search['destination'].'%')
                    ->orWhere('hotels.email','like','%'.$search['destination'].'%')
                    ->where('flag',true)
                    ->orderBy('rooms.room_flat_cost','ASC')
                    ->get();
            }
            elseif ($sort == "price-high-low") {
                $hotels
                    ->join('rooms','rooms.hotel_id','=','hotels.id')
                    ->where('hotels.address','like','%'.$search['destination'].'%')
                    ->whereExists(function ($query) {
                        $query->select("rooms.room_flat_cost")
                            ->from('rooms')
                            ->whereRaw('rooms.hotel_id = hotels.id');})
                    ->orWhere('hotels.name','like','%'.$search['destination'].'%')
                    ->orWhere('hotels.email','like','%'.$search['destination'].'%')
                    ->where('flag',true)
                    ->orderBy('room_flat_cost','DESC')
                    ->get();

            } else {
                $hotels->where('address','like','%'.$search['destination'].'%')
                    ->orWhere('name','like','%'.$search['destination'].'%')
                    ->orWhere('email','like','%'.$search['destination'].'%')
                    ->where('flag',true)
                    ->get();
            }

            $hotels = $hotels->get();
//            dd($hotels);
        }
        $output = view('sorthotel', ['hotels' => $hotels])->render();
        return response()->json(['output'=>$output]);
    }

    public function ajaxSortVehicle(Request $request) {

        if($request->ajax()) {
            $sort = $request->sort;
            $search = json_decode($request->search,true);
            $queryloc = $search['location'];
            $querypas = $search['passengers'];
            if($sort == "price-low-high") {
                $vehicles = Vehicle::
                where('location', 'like', '%' . $queryloc . '%')->where('no_of_people', '>=', $querypas)->where('flag',true)
                    ->orderBy('rate_per_day','ASC')
                    ->get();
            }
            elseif ($sort == "price-high-low") {
                $vehicles = Vehicle::
                where('location', 'like', '%' . $queryloc . '%')->where('no_of_people', '>=', $querypas)->where('flag',true)
                    ->orderBy('rate_per_day','DESC')
                    ->get();

            } else {
                $vehicles = Vehicle::where('location', 'like', '%' . $queryloc . '%')->where('no_of_people', '>=', $querypas)->where('flag',true)
                    ->orWhere('vehicle_code','like','%'.$queryloc.'%')
                    ->get();
            }

        }
        $output = view('sortvehicle', ['vehicles' => $vehicles])->render();
        return response()->json(['output'=>$output]);
    }

    public function ajaxSortActivity(Request $request) {

        if($request->ajax()) {
            $sort = $request->sort;
            $search = json_decode($request->search,true);
            $query = $search['destination'];
            if($sort == "price-low-high") {
                $tours = TourPackage::
                where('location','like','%'.$query.'%')->where('flag',true)
                    ->orderBy('price','ASC')
                    ->get();
            }
            elseif ($sort == "price-high-low") {
//                dd($request->sort);
                $tours = TourPackage::
                where('location','like','%'.$query.'%')->where('flag',true)
                    ->orderBy('price','DESC')
                    ->get();

            } else {
                $tours = TourPackage::where('location','like','%'.$query.'%')->where('flag',true)
                    ->get();
            }

        }
        $output = view('sorttour', ['tours' => $tours])->render();
        return response()->json(['output'=>$output]);
    }
}
