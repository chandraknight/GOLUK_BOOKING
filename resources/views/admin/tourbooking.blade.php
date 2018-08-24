@extends('admin.layouts.main')
@section('content')
<table id="tourbooking" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Tour Name
                        </th>
                        <th>
                          Tour Code
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
                    	{{--  @forelse($tourbookings as $booking)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$booking->tourPackage->name}}
                        </td>
                        <td>
                            {{$booking->tourPackage['tour_package_code']}}
                        </td>
                        <td>
                          {{$booking->tourPackage->provider}}
                        </td>
                        @if($booking->user_id != null)
                        <td>
                          {{$booking->user['email']}}
                        </td>
                        @else
                        <td>
                        	{{$booking->customer_email}}
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
                        	<a href="{{route('tour.confirm',$booking->id)}}"> <button type="button" class="btn btn-sm btn-gradient-primary btn-rounded">Confirm</button></a>
                        	@endif
                        	  <a href="{{route('admin.view.tour.booking',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-success btn-rounded">View</button></a>
                        	 @if($booking->booking_status == 'confirmed' || $booking->booking_status == 'pending')
                        	  <a href="{{route('tour.cancel',$booking->id)}}"><button type="button" class="btn btn-sm btn-gradient-danger btn-rounded">Cancel</button></a>
                        	  @endif
                        </td>
                      </tr>
                      @empty
                      No Bookings Yet
                      @endforelse  --}}
                    </tbody>
                  </table>
                  <script
                  src="https://code.jquery.com/jquery-3.3.1.min.js"
                  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                  crossorigin="anonymous"></script>
                  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                
                                  <script>
                                      $('#tourbooking').DataTable( {
                                          "processing": true,
                                          "serverSide": true,
                                          "ajax": {
                                            "url":"{{route('admin.tour.booking.data')}}",
                                            "dataType":"json",
                                            "type":"POST",
                                            "data":{"_token":"<?= csrf_token(); ?>"}
                                          },
                                          "columns":[
                                            {"data":"id","searchable":false,"orderable":false},
                                            {"data":"name"},
                                            {"data":"tour_package_code"},
                                            {"data":"provider"},
                                            {"data":"customer_name"},
                                            {"data":"created_at","searchable":false,"orderable":false},
                                            {"data":"booking_from","searchable":false,"orderable":false},
                                            {"data":"booking_status"},
                                            {"data":"actions","searchable":false,"orderable":false}
                                          ],
                                          language: {
                                            searchPlaceholder: "By Tour,Code,Status,Customer"
                                        }
                                      } );
                                  
                                  </script>
@endsection