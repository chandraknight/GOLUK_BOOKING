@extends('layouts.app')
@section('content')
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
                <td>Rs. {{$booking->vehicle->rate_per_day}}</td>
                <td>{{$days}}</td>
                <td>Rs. {{$days*$booking->vehicle->rate_per_day}}</td>
            </tr>

            @foreach($booking->bookingDetails as $detail)

                <tr>
                    <td>jhvjhvhj</td>
                    <td>{{$detail->vehicle_service_cost}}</td>
                    <td>{{$days}}</td>
                    <td>Rs. {{$days*$detail->vehicle_service_cost}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="2" align="right"><strong>Rs. {{$invoice->cost}}</strong></td>
            </tr>
            </tbody>
        </table>
        <a href="{{route('welcome')}}" class="btn btn-success">Home</a>
        <a href="{{route('vehicle.booking',$booking->vehicle_id)}}" class="btn btn-primary">Back</a>
    </div>
@endsection