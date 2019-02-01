<?php

namespace App\Http\Controllers;

use App\Domestic\Request\FlightAvailability;
use App\Domestic\Request\GetFlightDetail;
use App\Domestic\Request\Reservation;
use App\Domestic\Request\SectorCode;
use App\FlightPnr;
use App\SearchFlight;
use Illuminate\Http\Request;

class SearchFlightController extends Controller
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
    public function searchFlight(Request $request)
    {
//        dd($request);
        $search = new SearchFlight();
        $search->location = $request->flight_depart;
        $search->destination = $request->flight_arrival;
        $search->depart_date = $request->flight_date;
        $search->childs =  $request->flight_childs;
        $search->adults = $request->flight_adults;
        $search->nationality = $request->nationality;
        if(isset($request->flight_return)){
            $search->return_date = $request->flight_return;
        }
        $search->save();
        session()->put('searchid',$search->id);
        $sector = new SectorCode();
        $sectors = $sector->doRequest();
        $flights = new FlightAvailability($search->id);
        $response = $flights->doRequest();
//        dd($response);
        return view('searchflight',['search'=>$search,'flights'=>$response,'sectors'=>$sectors]);
    }

    public function reserveFlight(Request $request){
//        dd($request);
        $flights = [];
        $search = SearchFlight::findorfail(session()->get('searchid'));
        if(isset($request->returnflightid)){
            $flights['out']=$request->outflightid;
            $flights['in'] = $request->returnflightid;
        } else {
            $flights['out'] = $request->outflightid;
        }
        $reserve = new Reservation();
        $response = $reserve->doRequest($flights);
//        dd($response);
        if(!$response){
            return view('bookflight',['response'=>$response]);
        }
        foreach($response as $res){
            $flightpnr = new FlightPnr();
            $flightpnr->search_flight_id = $search->id;
            $flightpnr->airline_id = $res['airline'];
            $flightpnr->flight_id = $res['flight'];
            $flightpnr->pnr = $res['pnr'];
            $flightpnr->type = $res['status'];

            $flightpnr->save();
        }
        $details = [];
        $price = 0;
        if(isset($request->returnflightid)){

            $indetail = new GetFlightDetail();
            $indetails = $indetail->doRequest($request->returnflightid);
            $inprice = $search->adults * ($indetails['afare']+$indetails['fuel']+$indetails['tax']) + $search->childs * ($indetails['cfare']+$indetails['fuel']+$indetails['tax']);
            $outdetail = new GetFlightDetail();
            $outdetails = $indetail->doRequest($request->outflightid);

            $outprice = $search->adults * ($outdetails['afare']+$outdetails['fuel']+$outdetails['tax']) + $search->childs * ($outdetails['cfare']+$outdetails['fuel']+$outdetails['tax']);
            array_push($details,
                $indetails,
                $outdetails
            );
            $price= $inprice+$outprice;
        } else {
            $detail = new GetFlightDetail();
            $outdetails = $detail->doRequest($request->outflightid);
            array_push($details,
                $outdetails
            );
            $price = $search->adults * ($outdetails['afare']+$outdetails['fuel']+$outdetails['tax']) + $search->childs * ($outdetails['cfare']+$outdetails['fuel']+$outdetails['tax']);
        }

//        dd($details);
        return view('bookflight',['response'=>$response,'details'=>$details,'price'=>$price,'search'=>$search]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SearchFlight  $searchFlight
     * @return \Illuminate\Http\Response
     */
    public function show(SearchFlight $searchFlight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SearchFlight  $searchFlight
     * @return \Illuminate\Http\Response
     */
    public function edit(SearchFlight $searchFlight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SearchFlight  $searchFlight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SearchFlight $searchFlight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SearchFlight  $searchFlight
     * @return \Illuminate\Http\Response
     */
    public function destroy(SearchFlight $searchFlight)
    {
        //
    }
}
