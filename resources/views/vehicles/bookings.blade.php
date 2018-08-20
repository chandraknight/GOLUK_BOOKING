@extends('layouts.app')
@section('content')
 <div class="container">
    <h1 class="page-title">{{$vehicle->name}} Bookings</h1>
</div>
 <div class="container">
    <div class="row">
        @include('partials.usersidebar')
        <div class="col-md-9">
             <div class="row">
        @forelse($bookings as $booking)
        <div class="col-md-4">
            <div class="booking-item-payment">
                <header class="clearfix">
                    <a class="booking-item-payment-img" href="#">
                        <img src="{{url('/')}}/storage/vehicle/{{$vehicle['image']}}" alt="{{$vehicle->name}}" title="{{$vehicle->name}}">
                    </a>
                    <h5 class="booking-item-payment-title"><a href="#">{{$booking->customer_name}}</a></h5>
                   <h3 class="booking-item-payment-title">{{$booking->customer_email}}</h3>
                   <h3 class="booking-item-payment-title">{{$booking->customer_contact}}</h3>
                   <h3 class="booking-item-payment-title">{{$booking->customer_address}}</h3>
                </header>
                <ul class="booking-item-payment-details">
                    <li>
                        <h5>Booking for {{$booking->no_of_passenger}} People</h5>
                        <div class="booking-item-payment-date">
                            <p class="booking-item-payment-date-day">{{\Carbon\Carbon::parse($booking->from)->format('F')}}, {{\Carbon\Carbon::parse($booking->from)->day}}</p>
                            <p class="booking-item-payment-date-weekday">{{\Carbon\Carbon::parse($booking->from)->format('l')}}</p>
                            <p class="booking-item-payment-date-weekday">{{$booking->pickup_time}}</p>
                        </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                        <div class="booking-item-payment-date">
                            <p class="booking-item-payment-date-day">{{\Carbon\Carbon::parse($booking->to)->format('F')}}, {{\Carbon\Carbon::parse($booking->to)->day}}</p>
                            <p class="booking-item-payment-date-weekday">{{\Carbon\Carbon::parse($booking->to)->format('l')}}</p>
                            <p class="booking-item-payment-date-weekday">{{$booking->dropoff_time}}</p>
                        </div>
                    </li>
                    <li>
                         <div class="booking-item-payment-date">
                             <p class="booking-item-payment-date-weekday">{{$booking->location}}</p>
                         </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                          <div class="booking-item-payment-date">
                              <p class="booking-item-payment-date-weekday">{{$booking->destination}}</p>
                          </div>
                    </li>
                </ul>
                <p class="booking-item-payment-total">Total Amount: <span>${{$booking->invoice['cost']}}</span>
                </p>
                <p><a href="{{route('viewvehicleinvoice',$booking->id)}}" class="btn btn-info">Invoice</a>@if($booking->booking_status == 'pending') <a href="{{route('confirmvehiclebooking',$booking->id)}}" class="btn btn-success">Confirm</a> @endif @if($booking->booking_status == 'pending'||$booking->booking_status == 'confirmed') <a href="#" class="btn btn-danger">Cancel</a>@endif</p>
            </div>
        </div>
        @empty
        No Bookings Yet
        @endforelse
    </div>      
        </div>
    </div>
</div>
<div class="gap gap-small"></div>
@endsection