<?php

namespace App\Http\Controllers;

use App\Domestic\Request\FlightAvailability;
use App\Domestic\Request\GetFlightDetail;
use App\Domestic\Request\Reservation;
use App\Domestic\Request\SectorCode;
use App\FlightPnr;
use App\Http\Requests\SearchFlightRequest;
use App\SearchFlight;
use Illuminate\Http\Request;
use App\Events\TicketTimeExpiredEvent;
use Carbon\Carbon;

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
    public function searchFlight(SearchFlightRequest $request)
    {
//        dd($request);
        try {
            $flight = [];
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
            $response = $flights->formatResponse();
            $out = collect($response['out']);
            $in = collect($response['in']);
            $flight['out'] = $out;
            $flight['in'] = $in;
            $airlines = $out->unique('airline')->pluck('airline');
//        dd($airlines);
            return view('searchflight',['search'=>$search,'flights'=>$flight,'sectors'=>$sectors,'airlines'=>$airlines]);
        } catch (\Exception $e){
            return redirect()->route('welcome')->with('error',$e->getMessage());
        }

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
        event(new TicketTimeExpiredEvent());
        // $job = (new TicketTimeExpired())->delay(Carbon::now()->addSeconds(90));
        // dispatch($job);
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

    public function sortFlight(Request $request){
        $flights=[];
        if($request->sorttype == 'hightolow'){
            $outbounds = collect($request->outbound)->sortByDesc('tafare');
            $inbounds = collect($request->inbound)->sortByDesc('tafare');
        }
        if($request->sorttype == 'lowtohigh'){
            $outbounds = collect($request->outbound)->sortBy('tafare');
            $inbounds = collect($request->inbound)->sortBy('tafare');
        } 
        if($request->sorttype == 'airline'){
            $outbounds = collect($request->outbound)->sortBy('airline');
            $inbounds = collect($request->inbound)->sortBy('airline');
        }
       
        $flights['out'] = $outbounds;
        $flights['in'] = $inbounds;
        $output = view('sortflight', ['flights' =>$flights ])->render();
        return response()->json(['output'=>$output]);
    }

    public function filterFlight(Request $request){
        $flights = [];
        $airline = $request->airline;
        $outbounds = collect($request->outbound)->where('airline',$airline);
        $inbounds = collect($request->inbound)->where('airline',$airline);
        $flights['out'] = $outbounds;
        $flights['in'] = $inbounds;
        $output = view('sortflight',['flights'=>$flights])->render();
        return response()->json(['output'=>$output]);
    }
}
