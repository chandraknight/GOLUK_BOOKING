<?php

namespace App\Http\Controllers;
use Auth;
use App\Hotel;
use App\Photo;
use App\HotelService;
use App\RoomService;
use Illuminate\Http\Request;
use App\Http\Requests\HotelStoreRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Notifications\HotelRegisteredNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications;
class HotelController extends Controller
{
     public function index() {
        $hotels= Hotel::where('created_by','=',Auth()->user()->id)->get();
        $user = Auth::user();
        return view('user.hotels',['hotels'=>$hotels,'user'=>$user]);
    }

    public function register(){
         if(Auth::user()->hasRole('hotelowner')){
            $user = Auth::user();
             $services = HotelService::all();
             return view('hotels.register',['hotelservice'=>$services,'user'=>$user]);
         }

    }

    public function store(HotelStoreRequest $request){
        
        $filenamewithext = $request->file('logo')->getClientOriginalName();

        $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);

        $extension = $request->file('logo')->getClientOriginalExtension();

        $storename = $filename.time().'.'.$extension;
        $path = $request->file('logo')->storeAs('public/hotel_logo',$storename);
    	$user = Auth::user();
        $hotel = new Hotel;


    	$hotel->email = $request->email;
    	$hotel->name = $request->name;
        $hotel->description = $request->description;
    	$hotel->website = $request->website;
    	$hotel->logo = $storename;
    	$hotel->address = $request->address;
    	$hotel->no_rooms = $request->no_rooms;
    	$hotel->contact = $request->contact;
    	$hotel->agent_name = $request->agent_name;
    	$hotel->agent_contact = $request->agent_contact;
    	$hotel->check_out_time = $request->check_out_time;
    	$hotel->created_by = Auth()->user()->id;
    	$hotel->last_updated_by = Auth()->user()->id;

    	if($hotel->save()){
            $hotel->update([
                'hotel_code'=>"AL-H-".$hotel->id
            ]);
        }
        $hotel->hotelservices()->sync($request->services);
        $admins = User::whereHas('roles', function($q){
            $q->where('name', 'admin');
            })->get();
        foreach($admins as $admin){
        $admin->notify(new HotelRegisteredNotification($hotel, $user));
    }
    	return redirect()->route('hotel.index')->with('success','Hotel Registered');
    }

    public function edit($id) {
        $hotel = Hotel::findorfail($id);
        // dd(\Carbon\Carbon::parse($hotel->bookHotel->first()->created_at)->diffForHumans());
        $services = HotelService::all();
        if(Auth()->user()->id == $hotel->created_by){
            $user = Auth::user();
        return view('hotels.update',['hotel'=>$hotel
        ,'services'=>$services,'user'=>$user]);
        }
        else {
            return view('hotels.index')->with('error','Permission Denied');
        }
    }

    public function update(Request $request){
        $hotel = Hotel::findorfail($request->id);
        if(Auth()->user()->id == $hotel->created_by){
            if($request->logo) {
                
                // dd($hotel->logo);
                Storage::disk('public')->delete('hotel_logo/'.$hotel->logo); 
                
                $filenamewithext = $request->file('logo')->getClientOriginalName();

                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);

                $extension = $request->file('logo')->getClientOriginalExtension();

                $storename = $filename.time().'.'.$extension;
                $path = $request->file('logo')->storeAs('public/hotel_logo',$storename);
                $hotel = Hotel::where('id',$request->id);
                $hotel -> update([
                    'logo' => $storename,
                ]);

            }
        	$hotel = Hotel::findorfail($request->id);
        	$hotel -> update([
        		'email' => $request->email,
        		'name' => $request->name,
                'description'=>$request->description,
        		'website'=>$request->website,
        		'address' => $request->address,
        		'no_rooms' => $request->no_rooms,
        		'contact' => $request->contact,
        		'agent_name' => $request->agent_name,
        		'agent_contact' => $request->agent_contact,
        		'check_out_time' => $request->check_out_time,
                'last_updated_by' =>Auth()->user()->id,
                'hotel_code'=>"AL-H-".$hotel->id

        	]);
            $hotel->hotelservices()->sync($request->services);
        
        	// $hotel->update();
        	return redirect()->route('hotel.index')->with('success','Hotel Updated');
    } else {
        return redirect()->route('hotel.index')->with('error','Permission Denied');
        }
    }

    public function delete($id) {
        $hotel = Hotel::findorfail($id);
        $photos = Photo::where('hotel_id',$hotel->id)->get();
        if(Auth()->user()->id == $hotel->created_by) {
            
            Storage::disk('public')->delete('hotel_logo/'.$hotel->logo);
            foreach($photos as $photo){
                Storage::disk('public')->delete('hotel_photos/'.$photo->photo);
                $photo->delete();
            }
            $hotel->delete();
        } else {
            return redirect()->route('hotel.index')->with('error','Permission Denied');
            }
        return redirect()->route('hotel.index');
    }

    public function view($id){
         $hotel = Hotel::findorfail($id);
         if(Auth()->user()->id == $hotel->created_by) {
            $user = Auth::user();
             $photos = Photo::where('hotel_id','=',$hotel->id)->get();
             $roomservices = RoomService::where('hotel_id',$hotel->id)->get();
            return view('hotels.view',['user'=>$user,'hotel'=>$hotel,'photos'=>$photos,'roomservices'=>$roomservices]);
        } else {
            return redirect()->route('welcome');
        }
    }
}
