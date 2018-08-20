@extends('layouts.app')
@section('content')
 <div class="container">
            <h1 class="page-title">Commissions</h1>
        </div>
        <div class="container">
            <div class="row">
                @include('partials.usersidebar')
                
                <div class="col-md-9">
                	<div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">Hotel Bookings Commissions</a>
                                    </li>
                                    <li><a href="#tab-2" data-toggle="tab">Vehicle Booking Commissions</a>
                                    </li>
                                    <li><a href="#tab-3" data-toggle="tab">Tour Booking Commissions</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-1">
                                         <table class="table table-bordered table-striped table-booking-history">
						                <thead>
						                    <tr>
						                        <th>Hotel Name</th>
						                        <th>Address</th>
						                        <th>Location</th>
						                        <th>Booked Date</th>
						                        <th>Booking On</th>
						                        <th>Invoice Amount</th>
						                        <th>Commission</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	@forelse($user->hotelBooking as $booking)
						                    <tr>
						                        <td class="booking-history-type"><i class="fa fa-building-o"></i><small>Hotel</small>
						                        </td>
						                        <td class="booking-history-title">{{$booking->hotel->name}}</td>
						                        <td>{{$booking->hotel->address}}</td>
						                        <td>{{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}</td>
						                        <td>{{\Carbon\Carbon::parse($booking->from_date)->toFormattedDateString()}} <i class="fa fa-long-arrow-right"></i> {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}</td>
						                        <td>{{$booking->invoice['amount']}}</td>
					                        	<td class="text-center">{{$booking->agentCommission['commission']}}</td>
						                    </tr>
						                    @empty
						                    No Bookings Yet!!!
						                    @endforelse
						                </tbody>
						            </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab-2">
                                       <table class="table table-bordered table-striped table-booking-history">
						                <thead>
						                     <tr>
						                        <th>Vehicle Name</th>
						                        <th>Route</th>
						                        <th>Booked Date</th>
						                        <th>Booking On</th>
						                        <th>Invoice Amount</th>
						                        <th>Commission</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	@forelse($user->vehicleBooking as $booking)
						                    <tr>
				                                <td class="booking-history-type"><i class="fa fa-dashboard"></i><small>car</small>
				                                </td>
				                                <td class="booking-history-title">{{$booking->vehicle->name}}</td>
				                                <td>{{$booking->location}} <i class="fa fa-long-arrow-right"></i> {{$booking->destination}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->from)->toFormattedDateString()}} <i class="fa fa-long-arrow-right"></i> {{\Carbon\Carbon::parse($booking->to)->toFormattedDateString()}}</td>
				                                <td>{{$booking->invoice['cost']}}</td>
					                        	<td class="text-center">{{$booking->agentVehicleBooking['commission']}}</td>
				                            </tr>
						                    @empty
						                    No Bookings Yet!!!
						                    @endforelse
						                </tbody>
						            </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab-3">
                                       <table class="table table-bordered table-striped table-booking-history">
						                <thead>
						                    <tr>
						                        <th>Tour Package Name</th>
						                        <th>Destination</th>
						                        <th>Booked Date</th>
						                        <th>Booking On</th>
						                        <th>Invoice Amount</th>
						                        <th>Commission</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	@forelse($user->tourPackageBooking as $booking)
						                	<tr>
				                                <td class="booking-history-type"><i class="fa fa-bolt"></i><small>activity</small>
				                                </td>
				                                <td class="booking-history-title">{{$booking->tourPackage->name}}</td>
				                                <td>{{$booking->tourPackage->location}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->starting_from)->toFormattedDateString()}} <i class="fa fa-long-arrow-right"></i> {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}</td>
				                                <td>{{$booking->invoices['amount']}}</td>
					                        	<td class="text-center">{{$booking->agentTourBookingCommission['commission']}}</td>
				                            </tr>
				                            @empty
				                            No bookings Yet!!!
				                            @endforelse
				                        </tbody>
				                    </table>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
        @endsection