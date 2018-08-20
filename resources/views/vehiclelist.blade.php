@extends('layouts.app')
@section('content')
    <div class="container">
            <h1 class="page-title">Search for Rental Cars</h1>
        </div>




        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        <form method="get" action="{{route('vehiclesearch')}}">
                            <div class="input-daterange" data-date-format="m/d">
                                <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                    <label>Pickup Location</label>
                                    <input class="typeahead form-control" placeholder="City or Airport" name="location" type="text">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                            <label>Check in</label>
                                            <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from_date" type="text">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                                            <label>Pick up Time</label>
                                            <input class="form-control time-pick" name="pickup_time" type="text">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                    <label>Drop off Location</label>
                                    <input class="typeahead form-control" value="Same as pickup" placeholder="City or Airport" name="destination" type="text">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                            <label>Check out</label>
                                            <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="till_date" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                                            <label>Drop off Time</label>
                                            <input class="form-control time-pick" name="dropoff_time" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-male input-icon input-icon-hightlight"></i>
                                            <label>Passenger</label>
                                            <input class="form-control" name="passenger" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-primary mt10" type="submit" value="Search for Rental Cars">
                        </form>
                    </aside>
                </div>
                <div class="col-md-9">
                    <h3 class="mb20">Cars in Popuplar Destinations</h3>
                    
                    <div class="gap"></div>
                    @foreach($vehicles->chunk(3) as $v)
                    <div class="row row-wrap">
                        @forelse($v as $vehicle)
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a href="{{route('vehicle.show',$vehicle->id)}}">
                                        <img src="{{url('/')}}/storage/vehicle/{{$vehicle['image']}}" alt="{{$vehicle->name}}" title="{{$vehicle->name}}">
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <h5 class="thumb-title"><a class="text-darken" href="{{route('vehicle.show',$vehicle->id)}}">{{$vehicle->name}}</a></h5><small>{{$vehicle->types['type_name']}}</small>
                                    <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                                        <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$vehicle->no_of_people}}</span>
                                        </li>
                                       
                                        <li rel="tooltip" data-placement="top" title="Diesel Vehicle"><i class="im im-diesel"></i><span class="booking-item-feature-sign">{{$vehicle->fuel}}</span>
                                        </li>
                                    </ul>
                                    <p class="text-darken mb0 text-color">${{$vehicle->rate_per_day}}<small> /day</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Vehicles Available
                        @endforelse
                    </div>
                    @endforeach
                    <div class="gap gap-small"></div>
                </div>
            </div>
        </div>
@endsection