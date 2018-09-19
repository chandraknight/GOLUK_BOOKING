@extends('layouts.app')
@section('content')
    <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('welcome')}}">Home</a>
                </li>
                <li class="active">Search Vehicle</li>
            </ul>
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Car</h3>
                <form method="get" action="{{route('vehiclesearch')}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                                <label>Pick-up From</label>
                                <input class="form-control" placeholder="City" type="text" name="location">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                                <label>Drop-off To</label>
                                <input class="form-control" placeholder="City" placeholder="Same as Pick-up" name="destination" type="text">
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Pick-up Date</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from_date" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="   fa fa-clock-o input-icon input-icon-highlight"></i>
                                    <label>Pick-up Time</label>
                                    <input class="time-pick form-control" name="pickup_time" value="12:00 AM" type="text">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Drop-off Date</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="till_date" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                    <label>Drop-off Time</label>
                                    <input class="time-pick form-control" name="dropoff_time" value="12:00 AM" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-male input-icon input-icon-highlight"></i>
                                    <label>Passenger</label>
                                    <input class="form-control" name="passenger" type="number">
                                </div>
                            </div>
                        </div>
                    <button class="btn btn-primary btn-lg" type="submit">Search for Vehicles</button>
                </form>
            </div>
            <h3 class="booking-title">{{$vehicles->count()}} Rental Vehicles in {{$search->destination}} on {{\Carbon\Carbon::parse($search->from)->toFormattedDateString()}} -{{\Carbon\Carbon::parse($search->till)->toFormattedDateString()}}<small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></small></h3>
              
                <div class="col-md-9">
                   
                    <div class="row row-wrap">
                        @forelse($vehicles as $vehicle)
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a href="{{route('vehicle.show',$vehicle->id)}}">
                                        <img src="{{url('/')}}/storage/vehicle/{{$vehicle->image}}" alt="Image Alternative text" title="{{$vehicle->name}}">
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <h5 class="thumb-title"><a class="text-darken" href="{{route('vehicle.show',$vehicle->id)}}">{{$vehicle->name}}</a></h5><small>{{$vehicle->types->type_name}}</small>
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
                                    <p class="text-darken mb0 text-color">Rs {{$vehicle->rate_per_day}}<small> /day</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Vehicles Available
                        @endforelse
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                           
                           
                            <ul class="pagination">
                                {{ $vehicles->links() }}
                            </ul>
                        </div>
                        <div class="col-md-6 text-right">
                            <p>Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div> 
            <div class="gap"></div>
       

@endsection