@extends('superadmin.layouts.main')
@section('content')
<table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Tour Name
                        </th>
                        <th>
                          Provider
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
                    	@forelse($tourbookings as $booking)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$booking->tourPackage->name}}
                        </td>
                        <td>
                          {{$booking->tourPackage->provider}}
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
                          {{\Carbon\Carbon::parse($booking->from_date)->toFormattedDateString()}}
                          <i class="mdi mdi-arrow-right-bold"></i> 
                          {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}
                        </td>
                        <td>
                        	{{ucfirst($booking->booking_status)}}
                        </td>
                        <td>
                        	@if($booking->booking_status == 'pending' || $booking->booking_status == 'canceled')
                        	<a href="{{route('admin.confirm.tour.booking',$booking->id)}}"> <button type="button" class="btn btn-sm btn-gradient-primary btn-rounded">Confirm</button></a>
                        	@endif
                        	  <a href="{{route('admin.view.tour.booking',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-success btn-rounded">View</button></a>
                        	 @if($booking->booking_status == 'confirmed' || $booking->booking_status == 'pending')
                        	  <a href="{{route('admin.cancel.tour.booking',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-danger btn-rounded">Cancel</button></a>
                        	  @endif
                        </td>
                      </tr>
                      @empty
                      No Bookings Yet
                      @endforelse
                    </tbody>
                  </table>

@endsection