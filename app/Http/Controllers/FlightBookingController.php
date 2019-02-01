<?php

namespace App\Http\Controllers;

use App\Domestic\Request\GetFlightDetail;
use App\Domestic\Request\IssueTicket;
use App\FlightBooking;
use App\FlightBookingDetails;
use App\SearchFlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $booking = new FlightBooking();
        $booking->search_flight_id = $search->id;
        $booking->customer_name = $request->customer_name;
        $booking->customer_contact = $request->customer_phone;
        $booking->customer_email = $request->customer_email;
        $booking->adults = $search->adults;
        $booking->childs = $search->adults;
        if(Auth::user()){
            $booking->user_id = Auth::user()->id;
        }
        $flightids = collect($request->flightid);
//        dd($flightids);
        $flights=[];
        $price = 0;
        foreach($flightids as $flightid){
            $details = new GetFlightDetail();
            $detail = $details->doRequest($flightid);
            $currency = $detail['currency'];
            $price = $price + $search->adults * ($detail['afare']+$detail['fuel']+$detail['tax']) + $search->childs * ($detail['cfare']+$detail['fuel']+$detail['tax']);
            array_push($flights,$flightid);
        }
        $booking->currency = $currency;
        $booking->amount = $price;
        $booking->save();
//        dd($price);
        $pax_details = collect($request->only(
            'pax_title','pax_name','pax_surname','pax_gender','pax_type','pax_nationality','pax_remarks'
        ));
        $passengerdetails = $pax_details->transpose()->map(function($paxData){
            return [
                'title'=>$paxData[0],
                'name'=>$paxData[1],
                'surname'=>$paxData[2],
                'gender'=>$paxData[3],
                'type'=>$paxData[4],
                'nationality'=>$paxData[5],
                'remarks'=>$paxData[6],
            ];
        });
        $ticketdetails['pax']=$passengerdetails;
        $ticketdetails['flights']=$flights;
        $ticketdetails['contact'] = $contactperson;
//        dd($ticketdetails['pax']);
        array_push($ticketdetails,[
            'pax'=>$passengerdetails,
            'flights'=>$flightids,
            'contact'=>$contactperson
        ]);
        $tickets = new IssueTicket();
        $ticketdetails = $tickets->doRequest($ticketdetails);
//        dd($passengerdetails);

//        $booking->details()->saveMany($passengers);
        return view('flightbookingsuccess',['response'=>$ticketdetails]);
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
