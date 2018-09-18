@extends('layouts.app') 
@section('content')
 <div class="container">
    <h1 class="page-title">{{$vehicle->name}}</h1>
</div>
 <div class="container">
    <div class="row">
        @include('partials.usersidebar')
        <div class="col-md-9">
            
            <div class="booking-item-details">

                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em">{{$vehicle->name}}<small>Vehicle Code: {{$vehicle->vehicle_code}}</small></h2>
                            <ul class="list list-inline text-small">
                                <li><a href="#"><i class="fa fa-envelope"></i> {{$vehicle->email}}</a>
                                </li>
                                <li><a><i class="fa fa-phone"></i>{{$vehicle->contact}}</a></li>
                                 <li><a href="#"><i class="fa fa-map-marker"></i>{{$vehicle->location}}</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <p class="booking-item-header-price"><small>price</small>  <span class="text-lg">{{$vehicle->rate_per_day}}</span>/day</p>
                        </div>
                    </div>
                </header>
                <div class="gap gap-small"></div>
                <div class="row row-wrap">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{url('/')}}/storage/vehicle/{{$vehicle->image}}" alt="{{$vehicle->name}}" title="{{$vehicle->name}}">
                            </div>
                            <div class="col-md-7">
                                <div class="booking-item-price-calc">
                                    <div class="row row-wrap">
                                        <div class="col-md-6">
                                            @forelse($vehicle->vehicleServiceCost as $servicecost)
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" checked disabled>{{$servicecost->vehicleService->service_name}}<span class="pull-right">${{$servicecost->cost_per_day}}</span>
                                                </label>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="col-md-5">
                                            <ul class="list">
                                                <li>
                                                    <p>Price Per Day <span>${{$vehicle->rate_per_day}}</span>
                                                    </p>
                                                </li>
                                              
                                            </ul>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thumb-caption">
                            <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                                <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$vehicle->no_of_people}}</span>
                                </li>
                              
                                <li rel="tooltip" data-placement="top" title="Fuel Type"><i class="im im-electric"></i><span class="booking-item-feature-sign">{{$vehicle->fuel}}</span>
                                </li>
    
                                <li rel="tooltip" data-placement="top" title="Drive Train - {{$vehicle->drive_train}}" ><i class="im im-car-wheel " ></i><span class="booking-item-feature-sign">{{$vehicle->drive_train}}</span>
                                </li>
    
                                <li title="" data-original-title="Car with Driver" data-placement="top" rel="tooltip" ><i class="im im-driver"></i> <span class="booking-item-feature-sign">Yes</span>
                                </li>
    
                                <li title="" data-original-title="Satellite Navigation - {{ucfirst($vehicle->gps)}}" data-placement="top" rel="tooltip" ><i class="im im-satellite"></i> <span class="booking-item-feature-sign">{{$vehicle->gps}}</span>
                                </li>
    
                                <li rel="tooltip" data-placement="top" title="Vehicle Origin location - {{ucfirst($vehicle->location)}}"><i class="fa fa-map-marker"></i><span class="booking-item-feature-sign">{{ucfirst($vehicle->location)}}</span>
                                </li>
    
                            </ul>
                            
                        </div>
                        <p class="text-small">{!!$vehicle->description!!}</p>

                        <hr>
                        <div class="row row-wrap">
                            <div class="col-md-4">
                                <h5>Car Features</h5>
                                <ul class="booking-item-features booking-item-features-expand clearfix">
                                    @forelse($vehicle->services as $service)
                                    <li><i class="fa fa-car"></i><span class="booking-item-feature-title">{{$service->service_name}}</span>
                                    </li>
                                    @empty
                                    No Additional Services
                                    @endforelse
                                </ul>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p><a class="btn btn-primary" href="{{route('vehicle.edit',$vehicle->id)}}" >Edit Details</a></p>
                        @if($vehicle->flag == 1)
                            <p> <a  class="popup-text btn btn-primary" href="#add-services" data-effect="mfp-zoom-out">Add Services</a></p>
                            <p><a class="btn btn-primary" href="{{route('vehicle.booking',$vehicle->id)}}" >View Bookings</a></p>        
                        @endif
                    </div>
                </div>
                <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="add-services">
                    <h5>Add Services</h5>
                    <form method="post" action="{{route('add.services')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$vehicle->id}}">
                        @foreach($services as $service)
                        <div class="checkbox">
                            <label><input class="i-check"  type="checkbox"  name="services[]"  value="{{$service->id}}" @foreach($vehicle->services as $s) {{($s->id == $service->id)?'checked':''}} @endforeach>
                            {{$service->service_name}}</label>
                        </div>
                        @endforeach
                        <input type="submit" class="btn btn-primary" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection