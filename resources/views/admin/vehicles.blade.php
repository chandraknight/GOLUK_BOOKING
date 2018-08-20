@extends('admin.layouts.main')
@section('content')
     <table class="table table-bordered table-striped">
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
                      
                     @forelse($vehicles as $vehicle)
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
                      @endforelse
                    </tbody>
                  </table>
@endsection