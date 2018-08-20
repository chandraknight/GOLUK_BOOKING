@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">Booking Details</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Hotel: {{$hotel->name}}</li>
                            <li class="list-group-item">Number of Rooms: {{$booking->no_rooms}}</li>
                            <li class="list-group-item">Number of Adults: {{$booking->no_adults}}</li>
                            <li class="list-group-item">Number of Childs: {{$booking->no_childs}}</li>
                            <li class="list-group-item">From: {{$booking->from_date}}</li>
                            <li class="list-group-item">To: {{$booking->till_date}}</li>
                            <li class="list-group-item">Booked By:
                                <ul class="list-group">
                                    <li class="list-group-item">Name: {{$booking->customer_name}}</li>
                                    <li class="list-group-item">Email: {{$booking->customer_email}}</li>
                                    <li class="list-group-item">Phone: {{$booking->customer_phone}}</li>
                                    <li class="list-group-item">Address: {{$booking->customer_address}}</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-footer">
                        @if($booking->status == 'pending')
                            <a class="btn btn-success" href="{{route('book.confirm',$booking->id)}}">Confirm</a>

                        @endif
                        <a class="btn btn-success" href="{{route('hotel.bookings',$hotel->id)}}">Other Bookings</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">Room Details</div>
                    <div class="panel-body">
                        @foreach($booking->bookedRoom as $room)
                            <ul class="list-group">
                                <li class="list-group-item">Room Type: {{$room->room_type}}</li>
                                <li class="list-group-item">Room Name: {{$room->rooms->room_no}}</li>
                                <li class="list-group-item">Plan: {{strtoupper($room->plan)}}</li>
                                
                                <li class="list-group-item">Number of Rooms: {{$room->no_of_rooms}}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">Guest Details</div>
                    <div class="panel-body">
                        @foreach($booking->bookingDetails as $guest)
                            <ul class="list-group">
                                <li class="list-group-item">Guest Name: {{$guest->guest_name}}</li>
                                <li class="list-group-item">Date of Birth: {{$guest->date_of_birth}}</li>
                                <li class="list-group-item">Address: {{$guest->address}}</li>
                                @if($guest->gender == 'm')
                                    <li class="list-group-item">Male</li>
                                @elseif($guest->gender == 'f')
                                    <li class="list-group-item">Female</li>
                                @else
                                    <li class="list-group-item">Unspecified</li>
                                @endif
                                @if ($guest->adult_child == 'a')
                                    <li class="list-group-item">Adult</li>
                                @else
                                    <li class="list-group-item">Child</li>
                                @endif
                                <li class="list-group-item">Remarks: {{$guest->remarks}}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection