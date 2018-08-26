@extends('admin.layouts.main')
@section('content')
     <table id="vehicles" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Vehicle Code
                        </th>
                        <th>
                          Vehicle Name
                        </th>
                        <th>
                          Address
                        </th>
                        <th>
                          Join Date
                        </th>
                        <th>
                          Email
                        </th>
                        <th>
                          Status
                        </th>
                        <th>
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     {{--  @forelse($vehicles as $vehicle)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$vehicle->vehicle_code}}
                        </td>
                        <td>
                          <h4><a href="{{route('admin.vehicle.view',$vehicle->id)}}"> {{$vehicle->name}}</a></h4>
                        </td>
                        <td>
                          {{$vehicle->location}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($vehicle->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{$vehicle->email}}
                        </td>
                        <td>
                           @if($vehicle->flag == true)
                          Confirmed
                           @elseif($vehicle->flag == false)
                           Not Confirmed
                            @endif
                        </td>
                        <td>
                           @if($vehicle->flag == true)
                                <a href="{{route('admin.vehicle.append',$vehicle->id)}}" class="btn btn-danger">Deactive</a>
                            @elseif($vehicle->flag == false)
                                <a href="{{route('admin.vehicle.confirm',$vehicle->id)}}" class="btn btn-success">Confirm</a>
                              @endif
                        </td>
                      </tr>
                     @empty
                     No Hotels available
                      @endforelse  --}}
                    </tbody>
                  </table>
                  <script
                  src="https://code.jquery.com/jquery-3.3.1.min.js"
                  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                  crossorigin="anonymous"></script>
                  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                
                                  <script>
                                      $('#vehicles').DataTable( {
                                          "processing": true,
                                          "serverSide": true,
                                          "ajax": {
                                            "url":"{{route('admin.vehicle.data')}}",
                                            "dataType":"json",
                                            "type":"POST",
                                            "data":{"_token":"<?= csrf_token(); ?>"}
                                          },
                                          "columns":[
                                            {"data":"id","searchable":false,"orderable":false},
                                            {"data":"vehicle_code"},
                                            {"data":"name"},
                                            {"data":"location"},
                                            {"data":"created_at"},
                                            {"data":"email"},
                                            {"data":"flag"},
                                            {"data":"actions","searchable":false,"orderable":false}
                                          ],
                                          language: {
                                            searchPlaceholder: "By Name,Email,Address"
                                        }
                                      } );
                                  
                                  </script>
@endsection