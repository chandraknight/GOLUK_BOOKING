@extends('admin.layouts.main')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                      <h4 class="font-weight-normal mb-3">Weekly Bookings
                        <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                      </h4>
                      <h2 class="mb-5">{{ \App\Helper::getWeeklyVehicleBookings($vehicle->id) }}</h2>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                      <h4 class="font-weight-normal mb-3">Total Bookings
                        <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                      </h4>
                      <h2 class="mb-5">{{ \App\Helper::getTotalVehicleBookings($vehicle->id) }}</h2>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                      <h4 class="font-weight-normal mb-3">Commission
                        <i class="mdi mdi-diamond mdi-24px float-right"></i>
                      </h4>
                      <h2 class="mb-5"></h2>
                    </div>
                  </div>
                </div>
            </div>
            <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading">{{$vehicle->name}}</h1>
                    <p class="lead text-muted">{{$vehicle->contact}}<span class="badge">{{$vehicle->email}}</span></p>
                    </p>

                </div>
            </section> 
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Details</div>
                        <div class="panel-body">
                            <ul class="list-group">
                              <li class="list-group-item">Vehicle Code : {{$vehicle->vehicle_code}}</li>
                                <li class="list-group-item">Location: {{$vehicle->location}}</a> </li>
                                <li class="list-group-item"><img src="{{url('/')}}/storage/vehicle/{{$vehicle->image}}" class="mb-2 mw-100 w-100 rounded" alt="image"> </li>
                                <li class="list-group-item">Type: {{ucfirst($vehicle->types->type_name)}}</li>
                                <li class="list-group-item">Passengers: {{$vehicle->no_of_people}}</li>
                                <li class="list-group-item">Rate per Day: {{$vehicle->rate_per_day}}</li>
                                <li class="list-group-item">Fuel Type: {{ucfirst($vehicle->fuel)}}</li>
                                <li class="list-group-item">Description: {{$vehicle->description}}</li>
                                @if($vehicle->flag == true)
                                    <li class="list-group-item">
                                        <ul class="list-group">Status: Confirmed
                                            <li class="list-group-item"><a href="{{route('admin.vehicle.append',$vehicle->id)}}" class="btn btn-danger">Append</a>
                                            </li>
                                        </ul>
                                    </li>
                                @elseif($vehicle->flag == false)
                                    <li class="list-group-item">
                                        <ul class="list-group">Status : Pending
                                            <li class="list-group-item"><a href="{{route('admin.vehicle.confirm',$vehicle->id)}}" class="btn btn-success">Confirm</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if($vehicle->vehicleCommission != null)
                                    <li class="list-group-item">Commission: {{$vehicle->vehicleCommission->commission_percent}}%</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                 @if($vehicle->vehicleCommission == null)
                <div class="col-md-5">
                    <h3>Assign commission</h3>
                     <div class="card">
                        <div class="card-body">
                         
                          <form class="forms-sample" method="post" action="{{route('assign.vehicle.commission')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                              <label>Vehicle Name</label>
                              <input type="text" class="form-control" value="{{$vehicle->name}}">
                            </div>
                            <input type="hidden" name="id" value="{{$vehicle->id}}">
                            <div class="form-group">
                              <label>Commission (%)</label>
                              <input type="text" class="form-control" name="commission">
                            </div>
                            <button type="submit" class="btn btn-gradient-primary mr-2">Assign</button>
                          </form>
                        </div>
                      </div>
                </div>
                @else
                <div class="col-md-5">
                    <h3>Update commission</h3>
                     <div class="card">
                        <div class="card-body">
                         
                          <form class="forms-sample" method="post" action="{{route('assign.vehicle.commission')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                              <label>Vehicle Name</label>
                              <input type="text" class="form-control" value="{{$vehicle->name}}">
                            </div>
                            <input type="hidden" name="id" value="{{$vehicle->id}}">
                            <div class="form-group">
                              <label>Commission (%)</label>
                              <input type="text" class="form-control" name="commission" value="{{$vehicle->vehicleCommission->commission_percent}}">
                            </div>
                            <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                          </form>
                        </div>
                      </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection