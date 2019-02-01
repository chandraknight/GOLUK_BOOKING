@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{route('welcome')}}">Home</a>
            </li>
            <li class="active">Flights</li>
        </ul>
        <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
            <h3>Search for Flight</h3>
            <form>
                <div class="tabbable">
                    <ul class="nav nav-pills nav-sm nav-no-br mb10" id="flightChooseTab">
                        <li class="{{($search->return_date)?'active':''}}"><a href="#flight-search-1" data-toggle="tab">Round Trip</a>
                        </li>
                        <li class="{{($search->return_date)?'':'active'}}"><a href="#flight-search-2" data-toggle="tab">One Way</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in {{($search->return_date)?'active':''}}" id="flight-search-1">
                            <form method="post" action="{{route('flight.search')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-lg form-group-select-plus">
                                            <label>From</label>

                                            <select class="form-control" name="flight_depart">
                                                <option selected>Departure</option>

                                                @foreach($sectors as $key=>$value)
                                                    <option value="{{$key}}" {{($search->location==$key)?'selected':''}}>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('flight_depart'))
                                                <span style="color:red">{{$errors->first('flight_depart')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-lg form-group-select-plus">
                                            <label>To</label>

                                            <select class="form-control" name="flight_arrival">
                                                <option selected>Arrival</option>
                                                @foreach($sectors as $key=>$value)
                                                    <option value="{{$key}}" {{($search->destination==$key)?'selected':''}}>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('flight_arrival'))
                                                <span style="color:red">{{$errors->first('flight_arrival')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="input-daterange" data-date-format="M d, D">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                <label>Departing</label>
                                                <input class="form-control" data-date-format="yyyy-mm-dd" name="flight_date" value="{{$search->depart_date}}" type="text">
                                                @if($errors->has('flight_date'))
                                                    <span style="color:red">{{$errors->first('flight_date')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                <label>Returning</label>
                                                <input class="form-control" data-date-format="yyyy-mm-dd" name="flight_return" @if(isset($search->return_date))value="{{$search->return_date->format('yyyy-mm-dd')}}" @endif type="text">
                                                @if($errors->has('flight_return'))
                                                    <span style="color:red">{{$errors->first('flight_return')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-lg form-group-select-plus">
                                                <label>Children</label>

                                                <select class="form-control" name="flight_childs">
                                                    <option selected>0</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>

                                                </select>
                                                @if($errors->has('flight_childs'))
                                                    <span style="color:red">{{$errors->first('flight_childs')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-lg form-group-select-plus">
                                                <label>Adults</label>

                                                <select class="form-control" name="flight_adults" required>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>

                                                </select>
                                                @if($errors->has('flight_adults'))
                                                    <span style="color:red">{{$errors->first('flight_adults')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-lg form-group-select-plus">
                                                <label>Nationality</label>
                                                <select class="form-control" name="nationality">
                                                    <option selected value="NP">Nepalese</option>
                                                    <option value="">Others</option>
                                                </select>
                                                @if($errors->has('nationality'))
                                                    <span style="color:red">{{$errors->first('nationality')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-lg" type="submit">Search for Flights</button>
                            </form>
                        </div>
                        <div class="tab-pane fade {{($search->return_date)?'':'active'}}" id="flight-search-2">
                            <form method="post" action="{{route('flight.search')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-lg form-group-select-plus">
                                            <label>From</label>

                                            <select class="form-control" name="flight_depart">
                                                <option selected>Departure</option>

                                                @foreach($sectors as $key=>$value)
                                                    <option value="{{$key}}" {{($search->location==$key)?'selected':''}}>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('flight_depart'))
                                                <span style="color:red">{{$errors->first('flight_depart')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-lg form-group-select-plus">
                                            <label>To</label>

                                            <select class="form-control" name="flight_arrival">
                                                <option selected>Arrival</option>
                                                @foreach($sectors as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('flight_arrival'))
                                                <span style="color:red">{{$errors->first('flight_arrival')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                            <label>Departing</label>
                                            <input class="date-pick form-control" name="flight_date" data-date-format="yyyy-mm-dd" type="text">
                                            @if($errors->has('flight_date'))
                                                <span style="color:red">{{$errors->first('flight_date')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-lg form-group-select-plus">
                                            <label>Children</label>

                                            <select class="form-control" name="flight_childs">
                                                <option selected>0</option>
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
                                            @if($errors->has('flight_childs'))
                                                <span style="color:red">{{$errors->first('flight_childs')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-lg form-group-select-plus">
                                            <label>Adults</label>

                                            <select class="form-control" name="flight_adults" required>
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
                                            @if($errors->has('flight_adults'))
                                                <span style="color:red">{{$errors->first('flight_adults')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-lg form-group-select-plus">
                                            <label>Nationality</label>
                                            <select class="form-control" name="nationality">
                                                <option selected value="NP">Nepalese</option>
                                                <option value="">Others</option>
                                            </select>
                                            @if($errors->has('nationality'))
                                                <span style="color:red">{{$errors->first('nationality')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-lg" type="submit">Search for Flights</button>
                            </form>
                        </div>
                    </div>
                </div>

            </form>
        </div>
{{--        {{dd($flights['out'])}}--}}

        <h3 class="booking-title">{{count($flights['out']) + count($flights['in'])}} Flights from {{$search->location}} to {{$search->destination}}
            on {{$search->depart_date->toFormattedDateString()}} for {{$search->adults}} adults @if(isset($search->childs)) and {{$search->childs}} childs @endif
            <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></small></h3>
        @if(count($flights['out']) > 0)
            <div class="row">
            <div class="col-md-3">
                <form class="booking-item-dates-change mb30">
                    <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                        <label>From</label>
                        <input class="typeahead form-control" value="Great Britan, London" placeholder="City, Hotel Name or U.S. Zip Code" type="text">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                        <label>To</label>
                        <input class="typeahead form-control" value="United States, New York" placeholder="City, Hotel Name or U.S. Zip Code" type="text">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                        <label>Departing</label>
                        <input class="date-pick form-control" data-date-format="MM d, D" type="text">
                    </div>
                    <div class="form-group form-group-select-plus">
                        <label>Passengers</label>
                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="options">1</label>
                            <label class="btn btn-primary">
                                <input type="radio" name="options">2</label>
                            <label class="btn btn-primary">
                                <input type="radio" name="options">3</label>
                            <label class="btn btn-primary">
                                <input type="radio" name="options">4</label>
                            <label class="btn btn-primary">
                                <input type="radio" name="options">4+</label>
                        </div>
                        <select class="form-control hidden">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option selected="selected">5</option>
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
                    <input class="btn btn-primary" type="submit" value="Update Search">
                </form>

            </div>
            <div class="col-md-9">
                <div class="nav-drop booking-sort">
                    <h5 class="booking-sort-title"><a href="#">Sort: Sort: Price (low to high)<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                    <ul class="nav-drop-menu">
                        <li><a href="#">Price (high to low)</a>
                        </li>
                        <li><a href="#">Duration</a>
                        </li>
                        <li><a href="#">Stops</a>
                        </li>
                        <li><a href="#">Arrival</a>
                        </li>
                        <li><a href="#">Departure</a>
                        </li>
                    </ul>
                </div>
                <ul class="booking-list">
                    @foreach($flights['out'] as $flight)
                    <li>
                        <div class="booking-item-container">
                            <div class="booking-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="booking-item-airline-logo">
                                            <img src="{{$flight['logo']}}" alt="{{$flight['airline']}}" title="{{$flight['airline']}}">
                                            <p>{{$flight['airline']}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="booking-item-flight-details">
                                            <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                <h5>{{$flight['departuretime']}}</h5>
                                                <p class="booking-item-date">{{$flight['date']}}</p>
                                                <p class="booking-item-destination">{{$flight['departure']}}</p>
                                            </div>
                                            <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                <h5>{{$flight['arrivaltime']}}</h5>
                                                <p class="booking-item-date">{{$flight['date']}}</p>
                                                <p class="booking-item-destination">{{$flight['arrival']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h5>{{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</h5>
                                        <p>1 stop</p>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">{{$flight['currency']}} {{$flight['afare']}}</span><span>/adult</span>
                                        <p class="booking-item-flight-class">Class: {{$flight['class']}}</p>

                                        @if(count($flights['in']) <= 0)
                                           <form method="post" action="{{route('flight.reserve')}}">
                                               @csrf
                                               <input type="hidden" name="outflightid" value="{{$flight['flightid']}}">
                                               <input type="submit" class="btn btn-secondary" value="Book">
                                           </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="booking-item-details">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>Flight Details</p>
                                        <h5 class="list-title">{{$flight['departure']}} to {{$flight['arrival']}}</h5>
                                        <ul class="list">
                                            <li>{{$flight['flightno']}}</li>
                                            <li>{{$flight['class']}} / AirCraft Type : {{$flight['type']}}</li>
                                            <li>Depart {{$flight['departuretime']}} Arrive {{$flight['arrivaltime']}}</li>
                                            <li>Duration: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} minutes</li>
                                        </ul>
                                        {{--<h5>Stopover: Charlotte (CLT) 7h 1m</h5>--}}
                                        <h5 class="list-title">Pricing</h5>
                                        <ul class="list">
                                            <li>Adult Fare: {{$flight['currency']}} {{$flight['afare']}}</li>
                                            <li>Child Fare: {{$flight['currency']}} {{$flight['cfare']}}</li>
                                            <li>Infant Fare: {{$flight['currency']}} {{$flight['ifare']}}</li>
                                            <li>Fuel Surcharge: {{$flight['currency']}} {{$flight['fuel']}}</li>
                                            <li>Tax: {{$flight['currency']}} {{$flight['tax']}}</li>
                                            <li>Baggage: {{$flight['baggage']}}</li>
                                            <li>Refundable: {{$flight['refund']}}</li>
                                            <li>Duration: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</li>
                                        </ul>
                                        <p>Total trip time: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                     @endforeach
                    @if(count($flights['in']) > 0)
                        @foreach($flights['in'] as $flight)
                            <li>
                                <div class="booking-item-container">
                                    <div class="booking-item">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="booking-item-airline-logo">
                                                    <img src="{{$flight['logo']}}" alt="{{$flight['airline']}}" title="{{$flight['airline']}}">
                                                    <p>{{$flight['airline']}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="booking-item-flight-details">
                                                    <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                        <h5>{{$flight['departuretime']}}</h5>
                                                        <p class="booking-item-date">{{$flight['date']}}</p>
                                                        <p class="booking-item-destination">{{$flight['departure']}}</p>
                                                    </div>
                                                    <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                        <h5>{{$flight['arrivaltime']}}</h5>
                                                        <p class="booking-item-date">{{$flight['date']}}</p>
                                                        <p class="booking-item-destination">{{$flight['arrival']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <h5>{{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</h5>
                                                <p>1 stop</p>
                                            </div>
                                            <div class="col-md-3"><span class="booking-item-price">{{$flight['currency']}} {{$flight['afare']}}</span><span>/adult</span>
                                                <p class="booking-item-flight-class">Class: {{$flight['class']}}</p>
                                                <a class="btn btn-primary" href="#">Details</a>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="booking-item-details">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p>Flight Details</p>
                                                <h5 class="list-title">{{$flight['departure']}} to {{$flight['arrival']}}</h5>
                                                <ul class="list">
                                                    <li>{{$flight['flightno']}}</li>
                                                    <li>{{$flight['class']}} / AirCraft Type : {{$flight['type']}}</li>
                                                    <li>Depart {{$flight['departuretime']}} Arrive {{$flight['arrivaltime']}}</li>
                                                    <li>Duration: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} minutes</li>
                                                </ul>
                                                {{--<h5>Stopover: Charlotte (CLT) 7h 1m</h5>--}}
                                                <h5 class="list-title">Pricing</h5>
                                                <ul class="list">
                                                    <li>Adult Fare: {{$flight['currency']}} {{$flight['afare']}}</li>
                                                    <li>Child Fare: {{$flight['currency']}} {{$flight['cfare']}}</li>
                                                    <li>Infant Fare: {{$flight['currency']}} {{$flight['ifare']}}</li>
                                                    <li>Fuel Surcharge: {{$flight['currency']}} {{$flight['fuel']}}</li>
                                                    <li>Tax: {{$flight['currency']}} {{$flight['tax']}}</li>
                                                    <li>Baggage: {{$flight['baggage']}}</li>
                                                    <li>Refundable: {{$flight['refund']}}</li>
                                                    <li>Duration: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</li>
                                                </ul>
                                                <p>Total trip time: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <p class="text-right">Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                </p>
            </div>
        </div>
        @else
            No Flights available
            @endif
        <div class="gap"></div>
    </div>
@endsection