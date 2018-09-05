@extends('layouts.app')
@section('content')
    <div class="top-area show-onload">
        <div class="bg-holder full">
            <div class="bg-mask"></div>
            <div class="bg-parallax" style="background-image:url(img/196_365_2048x1365.jpg);"></div>
            <div class="bg-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="search-tabs search-tabs-bg mt50">
                                <h1>Find Your Perfect Trip</h1>
                                <div class="tabbable">
                                    <ul class="nav nav-tabs" id="myTab">
                                        <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-building-o"></i> <span>Hotels</span></a>
                                        </li>

                                        <li><a href="#tab-4" data-toggle="tab"><i class="fa fa-car"></i> <span>Vehicles</span></a>
                                        </li>
                                        <li><a href="#tab-5" data-toggle="tab"><i class="fa fa-bolt"></i> <span>Tours</span></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="tab-1">
                                            <h2>Search and Save on Hotels</h2>
                                            <form method="get" action="{{route('hotelsearch.index')}}">
                                                {{csrf_field()}}
                                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                    <label>Where are you going?</label>
                                                    <input class="typeahead form-control" placeholder="City, Airport, Point of Interest or U.S. Zip Code" type="text" name="destination">
                                                </div>
                                                <div class="input-daterange" data-date-format="M d, D">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                <label>Check-in</label>
                                                                <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from_date" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                <label>Check-out</label>
                                                                <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="till_date" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-select-plus">
                                                                <label>Children</label>

                                                                <select class="form-control" name="no_childs">
                                                                    <option>0</option>
                                                                    <option>1</option>
                                                                    <option>2</option>
                                                                    <option>3</option>
                                                                    <option>4</option>
                                                                    <option>5</option>
                                                                    <option>6</option>
                                                                    <option>7</option>
                                                                    <option>8</option>
                                                                    <option>9</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-select-plus">
                                                                <label>Guests</label>

                                                                <select class="form-control" name="no_adults">
                                                                    <option>1</option>
                                                                    <option>2</option>
                                                                    <option>3</option>
                                                                    <option>4</option>
                                                                    <option>5</option>
                                                                    <option>6</option>
                                                                    <option>7</option>
                                                                    <option>8</option>
                                                                    <option>9</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary btn-lg" type="submit">Search for Hotels</button>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="tab-4">
                                            <h2>Search for Cheap Rental Cars</h2>
                                            <form method="get" action="{{route('vehiclesearch')}}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                            <label>Pick-up Location</label>
                                                            <input class="typeahead form-control" placeholder="City, Airport, U.S. Zip" type="text" name="location">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                            <label>Drop-off Location</label>
                                                            <input class="typeahead form-control" placeholder="City, Airport, U.S. Zip" type="text" name="destination">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-daterange" data-date-format="M d, D">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                <label>Pick-up Date</label>
                                                                <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from_date" type="text">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                <label>Pick-up Time</label>
                                                                <input class="time-pick form-control" name="pickup_time" value="12:00 AM" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                <label>Drop-off Date</label>
                                                                <input class="form-control date-pick"  data-date-format="yyyy-mm-dd" type="text" name="till_date">
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
                                                                <label>Passengers</label>
                                                                <input class="form-control"  type="text" name="passenger">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary btn-lg" type="submit">Search for Vehicles</button>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="tab-5">
                                            <h2>Search for Activities</h2>
                                            <form action="{{route('toursearch')}}" method="get">
                                                <div class="input-daterange" data-date-format="M d, D">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                <label>Where are you going?</label>
                                                                <input class="typeahead form-control" placeholder="City, Airport, Point of Interest or U.S. Zip Code" type="text" name="destination">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                <label>From</label>
                                                                <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                <label>Till</label>
                                                                <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="till" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-male input-icon input-icon-highlight"></i>
                                                                <label>People</label>
                                                                <input class="form-control" name="people" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary btn-lg" type="submit">Search for Tours</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="loc-info text-right hidden-xs hidden-sm">
                                <h3 class="loc-info-title"><img src="img\flags\32\np.png" alt="Image Alternative text" title="Image Title">Kathmandu</h3>
                                <p class="loc-info-weather"><span class="loc-info-weather-num">+31</span><i class="im im-rain loc-info-weather-icon"></i>
                                </p>
                                <ul class="loc-info-list">
                                    <li><a href="#"><i class="fa fa-building-o"></i> 277 Hotels from $36/night</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-home"></i> 130 Rentals from $44/night</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-car"></i> 294 Car Offers from $45/day</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-bolt"></i> 200 Activities this Week</a>
                                    </li>
                                </ul><a class="btn btn-white btn-ghost mt10" href="#"><i class="fa fa-angle-right"></i> Explore</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="gap"></div>

    <div class="container">
        <div class="row row-wrap" data-gutter="60">
            <div class="col-md-4">
                <div class="thumb">
                    <header class="thumb-header"><i class="fa fa-dollar box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                    </header>
                    <div class="thumb-caption">
                        <h5 class="thumb-title"><a class="text-darken" href="#">Best Price Guarantee</a></h5>
                        <p class="thumb-desc">Eu lectus non vivamus ornare lacinia elementum faucibus natoque parturient ullamcorper placerat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumb">
                    <header class="thumb-header"><i class="fa fa-lock box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                    </header>
                    <div class="thumb-caption">
                        <h5 class="thumb-title"><a class="text-darken" href="#">Trust & Safety</a></h5>
                        <p class="thumb-desc">Imperdiet nisi potenti fermentum vehicula eleifend elementum varius netus adipiscing neque quisque</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumb">
                    <header class="thumb-header"><i class="fa fa-thumbs-o-up box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                    </header>
                    <div class="thumb-caption">
                        <h5 class="thumb-title"><a class="text-darken" href="#">Best Travel Agent</a></h5>
                        <p class="thumb-desc">Curae urna fusce massa a lacus nisl id velit magnis venenatis consequat</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="gap gap-small"></div>
    </div>
    <div class="bg-holder">
        <div class="bg-mask"></div>
        <div class="bg-parallax" style="background-image:url(img/hotel_the_cliff_bay_spa_suite_2048x1310.jpg);"></div>
        <div class="bg-content">
            <div class="container">
                <div class="gap gap-big text-center text-white">
                    <h2 class="text-uc mb20">Top Hotels in Demand</h2>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="gap"></div>
        <div class="gap">
            <div class="row row-wrap">
                @foreach($hotels  as $hotel)
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="{{route('hotel.show',$hotel->id)}}" >
                                    <img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" alt="{{$hotel->name}}" title="{{$hotel->name}}" height="160px">
                                    <h5 class="hover-title-center">Book Now</h5>
                                </a>
                            </header>
                            <div class="thumb-caption">

                                <h5 class="thumb-title"><a class="text-darken" href="#">{{$hotel->name}}</a></h5>
                                <p class="mb0"><small>{{$hotel->address}}</small>
                                </p>
                                <p class="mb0 text-darken"><span class="text-lg lh1em">Rs {{collect($hotel->rooms)->min('room_flat_cost')}}</span><small> /night</small>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-holder">
        <div class="bg-mask"></div>
        <div class="bg-parallax" style="background-image:url(img/hotel_the_cliff_bay_spa_suite_2048x1310.jpg);"></div>
        <div class="bg-content">
            <div class="container">
                <div class="gap gap-big text-center text-white">
                    <h2 class="text-uc mb20">Vehicles in Demand</h2>



                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="gap"></div>
        <div class="gap">
            <div class="row row-wrap">
                @foreach($vehicles  as $vehicle)
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a href="{{route('vehicle.show',$vehicle->id)}}" class="hover-img curved">
                                    <img src="{{url('/')}}/storage/vehicle/{{$vehicle['image']}}" alt="{{$vehicle->name}}" title="{{$vehicle->name}}" height="160px">
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
                                <p class="text-darken mb0 text-color">Rs {{$vehicle->rate_per_day}}<small> /day</small>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-holder">
        <div class="bg-mask"></div>
        <div class="bg-parallax" style="background-image:url(img/hotel_the_cliff_bay_spa_suite_2048x1310.jpg);"></div>
        <div class="bg-content">
            <div class="container">
                <div class="gap gap-big text-center text-white">
                    <h2 class="text-uc mb20">Top Tour Packages</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="gap"></div>
        <div class="gap">
            <div class="row row-wrap">
                @foreach($tours as $tour)
                    <div class="col-md-3">
                        <div class="thumb " >
                            <header class="thumb-header">
                                <a class="hover-img curved" href="{{route('tour.show',$tour->id)}}">
                                    <img src="{{url('/')}}/storage/tourpackage/{{$tour['image']}}" title="{{$tour->name}}" height="160px">
                                    <i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </a>
                            </header>
                            <hr style="color:orange;">
                            <div class="thumb-caption">
                                <h4 class="thumb-title">{{$tour->name}}</h4>
                                <p class="thumb-desc">{{$tour->location}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection