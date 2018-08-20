<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index(){
        $types = RoomType::all();
        return view('admin.roomtype',['types'=>$types]);
    }

    public function store(Request $request) {
        $roomtype = new RoomType;
        $roomtype->name =$request->type_name;
        $roomtype->description = $request->type_description;
        $roomtype->save();
        return redirect()->route('roomtype.index')->with('success','Room Type succesfully Created');
    }

    public function delete($id){
        $hotel = Hotel::findorfail($hotel_id);
        $roomtype = RoomType::findorfail($id);
        $roomtype->delete();
        return redirect()->route('roomtype.index')->with('success','Room Type Succesfully Deleted');
    }
}
