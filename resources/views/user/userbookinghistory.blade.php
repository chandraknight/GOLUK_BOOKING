@extends('layouts.app')
@section('content')
 <div class="container">
            <h1 class="page-title">Booking History</h1>
        </div>




        <div class="container">
            <div class="row">
                @include('partials.usersidebar')
               
                <div class="col-md-9">
                	
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">Hotel Bookings</a>
                                    </li>
                                    <li><a href="#tab-2" data-toggle="tab">Vehicle Booking</a>
                                    </li>
                                    <li><a href="#tab-3" data-toggle="tab">Tour Booking</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-1">
                                         <table id="hotelbookings" class="table table-bordered table-striped table-booking-history">
						                <thead>
						                    <tr>
						                        <th>S.No</th>
												<th>Hotel Code</th>
												<th>Name</th>
						                        <th>Address</th>
						                        <th>Booked Date</th>
						                        <th>Booking On</th>
						                        <th>Cost</th>
						                        <th>Current</th>
						                        <th>Cancel</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	{{--  @forelse($hotelBooking as $booking)
						                    <tr>
						                        <td class="booking-history-type"><i class="fa fa-building-o"></i><small>Hotel</small>
						                        </td>
						                        <td class="booking-history-title">{{$booking->hotel->name}}</td>
						                        <td>{{$booking->hotel->address}}</td>
						                        <td>{{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}</td>
						                        <td>{{\Carbon\Carbon::parse($booking->from_date)->toFormattedDateString()}} <i class="fa fa-long-arrow-right"></i> {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}</td>
						                        <td>{{$booking->invoice['amount']}}</td>
						                        @if(\Carbon\Carbon::parse($booking->from_date)->eq(\Carbon\Carbon::yesterday()))
						                        <td class="text-center"><i class="fa fa-check"></i></td>
						                        @else
						                         <td class="text-center"><i class="fa fa-times-circle"></i></td>
						                        @endif	
						                        @if(\Carbon\Carbon::parse($booking->from_date)->eq(\Carbon\Carbon::yesterday()))
						                        <td class="text-center"><a class="btn btn-default btn-sm" href="#">Cancel</a></td>
						                        @else
						                        	<td class="text-center">Completed</td>
						                        	@endif
						                    </tr>
						                    @empty
						                    No Bookings Yet!!!
						                    @endforelse  --}}
						                </tbody>
						            </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab-2">
                                       <table id="vehiclebookings" class="table table-bordered table-striped table-booking-history">
						                <thead>
						                    <tr>
												<th>S.No</th>
												<th>Vehicle Code</th>
						                        <th>Vehicle</th>
						                        <th>Booked Date</th>
												<th>Booking On</th>
												<th>Route</th>
						                        <th>Cost</th>
						                        <th>Current</th>
						                        <th>Cancel</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	{{--  @forelse($vehicleBooking as $booking)
						                    <tr>
				                                <td class="booking-history-type"><i class="fa fa-dashboard"></i><small>car</small>
				                                </td>
				                                <td class="booking-history-title">{{$booking->vehicle->name}}</td>
				                                <td>{{$booking->location}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->from)->toFormattedDateString()}} <i class="fa fa-long-arrow-right"></i> {{\Carbon\Carbon::parse($booking->to)->toFormattedDateString()}}</td>
				                                <td>{{$booking->invoice['cost']}}</td>
				                                @if(\Carbon\Carbon::parse($booking->from)->eq(\Carbon\Carbon::yesterday()))
						                        <td class="text-center"><i class="fa fa-check"></i></td>
						                        @else
						                         <td class="text-center"><i class="fa fa-times-circle"></i></td>
						                        @endif	
						                        @if(\Carbon\Carbon::parse($booking->from)->eq(\Carbon\Carbon::yesterday()))
						                        <td class="text-center"><a class="btn btn-default btn-sm" href="#">Cancel</a></td>
						                        @else
						                        	<td class="text-center">Completed</td>
						                        	@endif
				                            </tr>
						                    @empty
						                    No Bookings Yet!!!
						                    @endforelse  --}}
						                </tbody>
						            </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab-3">
                                       <table id="tourbookings" class="table table-bordered table-striped table-booking-history">
						                <thead>
						                    <tr>
						                        <th>S.No</th>
												<th>Tour Code</th>
												<th>Name</th>
						                        <th>Location</th>
						                        <th>Booked Date</th>
						                        <th>Booking On</th>
						                        <th>Cost</th>
						                        <th>Current</th>
						                        <th>Cancel</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	{{-- @forelse($tourBooking as $booking)
						                	<tr>
				                                <td class="booking-history-type"><i class="fa fa-bolt"></i><small>activity</small>
				                                </td>
				                                <td class="booking-history-title">{{$booking->tourPackage->name}}</td>
				                                <td>{{$booking->tourPackage->location}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}</td>
				                                <td>{{\Carbon\Carbon::parse($booking->starting_from)->toFormattedDateString()}} <i class="fa fa-long-arrow-right"></i> {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}</td>
				                                <td>{{$booking->invoice['amount']}}</td>
				                                 @if(\Carbon\Carbon::parse($booking->starting_from)->eq(\Carbon\Carbon::yesterday()))
						                        <td class="text-center"><i class="fa fa-check"></i></td>
						                        @else
						                         <td class="text-center"><i class="fa fa-times-circle"></i></td>
						                        @endif	
						                        @if(\Carbon\Carbon::parse($booking->starting_from)->eq(\Carbon\Carbon::yesterday()))
						                        <td class="text-center"><a class="btn btn-default btn-sm" href="#">Cancel</a></td>
						                        @else
						                        	<td class="text-center">Completed</td>
						                        	@endif
				                            </tr>
				                            @empty
				                            No bookings Yet!!!
				                            @endforelse --}}
				                        </tbody>
				                    </table>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
		<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	  
						<script>
							$('#hotelbookings').DataTable( {
								"processing": true,
								"serverSide": true,
								"ajax": {
								  "url":"{{route('userhotelbooking')}}",
								  "dataType":"json",
								  "type":"POST",
								  "data":{"_token":"<?= csrf_token(); ?>"}
								},
								"columns":[
								  {"data":"id","searchable":false,"orderable":false},
								  {"data":"hotel_code"},
								  {"data":"name"},
								  {"data":"address"},
								  {"data":"created_at"},
								  {"data":"booking_from","searchable":false,"orderable":false},
								  {"data":"amount"},
								  {"data":"current","searchable":false,"orderable":false},
								  {"data":"actions","searchable":false,"orderable":false}
								],
								language: {
								  searchPlaceholder: "By Name,Email,Address"
							  }
							} );
						
						</script>

						<script>
								
							$('#vehiclebookings').DataTable( {
								"processing": true,
								"serverSide": true,
								"ajax": {
								  "url":"{{route('uservehiclebooking')}}",
								  "dataType":"json",
								  "type":"POST",
								  "data":{"_token":"<?= csrf_token(); ?>"}
								},
								"columns":[
								  {"data":"id","searchable":false,"orderable":false},
								  {"data":"vehicle_code"},
								  {"data":"name"},
								  {"data":"created_at"},
								  {"data":"booking_from","searchable":false,"orderable":false},
								  {"data":"route","searchable":false,"orderable":false},
								  {"data":"cost"},
								  {"data":"current","searchable":false,"orderable":false},
								  {"data":"actions","searchable":false,"orderable":false}
								],
								language: {
								  searchPlaceholder: "By Name,Email,Address"
							  }
							} );
						</script>
						<script>
								
								$('#tourbookings').DataTable( {
									"processing": true,
									"serverSide": true,
									"ajax": {
									  "url":"{{route('usertourbooking')}}",
									  "dataType":"json",
									  "type":"POST",
									  "data":{"_token":"<?= csrf_token(); ?>"}
									},
									"columns":[
									  {"data":"id","searchable":false,"orderable":false},
									  {"data":"tour_package_code"},
									  {"data":"name"},
									  {"data":"location"},
									  {"data":"created_at","searchable":false,"orderable":false},
									  {"data":"booking_from","searchable":false,"orderable":false},
									  {"data":"cost"},
									  {"data":"current","searchable":false,"orderable":false},
									  {"data":"actions","searchable":false,"orderable":false}
									],
									language: {
									  searchPlaceholder: "By Name,Address"
								  }
								} );
							</script>
@endsection