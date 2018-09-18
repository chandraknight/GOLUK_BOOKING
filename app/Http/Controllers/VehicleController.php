<?php

namespace App\Http\Controllers;

use App\Http\Request\VehicleStoreRequest;
use App\Notifications\VehicleRegisteredNotification;
use App\Vehicle;
use App\VehicleService;
use App\VehicleServiceCost;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(){
        $vehicles = Vehicle::where('user_id',Auth::user()->id)->get();
        $user = Auth::user();
        return view('user.vehicles',['vehicles'=>$vehicles,'user'=>$user]);
    }

    public function addVehicle(){
        if(Auth::user()->hasRole('vehicleowner')){
        $types = VehicleType::all();
        $vehicleservices = VehicleService::all();
        $user = Auth::user();
        return view('vehicles.addvehicle',['types'=>$types,'vehicleservices'=>$vehicleservices,'user'=>$user]);
        } else {
            return redirect()->route('welcome');
        }
    }


    public function registerVehicle(VehicleStoreRequest $request){
       dd($request);
        $vehicle = new Vehicle;
        if($request->has('image')){
            $filenamewithext = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $storename = $filename.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/vehicle/',$storename);

            $vehicle->image = $storename;
        }

        if($request->has('sit_pattern')){
            $filenamewithext = $request->file('sit_pattern')->getClientOriginalName();
            $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
            $extension = $request->file('sit_pattern')->getClientOriginalExtension();
            $storename = $filename.time().'.'.$extension;
            $path = $request->file('sit_pattern')->storeAs('public/vehicle/sitpattern/',$storename);

            $vehicle->sit_pattern = $storename;
        }

        $vehicle ->name = $request->name;
        $vehicle ->description = $request->description;
        $vehicle->location = $request->location;
        $vehicle->contact = $request->contact;
        $vehicle->email = $request->email;
        $vehicle->type = $request->type;
        $vehicle->no_of_people = $request->no_of_people;
        $vehicle->rate_per_day = $request->rate_per_day;
        $vehicle->user_id = Auth::user()->id;
        $vehicle->fuel = $request->fuel;
        $vehicle->gear = $request->gear;
        $vehicle->drive_train = $request->drivetrain;
        $vehicle->gps = $request->gps;

       if($vehicle->save()) {
            $vehicle->update([
                'vehicle_code'=>"AL-V-".$vehicle->id
            ]);
           $requestData = collect($request->only('services','services_cost'));
           if($requestData->has('services')){
           $serviceCost = $requestData->transpose()->map(function($guestData){
               return new VehicleServiceCost([
                   'vehicle_service_id'=>$guestData[0],
                   'cost_per_day'=>$guestData[1]
               ]);
           });


           $k = $serviceCost->search(function($item){
               return $item->vehicle_service_id == null;
           });
           if($k) {
               $serviceCost->pull($k);
           }

           $vehicle->vehicleServiceCost()->saveMany($serviceCost);
        }
       }



        $vehicle->services()->sync($request->services);
        $user = Auth::user();
        $admins = User::whereHas('roles', function($q){
                $q->where('name', 'admin');
                })->get();
        foreach($admins as $admin) {
                $admin->notify(new VehicleRegisteredNotification($vehicle, $user));
            }

        return redirect()->route('vehicle.index')->withSuccess('Vehicle Added Successfully');
    }

    public function editVehicle($id){
        $vehicle = Vehicle::findorfail($id);
        if($vehicle->user_id == Auth::user()->id) {
            $user = Auth::user();
            $types = VehicleType::all();
            $services = VehicleService::all();
            return view('vehicles.editvehicle',['vehicle'=>$vehicle,'types'=>$types,'vehicleservices'=>$services,'user'=>$user]);
        } else {
            return redirect()->route('welcome');
        }

    }

    public function updateVehicle(Request $request) {
        $vehicle = Vehicle::findorfail($request->vehicle_id);
        if($vehicle->user_id == Auth::user()->id) {
            if($request->has('image')){
                Storage::disk('public')->delete('vehicle/image/'.$vehicle->image);
                $filenamewithext = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $storename = $filename.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/vehicle/',$storename);

                $vehicle -> update([
                    'image'=>$storename,
                ]);
            }

            if($request->has('sit_pattern')){
                Storage::disk('public')->delete('vehicle/sitpattern/'.$vehicle->sit_pattern);
                $filenamewithext = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenamewithext,PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $storename = $filename.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/vehicle/sitpattern/',$storename);

                $vehicle -> update([
                    'sit_pattern'=>$storename,
                ]);
            }

            $vehicle -> update([
                'name'=>$request->name,
                'description'=>$request->description,
                'location'=>$request->location,
                'type'=>$request->type,
                'no_of_people'=>$request->no_of_people,
                'rate_per_day'=>$request->rate_per_day,
                'fuel'=>$request->fuel,
                'gear'=>$request->gear,
                'drive_train'=>$request->drivetrain,
                'gps'=>$request->gps,
                'vehicle_code'=>"AL-V-".$vehicle->id
            ]);

            if($request->has('services')){
                $vehicle->services()->sync($request->services);
            }

            return redirect()->route('vehicle.index')->withSuccess('Vehicle updated Successfuly');
        } else {
            return redirect()->route('welcome');
        }


    }

    public function viewVehicle($id) {
        $vehicle = Vehicle::findorfail($id);
        if($vehicle->user_id == Auth::user()->id) {
            $user = Auth::user();
            $services = VehicleService::all();
            return view('vehicles.viewvehicle',['vehicle'=>$vehicle,'user'=>$user,'services'=>$services]);
        } else {
            return redirect()->route('welcome');
        }

    }

    public function deleteVehicle($id) {
        $vehicle = Vehicle::findorfail($id);
        if($vehicle->user_id == Auth::user()->id) {
            Storage::disk('public')->delete('vehicle/'.$vehicle->image);
            Storage::disk('public')->delete('vehicle/sitpattern'.$vehicle->sit_pattern);
            $vehicle->delete();
            return redirect()->route('vehicle.index')->withSuccess('Vehicle Successfully Deleted');
        } else {
            return redirect()->route('welcome');
        }

    }

    public function addServices(Request $request) {
        $vehicle = Vehicle::findorfail($request->id);
        if($vehicle->user_id == Auth::user()->id) {
             if($request->has('services')){
                $vehicle->services()->sync($request->services);
            }
            return redirect()->back()->withSuccess('Services Added Successfully');
        } else {
            return redirect()->back();
        } 
    }
}
