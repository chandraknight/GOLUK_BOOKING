@extends('admin.layouts.main')
@section('content')
<div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              {{$user->name}}
            </h3>
        </div>
    	<div class="col-md-9">
            
            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="{{route('assign.agent.hotel.commission')}}">
                        {{csrf_field()}}
                        <h6>Assign Hotel Commission</h6>
                        <div class="form-group">
                            <label for="user">Select Hotel:</label>
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <select class="form-control" name="hotel_id">
                                @foreach($hotels as $hotel)
                                <option value="{{$hotel->id}}" >{{$hotel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user">Commission(in Percentage)</label>
                            <input type="text" class="form-control" name="commission" placeholder="Commission(%)">
                        </div>
                        <a><button type="submit"  class="btn btn-primary">Assign</button></a>
                    </form>
                </div>
                <div class="col-md-4">
                    <form method="post" action="{{route('assign.agent.vehicle.commission')}}">
                        {{csrf_field()}}
                        <h6>Assign Vehicle Commission</h6>
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group">
                            <label for="user">Select Vehicle:</label>
                            <select class="form-control" name="vehicle_id">
                                @foreach($vehicles as $vehicle)
                                <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user">Commission(in Percentage)</label>
                            <input type="text" class="form-control" name="commission" placeholder="Commission(%)">
                        </div>
                        <a><button type="submit"  class="btn btn-primary">Assign</button></a>
                    </form>
                </div>
                <div class="col-md-4">
                    <form method="post" action="{{route('assign.agent.tour.commission')}}">
                        {{csrf_field()}}
                        <h6>Assign Tour Commission</h6>
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group">
                            <label for="user">Select Tours:</label>
                            <select class="form-control" name="tour_id">
                                @foreach($tours as $tour)
                                <option value="{{$tour->id}}" >{{$tour->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user">Commission(in Percentage)</label>
                            <input type="text" name="commission" class="form-control" placeholder="Commission(%)">
                        </div>
                        <a><button type="submit"  class="btn btn-primary">Assign</button></a>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <h3>Hotel Commisions</h3>
        <table  class="table table-bordered table-striped">
            <thead>
                  <tr>
                    <th>
                      #
                    </th>
                    <th>
                      User Name
                    </th>
                    <th>
                      Hotel Name
                    </th>
                    <th>
                        Hotel Code
                    </th>
                    <th>
                      Hotel Commission
                    </th>
                    <th>
                      Agent Commission
                    </th>
                    <th>
                    Actions
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($hotelcommissions as $commission)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$commission->hotel->name}}
                        </td>
                        <td>
                            {{$commission->hotel->hotel_code}}
                        </td>
                        <td>
                            {{$commission->hotel->hotelCommission->commission_percent}}
                        </td>
                        <td>
                            {{$commission->commission_percent}}
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{route('edit.agent.hotel.commission',$commission->id)}}">Edit</a>
                        </td>
                    </tr>
                    @empty
                    No Records Available
                    @endforelse
                </tbody>
        </table>
         <h3>Vehicle Commisions</h3>
        <table  class="table table-bordered table-striped">
            <thead>
                  <tr>
                    <th>
                      #
                    </th>
                    <th>
                      User Name
                    </th>
                    <th>
                      Vehicle Name
                    </th>
                    <th>
                        Vehicle Code
                    </th>
                    <th>
                      Vehicle Commission
                    </th>
                    <th>
                      Agent Commission
                    </th>
                    <th>
                    Actions
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($vehiclecommissions as $commission)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$commission->vehicle->name}}
                        </td>
                        <td>
                            {{$commission->vehicle->vehicle_code}}
                        </td>
                        <td>
                            {{$commission->vehicle->vehicleCommission->commission_percent}}
                        </td>
                        <td>
                            {{$commission->commission_percent}}
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{route('edit.agent.vehicle.commission',$commission->id)}}">Edit</a>
                        </td>
                    </tr>
                    @empty
                    No Records Available
                    @endforelse
                </tbody>
        </table>
         <h3>Tour Commisions</h3>
        <table  class="table table-bordered table-striped">
            <thead>
                  <tr>
                    <th>
                      #
                    </th>
                    <th>
                      User Name
                    </th>
                    <th>
                      Tour Name
                    </th>
                    <th>
                        Tour Code
                    </th>
                    <th>
                      Tour Commission
                    </th>
                    <th>
                      Agent Commission
                    </th>
                    <th>
                    Actions
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($tourcommissions as $commission)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$commission->tourPackage->name}}
                        </td>
                        <td>
                            {{$commission->tourPackage->tour_package_code}}
                        </td>
                        <td>
                            {{$commission->tourPackage->tourPackageCommission->commission_percent}}
                        </td>
                        <td>
                            {{$commission->commission_percent}}
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{route('edit.agent.tour.commission',$commission->id)}}">Edit</a>
                        </td>
                    </tr>
                    @empty
                    No Records Available
                    @endforelse
                </tbody>
        </table>
    </div>
</div>
@endsection