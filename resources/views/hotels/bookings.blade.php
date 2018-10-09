@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="page-title">{{$hotel->name}} Bookings</h1>
    </div>
    <div class="container">
        @include('partials.usersidebar')
        <div class="col-md-9">
            @foreach($bookings->chunk(3) as $b)
                <div class="row">

                    @forelse($b as $booking)
                        <div class="col-md-4">
                            <div class="booking-item-payment">
                                <header class="clearfix">
                                    <a class="booking-item-payment-img" href="#">
                                        <img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" alt="{{$hotel->name}}" title="{{$hotel->name}}">
                                    </a>
                                    <h5 class="booking-item-payment-title"><a href="#">{{$hotel->name}}</a></h5>

                                    <h3 class="booking-item-payment-title">{{$booking->customer_email}}</h3>
                                    <h3 class="booking-item-payment-title">{{$booking->customer_name}}</h3>
                                    <h3 class="booking-item-payment-title">{{$booking->customer_phone}}</h3>
                                    <h3 class="booking-item-payment-title">{{$booking->customer_address}}</h3>
                                </header>
                                <ul class="booking-item-payment-details">
                                    <li>
                                        <h5>Booking for {{\Carbon\Carbon::parse($booking->from_date)->diffInDays(\Carbon\Carbon::parse($booking->till_date))}} nights</h5>
                                        <div class="booking-item-payment-date">
                                            <p class="booking-item-payment-date-day">{{\Carbon\Carbon::parse($booking->from_date)->format('F')}}, {{\Carbon\Carbon::parse($booking->from_date)->day}}</p>
                                            <p class="booking-item-payment-date-weekday">{{\Carbon\Carbon::parse($booking->from_date)->format('l')}}</p>
                                        </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                        <div class="booking-item-payment-date">
                                            <p class="booking-item-payment-date-day">{{\Carbon\Carbon::parse($booking->till_date)->format('F')}}, {{\Carbon\Carbon::parse($booking->till_date)->day}}</p>
                                            <p class="booking-item-payment-date-weekday">{{\Carbon\Carbon::parse($booking->till_date)->format('l')}}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <h5>Room</h5>
                                        @foreach($booking->bookedRoom as $room)
                                            <p class="booking-item-payment-item-title">{{$room->rooms->room_no}}</p>
                                            <ul class="booking-item-payment-price">
                                                <li>
                                                    <p class="booking-item-payment-price-title">Number of Rooms</p>
                                                    <p class="booking-item-payment-price-amount">{{$room->no_of_rooms}}
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="booking-item-payment-price-title">Plan</p>
                                                    <p class="booking-item-payment-price-amount">{{strtoupper($room->plan)}}
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="booking-item-payment-price-title">Rate</p>
                                                    @if($room->plan == null)
                                                        <p class="booking-item-payment-price-amount">{{$room->rooms->room_flat_cost}}<small>/per day</small>
                                                        </p>

                                                    @elseif($room->plan == 'ap')
                                                        <p class="booking-item-payment-price-amount">{{$room->rooms->cost_ap_plan}}<small>/per day</small>
                                                        </p>
                                                    @elseif($room->plan == 'cp')
                                                        <p class="booking-item-payment-price-amount">{{$room->rooms->cost_cp_plan}}<small>/per day</small>
                                                        </p>
                                                    @elseif($room->plan == 'ep')
                                                        <p class="booking-item-payment-price-amount">{{$room->rooms->cost_ep_plan}}<small>/per day</small>
                                                        </p>
                                                    @elseif($room->plan == 'map')
                                                        <p class="booking-item-payment-price-amount">{{$room->rooms->cost_map_plan}}<small>/per day</small>
                                                        </p>
                                                    @endif
                                                </li>
                                            </ul>
                                        @endforeach
                                    </li>
                                </ul>
                                <p class="booking-item-payment-total">Total Amount: <span>Rs {{$booking->invoice['amount']}}</span>
                                <p class="booking-item-payment-total">Booking Status: <span>{{$booking->status}}</span>
                                </p>
                                <p>
                                    <a href="{{route('booking.details',$booking->id)}}" class="btn btn-sm btn-info">Guest Details</a>
                                    @if($booking->status == 'pending')
                                        <a href="{{route('book.confirm',$booking->id)}}" class="btn btn-sm btn-success">Confirm</a>
                                    @endif
                                    @if($booking->status == 'pending'||$booking->status == 'confirmed')
                                        <a href="{{route('booking.cancel',$booking->id)}}" class="btn btn-sm btn-danger">Cancel</a>
                                    @endif

                                    <a href="{{route('booking.change',$booking->id)}}" class="btn btn-success">Change</a>
                                </p>
                            </div>
                        </div>

                    @empty
                        No Bookings Yet
                    @endforelse
                </div>
                <br>
            @endforeach
        </div>
    </div>
@endsection
