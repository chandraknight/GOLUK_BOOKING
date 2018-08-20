<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Room;
use App\RoomGallery;
use App\RoomService;
use App\RoomType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomsController extends Controller
{
    public function index($id){
        $hotel = Hotel::findorfail($id);

        $rooms = Room::where('hotel_id','=',$hotel->id)->orderBy('room_flat_cost','ASC')->get();

        if($hotel->created_by == Auth()->user()->id) {
            return view('rooms.index',['rooms'=>$rooms,'hotel'=>$hotel]);
        } else {
            return redirect()->route('hotels.index');
        }

    }

    public function add($id){
        $hotel=Hotel::findorfail($id);
        $types = RoomType::all();
        $roomservices = RoomService::where('hotel_id',$hotel->id)->get();
        if(Auth()->user()->id == $hotel->created_by){
            $user = Auth::user();
            return view('hotels.addroom',['hotel'=>$hotel,'types'=>$types,'roomservices'=>$roomservices,'user'=>$user]);
        } else {
            return redirect()->route('hotel.index');
        }
    }

    public function register(Request $request){

        $hotel = Hotel::findorfail($request->hotel_id);
        if($hotel->created_by == Auth()->user()->id){
            $room = new Room;
            if($request->image) {
                $filenamewithext = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $storename = $filename.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/rooms/'.$hotel->id,$storename);

                $room->image = $storename;
            }
            $room->room_no = $request->room_no;
            $room->no_of_rooms = $request->no_of_rooms;
            $room->hotel_id = $request->hotel_id;
            $room->room_flat_cost = $request->room_flat_cost;
            $room->room_type_id = $request->room_type;
            $room->no_adults = $request->no_adults;
            $room->no_childs = $request->no_childs;
            $room->no_beds = $request->no_beds;
            $room->max_add_beds = $request->max_add_beds;
            $room->cost_per_add_bed = $request->cost_per_add_bed;
            $room->cost_ep_plan = $request->cost_ep_plan;
            $room->cost_ap_plan = $request->cost_ap_plan;
            $room->cost_cp_plan = $request->cost_cp_plan;
            $room->cost_map_plan = $request->cost_map_plan;
            $room->user_id = Auth()->user()->id;
            $room->last_updated_by = Auth()->user()->id;

            $room->save();
            $room->roomservices()->sync($request->roomservices);

            return redirect()->back()->with('success','Room Added Successfully');

        }

    }
    public function view($id) {
        $room = Room::findorfail($id);
        $roomgalleries = RoomGallery::where('room_id','=',$room->id)->get();
        $hotel = Hotel::where('id','=',$room->hotel_id)->get()->first();
        if(Auth()->user()->id == $hotel->created_by) {
            return view('rooms.view',['room'=>$room,'hotel'=>$hotel,'roomgalleries'=>$roomgalleries]);
        } else {
            return redirect()->route('welcome');
        }

    }

    public function edit($id) {
        $room = Room::findorfail($id);
        $types = RoomType::all();
        $hotel = Hotel::where('id','=',$room->hotel_id)->get()->first();
        if(Auth()->user()->id == $hotel->created_by) {
            $user = Auth::user();
            return view('hotels.roomedit',['room'=>$room,'types'=>$types,'hotel'=>$hotel,'user'=>$user]);
        }else {
            return route('welcome');
        }
    }
    public function update(Request $request) {
        $room=Room::findorfail($request->room_id);
        $hotel = Hotel::where('id','=',$room->hotel_id)->get()->first();
        if(Auth()->user()->id == $hotel->created_by) {
            if($request->image) {
                Storage::disk('public')->delete('rooms/'.$hotel->id.'/'.$room->image);
                $filenamewithext = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $storename = $filename.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/rooms/'.$hotel->id,$storename);

                $room->update([
                    'image'=>$storename
                ]);

            }
            $room->update([
                'room_no'=>$request->room_no,
               'no_of_rooms'=>$request->no_of_rooms,
               'room_flat_cost'=>$request->room_flat_cost,
               'room_type'=>$request->room_type,
               'no_adults'=>$request->no_adults,
               'no_childs'=>$request->no_childs,
               'no_beds'=>$request->no_beds,
               'max_add_beds'=>$request->max_add_beds,
               'cost_per_add_bed'=>$request->cost_per_add_bed,
               'cost_ep_plan'=>$request->cost_ep_plan,
               'cost_ap_plan'=>$request->cost_ap_plan,
               'cost_cp_plan'=>$request->cost_cp_plan,
               'cost_map_plan'=>$request->cost_map_plan,

            ]);

            return redirect()->back()->with('success','Room Successfully Updated');

        } else {
            return redirect()->route('welcome');
        }
    }

    public function delete($id) {
        $room = Room::findorfail($id);
        $hotel = Hotel::where('id','=',$room->hotel_id)->get()->first();
        if(Auth()->user()->id == $hotel->created_by) {
            Storage::disk('public')->delete('rooms/'.$hotel->id.'/'.$room->image);
            $room->delete();
            return redirect()->back()->with('success','Room Successfully Deleted');
        } else {
            return redirect()->route('welcome');
        }
    }
}
