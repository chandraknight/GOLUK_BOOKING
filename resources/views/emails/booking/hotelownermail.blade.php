@component('mail::message')
# Introduction

Your hotel has new bookings to be confirmed.
<div class="panel panel-primary">
    <div class="panel-heading">Booking Details</div>
    <div class="panel-body">
        <div class="panel panel-default">
            <div class="panel-heading">{{$hotel->name}}</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">Number of Rooms: {{$booking->no_rooms}}</li>
                    <li class="list-group-item">From: {{$booking->from_date}}</li>
                    <li class="list-group-item">To: {{$booking->till_date}}</li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Details</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <ul class="list-group">
                            <li class="list-group-item">Customer Name: {{$booking->customer_name}}</li>
                            <li class="list-group-item">Customer Email: {{$booking->customer_email}}</li>
                            <li class="list-group-item">Customer Address: {{$booking->customer_address}}</li>
                            <li class="list-group-item">Customer Phone: {{$booking->customer_phone}}</li>
                        </ul>
                        <hr>
                    </li>
                    <h3>Room Details</h3>
                    <li class="list-group-item">
                        @foreach($booking->bookedRoom as $room_booked_detail)<ul class="list-group">
                            <li class="list-group-item">Room Id: {{$room_booked_detail->room_id}}</li>
                            <li class="list-group-item">Room Name: {{$room_booked_detail->rooms->room_no}}</li>
                            <li class="list-group-item">Room Type: {{$room_booked_detail->room_type}}</li>
                            <li class="list-group-item">Plan: {{$room_booked_detail->plan}}</li>
                            <hr>
                        </ul>
                        @endforeach
                    </li>
                    <h3>Guest Details</h3>
                    <li class="list-group-item">
                        @foreach($booking->bookingDetails  as $booking_detail)
                            <ul class="list-group">
                                <li class="list-group-item">{{$booking_detail->guest_name}}</li>
                                <li class="list-group-item">{{$booking_detail->date_of_birth}}</li>
                                <li class="list-group-item">{{$booking_detail->address}}</li>
                                <li class="list-group-item">{{$booking_detail->gender}}</li>
                                <li class="list-group-item">{{$booking_detail->adult_child}}</li>
                                <li class="list-group-item">{{$booking_detail->remarks}}</li>
                                <hr>
                            </ul>
                        @endforeach
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@component('mail::button', ['url' => route('book.confirm',[$booking->id])])
Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
