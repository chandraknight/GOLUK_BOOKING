@extends('admin.layouts.main')
@section('content')
     <table class="table table-bordered table-striped">
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
                          Email
                        </th>
                        <th>
                            Added on
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
                      
                     @forelse($tours as $tour)
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
                      @endforelse
                    </tbody>
                  </table>
@endsection