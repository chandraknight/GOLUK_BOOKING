@extends('admin.layouts.main')
@section('content')
<div class="main-panel">
	<div class="content-wrapper">
		<div class="page-header">
            <h3 class="page-title">
              
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.tour.booking')}}">Back</a></li>
              </ol>
            </nav>
          </div>
           <div class="grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Booked On</h4>
                  <p class="card-description">
                    {{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}
                  </p>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Tour</th>
                        <th>Booked By</th>
                        <th>Email Address</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>People</th>
                        <th>Booking From</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><a href="{{route('admin.tour.view',$booking->tourPackage->id)}}" target="_blank"> {{$booking->tourPackage->name}}</a></td>
                        <td>{{$booking->customer_name}}</td>
                        <td><a href="mailto::{{$booking->customer_mail}}"> {{$booking->customer_email}}</a></td>
                        <td>{{$booking->customer_contact}}</td>
                        <td>{{$booking->location}}</td>
                        <td>{{$booking->no_of_people}}</td>
                        <td> {{\Carbon\Carbon::parse($booking->starting_from)->toFormattedDateString()}}<br>
                          <i class="mdi mdi-arrow-right-bold"></i> <br>
                          {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}</td>
                          <td><label class="badge badge-warning">{{ucfirst($booking->booking_status)}}</label></td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>

             <div class="grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">People Details</h4>
                 
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Contact</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($booking->bookingDetails as $guest)
                      <tr>
                        <td>{{$guest->name}}</td>
                        <td>{{$guest->address}}</td>
                        @if($guest->gender == 'male')
                        <td><i class="mdi mdi-human-male icon-md"></i></td>
                        @elseif($guest->gender == 'female')
                        <td><i class="mdi mdi-human-female icon-md"></i></td>
                        @else($guest->gender == 'other') 
                        <td><i class="mdi mdi-gender-transgender"></i></td>
                        @endif
                        <td>{{\Carbon\Carbon::parse($guest->dob)->toFormattedDateString()}}</td>
                        <td>{{$guest->contact}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
             <button type="button" disabled class="btn btn-dark btn-lg btn-block">Total: {{$booking->invoices['amount']}}</button>
            @if($booking->tourBookingCommission != null) 
              <button type="button" disabled class="btn btn-dark btn-lg btn-block">Commission: {{$booking->tourBookingCommission->commission}}</button>
            @endif

	</div>
</div>
@endsection