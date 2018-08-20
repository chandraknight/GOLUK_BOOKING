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
                <li class="list-group-item">From: {{$booking->starting_from}}</li>
                <li class="list-group-item">To: {{$booking->till_date}}</li>
            </ul>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Number of People</th>
                <th>Rate (/day)</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$booking->tourPackage->name}}</td>
                <td>{{$booking->no_of_people}}</td>
                <td>Rs {{$invoice->rate}}</td>
                <td>Rs. {{$invoice->rate*$booking->no_of_people}}</td>
            </tr>


            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="2" align="right"><strong>Rs. {{$invoice->amount}}</strong></td>
            </tr>
            </tbody>
        </table>
        <a class="btn btn-danger" href="{{route('viewvehiclestripe',$booking->id)}}">Pay</a>
        <a href="{{route('welcome')}}" class="btn btn-success">Home</a>
    </div>
@endsection