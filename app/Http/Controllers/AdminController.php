<?php

namespace App\Http\Controllers;

use App\AgentHotelCommission;
use App\AgentTourPackageCommission;
use App\AgentVehicleCommission;
use App\Booking;
use App\FlightBooking;
use App\Hotel;
use App\TourPackage;
use App\TourPackageBooking;
use App\User;
use App\Vehicle;
use App\VehicleBooking;
use App\VehicleService;
use App\VehicleType;
use App\HotelService;
use App\RoomService;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{

    public function index(){
        return view('admin.index');
    }

    public function hotel() {
        $hotels = Hotel::all();
        return view('admin.hotels',['hotels'=>$hotels]);
    }

    public function hotelData(Request $request) {
        $columns = array(
            0=>'id',
            1=>'hotel_code',
            2=>'name',
            3=>'address',
            4=>'created_at',
            5=>'email',
            6=>'flag',
            7=>'actions'
        );
        $totalData = Hotel::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = Hotel::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            $totalFiltered = Hotel::offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = Hotel::where('name', 'like', "%{$search}%")
                     ->orWhere('hotel_code','like',"%{$search}%")
                     ->orWhere('email','like',"%{$search}%")
                     ->orWhere('address','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = Hotel::where('name', 'like', "%{$search}%")
                            ->orWhere('hotel_code','like',"%{$search}%")
                            ->orWhere('email','like',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
							->count();
		}	


        $data = array();
        if($posts) {
            $c=1;
            // dd($posts);
            foreach($posts as $r) {
                if($r->status == true){
                $status = URL::to(route('admin.hotel.append',$r->id));
                }else {
                $status = URL::to(route('admin.hotel.confirm',$r->id));
                }
                $view = URL::to(route('admin.hotel.view',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['hotel_code'] = $r->hotel_code;
                $nestedData['name'] = "<a href=".$view.">".$r->name."</a>";
                $nestedData['address'] = $r->address;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['email'] = $r->email;
                if($r->flag == false){
                    $nestedData['flag']="Pending";
                } else {
                    $nestedData['flag']="Confirmed";
                }
                if($r->flag == true){
                $nestedData['actions']="<a href=".$status."> <button type='button' class='btn btn-sm btn-gradient-warning btn-rounded'>Deactivate</button></a>";
                } else {
                    $nestedData['actions']="<a href=".$status."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>Activate</button></a>";
                }
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);
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
        return view('admin.vehicles');
    }

    public function vehicleData(Request $request) {
        $columns = array(
            0=>'id',
            1=>'vehicle_code',
            2=>'name',
            3=>'location',
            4=>'created_at',
            5=>'email',
            6=>'flag',
            7=>'actions'
        );
        $totalData = Vehicle::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = Vehicle::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            $totalFiltered = Vehicle::offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = Vehicle::where('name', 'like', "%{$search}%")
                     ->orWhere('vehicle_code','like',"%{$search}%")
                     ->orWhere('email','like',"%{$search}%")
                     ->orWhere('location','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = Vehicle::where('name', 'like', "%{$search}%")
                            ->orWhere('vehicle_code','like',"%{$search}%")
                            ->orWhere('email','like',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
							->count();
		}	


        $data = array();
        if($posts) {
            $c=1;
            // dd($posts);
            foreach($posts as $r) {
                if($r->status == true){
                $status = URL::to(route('admin.vehicle.append',$r->id));
                }else {
                $status = URL::to(route('admin.vehicle.confirm',$r->id));
                }
                $view = URL::to(route('admin.vehicle.view',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['vehicle_code'] = $r->vehicle_code;
                $nestedData['name'] = "<a href=".$view.">".$r->name."</a>";
                $nestedData['location'] = $r->location;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['email'] = $r->email;
                if($r->flag == false){
                    $nestedData['flag']="Pending";
                } else {
                    $nestedData['flag']="Confirmed";
                }
                if($r->flag == true){
                $nestedData['actions']="<a href=".$status."> <button type='button' class='btn btn-sm btn-gradient-warning btn-rounded'>Deactivate</button></a>";
                } else {
                    $nestedData['actions']="<a href=".$status."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>Activate</button></a>";
                }
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);
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
        return view('admin.tours');
    }

    public function tourData(Request $request) {
        $columns = array(
            0=>'id',
            1=>'tour_package_code',
            2=>'name',
            3=>'location',
            4=>'provider',
            5=>'created_at',
            6=>'email',
            7=>'flag',
            8=>'actions'
        );
        $totalData = TourPackage::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = TourPackage::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            $totalFiltered = TourPackage::offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = TourPackage::where('name', 'like', "%{$search}%")
                     ->orWhere('tour_package_code','like',"%{$search}%")
                     ->orWhere('email','like',"%{$search}%")
                     ->orWhere('location','like',"%{$search}%")
                     ->orWhere('provider','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = TourPackage::where('name', 'like', "%{$search}%")
                            ->orWhere('tour_package_code','like',"%{$search}%")
                            ->orWhere('email','like',"%{$search}%")
                            ->orWhere('location','like',"%{$search}%")
                            ->orWhere('provider','like',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
							->count();
		}	


        $data = array();
        if($posts) {
            $c=1;
            // dd($posts);
            foreach($posts as $r) {
                if($r->status == true){
                $status = URL::to(route('admin.tour.append',$r->id));
                }else {
                $status = URL::to(route('admin.tour.confirm',$r->id));
                }
                $view = URL::to(route('admin.tour.view',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['tour_package_code'] = $r->tour_package_code;
                $nestedData['name'] = "<a href=".$view.">".$r->name."</a>";
                $nestedData['location'] = $r->location;
                $nestedData['provider'] = $r->provider;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['email'] = $r->email;
                if($r->flag == false){
                    $nestedData['flag']="Pending";
                } else {
                    $nestedData['flag']="Confirmed";
                }
                if($r->flag == true){
                $nestedData['actions']="<a href=".$status."> <button type='button' class='btn btn-sm btn-gradient-warning btn-rounded'>Deactivate</button></a>";
                } else {
                    $nestedData['actions']="<a href=".$status."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>Activate</button></a>";
                }
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);
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

    public function usersData(Request $request) {
        $columns = array(
            0=>'id',
            1=>'username',
            2=>'email',
            3=>'created_at',
            4=>'rolename',
            5=>'actions'
        );
        $totalData = User::all()->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = DB::table('users')
                    ->select('users.id','users.name as username','users.email','users.created_at','roles.name as rolename')
                    ->join('users_roles','users.id','=','users_roles.user_id')
                    ->join('roles','roles.id','=','users_roles.role_id')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            $totalFiltered = DB::table('users')
                            ->select('users.id','users.name','users.email','users.created_at')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = DB::table('users')
                    ->select('users.id','users.name as username','users.email','users.created_at','roles.name as rolename')
                    ->join('users_roles','users.id','=','users_roles.user_id')
                    ->join('roles','roles.id','=','users_roles.role_id')   
                     ->where('users.name', 'like', "%{$search}%")
                     ->orWhere('users.email','like',"%{$search}%")
                     ->orWhere('roles.name','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = DB::table('users')
                            ->select('users.id','users.name as username','users.email','users.created_at','roles.name as rolename')
                            ->join('users_roles','users.id','=','users_roles.user_id')
                            ->join('roles','roles.id','=','users_roles.role_id')   
                            ->where('users.name', 'like', "%{$search}%")
                            ->orWhere('users.email','like',"%{$search}%")
                            ->orWhere('roles.name','like',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
							->count();
		}	


        $data = array();
        if($posts) {
            $c=1;
            
            foreach($posts as $r) {
                $edit = URL::to(route('admin.user.edit',$r->id));
                $delete = URL::to(route('admin.user.delete',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['username'] = $r->username;
                $nestedData['email'] = $r->email;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['rolename']=$r->rolename;
                $nestedData['actions']="<a href=".$edit."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";
                    $nestedData['actions'].="<a href=".$delete."> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Confirm</button></a>";
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);
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
    
    public function hotelBookingsData(Request $request){
        $columns = array(
            0=>'id',
            1=>'name',
            2=>'hotel_code',
            3=>'customer_name',
            4=>'created_at',
            5=>'booking_from',
            6=>'status',
            7=>'actions'
        );
        $totalData = Booking::with('hotel')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
			$posts = DB::table('bookings')
                    ->join('hotels','bookings.hotel_id', '=', 'hotels.id')
                    ->select('bookings.id','hotels.name', 'hotels.hotel_code','bookings.customer_name','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                    // dd($posts);
            $totalFiltered = DB::table('bookings')
                            ->join('hotels','bookings.hotel_id', '=', 'hotels.id')
                            ->select('bookings.id','hotels.name', 'hotels.hotel_code','bookings.customer_name','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status')
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = DB::table('bookings')
                     ->join('hotels','bookings.hotel_id', '=', 'hotels.id')
                     ->select('bookings.id','hotels.name', 'hotels.hotel_code','bookings.customer_name','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status')
                     ->where('name', 'like', "%{$search}%")
                     ->orWhere('hotel_code','like',"%{$search}%")
                     ->orWhere('customer_name','like',"%{$search}%")
                     ->orWhere('status','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = DB::table('bookings')
                            ->join('hotels','bookings.hotel_id', '=', 'hotels.id')
                            ->select('bookings.id','hotels.name', 'hotels.hotel_code','bookings.customer_name','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status')
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('hotel_code','like',"%{$search}%")
                            ->orWhere('customer_name','like',"%{$search}%")
                            ->orWhere('status','like',"%{$search}%")
							->count();
		}	


        $data = array();
        if($posts) {
            $c=1;
            
            foreach($posts as $r) {
                $viewBooking = URL::to(route('admin.view.hotel.booking',$r->id));
                $confirmBooking = URL::to(route('book.confirm',$r->id));
                $cancelBooking = URL::to(route('booking.cancel',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['name'] = $r->name;
                $nestedData['hotel_code'] = $r->hotel_code;
                $nestedData['customer_name']=$r->customer_name;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['booking_from']=Carbon::parse($r->from_date)->toFormattedDateString().'<i class="mdi mdi-arrow-right-bold"></i>'.
                Carbon::parse($r->till_date)->toFormattedDateString();
                $nestedData['status']=ucfirst($r->status);
                $nestedData['actions']="<a href=".$viewBooking."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";
                if($r->status == 'pending'){
                    $nestedData['actions'].="<a href=".$confirmBooking."> <button type='button' class='btn btn-sm btn-gradient-primary btn-rounded'>Confirm</button></a>";
                    $nestedData['actions'].="<a href=".$cancelBooking."> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Cancel</button></a>";
                } elseif($r->status == 'confirmed'){
                    $nestedData['actions'].="<a href=".$cancelBooking."> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Cancel</button></a>";
                } else {
                    $nestedData['actions'].="<a href=".$confirmBooking."> <button type='button' class='btn btn-sm btn-gradient-primary btn-rounded'>Confirm</button></a>";
                }
                
                    
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);    
    }

    public function viewHotelBooking($id) {
        $booking= Booking::findorfail($id);
        
             return view('admin.viewhotelbooking',['booking'=>$booking]);
    }

    public function vehicleBookings() {
        if(Auth::user()->hasRole('admin')) {
            return view('admin.vehiclebooking');
        } elseif(Auth::user()->hasRole('superadmin')) {
             return view('superadmin.vehiclebooking');
        }
        
    }

    public function vehicleBookingsData(Request $request){
        $columns = array(
            0=>'id',
            1=>'name',
            2=>'vehicle_code',
            3=>'customer_name',
            4=>'created_at',
            5=>'booking_from',
            6=>'route',
            7=>'booking_status',
            8=>'actions'
        );
        $totalData = VehicleBooking::with('vehicle')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
			$posts = DB::table('vehicle_bookings')
                    ->join('vehicles','vehicle_bookings.vehicle_id', '=', 'vehicles.id')
                    ->select('vehicle_bookings.id','vehicles.name', 'vehicles.vehicle_code','vehicle_bookings.customer_name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                    // dd($posts);
            $totalFiltered = DB::table('vehicle_bookings')
                            ->join('vehicles','vehicle_bookings.vehicle_id', '=', 'vehicles.id')
                            ->select('vehicle_bookings.id','vehicles.name', 'vehicles.vehicle_code','vehicle_bookings.customer_name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status')
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = DB::table('vehicle_bookings')
                    ->join('vehicles','vehicle_bookings.vehicle_id', '=', 'vehicles.id')
                    ->select('vehicle_bookings.id','vehicles.name', 'vehicles.vehicle_code','vehicle_bookings.customer_name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status')
                     ->where('name', 'like', "%{$search}%")
                     ->orWhere('vehicle_code','like',"%{$search}%")
                     ->orWhere('customer_name','like',"%{$search}%")
                     ->orWhere('status','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = DB::table('vehicle_bookings')
                            ->join('vehicles','vehicle_bookings.vehicle_id', '=', 'vehicles.id')
                            ->select('vehicle_bookings.id','vehicles.name', 'vehicles.vehicle_code','vehicle_bookings.customer_name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status')
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('vehicle_code','like',"%{$search}%")
                            ->orWhere('customer_name','like',"%{$search}%")
                            ->orWhere('status','like',"%{$search}%")
							->count();
		}	



        $data = array();
        if($posts) {
            $c=1;
            
            foreach($posts as $r) {
                $viewBooking = URL::to(route('admin.view.vehicle.booking',$r->id));
                $confirmBooking = URL::to(route('confirmvehiclebooking',$r->id));
                $cancelBooking = URL::to(route('cancelvehiclebooking',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['name'] = $r->name;
                $nestedData['vehicle_code'] = $r->vehicle_code;
                $nestedData['customer_name']=$r->customer_name;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['booking_from']=Carbon::parse($r->from)->toFormattedDateString().'<i class="mdi mdi-arrow-right-bold"></i>'.
                Carbon::parse($r->to)->toFormattedDateString();
                $nestedData['route']=ucfirst($r->location).'<i class="mdi mdi-arrow-right-bold"></i>'.ucfirst($r->destination);
                $nestedData['booking_status']=ucfirst($r->booking_status);
                $nestedData['actions']="<a href=".$viewBooking."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";
                if($r->booking_status == 'pending'){
                    $nestedData['actions'].="<a href=".$confirmBooking."> <button type='button' class='btn btn-sm btn-gradient-primary btn-rounded'>Confirm</button></a>";
                    $nestedData['actions'].="<a href=".$cancelBooking."> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Cancel</button></a>";
                } elseif($r->booking_status == 'confirmed'){
                    $nestedData['actions'].="<a href=".$cancelBooking."> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Cancel</button></a>";
                } else {
                    $nestedData['actions'].="<a href=".$confirmBooking."> <button type='button' class='btn btn-sm btn-gradient-primary btn-rounded'>Confirm</button></a>";
                }
                
                    
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);
    }

    public function viewVehicleBooking($id) {
        $vehiclebooking = VehicleBooking::findorfail($id);
        return view('admin.viewvehiclebooking',['booking'=>$vehiclebooking]);
    }

    public function tourBookings() {
        $tourbookings = TourPackageBooking::all()->sortByDesc('created_at');
        if(Auth::user()->hasRole('admin')) {
             return view('admin.tourbooking');
         } elseif (Auth::user()->hasRole('superadmin')) {
            return view('superadmin.tourbooking');
         }
    }

    public function tourBookingsData(Request $request) {
        $columns = array(
            0=>'id',
            1=>'name',
            2=>'tour_package_code',
            3=>'provider',
            4=>'customer_name',
            5=>'created_at',
            6=>'booking_from',
            7=>'booking_status',
            8=>'actions'
        );
        $totalData = TourPackageBooking::with('tourPackage')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
			$posts = DB::table('tour_package_bookings')
                    ->join('tour_packages','tour_package_bookings.tour_package_id', '=', 'tour_packages.id')
                    ->select('tour_package_bookings.id','tour_packages.name','tour_packages.tour_package_code', 'tour_packages.provider','tour_package_bookings.customer_name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_package_bookings.booking_status')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                    // dd($posts);
            $totalFiltered = DB::table('tour_package_bookings')
                            ->join('tour_packages','tour_package_bookings.tour_package_id', '=', 'tour_packages.id')
                            ->select('tour_package_bookings.id','tour_packages.name','tour_packages.tour_package_code', 'tour_packages.provider','tour_package_bookings.customer_name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_package_bookings.booking_status')
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = DB::table('tour_package_bookings')
                    ->join('tour_packages','tour_package_bookings.tour_package_id', '=', 'tour_packages.id')
                    ->select('tour_package_bookings.id','tour_packages.name','tour_packages.tour_package_code', 'tour_packages.provider','tour_package_bookings.customer_name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_package_bookings.booking_status')
                     ->where('name', 'like', "%{$search}%")
                     ->orWhere('tour_package_code','like',"%{$search}%")
                     ->orWhere('customer_name','like',"%{$search}%")
                     ->orWhere('booking_status','like',"%{$search}%")
                     ->orWhere('provider','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = DB::table('tour_package_bookings')
                                ->join('tour_packages','tour_package_bookings.tour_package_id', '=', 'tour_packages.id')
                                ->select('tour_package_bookings.id','tour_packages.name','tour_packages.tour_package_code', 'tour_packages.provider','tour_package_bookings.customer_name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_package_bookings.booking_status')
                                 ->where('name', 'like', "%{$search}%")
                                 ->orWhere('tour_package_code','like',"%{$search}%")
                                 ->orWhere('customer_name','like',"%{$search}%")
                                 ->orWhere('booking_status','like',"%{$search}%")
                                 ->orWhere('provider','like',"%{$search}%")
							    ->count();
		}	


        $data = array();
        if($posts) {
            $c=1;
            
            foreach($posts as $r) {
                $viewBooking = URL::to(route('admin.view.tour.booking',$r->id));
                $confirmBooking = URL::to(route('tour.confirm',$r->id));
                $cancelBooking = URL::to(route('tour.cancel',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['name'] = $r->name;
                $nestedData['tour_package_code'] = $r->tour_package_code;
                $nestedData['provider'] = $r->provider;
                $nestedData['customer_name']=$r->customer_name;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['booking_from']=Carbon::parse($r->starting_from)->toFormattedDateString().'<i class="mdi mdi-arrow-right-bold"></i>'.
                Carbon::parse($r->till_date)->toFormattedDateString();
                $nestedData['booking_status']=ucfirst($r->booking_status);
                $nestedData['actions']="<a href=".$viewBooking."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";
                if($r->booking_status == 'pending'){
                    $nestedData['actions'].="<a href=".$confirmBooking."> <button type='button' class='btn btn-sm btn-gradient-primary btn-rounded'>Confirm</button></a>";
                    $nestedData['actions'].="<a href=".$cancelBooking."> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Cancel</button></a>";
                } elseif($r->booking_status == 'confirmed'){
                    $nestedData['actions'].="<a href=".$cancelBooking."> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Cancel</button></a>";
                } else {
                    $nestedData['actions'].="<a href=".$confirmBooking."> <button type='button' class='btn btn-sm btn-gradient-primary btn-rounded'>Confirm</button></a>";
                }
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);    
    }


    public function viewTourBooking($id) {
        $tourbooking = TourPackageBooking::findorfail($id);
        return view('admin.viewtourbooking',['booking'=>$tourbooking]);
    }

    public function agentList() {
        return view('admin.agents');
    }

    public function agentListData(Request $request) {
        $columns = array(
            0=>'id',
            1=>'name',
            2=>'email',
            3=>'created_at',
            8=>'actions'
        );
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = DB::table('users')
                    ->join('users_roles','users.id','=','users_roles.user_id')
                    ->join('roles','users_roles.role_id','=','roles.id')
                    ->select('users.id','users.name','users.email','users.created_at')
                    ->where('roles.name','=','agent')
                    ->count();
        if(empty($request->input('search.value'))){
            $posts = DB::table('users')
                    ->join('users_roles','users.id','=','users_roles.user_id')
                    ->join('roles','users_roles.role_id','=','roles.id')
                    ->select('users.id','users.name','users.email','users.created_at')
                    ->where('roles.name','=','agent')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            $totalFiltered = DB::table('users')
                            ->join('users_roles','users.id','=','users_roles.user_id')
                            ->join('roles','users_roles.role_id','=','roles.id')
                            ->select('users.id','users.name','users.email','users.created_at')
                            ->where('roles.name','=','agent')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->count();
		}else{
			$search = $request->input('search.value');
            $posts = DB::table('users')
                    ->join('users_roles','users.id','=','users_roles.user_id')
                    ->join('roles','users_roles.role_id','=','roles.id')
                    ->select('users.id','users.name','users.email','users.created_at')
                    ->where('roles.name','=','agent')
                     ->orWhere('users.name','like',"%{$search}%")
                     ->orWhere('users.email','like',"%{$search}%")
                     ->offset($start)
                     ->limit($limit)
                     ->orderBy($order, $dir)
                     ->get();
			$totalFiltered = DB::table('users')
                            ->join('users_roles','users.id','=','users_roles.user_id')
                            ->join('roles','users_roles.role_id','=','roles.id')
                            ->select('users.id','users.name','users.email','users.created_at')
                            ->where('roles.name','=','agent')
                            ->orWhere('name','like',"%{$search}%")
                            ->orWhere('email','like',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->count();
		}	



        $data = array();
        if($posts) {
            $c=1;
            
            foreach ($posts as $r) {
                $viewBooking = URL::to(route('admin.agent.booking',$r->id));
                $viewDetails = URL::to(route('admin.agent.details',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['name'] = $r->name;
                $nestedData['email'] = $r->email;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                    $nestedData['actions']="<a href=".$viewBooking."> <button type='button' class='btn btn-sm btn-gradient-primary btn-rounded'>Bookings</button></a>";
                    $nestedData['actions'].="<a href=".$viewDetails."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>Details</button></a>";
                 $data[]=$nestedData;
                 $c++;
            }
        }
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);
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

    public function hotelServices() {
        // dd('asdasdas');
        $services = HotelService::all();
        return view('admin.hotelservices',['services'=>$services]);
    }

    public function editHotelService($id) {
        $service = HotelService::findorfail($id);
        return view('admin.edithotelservice',['service'=>$service]);
    }

    public function roomServices() {
        // dd('roomservices');
        $services = RoomService::all();
        return view('admin.roomservices',['services'=>$services]);
    }

    public function editRoomService($id) {
        $service = RoomService::findorfail($id);
        return view('admin.editroomservice',['service'=>$service]);
    }

    public function flightBooking(){
        $bookings = FlightBooking::all()->sortByDesc('created_at');
        return view('admin.flightbooking',['bookings'=>$bookings]);
    }

    public function flightBookingsData(Request $request){
        dd($request);
        $columns = array(
            0=>'id',
            1=>'customer_name',
            2=>'customer_contact',
            3=>'customer_email',
            4=>'adults',
            5=>'childs',
            6=>'amount',
            7=>'commission',
            8=>'actions'
        );
        $totalData = FlightBooking::all()->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $posts = DB::table('flight_bookings')
                ->select('flight_bookings.id','flight_bookings.customer_name', 'flight_bookings.customer_contact','flight_bookings.customer_email','flight_bookings.adults','flight_bookings.childs','flight_bookings.amount','flight_bookings.commission')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            // dd($posts);
            $totalFiltered = DB::table('flight_bookings')
                ->select('flight_bookings.id','flight_bookings.customer_name', 'flight_bookings.customer_contact','flight_bookings.customer_email','flight_bookings.adults','flight_bookings.childs','flight_bookings.amount','flight_bookings.commission')
                ->count();
        }else{
            $search = $request->input('search.value');
            $posts = DB::table('flight_bookings')
                ->select('flight_bookings.id','flight_bookings.customer_name', 'flight_bookings.customer_contact','flight_bookings.customer_email','flight_bookings.adults','flight_bookings.child','flight_bookings.amount','flight_bookings.commission')
                ->where('customer_name', 'like', "%{$search}%")
                ->orWhere('customer_contact','like',"%{$search}%")
                ->orWhere('customer_email','like',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = DB::table('flight_bookings')
                ->select('flight_bookings.id', 'flight_bookings.customer_name', 'flight_bookings.customer_contact', 'flight_bookings.customer_email', 'flight_bookings.adults', 'flight_bookings.child', 'flight_bookings.amount', 'flight_bookings.commission')
                ->where('customer_name', 'like', "%{$search}%")
                ->orWhere('customer_contact', 'like', "%{$search}%")
                ->orWhere('customer_email', 'like', "%{$search}%")
                ->count();
        }


        $data = array();
        if($posts) {
            $c=1;

            foreach($posts as $r) {
                $viewBooking = URL::to(route('admin.view.flight.booking',$r->id));
                $nestedData['id']=$r->id;
                $nestedData['customer_name']=$r->customer_name;
                $nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
                $nestedData['actions']="<a href=".$viewBooking."> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";

                $data[]=$nestedData;
                $c++;
            }
        }
        dd($posts);
        $json_data = array(
            "draw"=>intval($request->input('draw')),
            "recordsTotal"=>intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"=>$data
        );
        echo json_encode($json_data);
    }
    
}
