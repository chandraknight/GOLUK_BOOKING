@extends('layouts.app')
@section('content')
 <div class="container">
    <h1 class="page-title">{{$tour->name}} Bookings</h1>
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
                        <img src="{{url('/')}}/storage/tourpackage/{{$tour['image']}}" alt="{{$tour->name}}" title="{{$tour->name}}">
                    </a>
                    <h5 class="booking-item-payment-title"><a href="#">{{$booking->customer_name}}</a></h5>
                   <h3 class="booking-item-payment-title">{{$booking->customer_email}}</h3>
                   <h3 class="booking-item-payment-title">{{$booking->customer_contact}}</h3>
                   <h3 class="booking-item-payment-title">{{$booking->customer_address}}</h3>
                </header>
                <ul class="booking-item-payment-details">
                    <li>
                        <h5>Booking for {{$booking->no_of_people}} People</h5>
                        <div class="booking-item-payment-date">
                            <p class="booking-item-payment-date-day">{{\Carbon\Carbon::parse($booking->starting_from)->format('F')}}, {{\Carbon\Carbon::parse($booking->starting_from)->day}}</p>
                            <p class="booking-item-payment-date-weekday">{{\Carbon\Carbon::parse($booking->starting_from)->format('l')}}</p>
                        </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                        <div class="booking-item-payment-date">
                            <p class="booking-item-payment-date-day">{{\Carbon\Carbon::parse($booking->till_date)->format('F')}}, {{\Carbon\Carbon::parse($booking->till_date)->day}}</p>
                            <p class="booking-item-payment-date-weekday">{{\Carbon\Carbon::parse($booking->till_date)->format('l')}}</p>
                        </div>
                    </li>
                    <li>
                    	<ul class="booking-item-payment-price">
                    		<li>
                    			<p class="booking-item-payment-price-title">Pricing</p>
		                        <p class="booking-item-payment-price-amount">{{$booking->invoices['pricing']}}
		                        </p>
                    		</li>
                    		<li>
	                        <p class="booking-item-payment-price-title">Rate</p>
	                        <p class="booking-item-payment-price-amount">{{$booking->invoices['rate']}}
	                        </p>
                    		</li>
                    	</ul>
                    </li>
                </ul>
                <p class="booking-item-payment-total">Total Amount: <span>${{$booking->invoices['amount']}}</span>
                </p>
                <p><a href="{{route('tour.book.details',$booking->id)}}" class="btn btn-info">Guest</a>@if($booking->booking_status == 'pending') <a href="{{route('tour.confirm',$booking->id)}}" class="btn btn-success">Confirm</a> @endif @if($booking->booking_status == 'pending'||$booking->booking_status == 'confirmed') <a href="{{route('booking.cancel',$booking->id)}}" class="btn btn-danger">Cancel</a>@endif</p>
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