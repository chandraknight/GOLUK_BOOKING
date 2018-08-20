@extends('admin.layouts.main')
@section('content')
<div class="main-panel">
	<div class="content-wrapper">
		<div class="page-header">
            <h3 class="page-title">
              
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.vehicle.booking')}}">Back</a></li>
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
                        <th>Vehicle</th>
                        <th>Booked By</th>
                        <th>Email Address</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>Passengers</th>
                        <th>Booking From</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><a href="{{route('vehicle.show',$booking->vehicle->id)}}" target="_blank"> {{$booking->vehicle->name}}</a></td>
                        <td>{{$booking->customer_name}}</td>
                        <td><a href="mailto::{{$booking->customer_mail}}"> {{$booking->customer_email}}</a></td>
                        <td>{{$booking->customer_contact}}</td>
                        <td>
                          {{$booking->location}}<br>
                           <i class="mdi mdi-arrow-right-bold"></i> <br>
                           {{$booking->destination}}
                        </td>
                        <td>{{$booking->no_of_passenger}}</td>
                        <td> {{\Carbon\Carbon::parse($booking->from)->toFormattedDateString()}}<br>
                          <i class="mdi mdi-arrow-right-bold"></i> <br>
                          {{\Carbon\Carbon::parse($booking->to)->toFormattedDateString()}}</td>
                          <td><label class="badge badge-warning">{{ucfirst($booking->booking_status)}}</label></td>
                          <td>@if($booking->booking_status == 'pending' || $booking->booking_status == 'canceled')
                          <a href="{{route('confirmvehiclebooking',$booking->id)}}"> <button type="button" class="btn btn-gradient-primary btn-rounded btn-icon"><i class="mdi mdi mdi-checkbox-marked-circle"></i>
                        </button></a>
                          @endif
                            
                           @if($booking->booking_status == 'confirmed' || $booking->booking_status == 'pending')
                            <a href="{{route('admin.cancel.vehicle.booking',$booking->id)}}"><button type="button" class="btn btn-gradient-danger btn-rounded btn-icon"><i class="mdi mdi-close-octagon"></i>
                        </button></a>
                            @endif</td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
             

            
             <button type="button" disabled class="btn btn-dark btn-lg btn-block">Total: {{$booking->invoice['cost']}}</button>
              @if($booking->bookingCommission != null)
             <button type="button" disabled class="btn btn-dark btn-lg btn-block">Commission: {{$booking->bookingCommission->commission}}</button>
             @endif
	</div>
</div>
@endsection