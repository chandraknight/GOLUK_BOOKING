@extends('layouts.app')
@section('content')
@php
use Carbon\Carbon;
$start = Carbon::parse($booking->from);
$end = Carbon::parse($booking->to);
$days = $start->diffInDays($end);
$total=$booking->invoice['cost'];
@endphp
<div class="container">
    <div class="col-md-5">
        <ul class="list-group">
            <li class="list-group-item">Booked By:
                <ul class="list-group">
                    <li class="list-group-item">Name: {{$booking->customer_name}}</li>
                    <li class="list-group-item">Phone Number: {{$booking->customer_contact}}</li>
                    <li class="list-group-item">Email: {{$booking->customer_email}}</li>
                    <li class="list-group-item">Address: {{$booking->customer_address}}</li>
                </ul>
            </li>
            <li class="list-group-item">From: {{$booking->from}}</li>
            <li class="list-group-item">To: {{$booking->to}}</li>
        </ul>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Title</th>
            <th>Rate (/day)</th>
            <th>Days</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$booking->vehicle->name}}</td>
            <td>Rs. {{$booking->invoice['rate']}}</td>
            <td>{{$days}}</td>
            <td>Rs. {{$booking->invoice['cost']}}</td>
        </tr>

            @foreach($booking->bookingDetails as $detail)

            <tr>
                <td>{{$detail->vehicleService['service_name']}}</td>
                <td>{{$detail->vehicle_service_cost}}</td>
                <td>{{$days}}</td>
                <td>Rs. {{$days*$detail->vehicle_service_cost}}</td>
                @php $total= $total+$days*$detail->vehicle_service_cost @endphp
            </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="2" align="right"><strong>Rs. {{$total}}</strong></td>
            </tr>
        </tbody>
    </table>
    <a class="btn btn-danger" href="{{route('viewvehiclestripe',$booking->id)}}">Pay</a>
    <a href="{{route('welcome')}}" class="btn btn-success">Home</a>
</div>
<div class="gap gap-small"></div>
@endsection