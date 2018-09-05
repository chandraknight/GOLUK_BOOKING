<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\RoomService;
use Auth;
use Illuminate\Http\Request;

class RoomServiceController extends Controller
{
    public function index($id)
    {
        $hotel = Hotel::findorfail($id);
        $roomservices = RoomService::all();
        $user = Auth::user();
        return view('rooms.roomservices.index',['roomservices'=>$roomservices,'hotel'=>$hotel,'user'=>$user]);
    }

    public function insertService(Request $request)
    {
        $roomservice = new RoomService;

        $roomservice->name = $request->service_name;
        $roomservice->description = $request->service_description;
        $roomservice->hotel_id = $request->hotel_id;

        $roomservice->save();

        return redirect()->back()->withSuccess('Room Service successfully added');
    }

    public function editRoomService($id)
    {
        $editroomservice = RoomService::findorfail($id);
        $hotel = Hotel::where('id',$editroomservice->hotel_id)->first();
        $roomservices = RoomService::all();
        $user = Auth::user();
        return view('rooms.roomservices.edit',['editroomservice'=>$editroomservice,'roomservices'=>$roomservices,'hotel'=>$hotel,'user'=>$user]);
    }

    public function updateRoomService(Request $request)
    {
        $roomservice = RoomService::findorfail($request->id);

        $roomservice->update([
            'name'=>$request->service_name,
            'description'=>$request->service_description
        ]);
        return redirect()->route('roomservices.index',$roomservice->hotel_id)->withSuccess('Room Service successfully Updated');

    }

    public function deleteRoomService($id)
    {
        $roomservice = RoomService::findorfail($id);

        $roomservice->delete();
        return redirect()->route('roomservices.index',$roomservice->hotel_id)->withSuccess('Room Service successfully deleted');
    }
}
