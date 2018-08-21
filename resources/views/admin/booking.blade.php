@extends('admin.layouts.main')
@section('content')
<table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Hotel Name
                        </th>
                        <th>
                          Hotel Code
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
                    	@forelse($hotelbookings as $booking)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$booking->hotel->name}}
                        </td>
                        <td>
                          {{$booking->hotel['hotel_code']}}
                        </td>
                        @if($booking->user_id != null)
                        <td>
                          {{$booking->user['name']}}
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
                        	<label class="badge badge-warning">{{ucfirst($booking->status)}}</label>
                        </td>
                        <td>
                        	@if($booking->status == 'pending' || $booking->status == 'canceled')
                        	<a href="{{route('book.confirm',$booking->id)}}"> <button type="button" class="btn btn-sm btn-gradient-primary btn-rounded">Confirm</button></a>
                        	@endif
                        	  <a href="{{route('admin.view.hotel.booking',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-success btn-rounded">View</button></a>
                        	 @if($booking->status == 'confirmed' || $booking->status == 'pending')
                        	  <a href="{{route('booking.cancel',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-danger btn-rounded">Cancel</button></a>
                        	  @endif
                        </td>
                      </tr>
                      @empty
                      No Bookings Yet
                      @endforelse
                    </tbody>
                  </table>
@endsection