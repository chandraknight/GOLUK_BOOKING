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
                      <h2 class="mb-5">{{ \App\Helper::getWeeklyTourBookings($tour->id) }}</h2>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 stretch-card grid-margin">
                  <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                      <h4 class="font-weight-normal mb-3">Total Bookings
                        <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                      </h4>
                      <h2 class="mb-5">{{ \App\Helper::getTotalTourBookings($tour->id) }}</h2>
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
                    <h1 class="jumbotron-heading">{{$tour->name}}</h1>
                    <p class="lead text-muted">{{$tour->contact}}<span class="badge">{{$tour->email}}</span></p>
                    </p>
                </div>
            </section>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Details</div>
                        <div class="panel-body">
                            <ul class="list-group">
                              <li class="list-group-item">Tour Code : {{$tour->tour_package_code}}</li>
                                <li class="list-group-item">Location: {{$tour->location}}</a> </li>
                                <li class="list-group-item"><img src="{{url('/')}}/storage/tourpackage/{{$tour->image}}" class="mb-2 mw-100 w-100 rounded" alt="image"> </li>
                                <li class="list-group-item">Duration: {{$tour->duration}}</li>
                                <li class="list-group-item">Price: {{$tour->price}}</li>
                                <li class="list-group-item">
                                    <ul class="list-group">For Groups
                                        <li class="list-group-item">Group size: {{$tour->group_size}}</li>
                                        <li class="list-group-item">Group price: {{$tour->group_price}}</li>
                                    </ul>
                                </li>
                                <li class="list-group-item">Provider: {{ucfirst($tour->provider)}}</li>
                                <li class="list-group-item">Description: {{$tour->description}}</li>
                                <li class="list-group-item">Itenary: {{$tour->itenary}}</li>
                                @if($tour->flag == true)
                                    <li class="list-group-item">
                                        <ul class="list-group">Status: Confirmed
                                            <li class="list-group-item"><a href="{{route('admin.tour.append',$tour->id)}}" class="btn btn-danger">Append</a>
                                            </li>
                                        </ul>
                                    </li>
                                @elseif($tour->flag == false)
                                    <li class="list-group-item">
                                        <ul class="list-group">Status : Pending
                                            <li class="list-group-item"><a href="{{route('admin.tour.confirm',$tour->id)}}" class="btn btn-success">Confirm</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if($tour->tourPackageCommission != null)
                                <li class="list-group-item">Commission: {{$tour->tourPackageCommission->commission_percent}}%</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @if($tour->tourPackageCommission == null)
                <div class="col-md-6">
                    <h3>Assign commission</h3>
                 <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" method="post" action="{{route('assign.tour.commission')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                          <label>Tour Name</label>
                          <input type="text" class="form-control" value="{{$tour->name}}">
                        </div>
                        <input type="hidden" name="id" value="{{$tour->id}}">
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
                <div class="col-md-6">
                    <h3>Update commission</h3>
                 <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" method="post" action="{{route('assign.tour.commission')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                          <label>Tour Name</label>
                          <input type="text" class="form-control" value="{{$tour->name}}">
                        </div>
                        <input type="hidden" name="id" value="{{$tour->id}}">
                        <div class="form-group">
                          <label>Commission (%)</label>
                          <input type="text" class="form-control" name="commission" value="{{$tour->tourPackageCommission->commission_percent}}">
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