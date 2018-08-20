<?php

namespace App\Http\Controllers;

use App\TourGallery;
use App\TourPackage;
use App\TourPackageBooking;
use App\TourPackageBookingDetails;
use App\Notifications\TourPackageRegisteredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications;
use App\Http\Requests\TourPackageStoreRequest;

class TourPackageController extends Controller
{
    public function index() {
        $packages = TourPackage::where('user_id',Auth::user()->id)->get();
        $user = Auth::user();
        return view('user.tours',['packages'=>$packages,'user'=>$user]);
    }

    public function addPackage() {
        if(Auth::user()->hasRole('tourowner')){
            $user = Auth::user();
            return view('tourpackage.addpackage',['user'=>$user]);
        }
    }

    public function registerPackage(TourPackageStoreRequest $request) {
            $package = new TourPackage;
            if($request->has('image')){
                $filenamewithext = $request->file('image')->getClientOriginalName();
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
                $storename = $filename.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/tourpackage',$storename);
                $package->image = $storename;
            }

            $package->name = $request->name;
            $package->location = $request->location;
            $package->description = $request->description;
            $package->email = $request->email;
            $package->contact = $request->contact;
            $package->provider = $request->provider;
            $package->provider_location = $request->provider_location;
            $package->tag = $request->tag;
            $package->itenary = $request->itenary;
            $package->duration = $request->duration;
            $package->price = $request->price;
            $package->group_price = $request->group_price;
            $package->group_size = $request->group_size;
            $package->user_id = Auth::user()->id;

            $user = Auth::user();

            if($package->save()){
               
                $package->update([
                    'tour_package_code'=>"AL-T-".$package->id
                ]);
                $admins = User::whereHas('roles', function($q){
                $q->where('name', 'admin');
                })->get();
                foreach($admins as $admin){
                $admin->notify(new TourPackageRegisteredNotification($package, $user));
            }
                return redirect()->route('indexpackage')->withSuccess('Package registered Successfully');
            } else {
                return redirect()->route('indexpackage')->withError('Package couldn\'t be added');
            }

    }

    public function editPackage($id) {
        $package = TourPackage::findorfail($id);
        if($package->user_id == Auth::user()->id) {
            if(Auth::user()->hasRole('tourowner')) {
            $user = Auth::user();
            return view('tourpackage.editpackage',['package'=>$package,'user'=>$user]);
        } else {
            return redirect()->route('welcome');
        }
    }
    }

    public function updatePackage(Request $request) {
        $package = TourPackage::where('id',$request->id)->first();
        if($package->user_id == Auth::user()->id) {
            if($request->hasFile('image')){
                Storage::disk('public')->delete('tourpackage/'.$package->image);
                $filenamewithext = $request->file('image')->getClientOriginalName();
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
                $storename = $filename.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/tourpackage',$storename);

                $package->update([
                    'image'=>$storename
                ]);
            }

            $package->update([
                'name'=>$request->name,
                'location'=>$request->location,
                'description'=>$request->description,
                'email'=>$request->email,
                'contact'=>$request->contact,
                'provider'=>$request->provider,
                'provider_location'=>$request->provider_location,
                'tag'=>$request->tag,
                'itenary'=>$request->itenary,
                'duration'=>$request->duration,
                'price'=>$request->price,
                'group_price'=>$request->group_price,
                'group_size'=>$request->group_size,
                'tour_package_code'=>"AL-T-".$package->id
            ]);

            return redirect()->route('indexpackage')->withSuccess('Package Updated Successfully');
        } else {
            return redirect()->route('welcome');
        }

    }

    public function viewPackage($id) {
        $package = TourPackage::findorfail($id);
        if($package->user_id == Auth::user()->id){
            $user = Auth::user();
            return view('tourpackage.viewpackage',['package'=>$package,'user'=>$user]);
        } else {
            return redirect()->route('welcome');
        }
    }

    public function deletePackage($id) {
        $package = TourPackage::findorfail($id);
        $galleries = TourGallery::where('tour_package_id',$package->id)->get();

        if($package->user_id == Auth::user()->id) {
            foreach($galleries as $gallery) {
                Storage::disk('public')->delete('tourgallery/'.$gallery->image);
                $gallery->delete();
            }
            $package->delete();
            return redirect()->route('indexpackage')->withSuccess('Package Successfully Deleted');
        } else {
            return redirect()->route('welcome');
        }

    }

    /**
     * Package image gallery
     */

    public function addImage(Request $request) {
        $package = TourPackage::findorfail($request->tour_package_id);
        if($package->user_id == Auth::user()->id) {
            $gallery = new TourGallery;

            if($request->hasFile('image')){
                $filenamewithext = $request->file('image')->getClientOriginalName();
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
                $storename = $filename.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/tourgallery',$storename);
                $gallery->image = $storename;
            }

            $gallery->tour_package_id = $request->tour_package_id;

            $gallery->save();

            return redirect()->route('viewpackage',$package->id)->withSuccess('Image added Successfully');
        } else {
            return redirect()->route('welcome');
        }

    }

    public function deleteImage($id) {
        $image = TourGallery::findorfail($id);
        $package = TourPackage::where('id',$image->tour_package_id)->first();
        if($package->user_id == Auth::user()->id) {
            Storage::disk('public')->delete('tourgallery/'.$image->image);
            $image->delete();
            return redirect()->route('viewpackage',$image->tour_package_id)->withSuccess('Image successfully Deleted');
        } else {
            return redirect()->route('welcome');
        }

    }

    public function viewBookingDetails($id) {
        $tourpackagebooking = TourPackageBooking::findorfail($id);
        $bookingdetails = TourPackageBookingDetails::where('tour_package_booking_id',$tourpackagebooking->id)->get();
        $user = Auth::user();
        return view('tourpackage.bookingdetails',['bookingdetails'=>$bookingdetails,'user'=>$user,'booking'=>$tourpackagebooking]);
    }
}
