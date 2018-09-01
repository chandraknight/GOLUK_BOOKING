<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Booking;
use App\TourPackageBooking;
use App\VehicleBooking;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

   public function userHotelBooking(Request $request) {
	$columns = array(
		0=>'id',
		1=>'hotel_code',
		2=>'name',
		3=>'address',
		4=>'created_at',
		5=>'booking_from',
		6=>'amount',
		7=>'current',
		5=>'actions'
	);
	$totalData = Booking::Where('user_id',Auth::user()->id)->count();
	$limit = $request->input('length');
	$start = $request->input('start');
	$order = $columns[$request->input('order.0.column')];
	$dir = $request->input('order.0.dir');

	if(empty($request->input('search.value'))){
		$posts = DB::table('bookings')
				->where('user_id',Auth::user()->id)
				->join('hotels','bookings.hotel_id','=','hotels.id')
				->join('invoices','bookings.id','=','invoices.booking_id')
				->select('bookings.id','hotels.name','hotels.hotel_code','hotels.address','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status','invoices.amount')
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();
		$totalFiltered = DB::table('bookings')
						->where('user_id',Auth::user()->id)
						->join('hotels','bookings.hotel_id','=','hotels.id')
						->join('invoices','bookings.id','=','invoices.booking_id')
						->select('hotels.name','hotels.hotel_code','hotels.address','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status','invoices.amount')
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->count();
	}else{
		$search = $request->input('search.value');
		$posts = DB::table('bookings')
				->where('user_id',Auth::user()->id)
				->join('hotels','bookings.hotel_id','=','hotels.id')
				->join('invoices','bookings.id','=','invoices.booking_id')
				->select('bookings.id','hotels.name','hotels.hotel_code','hotels.address','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status','invoices.amount')
				 ->orWhere('name', 'like', "%{$search}%")
				 ->orWhere('hotel_code','like',"%{$search}%")
				 ->orWhere('address','like',"%{$search}%")
				 ->offset($start)
				 ->limit($limit)
				 ->orderBy($order, $dir)
				 ->get();
				//  dd($search);
		$totalFiltered = DB::table('bookings')
						->where('user_id',Auth::user()->id)
						->join('hotels','bookings.hotel_id','=','hotels.id')
						->join('invoices','bookings.id','=','invoices.booking_id')
						->select('bookings.id','hotels.name','hotels.hotel_code','hotels.address','bookings.created_at','bookings.from_date','bookings.till_date','bookings.status','invoices.amount')
						->orWhere('name', 'like', "%{$search}%")
						->orWhere('hotel_code','like',"%{$search}%")
						->orWhere('address','like',"%{$search}%")
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->count();
	}	


	$data = array();
	if($posts) {
		$c=1;
		
		foreach($posts as $r) {
			
			$nestedData['id']=$r->id;
			$nestedData['hotel_code'] = $r->hotel_code;
			$nestedData['name'] = $r->name;
			$nestedData['address'] = $r->address;
			$nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
			$nestedData['booking_from'] = Carbon::parse($r->from_date)->toFormattedDateString(). "<i class='fa fa-long-arrow-right'></i>". Carbon::parse($r->till_date)->toFormattedDateString();
			$nestedData['amount']=$r->amount;
			if(Carbon::parse($r->from_date)->eq(Carbon::yesterday())){
			$nestedData['current']="<td class='text-center'><i class='fa fa-check'></i></td>";
			}else{
			 $nestedData['current']="<td class='text-center'><i class='fa fa-times-circle'></i></td>";
			}	
			$nestedData['actions']="<a href='#'> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";
				$nestedData['actions'].="<a href='#'> <button type='button' class='btn btn-sm btn-gradient-danger btn-rounded'>Confirm</button></a>";
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

   public function userVehicleBooking(Request $request) {
	//    dd($request->all());
	$columns = array(
		0=>'id',
		1=>'vehicle_code',
		2=>'name',
		3=>'created_at',
		4=>'booking_from',
		5=>'route',
		6=>'cost',
		7=>'current',
		8=>'actions'
	);
	$totalData = VehicleBooking::Where('user_id',Auth::user()->id)->count();
	$limit = $request->input('length');
	$start = $request->input('start');
	$order = $columns[$request->input('order.0.column')];
	$dir = $request->input('order.0.dir');

	if(empty($request->input('search.value'))){
		$posts = DB::table('vehicle_bookings')
				->select('vehicle_bookings.id','vehicle_bookings.user_id','vehicles.vehicle_code','vehicles.name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status','vehicle_booked_invoices.cost')
				->join('vehicles','vehicle_bookings.vehicle_id','=','vehicles.id')
				->join('vehicle_booked_invoices','vehicle_bookings.id','=','vehicle_booked_invoices.vehicle_booking_id')
				
				->where('vehicle_bookings.user_id',Auth::user()->id)
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();
		$totalFiltered = DB::table('vehicle_bookings')
						->select('vehicle_bookings.id','vehicle_bookings.user_id','vehicles.vehicle_code','vehicles.name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status','vehicle_booked_invoices.cost')
						->join('vehicles','vehicle_bookings.vehicle_id','=','vehicles.id')
						->join('vehicle_booked_invoices','vehicle_bookings.id','=','vehicle_booked_invoices.vehicle_booking_id')
						
						->where('vehicle_bookings.user_id',Auth::user()->id)
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->count();
	}else{
		$search = $request->input('search.value');
		$posts = DB::table('vehicle_bookings')
				->select('vehicle_bookings.id','vehicles.vehicle_code','vehicles.name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status','vehicle_booked_invoices.cost')
				->join('vehicles','vehicle_bookings.vehicle_id','=','vehicles.id')
				->join('vehicle_booked_invoices','vehicle_bookings.id','=','vehicle_booked_invoices.vehicle_booking_id')				
				 ->where('vehicle_bookings.user_id',Auth::user()->id)
				 ->where('name', 'like', "%{$search}%")
				 ->orWhere('vehicle_code','like',"%{$search}%")
				 ->orWhere('vehicle_bookings.location','like',"%{$search}%")
				 ->orWhere('destination','like',"%{$search}%")
				 ->offset($start)
				 ->limit($limit)
				 ->orderBy($order, $dir)
				 ->get();
		$totalFiltered =DB::table('vehicle_bookings')
						->select('vehicle_bookings.id','vehicles.vehicle_code','vehicles.name','vehicle_bookings.created_at','vehicle_bookings.from','vehicle_bookings.to','vehicle_bookings.location','vehicle_bookings.destination','vehicle_bookings.booking_status','vehicle_booked_invoices.cost')					
						->join('vehicles','vehicle_bookings.vehicle_id','=','vehicles.id')
						->join('vehicle_booked_invoices','vehicle_bookings.id','=','vehicle_booked_invoices.vehicle_booking_id')
						->where('vehicle_bookings.user_id',Auth::user()->id)
						->where('name', 'like', "%{$search}%")
						->orWhere('vehicle_code','like',"%{$search}%")
						->orWhere('vehicle_bookings.location','like',"%{$search}%")
						->orWhere('destination','like',"%{$search}%")
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->count();
	}	


	$data = array();
	if($posts) {
		$c=1;
		
		foreach($posts as $r) {
			
			$nestedData['id']=$r->id;
			$nestedData['vehicle_code'] = $r->vehicle_code;
			$nestedData['name'] = $r->name;
			$nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
			$nestedData['booking_from'] = Carbon::parse($r->from)->toFormattedDateString(). "<i class='fa fa-long-arrow-right'></i>". Carbon::parse($r->to)->toFormattedDateString();
			$nestedData['route']= $r->location."<i class='fa fa-long-arrow-right'></i>".$r->destination;
			$nestedData['cost']=$r->cost;
			if(Carbon::parse($r->from)->eq(Carbon::yesterday())){
			$nestedData['current']="<td class='text-center'><i class='fa fa-check'></i></td>";
			}else{
			 $nestedData['current']="<td class='text-center'><i class='fa fa-times-circle'></i></td>";
			}	
			$nestedData['actions']="<a href='#'> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";
				
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

   public function userTourBooking(Request $request) {
	$columns = array(
		0=>'id',
		1=>'tour_package_code',
		2=>'name',
		3=>'location',
		4=>'created_at',
		5=>'booking_from',
		6=>'amount',
		7=>'current',
		8=>'actions'
	);
	$totalData = TourPackageBooking::Where('user_id',Auth::user()->id)->count();
	$limit = $request->input('length');
	$start = $request->input('start');
	$order = $columns[$request->input('order.0.column')];
	$dir = $request->input('order.0.dir');

	if(empty($request->input('search.value'))){
		$posts = DB::table('tour_package_bookings')
				->select('tour_package_bookings.id','tour_package_bookings.user_id','tour_packages.tour_package_code','tour_packages.name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_packages.location','tour_package_bookings.booking_status','tour_booked_invoices.amount')
				->join('tour_packages','tour_package_bookings.tour_package_id','=','tour_packages.id')
				->join('tour_booked_invoices','tour_package_bookings.id','=','tour_booked_invoices.tour_package_booking_id')
				->where('tour_package_bookings.user_id',Auth::user()->id)
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();
		$totalFiltered = DB::table('tour_package_bookings')
						->select('tour_package_bookings.id','tour_package_bookings.user_id','tour_packages.tour_package_code','tour_packages.name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_packages.location','tour_package_bookings.booking_status','tour_booked_invoices.amount')
						->join('tour_packages','tour_package_bookings.tour_package_id','=','tour_packages.id')
						->join('tour_booked_invoices','tour_package_bookings.id','=','tour_booked_invoices.tour_package_booking_id')
						->where('tour_package_bookings.user_id',Auth::user()->id)
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->count();
	}else{
		$search = $request->input('search.value');
		$posts =  DB::table('tour_package_bookings')
				->select('tour_package_bookings.id','tour_package_bookings.user_id','tour_packages.tour_package_code','tour_packages.name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_packages.location','tour_package_bookings.booking_status','tour_booked_invoices.amount')
				->join('tour_packages','tour_package_bookings.tour_package_id','=','tour_packages.id')
				->join('tour_booked_invoices','tour_package_bookings.id','=','tour_booked_invoices.tour_package_booking_id')
				->where('tour_package_bookings.user_id',Auth::user()->id)
				 ->orWhere('name', 'like', "%{$search}%")
				 ->orWhere('tour_package_code','like',"%{$search}%")
				 ->orWhere('tour_packages.location','like',"%{$search}%")
				 ->offset($start)
				 ->limit($limit)
				 ->orderBy($order, $dir)
				 ->groupBy('tour_package_bookings.id')
				 ->get();
				//  dd($posts);
		$totalFiltered = DB::table('tour_package_bookings')
						->select('tour_package_bookings.id','tour_package_bookings.user_id','tour_packages.tour_package_code','tour_packages.name','tour_package_bookings.created_at','tour_package_bookings.starting_from','tour_package_bookings.till_date','tour_packages.location','tour_package_bookings.booking_status','tour_booked_invoices.amount')
						->join('tour_packages','tour_package_bookings.tour_package_id','=','tour_packages.id')
						->join('tour_booked_invoices','tour_package_bookings.id','=','tour_booked_invoices.tour_package_booking_id')
						->where('tour_package_bookings.user_id',Auth::user()->id)
						->orWhere('name', 'like', "%{$search}%")
						->orWhere('tour_package_code','like',"%{$search}%")
						->orWhere('tour_packages.location','like',"%{$search}%")
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->groupBy('tour_package_bookings.id')
						->count();
	}	


	$data = array();
	if($posts) {
		$c=1;
		
		foreach($posts as $r) {
			
			$nestedData['id']=$r->id;
			$nestedData['tour_package_code'] = $r->tour_package_code;
			$nestedData['name'] = $r->name;
			$nestedData['location']=$r->location;
			$nestedData['created_at']=Carbon::parse($r->created_at)->toFormattedDateString();
			$nestedData['booking_from'] = Carbon::parse($r->starting_from)->toFormattedDateString(). "<i class='fa fa-long-arrow-right'></i>". Carbon::parse($r->till_date)->toFormattedDateString();
			$nestedData['amount']=$r->amount;
			if(Carbon::parse($r->starting_from)->eq(Carbon::yesterday())){
			$nestedData['current']="<td class='text-center'><i class='fa fa-check'></i></td>";
			}else{
			 $nestedData['current']="<td class='text-center'><i class='fa fa-times-circle'></i></td>";
			}	
			$nestedData['actions']="<a href='#'> <button type='button' class='btn btn-sm btn-gradient-success btn-rounded'>View</button></a>";
				
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
}
