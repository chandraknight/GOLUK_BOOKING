<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotel;
use App\Vehicle;
use App\User;
use App\TourPackage;
use App\HotelCommission;
use App\VehicleCommission;
use App\TourPackageCommission;
use App\AgentHotelCommission;
use App\AgentVehicleCommission;
use App\AgentTourPackageCommission;

class CommissionController extends Controller
{
    
   public function assignHotelCommission(Request $request) {
        $hotel = Hotel::findorfail($request->id);
        
        $commission = new HotelCommission;
        $commission->hotel_id = $request->id;
        $commission->commission_percent = $request->commission;

        $commission->save();

        return redirect()->back()->withSuccess('Commission Assigned Successfully');
    }

    public function assignVehicleCommission(Request $request) {
    	$vehicle = Vehicle::findorfail($request->id);

    	$commission = new VehicleCommission;
    	$commission->vehicle_id = $request->id;
    	$commission->commission_percent = $request->commission;

    	$commission->save();

    	return redirect()->back()->withSuccess('Commission Assigned Successfully');
    }

    public function assignTourCommission(Request $request) {
    	$tour = TourPackage::findorfail($request->id);
    	$commission = new TourPackageCommission;

    	$commission->tour_package_id = $request->id;
    	$commission->commission_percent = $request->commission;

    	$commission->save();

    	return redirect()->back()->withSuccess('Commission Assigned Successfully');
    }

    public function assignAgentHotelCommission(Request $request) {
        $user = User::findorfail($request->user_id);
        $hotel = Hotel::findorfail($request->hotel_id);
        $commission = new AgentHotelCommission;

        $commission->user_id = $user->id;
        $commission->hotel_id = $hotel->id;
        $commission->commission_percent = $request->commission;

        $commission->save();

        return redirect()->back()->withSuccess('Commission Assigned Successfully');
    }

    public function assignAgentVehicleCommission(Request $request) {
        $user = User::findorfail($request->user_id);
        $vehicle = Vehicle::findorfail($request->vehicle_id);
        $commission = new AgentVehicleCommission;

        $commission->user_id = $user->id;
        $commission->vehicle_id = $vehicle->id;
        $commission->commission_percent = $request->commission;

        $commission->save();

        return redirect()->back()->withSuccess('Commission Assigned Successfully');
    }

    public function assignAgentTourCommission(Request $request) {
        $user = User::findorfail($request->user_id);
        $tour = TourPackage::findorfail($request->tour_id);
        $commission = new AgentTourPackageCommission;

        $commission->user_id = $user->id;
        $commission->tour_package_id = $tour->id;
        $commission->commission_percent = $request->commission;

        $commission->save();

        return redirect()->back()->withSuccess('Commission Assigned Successfully');
    }

    public function edtAgentHotelCommission($id) {
        $agenthotelcommission = AgentHotelCommission::findorfail($id);
        $user = User::findorfail($agenthotelcommission->user_id);
        return view('admin.editagenthotelcommission',['commission'=>$agenthotelcommission,'user'=>$user]);
    }

    public function updateAgentHotelCommission(Request $request) {
        $hotel = Hotel::findorfail($request->hotel_id);
        $user = User::findorfail($request->user_id);
        $commission = AgentHotelCommission::findorfail($request->commission_id);
        $commission->update([
            'commission_percent'=>$request->commission_percent
        ]);

        return redirect()->route('admin.agent.details',$user->id)->withSuccess('Commission Updated Successfully');
    }

     public function edtAgentTourCommission($id) {
        $agenttourcommission = AgentTourPackageCommission::findorfail($id);
        $user = User::findorfail($agenttourcommission->user_id);
        return view('admin.editagenttourcommission',['commission'=>$agenttourcommission,'user'=>$user]);
    }

    public function updateAgentTourCommission(Request $request) {
        $tour = TourPackage::findorfail($request->tour_id);
        $user = User::findorfail($request->user_id);
        $commission = AgentTourPackageCommission::findorfail($request->commission_id);
        $commission->update([
            'commission_percent'=>$request->commission_percent
        ]);

        return redirect()->route('admin.agent.details',$user->id)->withSuccess('Commission Updated Successfully');
    }

     public function edtAgentVehicleCommission($id) {
        $agentvehiclecommission = AgentVehicleCommission::findorfail($id);
        $user = User::findorfail($agentvehiclecommission->user_id);
        return view('admin.editagentvehiclecommission',['commission'=>$agentvehiclecommission,'user'=>$user]);
    }

    public function updateAgentVehicleCommission(Request $request) {
        $vehicle = Vehicle::findorfail($request->vehicle_id);
        $user = User::findorfail($request->user_id);
        $commission = AgentVehicleCommission::findorfail($request->commission_id);
        $commission->update([
            'commission_percent'=>$request->commission_percent
        ]);

        return redirect()->route('admin.agent.details',$user->id)->withSuccess('Commission Updated Successfully');
    }

     public function agentCommissions($id) {
        $user = User::findorfail($id);
        
        return view('user.commissions',['user'=>$user]);
    }
    
}
