@extends('admin.layouts.main')
@section('content')
<table id="vehiclebooking" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Vehicle Name
                        </th>
                        <th>Vehicle Code</th>
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
                          Route
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
                    	
                    </tbody>
                  </table>
                  <script
                  src="https://code.jquery.com/jquery-3.3.1.min.js"
                  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                  crossorigin="anonymous"></script>
                  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                
                                  <script>
                                      $('#vehiclebooking').DataTable( {
                                          "processing": true,
                                          "serverSide": true,
                                          "ajax": {
                                            "url":"{{route('admin.vehicle.booking.data')}}",
                                            "dataType":"json",
                                            "type":"POST",
                                            "data":{"_token":"<?= csrf_token(); ?>"}
                                          },
                                          "columns":[
                                            {"data":"id","searchable":false,"orderable":false},
                                            {"data":"name"},
                                            {"data":"vehicle_code"},
                                            {"data":"customer_name"},
                                            {"data":"created_at"},
                                            {"data":"booking_from","searchable":false,"orderable":false},
                                            {"data":"route","searchable":false,"orderable":false},
                                            {"data":"booking_status"},
                                            {"data":"actions","searchable":false,"orderable":false}
                                          ],
                                          language: {
                                            searchPlaceholder: "By Vehicle,Status,Customer"
                                        }
                                      } );
                                  
                                  </script>
@endsection