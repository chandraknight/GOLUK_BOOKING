<?php

namespace App\Http\Controllers;

use App\Domestic\Request\GetFlightDetail;
use App\Domestic\Request\IssueTicket;
use App\FlightBooking;
use App\FlightBookingDetails;
use App\FlightPnr;
use App\SearchFlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Booking\FlightBookedEvent;

class FlightBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookFlight(Request $request)
    {
//        dd($request);
        $contactperson = [];
        $search = SearchFlight::findorfail(session()->get('searchid'));
        $contactperson['name'] = $request->customer_name;
        $contactperson['contact'] = $request->customer_phone;
        $contactperson['email'] = $request->customer_email;
        $passengers = collect($request->only(
            'pax_title','pax_name','pax_surname','pax_gender','pax_type','pax_nationality','pax_remarks'
        ));
        $pax_details = $passengers->transpose()->map(function($paxData){
                return  ([
                    'title'=>$paxData[0],
                    'name'=>$paxData[1],
                    'surname'=>$paxData[2],
                    'gender'=>$paxData[3],
                    'type'=>$paxData[4],
                    'nationality'=>$paxData[5],
                    'remarks'=>$paxData[6],
                ]);
        });
        $flightids = collect($request->flightid);
        $ticketdetails['pax']=$pax_details;
        $ticketdetails['flights']=$flightids;
        $ticketdetails['contact'] = $contactperson;



        $tickets = new IssueTicket();
        $ticketdetails = $tickets->doRequest($ticketdetails);
        if($ticketdetails != false) {
            $total = 0;
            $totalcommission = 0;
            $booking = new FlightBooking();

            $booking->search_flight_id = $search->id;
            $booking->customer_name = $request->customer_name;
            $booking->customer_contact = $request->customer_phone;
            $booking->customer_email = $request->customer_email;
            $booking->adults = $search->adults;
            $booking->childs = $search->adults;
            if (Auth::user()) {
                $booking->user_id = Auth::user()->id;
            }
            $booking->save();
            foreach ($ticketdetails as $ticket) {
                $detail = new FlightBookingDetails();
                $detail->flight_booking_id = $booking->id;
                $detail->passenger_title = $ticket['title'];
                $detail->passenger_name = $ticket['name'];
                $detail->passenger_surname = $ticket['surname'];
                $detail->passenger_gender = $ticket['gender'];
                $detail->passenger_type = $ticket['pax_type'];
                $detail->passenger_nationality = $ticket['nationality'];
                $detail->currency = $ticket['currency'];
                $detail->price = $ticket['fare'];
                $detail->fuel_surcharge = $ticket['surcharge'];
                $detail->tax = $ticket['tax'];
                $detail->pnr = $ticket['pnr'];
                $detail->ticket = $ticket['ticketno'];
                $detail->barcode = $ticket['barcode'];
                $detail->sector = $ticket['sector'];
                $detail->airline = $ticket['airline'];
                $detail->flight_no = $ticket['flightno'];
                $detail->flight_date = $ticket['flightdate'];
                $detail->flight_time = $ticket['flight_time'];
                $detail->class = $ticket['class'];
                $detail->refundable = $ticket['refundable'];
                $detail->commission = $ticket['commission'];

                $total = $total + $ticket['fare'] + $ticket['surcharge'] + $ticket['tax'];
                $totalcommission = $totalcommission + $ticket['commission'];
                $detail->save();
            }

            $booking->update([
                'amount' => $total,
                'commission' => $totalcommission
            ]);
            event(new FlightBookedEvent($booking));
            return redirect()->route('flightreserved',$booking->id);

        } else {
            $pnr_data = collect($request->only(
                'airline','flightid','pnr'
            ));
            $pnrs = $pnr_data->transpose()->map(function($data) use ($search){
                $pnr = new FlightPnr();
                    $pnr->search_flight_id=$search->id;
                    $pnr->airline_id=$data[0];
                    $pnr->flight_id=$data[1];
                    $pnr->pnr=$data[2];

                    $pnr->save();
            });
            return view('flightbookingsuccess',['booking'=>$ticketdetails]);
        }

    }


    public function flightReserved($id){
        $booking = FlightBooking::findorfail($id);
        return view('flightbookingsuccess',['booking'=>$booking]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FlightBooking  $flightBooking
     * @return \Illuminate\Http\Response
     */
    public function show(FlightBooking $flightBooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FlightBooking  $flightBooking
     * @return \Illuminate\Http\Response
     */
    public function edit(FlightBooking $flightBooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FlightBooking  $flightBooking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FlightBooking $flightBooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FlightBooking  $flightBooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(FlightBooking $flightBooking)
    {
        //
    }
}
