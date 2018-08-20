@extends('admin.layouts.main')
@section('content')
 <div class="main-panel">
    <div class="content-wrapper">
    	<div class="container">
	      <div class="row">
	        <div class="col-md-4 stretch-card grid-margin">
	          <div class="card bg-gradient-danger card-img-holder text-white">
	            <div class="card-body">
	              
	              <h4 class="font-weight-normal mb-3">Weekly Bookings
	                <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
	              </h4>
	              <h2 class="mb-5">434</h2>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-4 stretch-card grid-margin">
	          <div class="card bg-gradient-info card-img-holder text-white">
	            <div class="card-body">
	              <h4 class="font-weight-normal mb-3">Total Bookings
	                <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
	              </h4>
	              <h2 class="mb-5">43</h2>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-4 stretch-card grid-margin">
	          <div class="card bg-gradient-success card-img-holder text-white">
	            <div class="card-body">
	              <h4 class="font-weight-normal mb-3">Commission
	                <i class="mdi mdi-diamond mdi-24px float-right"></i>
	              </h4>
	              <h2 class="mb-5"></h2>
	            </div>
	          </div>
	        </div>
	      </div>
	  </div>
	  <h2>Hotel Bookings</h2>
	  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Booked By
                        </th>
                        <th>
                          Hotel Name
                        </th>
                        <th>
                          Booked Date
                        </th>
                        <th>
                          Booking Time
                        </th>
                        <th>
                          Invoice Amount
                        </th>
                        <th>
                        	Total Commission	
                        </th>
                        <th>
                        	Agent Commission
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     @forelse($hotelbookings as $booking)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                        	{{$booking->customer_name}}
                        </td>
                        <td>
                        	{{$booking->hotel->name}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($booking->from_date)->toFormattedDateString()}}<br>
                          <i class="mdi mdi-arrow-right-bold"></i> <br>
                          {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{$booking->invoice->amount}}
                        </td>
                        <td>
                          {{$booking->bookingCommission->commission}}
                        </td>
                        <td>
                        	{{$booking->agentCommission['commission']}}
                        </td>
                        
                      </tr>
                     @empty
                     No Bookings yet
                      @endforelse
                    </tbody>
                  </table>
<hr>
     <h2>Vehicle Bookings</h2>
    <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Booked By
                        </th>
                        <th>
                          Vehicle Name
                        </th>
                        <th>
                          Booked Date
                        </th>
                        <th>
                          Booking Time
                        </th>
                        <th>
                          Invoice Amount
                        </th>
                        <th>
                          Total Commission  
                        </th>
                        <th>
                          Agent Commission
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     @forelse($vehiclebookings as $booking)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$booking->customer_name}}
                        </td>
                        <td>
                          {{$booking->vehicle->name}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($booking->from)->toFormattedDateString()}}<br>
                          <i class="mdi mdi-arrow-right-bold"></i> <br>
                          {{\Carbon\Carbon::parse($booking->to)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{$booking->invoice->cost}}
                        </td>
                        <td>
                          {{$booking->bookingCommission->commission}}
                        </td>
                        <td>
                          {{$booking->agentVehicleBookingCommission->commission}}
                        </td>
                        
                      </tr>
                     @empty
                     No Bookings yet
                      @endforelse
                    </tbody>
                  </table> 
<hr>
     <h2>Tour Package Bookings</h2>
    <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Booked By
                        </th>
                        <th>
                          Tour Name
                        </th>
                        <th>
                          Booked Date
                        </th>
                        <th>
                          Booking Time
                        </th>
                        <th>
                          Invoice Amount
                        </th>
                        <th>
                          Total Commission  
                        </th>
                        <th>
                          Agent Commission
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     @forelse($tourbookings as $booking)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$booking->customer_name}}
                        </td>
                        <td>
                          {{$booking->tourPackage->name}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($booking->starting_from)->toFormattedDateString()}}<br>
                          <i class="mdi mdi-arrow-right-bold"></i> <br>
                          {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{$booking->invoices->amount}}
                        </td>
                        <td>
                          {{$booking->tourBookingCommission->commission}}
                        </td>
                        <td>
                          {{$booking->agentTourBookingCommission->commission}}
                        </td>
                        
                      </tr>
                     @empty
                     No Bookings yet
                      @endforelse
                    </tbody>
                  </table>
                  <hr>                             
	</div>
</div>
@endsection