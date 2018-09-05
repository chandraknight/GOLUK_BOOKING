<?php

namespace App\Http\Controllers;
use App\Hotel;
use App\HotelService;
use Auth;
use Illuminate\Http\Request;

class HotelServiceController extends Controller
{
    public function index($id){
        if(Auth::user()->hasRole('hotelowner')){
            $hotel = Hotel::findorfail($id);
            $user = Auth::user();
        	$services = HotelService::where('hotel_id',$hotel->id);
        	return view('services.index',['services'=>$services,'user'=>$user,'hotel'=>$hotel]);
        }
    }

    public function store(Request $request) {
    	$service = new HotelService;

        $service->service_name = $request->service_name;
        $service->service_time = $request->service_time;
        $service->service_type = $request->service_type;
        $service->service_cost = $request->service_cost;
        $service->service_cost_unit = $request->service_cost_unit;
        $service->service_description = $request->service_description;
        $service->service_remarks = $request->service_remarks;
        $service->service_enable = $request->service_enable;
        $service->service_created_by = Auth()->user()->id;
        $service->service_last_updated_by = Auth()->user()->id; 

        $service->save();
        return redirect()->route('service.index')->with('success','Service registered Successfully'); 
    }

    public function edit($id){
    	$service = HotelService::findorfail($id);
        if(Auth()->user()->id == $service->service_created_by){
            return view('services.update',['service'=>$service
            ]);
        }
        else {
            return view('services.index')->with('error','Permission Denied');
        }
    }

    public function update(Request $request){
        $service = HotelService::findorfail($request->id);
        if(Auth()->user()->id == $service->service_created_by) {
            $service -> update([
                'service_name' => $request->service_name,
                'service_type' => $request->service_type,
                'service_time' => $request->service_time,
                'service_cost' => $request->service_cost,
                'service_cost_unit' => $request->service_cost_unit,
                'service_description' => $request->service_description,
                'service_remarks' => $request->service_remarks,
                'service_enable' => $request->service_enable,
                'service_last_updated_by' => Auth()->user()->id,
            ]);
            return redirect()->route('service.index')->with('success','Service Successfully updated');
        } else {
            return redirect()->route('service.index')->with('error','Permission Denied');
        }
        
    }

    public function delete($id) {
        $service = HotelService::findorfail($id);
        if(Auth()->user()->id == $service->service_created_by) {
            $service->delete();
            return redirect()->route('service.index')->with('success','Successfully Deleted');
        } else {
            return redirect()->route('service.index')->with('error','Permission Denied');
        }
    }
}
