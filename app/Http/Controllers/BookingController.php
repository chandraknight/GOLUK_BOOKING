<?php

namespace App\Http\Controllers;

use App\BookedRoom;
use App\Booking;
use App\BookingDetail;
use App\HotelBookingCommission;
use App\VehicleBookingCommission;
use App\TourBookingCommission;
use App\Events\Booking\BookConfirmSendMailEvent;
use App\Events\Booking\RoomBookedSendMailEvent;
use App\Events\Booking\TourBookedEvent;
use App\Events\Booking\VehicleBookingConfirmEvent;
use App\Events\Booking\VehicleBookingMailOwnerEvent;
use App\Events\Booking\TourBookConfirmEvent;
use App\AgentHotelBookingCommission;
use App\AgentVehicleBookingCommission;
use App\AgentTourPackageBookingCommission;
use App\Events\PaymentConfirmMailEvent;
use App\Hotel;

use App\Invoice;
use App\Notifications\RoomBooked;
use App\Notifications\TourBookedNotification;
use App\Notifications\VehicleBooked;
use App\TourBookedInvoice;
use App\TourPackage;
use App\TourPackageBooking;
use App\TourPackageBookingDetails;
use App\TourSearch;
use App\User;
use App\Vehicle;
use App\VehicleBookedInvoice;
use App\VehicleBooking;
use App\VehicleBookingDetails;
use App\VehicleServiceCost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Auth;

class BookingController extends Controller
{
    public function index($id)
    {
        $hotel = Hotel::findorfail($id);
        if ($hotel->created_by == Auth()->user()->id) {
            $bookings = Booking::where('hotel_id', $id)->get();
            $user = Auth::user();
            return view('hotels.bookings', ['bookings' => $bookings,'user'=>$user,'hotel'=>$hotel]);
        } else {
            return redirect()->route('home');
        }

    }

    public function bookingDetails($id)
    {
        $user = Auth::user();
        $booking = Booking::findorfail($id);
        
        $bookingdetails = BookingDetail::where('booking_id', '=', $id)->get();
        return view('hotels.bookdetails', ['bookingdetails' => $bookingdetails, 'booking' => $booking,'user'=>$user]);
    }

    
    public function bookConfirm($id)
    {
        $booking = Booking::findorfail($id);
        $hotel = Hotel::where('id', $booking->hotel_id)->first();
        $booking->update([
            'status' => 'confirmed'
        ]);

        $c = $hotel->hotelCommission['commission_percent'];
        $commission = ($booking->invoice->amount*$c)/100;
        
        $hotelcommission = new HotelBookingCommission;
        $hotelcommission->hotel_booking_id = $booking->id;
        $hotelcommission->total_amount = $booking->invoice->amount;
        $hotelcommission->commission_percent = $c;
        $hotelcommission->commission = $commission;

        $hotelcommission->save();
        if($booking->user_id != null){
            if($booking->user->hasRole('agent')) {
                if($booking->user->agentHotelCommission->where('hotel_id',$hotel->id)->first() != null){
                    $agentcommission = new AgentHotelBookingCommission;
                    $agentcommission->booking_id = $booking->id;
                    $agentcommission->user_id = $booking->user->id;
                    $agentcommission->hotel_commission_percent = $hotel->hotelCommission->commission_percent;
                    $g=$booking->user->agentHotelCommission->where('hotel_id',$hotel->id)->first();
                    $agentcommission->agent_commission_percent = $g->commission_percent;
                    
                    $agentcommission->commission = ($commission*$g->commission_percent)/100;

                    $agentcommission->save();
                }
            }
        }
        
        event(new BookConfirmSendMailEvent($hotel, $booking));
        return redirect()->back()->with('success', 'Booking Confirmed');
    }

    
    public function register(Request $request)
    {
        $hotel = Hotel::where('id', '=', $request->hotel_id)->first();
        $user = User::where('id', '=', $hotel->created_by)->first();

        $booking = new Booking;
        $booking->customer_name = $request->customer_name;
        $booking->customer_phone = $request->customer_number;
        $booking->customer_address = $request->customer_address;
        $booking->customer_email = $request->customer_email;
        $booking->hotel_id = $request->hotel_id;
        $booking->no_rooms = $request->no_rooms;
        $booking->no_adults = $request->no_adults;
        $booking->no_childs = $request->no_childs;
        $booking->from_date = $request->from_date;
        $booking->till_date = $request->till_date;
        if(Auth::user()){
            $booking->user_id = Auth::user()->id;
        }

        if ($booking->save()) {
            $requestData = collect($request->only(
                'guest',
                'address',
                'gender',
                'dob',
                'adult_child',
                'remarks'
            ));
            $booking_details = $requestData->transpose()->map(function ($guestData) {
                return new BookingDetail([
                    'guest_name' => $guestData[0],
                    'address' => $guestData[1],
                    'gender' => $guestData[2],
                    'date_of_birth' => $guestData[3],
                    'adult_child' => $guestData[4],
                    'remarks' => $guestData[5]
                ]);

            });
            $k = $booking_details->search(function ($item) {
                return $item->guest_name == null;
            });
            if($k){
                $booking_details->pull($k);
            }

            $booking->bookingDetails()->saveMany($booking_details);

            $requestRoom = collect($request->only(
                'room',
                'roomtype',
                'plan',
                'rate',
                'no_of_rooms'
            ));

            $booked_rooms_details = $requestRoom->transpose()->map(function ($roomdata) {

                return new BookedRoom([
                    'room_id' => $roomdata[0],
                    'room_type' => $roomdata[1],
                    'plan' => $roomdata[2],
                    'rate'=>$roomdata[3],
                    'no_of_rooms'=>$roomdata[4]
                ]);

            });
            /*
             * truncate null  array data
             */

            $booking->bookedRoom()->saveMany($booked_rooms_details);

            session()->forget('search_id');
        }
        $user->notify(new RoomBooked($hotel, $booking));
        event(new RoomBookedSendMailEvent($booking, $hotel, $user));

        $invoice = new Invoice;
        $total = 0;
        $start = Carbon::parse($booking->from_date);
        $end = Carbon::parse($booking->till_date);
        $days_between = $start->diffInDays($end);
        foreach ($booking->bookedRoom as $room) {
            $amount = (int)$room->rate * $room->no_of_rooms * $days_between;
            $total += $amount;
        }


        $invoice->booking_id = $booking->id;
        $invoice->amount = $total;
        $invoice->payment_method = "stripe";

        $invoice->save();

        return redirect()->route('view.hotel.invoice',$booking->id)->withSuccess('Your Reservation has been sent for Confirmation');
        
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readnotify($id)
    {
        $notification = Notification::findorfail($id);
        $notification->unreadnotification()->update(['read_at' => now()]);
        return redirect()->back();
    }

    public function viewBook($id)
    {

        $booking = Booking::findorfail($id);
        // dd($booking);
        $hotel = Hotel::where('id', $booking->hotel_id)->first();
        return view('hotels.bookview', ['booking' => $booking, 'hotel' => $hotel]);
    }

    public function paymentStripe(Request $request)
    {
        $booking = Booking::findorfail($request->id);
        $invoice = Invoice::where('booking_id', $booking->id)->first();

        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $customer = Customer::create(array(
                "email"=>$request->stripeEmail,
                "token" => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => $invoice->amount,
                'currency' => 'usd'
            ));
            $invoice->update([
                'payment_status'=>"paid"
            ]);
            event(new PaymentConfirmMailEvent($booking));
            return redirect()->route('home')->withSuccess('Payment done successfully ');
        } catch (\Exception $e) {

            return redirect()->back()->withError('error on payment'.$e);

        }

    }

    public function viewStripe($id)
    {
        $booking = Booking::findorfail($id);
        $invoice = Invoice::where('booking_id', $booking->id)->first();

        return view('paypal', ['booking' => $booking,'invoice'=>$invoice]);
    }

    public function viewVehicleStripe($id) {
        $vehiclebooking = VehicleBooking::findorfail($id);
        $invoice = VehicleBookedInvoice::where('vehicle_booking_id',$vehiclebooking->id)->first();

        return view('vehiclestripe',['booking'=>$vehiclebooking,'invoice'=>$invoice]);
    }

    public function invoice($id) {
        $booking = Booking::findorfail($id);
        $invoice = Invoice::where('booking_id',$id)->first();
        return view('hotels.invoice',['booking'=>$booking,'invoice'=>$invoice]);
    }

    public function payInvoice($id) {
        $invoice = Invoice::findorfail($id);
        $invoice->update([
            'payment_status'=>'paid'
        ]);

        return redirect()->back()->withSuccess('Payment successfully completed');
    }

    public function cancelBooking($id) {
        $booking = Booking::findorfail($id);
        $booking->update([
            'status'=>'canceled'
        ]);

        return redirect()->back()->withSuccess('Booking canceled Successfully');
    }

    public function reserveVehicle(VehicleBookingRequest $request) {
        $vehicle = Vehicle::where('id',$request->vehicle_id)->first();
        $user = User::where('id',$vehicle->user_id)->first();
        $vehiclebooking = new VehicleBooking;
        $vehiclebooking->vehicle_id = $request->vehicle_id;
        $vehiclebooking->location = $request->location;
        $vehiclebooking->destination = $request->destination;
        $vehiclebooking->from = $request->from;
        $vehiclebooking->pickup_time = $request->pickup_time;
        $vehiclebooking->dropoff_time = $request->dropoff_time;
        $vehiclebooking->to = $request->till;
        $vehiclebooking->no_of_passenger = $request->passenger;
        $vehiclebooking->customer_name = $request->customer_name;
        $vehiclebooking->customer_address = $request->customer_address;
        $vehiclebooking->customer_email = $request->customer_email;
        $vehiclebooking->customer_contact = $request->customer_contact;
        $vehiclebooking->remarks = $request->remarks;
        if(Auth::user()){
            $vehiclebooking->user_id = Auth::user()->id;
        }
        if ($vehiclebooking->save()) {
            $requestData = collect($request->only('service','service_cost'));
            if($requestData->has('service')){
                         $vehiclebookingdetails = $requestData->transpose()->map(function($detaildata){
                       return new VehicleBookingDetails([
                           'vehicle_service_id' => $detaildata[0],
                           'vehicle_service_cost' => $detaildata[1]
                       ]);
                    });

                 $k = $vehiclebookingdetails->search(function($item){
                       return $item->vehicle_service_id == null;
                   });
                   if($k) {
                       $vehiclebookingdetails->pull($k);
                   }        
                $vehiclebooking->bookingDetails()->saveMany($vehiclebookingdetails);
        }

             
            }
           

       
        $user->notify(new VehicleBooked($vehicle,$vehiclebooking));
        event(new VehicleBookingMailOwnerEvent($vehiclebooking,$vehicle,$user));

        $invoice = new VehicleBookedInvoice;

        $total = 0;
        $start = Carbon::parse($vehiclebooking->from);
        $end = Carbon::parse($vehiclebooking->to);
        $days_between = $start->diffInDays($end);
        foreach($vehiclebooking->bookingDetails as $detail){
            $total = $total + ($days_between*$detail->vehicle_service_cost);
        }

        $total = $total + ($days_between*$vehicle->rate_per_day);

        $invoice->vehicle_id = $vehicle->id;
        $invoice->vehicle_booking_id = $vehiclebooking->id;
        $invoice->rate = $vehicle->rate_per_day;
        $invoice->cost = $total;

        $invoice->save();

        session()->forget('search_vehicle_id');

        return redirect()->route('view.vehicle.invoice',$vehiclebooking->id)->withSuccess('Your Booking has been sent for Confirmation');

//        return redirect()->route('welcome')->withSuccess('Your booking has been sent for conformation');

    }

    public function vehicleBookings($id){
        $bookings = VehicleBooking::where('vehicle_id',$id)->get();
        $vehicle = Vehicle::findorfail($id);
        if(Auth::user()->id == $vehicle->user_id) {
            $user = Auth::user();
            return view('vehicles.bookings',['bookings'=>$bookings,'vehicle'=>$vehicle,'user'=>$user]);
        }
    }

    public function confirmVehicleBooking($id) {
        $booking = VehicleBooking::findorfail($id);
        $booking->update([
            'booking_status'=>'confirmed'
        ]);

        $vehicle = Vehicle::where('id',$booking->vehicle_id)->first();
        $c = $vehicle->vehicleCommission['commission_percent'];
        $amount = $booking->invoice->cost;
        $commission = ($amount*$c)/100;

        $bookingcommission = new VehicleBookingCommission;
        $bookingcommission->vehicle_booking_id = $booking->id;
        $bookingcommission->total_amount = $amount;
        $bookingcommission->commission_percent = $c;
        $bookingcommission->commission = $commission;
        if($booking->user_id != null) { 
            if($booking->user->hasRole('agent')) {
                if($booking->user->agentVehicleCommission->where('vehicle_id',$vehicle->id)->first() != null) {
                    $agentcommission = new AgentVehicleBookingCommission;
                    $agentcommission->vehicle_booking_id = $booking->id;
                    $agentcommission->user_id = $booking->user->id;
                    $agentcommission->vehicle_commission_percent = $vehicle->vehicleCommission->commission_percent;
                    $g=$booking->user->agentVehicleCommission->where('vehicle_id',$vehicle->id)->first();
                    $agentcommission->agent_commission_percent = $g->commission_percent;
                    
                    $agentcommission->commission = ($commission*$g->commission_percent)/100;

                    $agentcommission->save();
                }

            }
        }

        $bookingcommission->save();

        event(new VehicleBookingConfirmEvent($booking,$vehicle));

        return redirect()->back()->withSuccess('Booking Confirmed');
    }
    public function viewVehicleInvoice($id) {

        $booking = VehicleBooking::findorfail($id);

        $invoice = VehicleBookedInvoice::where('vehicle_booking_id',$booking->id)->first();
        $start = Carbon::parse($booking->from);
        $end = Carbon::parse($booking->to);
        $days_between = $start->diffInDays($end);
        return view('vehicles.invoice',['booking'=>$booking,'invoice'=>$invoice,'days'=>$days_between]);
    }

    public function vehicleInvoice($id) {
        $booking = VehicleBooking::findorfail($id);
        return view('vehicleinvoice',['booking'=>$booking]);
    }

    /**
     * Tour Bookings
     */

    public function tourBook($id) {
        $tour = TourPackage::findorfail($id);
        $search_id = session('search_tour_id');
        $search = TourSearch::where('id',$search_id)->first();
        $start = Carbon::parse($search->from);
        return view('tourbook',['tour'=>$tour,'search'=>$search,'start'=>$start]);
    }

    public function bookTour(Request $request) {
        $tour = TourPackage::where('id',$request->tour_package_id)->first();
        $user = User::where('id',$tour->user_id)->first();
        $booking = new TourPackageBooking;
        $booking->tour_package_id = $request->tour_package_id;
        $booking->no_of_people = $request->no_of_people;
        $booking->starting_from = $request->starting_from;
        $booking->till_date = $request->till_date;
        $booking->customer_name = $request->customer_name;
        $booking->customer_email = $request->customer_email;
        $booking->customer_address = $request->customer_address;
        $booking->customer_contact = $request->customer_contact;
        $booking->booking_status = "pending";
        if(Auth::user()){
            $booking->user_id = Auth::user()->id;
        }

        if($booking->save()) {
            $requestData = collect($request->only('name','address','dob','gender','contact'));
            $bookingdetails = $requestData->transpose()->map(function($guestData){
                return new TourPackageBookingDetails([
                   'name'=>$guestData[0],
                   'address'=>$guestData[1],
                    'dob'=>$guestData[2],
                    'gender'=>$guestData[3],
                    'contact'=>$guestData[4]
                ]);
            });
        $booking->bookingDetails()->saveMany($bookingdetails);
        }

        event(new TourBookedEvent($booking,$tour,$user));
        $user->notify(new TourBookedNotification($booking,$tour));
          $this->tourInvoice($booking->id);
          session()->forget('search_tour_id');
         return redirect()->route('booking.success',$booking->id);
    }

    public function tourInvoice($id) {
        $booking = TourPackageBooking::findorfail($id);
        $tour = TourPackage::where('id',$booking->tour_package_id)->first();
        $invoice = new TourBookedInvoice;
        if($booking->no_of_people >= $tour->group_size) {
            $invoice->tour_package_booking_id = $booking->id;
            $invoice->pricing = "group";
            $invoice->rate = $tour->group_price;
            $invoice->amount = $tour->group_price * $booking->no_of_people;

            $invoice->save();
        } else {
            $invoice->tour_package_booking_id = $booking->id;
            $invoice->pricing = "single";
            $invoice->rate = $tour->price;
            $invoice->amount = $tour->price * $booking->no_of_people;

            $invoice->save();
        }
        return view('success',['booking'=>$booking,'invoice'=>$invoice]);

        // return view('tourinvoice',['invoice'=>$invoice,'booking'=>$booking])->withSuccess('Your Booking has been sent for confirmation');
    }

    public function viewTourBooking($id) {
        $tour = TourPackage::findorfail($id);
        if($tour->user_id == Auth::user()->id) {
            $user = Auth::user();
            $bookings = TourPackageBooking::where('tour_package_id',$tour->id)->get();
            return view('tourpackage.bookings',['bookings'=>$bookings,'tour'=>$tour,'user'=>$user]);
        } else {
            return redirect()->route('welcome');
        }
    }

    public function confirmTourBooking($id) {
        $booking = TourPackageBooking::findorfail($id);
        $tour = TourPackage::where('id',$booking->tour_package_id)->first();
        $booking->update([
            'booking_status'=>'confirmed'
        ]);
        $c = $tour->tourPackageCommission->commission_percent;
        $amount = $booking->invoices->amount;
        $commission = ($c*$amount)/100;
        $bookingcommission = new TourBookingCommission;

        $bookingcommission->tour_package_booking_id = $booking->id;
        $bookingcommission->total_amount = $amount;
        $bookingcommission->commission_percent = $c;
        $bookingcommission->commission = $commission;

        $bookingcommission->save();
        if($booking->user_id != null){
            if($booking->user->hasRole('agent')) {
                if($booking->user->agentTourPackageCommission->where('tour_package_id',$tour->id)->first() != null){
                $agentcommission = new AgentTourPackageBookingCommission;
                $agentcommission->tour_package_booking_id = $booking->id;
                $agentcommission->user_id = $booking->user->id;
                $agentcommission->tour_package_commission_percent = $tour->tourPackageCommission->commission_percent;
                $g=$booking->user->agentTourPackageCommission->where('tour_package_id',$tour->id)->first();
                $agentcommission->agent_commission_percent = $g->commission_percent;
                
                $agentcommission->commission = ($commission*$g->commission_percent)/100;

                $agentcommission->save();
                }
            }
        }

        event(new TourBookConfirmEvent($booking,$tour));
        return redirect()->back()->withSuccess('Booking Confirmed Successfully');
    }

    public function viewTourInvoice($id) {
        $booking = TourPackageBooking::findorfail($id);
        $invoice = TourBookedInvoice::where('tour_package_booking_id',$booking->id)->first();
        $tour = TourPackage::where('id',$booking->tour_package_id)->first();
        if($tour->user_id == Auth::user()->id) {
            return view('tourpackage.invoice',['booking'=>$booking,'invoice'=>$invoice,'tour'=>$tour]);
        } else {
            return redirect()->route('welcome');
        }
    }

    public function bookingSuccess($id) {
        $booking = TourPackageBooking::findorfail($id);
        $date = Carbon::parse($booking->starting_from);
        $invoice=TourBookedInvoice::where('tour_package_booking_id',$booking->id)->first();
        return view('success',['booking'=>$booking,'date'=>$date,'invoice'=>$invoice]);
    }

    public function cancelTourBooking($id) {
        $tourbooking = TourPackageBooking::findorfail($id);
        if(Auth::user()->hasRole('tourowner')) {
            $tourbooking->update([
                'booking_status'=>'canceled'
            ]);
            return redirect()->back()->withSuccess('Booking Canceled Successfully');
        } else {
            return redirect()->route('welcome');
        }
    }

}
