@extends('superadmin.layouts.main')
@section('content')
<table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Vehicle Name
                        </th>
                        <th>
                          Booked By
                        </th>
                        <th>
                          Booked On
                        </th>
                        <th>
                          Booking From
                        </th>
                        <th>
                        	Status
                        </th>
                        <th>
                        	Actions
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
                          {{$booking->vehicle->name}}
                        </td>
                        @if($booking->user_id != null)
                        <td>
                          {{$booking->user}}
                        </td>
                        @else
                        <td>
                        	{{$booking->customer_name}}
                        </td>
                        @endif
                        <td>
                          {{\Carbon\Carbon::parse($booking->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($booking->from)->toFormattedDateString()}}
                          <i class="mdi mdi-arrow-right-bold"></i> 
                          {{\Carbon\Carbon::parse($booking->to)->toFormattedDateString()}}
                        </td>
                        <td>
                        	{{ucfirst($booking->booking_status)}}
                        </td>
                        <td>
                        	@if($booking->booking_status == 'pending' || $booking->booking_status == 'canceled')
                        	<a href="{{route('admin.confirm.vehicle.booking',$booking->id)}}"> <button type="button" class="btn btn-sm btn-gradient-primary btn-rounded">Confirm</button></a>
                        	@endif
                        	  <a href="{{route('admin.view.vehicle.booking',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-success btn-rounded">View</button></a>
                        	 @if($booking->booking_status == 'confirmed' || $booking->booking_status == 'pending')
                        	  <a href="{{route('admin.cancel.vehicle.booking',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-danger btn-rounded">Cancel</button></a>
                        	  @endif
                        </td>
                      </tr>
                      @empty
                      No Bookings Yet
                      @endforelse
                    </tbody>
                  </table>
@endsection