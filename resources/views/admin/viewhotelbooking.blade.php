@extends('admin.layouts.main')
@section('content')
<div class="main-panel">
	<div class="content-wrapper">
		<div class="page-header">
            <h3 class="page-title">
              
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.hotel.booking')}}">Back</a></li>
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
                        <th>Hotel</th>
                        <th>Booked By</th>
                        <th>Email Address</th>
                        <th>Contact</th>
                        <th>Total Rooms</th>
                        <th>Adults</th>
                        <th>Child</th>
                        <th>Booking From</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><a href="{{route('hotel.show',$booking->hotel->id)}}" target="_blank"> {{$booking->hotel->name}}</a></td>
                        @if($booking->user_id == null)
                        <td>{{$booking->customer_name}}</td>
                        @else
                        <td>{{$booking->user->name}}</td>
                        @endif
                        <td><a href="mailto::{{$booking->customer_mail}}"> {{$booking->customer_email}}</a></td>

                        <td>{{$booking->customer_phone}}</td>
                        <td>{{$booking->no_rooms}}</td>
                        <td>{{$booking->no_adults}}</td>
                        <td>{{$booking->no_childs}}</td>
                        <td> {{\Carbon\Carbon::parse($booking->from_date)->toFormattedDateString()}}<br>
                          <i class="mdi mdi-arrow-right-bold"></i> <br>
                          {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}</td>
                          <td><label class="badge badge-warning">{{ucfirst($booking->status)}}</label></td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
             <div class="grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Guest Details</h4>
                  
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                    	@foreach($booking->bookingDetails as $guest)
                      <tr>
                        <td>{{$guest->guest_name}}</td>
                        <td>{{\Carbon\Carbon::parse($guest->date_of_birth)->toFormattedDateString()}}</td>
                        <td>{{$guest->address}}</td>
                        @if($guest->gender == 'm')
                        <td><i class="mdi mdi-human-male icon-md"></i></td>
                        @elseif($guest->gender == 'f')
                        <td><i class="mdi mdi-human-female icon-md"></i></td>
                        @else
                        <td><i class="mdi mdi-gender-transgender"></i></td>
                        @endif
                        <td>{{$guest->remarks}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>

             <div class="grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Rooms</h4>
                  
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Plan</th>
                        <th>Number of Rooms</th>
                      </tr>
                    </thead>
                    <tbody>
                    	@foreach($booking->bookedRoom as $room)
                      <tr>
                        <td>{{$room->rooms->room_no}}</td>
                        <td>{{$room->rooms->roomType->name}}</td>
                        <td>{{$room->plan}}</td>
                        <td>{{$room->no_of_rooms}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>
             <button type="button" disabled class="btn btn-dark btn-lg btn-block">Total: Rs {{$booking->invoice['amount']}}</button>
             @if($booking->bookingCommission != null)
             <button type="button" disabled class="btn btn-dark btn-lg btn-block">Commission: Rs {{$booking->bookingCommission['commission']}}</button>
             @endif
             @if($booking->agentCommission != null)
             <button type="button" disabled class="btn btn-dark btn-lg btn-block">Agent Commission: Rs {{$booking->agentCommission['commission']}}</button>
             @endif
	</div>
</div>
@endsection