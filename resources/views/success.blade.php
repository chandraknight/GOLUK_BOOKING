@extends('layouts.app')
@section('content')
<div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>	
                    <h2 class="text-center">{{$booking->customer_name}}, your booking was successful!</h2>
                    <h5 class="text-center mb30">Booking details has been send to {{$booking->customer_email}}</h5>
                    <ul class="order-payment-list list mb30">
                        <li>
                            <div class="row">
                                <div class="col-xs-9">
                                    <h5><i class="fa fa-plane"></i>{{$booking->tourPackage->name}}</h5>
                                    <p><small>{{$date->toFormattedDateString()}}</small>
                                    </p>
                                </div>
                                <div class="col-xs-3">
                                    <p class="text-right"><span class="text-lg">${{$invoice->amount}}</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                       
                    </ul>
                    <h4 class="text-center">We will contact you soon.</h4>
                   
                </div>
            </div>
            <div class="gap"></div>
        </div>
@endsection