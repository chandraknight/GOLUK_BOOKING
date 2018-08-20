<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Booking;
use App\TourPackageBooking;
use App\VehicleBooking;
use Auth;

class UserController extends Controller
{
    public function userProfile($id) {
        $user = User::findorfail($id);
        return view('user.profile',['user'=>$user]);
    }

    public function userSettings($id) {
        $user = User::findorfail($id);
        return view('user.usersetting',['user'=>$user]);
    }

    public function editProfile(Request $request) {
    	$user=User::findorfail($request->user_id);
    	$name = $request->firstname.' '.$request->lastname;
    	if($user->id == Auth::user()->id) {
    		$user->update([
    			'name'=>$name,
    		]);
    		return redirect()->back()->withSuccess('Profile Successfully Updated');
    	} else {
    		return redirect()->route('logout');
    	}
    }

    public function changePassword(Request $request) {
    	$user=User::findorfail($request->user_id);
    	$currentpassword =Hash::make($request->currentpassword);
    	if($user->password ==$currentpassword) {
    		$newpassword = bcrypt($request->newpassword);
    		$user->update([
    			'password'=>$newpassword,
    		]);
    		return redirect()->back()->withSuccess('Password Successfully Changed');
    	} else {
    		return redirect()->back()->withError('Your current password is incorrect');
    	}
    }

    public function bookingHistory($id) {
    	$user = Auth::user();
        if($user->id == $id) {
        	$hotelBooking = Booking::where('user_id',$user->id)->get()->sortByDesc('created_at');
        	$vehicleBooking = VehicleBooking::where('user_id',$user->id)->get()->sortByDesc('created_at');
        	$tourBooking = TourPackageBooking::where('user_id',$user->id)->get()->sortByDesc('created_at');
        	return view('user.userbookinghistory',['user'=>$user,'hotelBooking'=>$hotelBooking,'vehicleBooking'=>$vehicleBooking,'tourBooking'=>$tourBooking]);
        } else {
            return redirect()->route('welcome');
        }
    }

   
}
