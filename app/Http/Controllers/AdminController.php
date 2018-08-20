<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\TourPackage;
use App\Vehicle;
use App\VehicleService;
use App\VehicleType;
use App\User;
use App\Booking;
use App\VehicleBooking;
use App\TourPackageBooking;
use App\HotelCommission;
use App\Role;
use App\AgentHotelCommission;
use App\AgentVehicleCommission;
use App\AgentTourPackageCommission;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{

    public function index(){
        return view('admin.index');
    }

    public function hotel() {
        $hotels = Hotel::all();
        return view('admin.hotels',['hotels'=>$hotels]);
    }

    public function viewHotel($id) {
        $hotel = Hotel::findorfail($id);
        $hotels = Hotel::all();
        return view('admin.viewhotel',['hotel'=>$hotel,'hotels'=>$hotels]);
    }

    public function  confirmHotel($id) {
        $hotel = Hotel::findorfail($id);
        $hotel->update([
            'flag'=>true
        ]);
        return redirect()->back()->withSuccess('Hotel Confirmed Successfully');
    }

    public function appendHotel($id) {
        $hotel = Hotel::findorfail($id);
        $hotel->update([
            'flag'=>false
        ]);

        return redirect()->back()->withSuccess('Hotel deactivated successfully');
    }

    public function vehicles() {
        $vehicles = Vehicle::all();
        return view('admin.vehicles',['vehicles'=>$vehicles]);
    }

    public function viewVehicle($id) {
        $vehicle = Vehicle::findorfail($id);
        $vehicles = Vehicle::all();
        return view('admin.viewvehicle',['vehicle'=>$vehicle,'vehicles'=>$vehicles]);
    }

    public function confirmVehicle($id) {
        $vehicle = Vehicle::findorfail($id);
        $vehicle->update([
            'flag'=>true
        ]);

        return redirect()->back()->withSuccess('Vehicle confirmed Successfully');
    }

    public function appendVehicle($id) {
        $vehicle = Vehicle::findorfail($id);
        $vehicle->update([
            'flag'=>false
        ]);

        return redirect()->back()->withSuccess('Vehicle deactivated Successfully');
    }


    public function vehicleType() {
        $types = VehicleType::all();
        return view('admin.type',['types'=>$types]);
    }

    public function registerVehicleType(Request $request) {
        $types = VehicleType::all();

        $type = new VehicleType;

        $type->type_name = $request->type_name;
        $type->type_description = $request->type_description;

        $type->save();
        return redirect()->route('vehicle.type.index')->withSuccess('Vehicle Type added successfully');
    }

    public function editVehicleType($id) {
        $type = VehicleType::findorfail($id);
        $types = VehicleType::all();
        return view('admin.edittype',['type'=>$type,'othertypes'=>$types]);
    }

    public function updateVehicleType(Request $request){
        $type = VehicleType::findorfail($request->id);

        $type->update([
            'type_name'=>$request->type_name,
            'type_description'=>$request->type_description,
        ]);
        $types = VehicleType::all();

        return redirect()->route('vehicle.type.index')->withSuccess('Vehicle Type added Successfully');
    }

    public function deleteVehicleType($id){
        $type = VehicleType::findorfail($id);

        if($type->delete()){
            return redirect()->route('vehicle.type.index')->withSuccess('Vehicle Deleted Successfully');
        } else {
            return redirect()->route('vehicle.type.index')->withError('Vehicle could not be deleted');
        }
    }


    public function serviceIndex(){
        $services = VehicleService::all();
        return view('admin.service',['services'=>$services]);
    }

    public function registerVehicleService(Request $request){
        $service = new VehicleService;

        $service->service_name = $request->service_name;
        $service->service_description = $request->service_description;
        $services = VehicleService::all();
        $service->save();

        return redirect()->route('vehicle.service.index')->withSuccess('Vehicle service added successfully');
    }

    public function editVehicleService($id) {
        $service = VehicleService::findorfail($id);
        $services = VehicleService::all();
        return view('admin.editservice',['service'=>$service,'otherservices'=>$services]);
    }

    public function updateVehicleService(Request $request){
        $service = VehicleService::findorfail($request->id);

        $service->update([
            'service_name'=>$request->service_name,
            'service_description'=>$request->service_description,
        ]);

        return redirect()->route('vehicle.service.index')->withSuccess('Service Updated Successfully');
    }

    public function deleteVehicleService($id) {
        $service = VehicleService::findorfail($id);

        if($service->delete()){
            return redirect()->route('vehicle.service.index')->withSuccess('Service Successfully deleted');
        } else {
            return redirect()->route('vehicle.service.index')->withError('Service couldn\'t be deleted');
        }
    }

    public function tours() {
        $tours = TourPackage::all();
        return view('admin.tours',['tours'=>$tours]);
    }

    public function viewTour($id) {
        $tour = TourPackage::findorfail($id);
        $tours = TourPackage::all();
        return view('admin.viewtour',['tour'=>$tour,'tours'=>$tours]);
    }

    public function confirmTour($id) {
        $tour = TourPackage::findorfail($id);
        $tour->update([
            'flag'=>true
        ]);

        return redirect()->back()->withSuccess('Tour Confirmed Successfully');
    }

    public function appendTour($id) {
        $tour = TourPackage::findorfail($id);
        $tour->update([
            'flag'=>false
        ]);

        return redirect()->back()->withSuccess('Tour deactivated Successfuly');
    }

    public function users() {
       $users = User::all();
       $usere = $users->filter(function($user)
        {
            return !$user->hasRole('superadmin','admin');
        });
        return view('admin.users',['users'=>$usere]);
    }

    public function editUser($id) {
        $user = User::findorfail($id);
        if($user->hasRoles('superadmin')) {
            return redirect()->route('admin.users');
        } 
        return view('admin.edituser',['user'=>$user]);
    }

    public function updateUser(Request $request) {
        $user = User::findorfail($request->user_id);
        $reqpass = $request->password;
        if(empty($reqpass)){
            $pass= $user->password;
        } else {
            $pass = bcrypt($reqpass);
        }
        $user->update([

            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$pass

        ]);

        return redirect()->route('admin.users')->withSuccess('User Updated Successfully');
    }

    public function deleteUser($id) {
        $user = User::findorfail($id);
        $user->delete();
        return redirect()->route('admin.users')->withErrors('User Deleted Successfully');
    }

    public function hotelBookings() {
        $hotelbookings = Booking::all()->sortByDesc('created_at');
        if(Auth::user()->hasRole('admin')){
             return view('admin.booking',['hotelbookings'=>$hotelbookings]);
        } elseif (Auth::user()->hasRole('superadmin')) {
             return view('superadmin.hotelbooking',['hotelbookings'=>$hotelbookings]);
        }
       
    }

    
    public function cancelHotelBooking($id) {
        $booking=Booking::findorfail($id);
        $booking->update([
            'status'=>'canceled'
        ]);

        return redirect()->back()->withSuccess('Booking Successfully Canceled');
    }

    public function viewHotelBooking($id) {
        $booking= Booking::findorfail($id);
        
             return view('admin.viewhotelbooking',['booking'=>$booking]);
    }

    public function vehicleBookings() {
        $vehiclebookings = VehicleBooking::all()->sortByDesc('created_at');
        if(Auth::user()->hasRole('admin')) {
            return view('admin.vehiclebooking',['vehiclebookings'=>$vehiclebookings]);
        } elseif(Auth::user()->hasRole('superadmin')) {
             return view('superadmin.vehiclebooking',['vehiclebookings'=>$vehiclebookings]);
        }
        
    }

    

    public function cancelVehicleBooking($id) {
         $vehiclebooking = VehicleBooking::findorfail($id);
        $vehiclebooking->update([
            'booking_status'=>'canceled'
        ]);
        return redirect()->back()->withSuccess('Booking Canceled Successfully');
    }

    public function viewVehicleBooking($id) {
        $vehiclebooking = VehicleBooking::findorfail($id);
        return view('admin.viewvehiclebooking',['booking'=>$vehiclebooking]);
    }

    public function tourBookings() {
        $tourbookings = TourPackageBooking::all()->sortByDesc('created_at');
        if(Auth::user()->hasRole('admin')) {
             return view('admin.tourbooking',['tourbookings'=>$tourbookings]);
         } elseif (Auth::user()->hasRole('superadmin')) {
            return view('superadmin.tourbooking',['tourbookings'=>$tourbookings]);
         }
    }


    public function cancelTourBooking($id) {
         $tourbooking = TourPackageBooking::findorfail($id);
        $tourbooking->update([
            'booking_status'=>'canceled'
        ]);
        return redirect()->back()->withSuccess('Booking Canceled Successfully');
    }

    public function viewTourBooking($id) {
        $tourbooking = TourPackageBooking::findorfail($id);
        return view('admin.viewtourbooking',['booking'=>$tourbooking]);
    }

    public function agentList() {
        $u=[];
        $users = User::all();
        foreach($users as $user) {
            if($user->hasRole('agent')) {
                $u[] = $user;
            }
        }
        return view('admin.agents',['users'=>$u]);
    }

    public function agentDetails($id) {
        $user = User::findorfail($id);
        $hotels = Hotel::all();
        $vehicles = Vehicle::all();
        $tours = TourPackage::all();
        $hotelcommissions = AgentHotelCommission::where('user_id',$user->id)->get();
        $vehiclecommissions = AgentVehicleCommission::where('user_id',$user->id)->get();
        $tourcommissions = AgentTourPackageCommission::where('user_id',$user->id)->get();
        return view('admin.agentdetails',['user'=>$user,'hotels'=>$hotels,'tours'=>$tours,'vehicles'=>$vehicles,'hotelcommissions'=>$hotelcommissions,'vehiclecommissions'=>$vehiclecommissions,'tourcommissions'=>$tourcommissions]);
    }

    public function agentBookings($id) {
        $user = User::findorfail($id);
        $hotelbookings = Booking::where('user_id',$user->id)->get();
        $vehiclebookings = VehicleBooking::where('user_id',$user->id)->get();
        $tourbookings = TourPackageBooking::where('user_id',$user->id)->get();
        return view('admin.agentbookings',['hotelbookings'=>$hotelbookings,'vehiclebookings'=>$vehiclebookings,'tourbookings'=>$tourbookings]);
    }
    
}
