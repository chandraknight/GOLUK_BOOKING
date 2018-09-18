@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{route('welcome')}}">Home</a>
            </li>
            <li><a href="{{route('vehicle.list')}}">Vehicles</a>
            </li>


            <li class="active">{{$vehicle->name}}</li>
        </ul>
        <div class="booking-item-details">

            <header class="booking-item-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="lh1em">{{$vehicle->name}}</h2>
                        <ul class="list list-inline text-small">
                            <li><a href="#"><i class="fa fa-envelope"></i> {{$vehicle->email}}</a>
                            </li>
                            <li><a><i class="fa fa-phone"></i>{{$vehicle->contact}}</a></li>
                            <li><a href="#"><i class="fa fa-map-marker"></i>{{$vehicle->location}}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <p class="booking-item-header-price">
                            <small>price</small>
                            <span class="text-lg">Rs {{$vehicle->rate_per_day}}</span>/day
                        </p>
                    </div>
                </div>
            </header>
            <div class="gap gap-small"></div>
            <div class="row row-wrap">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="{{url('/')}}/storage/vehicle/{{$vehicle->image}}" alt="{{$vehicle->name}}"
                                 title="{{$vehicle->name}}">
                        </div>
                        <div class="col-md-7">
                            <div class="booking-item-price-calc">
                                <div class="row row-wrap">
                                    <div class="col-md-6">
                                        @forelse($vehicle->vehicleServiceCost as $servicecost)
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" checked
                                                           disabled>{{$servicecost->vehicleService->service_name}}<span
                                                            class="pull-right">Rs {{$servicecost->cost_per_day}}</span>
                                                </label>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <div class="col-md-5">
                                        <ul class="list">
                                            <li>
                                                <p>Price Per Day <span>Rs {{$vehicle->rate_per_day}}</span>
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
                                    <li><i class="fa fa-car"></i><span
                                                class="booking-item-feature-title">{{$service->service_name}}</span>
                                    </li>
                                @empty
                                    No Additional Services
                                @endforelse
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">

                    <div class="booking-item-deails-date-location">
                        @if(session()->has('vehicle_search_id'))
                            <ul>
                                <li>
                                    <h5>Location:</h5>
                                    <p>{{$search->location}}</p>
                                </li>
                                <li>
                                    <h5>Pick Up:</h5>
                                    <p>
                                        <i class="fa fa-map-marker box-icon-inline box-icon-gray"></i>{{$location->destination}}
                                    </p>
                                    <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>Sunday, April 13 2014
                                    </p>
                                </li>
                                <li>
                                    <h5>Drop Off:</h5>
                                    <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i>JFK International
                                        Airport</p>
                                    <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>Sunday, April 20 2014
                                    </p>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary">Change Location & Date</a>
                        @else
                            <a class="popup-text btn btn-primary" href="#search-dialog" data-effect="mfp-zoom-out">Reserve</a>
                        @endif
                    </div>

                    <div class="gap gap-small"></div>
                </div>
            </div>
        </div>
        <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
            <h3>Reserve {{$vehicle->name}}</h3>
            <form method="post" action="{{route('book.vehicle.session')}}">
                {{csrf_field()}}
                <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-lg form-group-icon-left"><i
                                    class="fa fa-map-marker input-icon input-icon-highlight"></i>
                            <label>Pick-up From</label>
                            <input class="typeahead form-control" name="location" value="{{$vehicle->location}}"
                                   placeholder="City" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-lg form-group-icon-left"><i
                                    class="fa fa-map-marker input-icon input-icon-highlight"></i>
                            <label>Drop-off To</label>
                            <input class="typeahead form-control" name="destination"
                                   placeholder="Same as Pick-up"  type="text">
                        </div>
                    </div>
                </div>
                <div class="input-daterange ">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-group-lg form-group-icon-left"><i
                                        class="fa fa-calendar input-icon input-icon-highlight"></i>
                                <label>Pick-up Date</label>
                                <input class="form-control date-pick"  name="from">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-group-lg form-group-icon-left"><i
                                        class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                <label>Pick-up Time</label>
                                <input class="time-pick form-control" name="pickup_time" value="12:00 AM" type="text">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group form-group-lg form-group-icon-left"><i
                                        class="fa fa-calendar input-icon input-icon-highlight"></i>
                                <label>Drop-off Date</label>
                                <input class="form-control date-pick" name="till">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-group-lg form-group-icon-left"><i
                                        class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                <label>Drop-off Time</label>
                                <input class="time-pick form-control" name="dropoff_time" value="12:00 AM" type="text">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-group-lg form-group-icon-left"><i
                                        class="fa fa-male input-icon input-icon-highlight"></i>
                                <label>Passenger</label>
                                <input class="form-control" name="passenger" type="number">
                            </div>
                        </div>

                    </div>
                </div>
                <button class="btn btn-primary btn-lg" type="submit">Reserve</button>
            </form>
        </div>
    </div>
@endsection