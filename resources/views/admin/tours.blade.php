@extends('admin.layouts.main')
@section('content')
     <table id="tours" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Tour Code
                        </th>
                        <th>
                          Tour Name
                        </th>
                        <th>
                          Provider
                        </th>
                        <th>
                          Location
                        </th>
                        <th>
                          Added on
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
                      
                     {{--  @forelse($tours as $tour)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$tour->tour_package_code}}
                        </td>
                        <td>
                          <h4><a href="{{route('admin.tour.view',$tour->id)}}"> {{$tour->name}}</a></h4>
                        </td>
                        <td>
                          {{$tour->provider}}
                        </td>
                        <td>
                          {{$tour->location}}
                        </td>
                        <td>
                          {{$tour->email}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($tour->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          @if($tour->flag == true)
                          Confirmed
                           @elseif($tour->flag == false)
                           Not Confirmed
                            @endif
                        </td>
                        <td>
                           @if($tour->flag == true)
                                   
                                        
                                            <a href="{{route('admin.tour.append',$tour->id)}}" class="btn btn-danger">Deactive</a>
                                            
                                @elseif($tour->flag == false)
                                   
                                        
                                            <a href="{{route('admin.tour.confirm',$tour->id)}}" class="btn btn-success">Confirm</a>
                                        
                                    
                                @endif
                        </td>
                      </tr>
                     @empty
                     No Tours available
                      @endforelse  --}}
                    </tbody>
                  </table>

                  <script
                  src="https://code.jquery.com/jquery-3.3.1.min.js"
                  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                  crossorigin="anonymous"></script>
                  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                
                                  <script>
                                      $('#tours').DataTable( {
                                          "processing": true,
                                          "serverSide": true,
                                          "ajax": {
                                            "url":"{{route('admin.tour.data')}}",
                                            "dataType":"json",
                                            "type":"POST",
                                            "data":{"_token":"<?= csrf_token(); ?>"}
                                          },
                                          "columns":[
                                            {"data":"id","searchable":false,"orderable":false},
                                            {"data":"tour_package_code"},
                                            {"data":"name"},
                                            {"data":"provider"},
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