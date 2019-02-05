@extends('layouts.app')
@section('content')
    <div class="container">
        {{--{{dd($response)}}--}}
        @if($booking != false)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>
                <h2 class="text-center">Your ticket has been confirmed.</h2>
                <h5 class="text-center mb30">Booking details has been send to johndoe@gmail.com</h5>
                <ul class="order-payment-list list mb30">
                    @foreach($booking->details as $ticket)
                    <li>
                        <div class="row">
                            <div class="col-xs-9">
                                <h5><i class="fa fa-plane"></i> Flight from {{$ticket->sector}} for {{$ticket->passenger_name}}</h5>
                                <h3><small>Ticket No - {{$ticket->ticket}}</small></h3>
                                <h3><small>PNR - {{$ticket->pnr}}</small></h3>
                                <h3><small>Bar Code - {{$ticket->barcode}}</small></h3>
                                <h2><small>{{$ticket->airline}}-{{$ticket->flight_no}}-{{$ticket->flight_date}}-{{$ticket->flight_time}}</small>
                                </h2>
                            </div>
                            <div class="col-xs-3">
                                <p class="text-right"><span class="text-lg">{{$ticket -> currency}} {{$ticket->price +$ticket->fuel_surcharge+$ticket->tax}}</span>
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <h4 class="text-center">You might also need in New York</h4>
                <ul class="list list-inline list-center">
                    <li><a class="btn btn-primary" href="#"><i class="fa fa-building-o"></i> Hotels</a>
                        <p class="text-center lh1em mt5"><small>362 offers<br> from $75</small>
                        </p>
                    </li>
                    <li><a class="btn btn-primary" href="#"><i class="fa fa-home"></i> Rentlas</a>
                        <p class="text-center lh1em mt5"><small>240 offers<br> from $85</small>
                        </p>
                    </li>
                    <li><a class="btn btn-primary" href="#"><i class="fa fa-dashboard"></i> Cars</a>
                        <p class="text-center lh1em mt5"><small>165 offers<br> from $143</small>
                        </p>
                    </li>
                    <li><a class="btn btn-primary" href="#"><i class="fa fa-bolt"></i> Activities</a>
                        <p class="text-center lh1em mt5"><small>366 offers<br> from $116</small>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="gap"></div>
        @else
            No ticket issued
        @endif
    </div>
@endsection