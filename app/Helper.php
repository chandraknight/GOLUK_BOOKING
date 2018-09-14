<?php 
namespace App;
use Carbon\Carbon;

class Helper {
	static function getWeeklyHotelBookings($id) {
		$hotel = Hotel::findorfail($id);
		$bookings = Booking::where('created_at','>',Carbon::now()->subWeek())->where('hotel_id',$hotel->id)->get();
		$weekbookings = $bookings->count();
		return $weekbookings;
	}

	static function getTotalHotelBookings($id) {
		$hotel = Hotel::findorfail($id);
		$bookings = Booking::where('hotel_id',$hotel->id)->get();
		$totalbookings = $bookings->count();
		return $totalbookings;
	}

	static function getWeeklyVehicleBookings($id) {
		$vehicle = Vehicle::findorfail($id);
		$bookings = VehicleBooking::where('vehicle_id',$vehicle->id)->where('created_at','>',Carbon::now()->subWeek())->get();
		$count = $bookings->count();
		return $count;
	}

	static function getTotalVehicleBookings($id) {
		$vehicle = Vehicle::findorfail($id);
		$bookings = VehicleBooking::where('vehicle_id',$vehicle->id)->get();
		$totalbookings = $bookings->count();
		return $totalbookings;
	}

	static function getWeeklyTourBookings($id) {
		$tour = TourPackage::findorfail($id);
		$bookings = TourPackageBooking::where('tour_package_id',$tour->id)->where('created_at','>',Carbon::now()->subWeek())->get();
		$count = $bookings->count();
		return $count;
	}

	static function getTotalTourBookings($id) {
		$tour = TourPackage::findorfail($id);
		$bookings = TourPackageBooking::where('tour_package_id',$tour->id)->get();
		$totalbookings = $bookings->count();
		return $totalbookings;
	}

	static function getUsersWithRole($role) {
        $users = User::all();
        $u =[];
        foreach($users as $user) {
            if($user->hasRoles($role)) {
                $u = $user;
            }
		}
        return $u;

    }
}
?>