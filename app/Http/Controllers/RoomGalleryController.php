<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Room;
use App\RoomGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomGalleryController extends Controller
{
    public function add($id) {
        $room = Room::findorfail($id);
        $hotel = Hotel::where('id','=',$room->hotel_id)->get();
        if(Auth()->user()->id == $hotel->created_by) {
            return view('rooms.addphoto',['room'=>$room]);
        } else {
            return redirect()->route('hotel.index');
        }
    }

    public function insert(Request $request) {
        $room = Room::findorfail($request->room_id);
        $hotel = Hotel::where('id','=',$room->hotel_id)->get()->first();
        if(Auth()->user()->id == $hotel->created_by) {
            $filenamewithext = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $storename = $filename.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/rooms/'.$hotel->id,$storename);

            $roomgallery = new RoomGallery;

            $roomgallery->room_id = $request->room_id;
            $roomgallery->image = $storename;

            $roomgallery -> save();
            return redirect()->route('room.view',$room->id)->with('success','Photo Successfully Inserted');
        } else {
            return redirect()->route('hotel.index');
        }
    }

    public function delete($id) {
        $roomgallery = RoomGallery::findorfail($id);
        $room = Room::where('id','=',$roomgallery->room_id)->get()->first();
        $hotel = Hotel::where('id','=',$room->hotel_id)->get()->first();
        if(Auth()->user()->id == $room->user_id) {
            Storage::disk('public')->delete('rooms/'.$hotel->id.'/'.$roomgallery->image);
            $roomgallery ->delete();
            return redirect()->route('room.view',$room->id)->with('success','Photo Successfully Deleted');
        } else {
            return redirect()->route('hotel.index');
        }
    }
}
