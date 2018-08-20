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
	              <h2 class="mb-5">{{ \App\Helper::getWeeklyHotelBookings($hotel->id) }}</h2>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-4 stretch-card grid-margin">
	          <div class="card bg-gradient-info card-img-holder text-white">
	            <div class="card-body">
	              <h4 class="font-weight-normal mb-3">Total Bookings
	                <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
	              </h4>
	              <h2 class="mb-5">{{ \App\Helper::getTotalHotelBookings($hotel->id) }}</h2>
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
                        <h1 class="jumbotron-heading">{{$hotel->name}}</h1>
                        <p class="lead text-muted">{{$hotel->contact}}<span class="badge">{{$hotel->email}}</span></p>
                        </p>
                    </div>
          </section>
		 <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Details</div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Hotel Code : {{$hotel->hotel_code}}
                                </li>
                                <li class="list-group-item">Address: {{$hotel->address}}</a> </li>
                                <li class="list-group-item"><img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" class="mb-2 mw-100 w-100 rounded" alt="image"> </li>
                                <li class="list-group-item">Website: {{$hotel->website}}</li>
                                <li class="list-group-item">Email: {{$hotel->email}}</li>
                                <li class="list-group-item">
                                    <ul class="list-group">Agent Details
                                        <li class="list-group-item">Agent Name: {{$hotel->agent_name}}</li>
                                        <li class="list-group-item">Agent Contact: {{$hotel->agent_contact}}</li>
                                    </ul>
                                </li>
                                
                                @if($hotel->flag == true)
                                    <li class="list-group-item">
                                        <ul class="list-group">Status: Confirmed
                                            <li class="list-group-item"><a href="{{route('admin.hotel.append',$hotel->id)}}" class="btn btn-danger">Append</a>
                                            </li>
                                        </ul>
                                    </li>
                                @elseif($hotel->flag == false)
                                    <li class="list-group-item">
                                        <ul class="list-group">Status : Pending
                                            <li class="list-group-item"><a href="{{route('admin.hotel.confirm',$hotel->id)}}" class="btn btn-success">Confirm</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if($hotel->hotelCommission != null)
                                <li class="list-group-item">Commission: {{$hotel->hotelCommission->commission_percent}}%</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @if($hotel->hotelCommission == null)
                <div class="col-md-6">
                    <h3>Assign commission</h3>
                 <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" method="post" action="{{route('assign.hotel.commission')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                          <label>hotel Name</label>
                          <input type="text" class="form-control" value="{{$hotel->name}}">
                        </div>
                        <input type="hidden" name="id" value="{{$hotel->id}}">
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
                      <form class="forms-sample" method="post" action="{{route('assign.hotel.commission')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                          <label>hotel Name</label>
                          <input type="text" class="form-control" value="{{$hotel->name}}">
                        </div>
                        <input type="hidden" name="id" value="{{$hotel->id}}">
                        <div class="form-group">
                          <label>Commission (%)</label>
                          <input type="text" class="form-control" name="commission" value="{{$hotel->hotelCommission->commission_percent}}">
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