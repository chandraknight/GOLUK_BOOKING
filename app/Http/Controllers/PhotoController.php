<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotel;
use Auth;
use App\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function add($id) {
    	$hotel = Hotel::findorfail($id);
    	if($hotel->created_by == Auth()->user()->id) {
	    	return view('photos.add',['id'=>$hotel->id]);
    	} else {
    		return redirect()->route('hotel.index');
    	}
    }

    public function upload(Request $request) {
    	$hotel = Hotel::findorfail($request->id);
    	if($hotel->created_by == Auth()->user()->id) {
    		$photo = new Photo;
    		$filenamewithext = $request->file('photo')->getClientOriginalName();

	        $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);

	        $extension = $request->file('photo')->getClientOriginalExtension();

	        $storename = $filename.time().'.'.$extension;
	        $path = $request->file('photo')->storeAs('public/hotel_photos/'.$hotel->id,$storename);

	        $photo->title = $request->title;
	        $photo->description = $request->description;
	        $photo->photo = $storename;
	        $photo->hotel_id = $hotel->id;

	        $photo->save();
	        return redirect()->route('hotel.view',$hotel->id);
    	} else {
    		return redirect()->route('hotel.index');
    	}

    }

    public function delete($id) {
        $photo = Photo::findorfail($id);
        $hotel = Hotel::where('id','=',$photo->hotel_id)->first();

        if($hotel->created_by == Auth()->user()->id) {
            $photo->delete();
            return redirect()->route('hotel.view',$hotel->id)->with('success','Photo Successfully Deleted');
        } else {
            return redirect()->route('hotel.index')->with('error','Premission Denied');
        }
    }
}
