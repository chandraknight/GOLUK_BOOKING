@extends('layouts.app')
@php
    use Carbon\Carbon;
    $total = 0;
    $start = Carbon::parse($booking->from_date);
    $end = Carbon::parse($booking->till_date);
    $days_between = $start->diffInDays($end);
@endphp
@section('content')
    <div class="container">
        <div class="col-md-5">
            <ul class="list-group">
                <li class="list-group-item">Booked By:
                    <ul class="list-group">
                        <li class="list-group-item">Name: {{$booking->customer_name}}</li>
                        <li class="list-group-item">Phone Number: {{$booking->customer_phone}}</li>
                        <li class="list-group-item">Email: {{$booking->customer_email}}</li>
                        <li class="list-group-item">Address: {{$booking->customer_address}}</li>
                    </ul>
                </li>
            </ul>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Room Name</th>
                <th>Type</th>
                <th>Plan</th>
                <th>Rate</th>
                <th>Number of Rooms</th>
                <th>Days</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($booking->bookedRoom as $room)
                <tr>
                   <td>{{$room->rooms->room_no}}</td>
                    <td>{{$room->room_type}}</td>
                    <td>{{$room->plan}}</td>
                    <td>Rs. {{$room->rate}}</td>
                    <td>{{$room->no_of_rooms}}</td>
                    <td>{{$days_between}}</td>
                    @php $amount = (int)$room->rate * $room->no_of_rooms * $days_between @endphp
                    <td>Rs. {{$amount}}</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="3" align="right"><strong>Rs. {{$booking->invoice['amount']}} </strong>{{$invoice->payment_status}}</td>
            </tr>
            </tbody>
        </table>
        @role('hotelowner','admin','superadmin')
        @if($invoice->payment_status == 'unpaid')
            <a href="{{route('invoice.pay.back',$invoice->id)}}" class="btn btn-danger">Pay</a>
        @endif

        @endrole
        <a href="{{route('welcome')}}" class="btn btn-success">Home</a>

    </div>


@endsection