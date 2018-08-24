@extends('admin.layouts.main')
@section('content')
    <table id="hotels" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Hotel Code
                        </th>
                        <th>
                          Hotel Name
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
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     {{--  @forelse($hotels as $hotel)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          {{$hotel->hotel_code}}
                        </td>
                        <td>
                          <h4><a href="{{route('admin.hotel.view',$hotel->id)}}"> {{$hotel->name}}</a></h4>
                        </td>
                        <td>
                          {{$hotel->address}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($hotel->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{$hotel->email}}
                        </td>
                        <td>
                          @if($hotel->flag == true)
                          Confirmed
                           @elseif($hotel->flag == false)
                           Not Confirmed
                            @endif
                        </td>
                        <td>
                           @if($hotel->flag == true)
                                   
                                        
                                            <a href="{{route('admin.hotel.append',$hotel->id)}}" class="btn btn-danger">Deactive</a>
                                            
                                @elseif($hotel->flag == false)
                                   
                                        
                                            <a href="{{route('admin.hotel.confirm',$hotel->id)}}" class="btn btn-success">Confirm</a>
                                        
                                    
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
                                      $('#hotels').DataTable( {
                                          "processing": true,
                                          "serverSide": true,
                                          "ajax": {
                                            "url":"{{route('admin.hotel.booking.data')}}",
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
                                            {"data":"email"},
                                            {"data":"status"},
                                            {"data":"actions","searchable":false,"orderable":false}
                                          ],
                                          language: {
                                            searchPlaceholder: "By Name,Email,Address"
                                        }
                                      } );
                                  
                                  </script>
@endsection