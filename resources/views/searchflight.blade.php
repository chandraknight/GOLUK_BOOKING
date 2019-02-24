@extends('layouts.app')
@section('content')
{{--  {{ dd($flights['out']) }}  --}}
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{route('welcome')}}">Home</a>
            </li>
            <li class="active">Flights</li>
        </ul>
        <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
            <h3>Search for Flight</h3>

                <div class="tabbable">
                    <ul class="nav nav-pills nav-sm nav-no-br mb10" id="flightChooseTab">
                        <li class="{{  ($search->return_date != null)?'active':'' }}"><a href="#flight-search-1" data-toggle="tab">Round Trip</a>
                        </li>
                        <li class="{{  ($search->return_date == null)?'active':'' }}"><a href="#flight-search-2" data-toggle="tab">One Way</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in {{  ($search->return_date != null)?'active':'' }}" id="flight-search-1">
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
                        <div class="tab-pane fade {{  ($search->return_date == null)?'active':'' }}" id="flight-search-2">
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
                                                <option>0</option>
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
                                                <option {{}}>0</option>
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
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="{{ ($search->return_date != null)?'active':'' }}"><a href="#tab-1" data-toggle="tab">Round Trip</a>
                        </li>
                        <li class="{{ ($search->return_date == null)?'active':'' }}"><a href="#tab-2" data-toggle="tab">One Way</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in {{ ($search->return_date != null)?'active':'' }} " id="tab-1">
                            <form class="booking-item-dates-change mb30" method="post" action="{{ route('flight.search') }}">
                                @csrf
                                <div class="form-group  form-group-select-plus">
                                    <label>Departure</label>
                                    <select class="form-control" name="flight_depart">
                                        @foreach($sectors as $key=>$value)
                                            <option value="{{$key}}" {{($search->location==$key)?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select> 
                                    @if($errors->has('flight_depart'))
                                        <span style="color:red">{{$errors->first('flight_depart')}}</span> 
                                    @endif
                                </div>
                                <div class="form-group  form-group-select-plus">
                                    <label>Arrival</label>
                                    <select class="form-control" name="flight_arrival">
                                        @foreach($sectors as $key=>$value)
                                            <option value="{{$key}}" {{  ($search->destination==$key)?'selected':'' }}>{{  $value }}</option>
                                        @endforeach
                                    </select> 
                                    @if($errors->has('flight_arrival'))
                                        <span style="color:red">{{  $errors->first('flight_arrival') }}</span> 
                                    @endif
                                </div>
                                <div class="form-group  form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Departing</label>
                                    <input class="date-pick form-control" name="flight_date" value="{{ $search->depart_date }}" data-date-format="yyyy-mm-dd" type="text">
                                    @if($errors->has('flight_date'))
                                        <span style="color:red">{{  $errors->first('flight_date') }}</span> 
                                    @endif
                                </div>
                                <div class="form-group  form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Return</label>
                                    <input class="date-pick form-control" name="flight_return" value="{{ $search->return_date }}" data-date-format="yyyy-mm-dd" type="text">
                                    @if($errors->has('flight_return'))
                                        <span style="color:red">{{ $errors->first('flight_return') }}</span> 
                                    @endif
                                </div>
                                    <div class="form-group  form-group-select-plus">
                                        <label>Adults</label>
                                        <select class="form-control" name="flight_adults" required>
                                            <option {{($search->adults == 0)?'selected':''}}>0</option>
                                            <option {{($search->sdults == 1)?'selected':''}}>1</option>
                                            <option {{($search->sdults == 2)?'selected':''}}>2</option>
                                            <option {{($search->sdults == 3)?'selected':''}}>3</option>
                                            <option {{($search->sdults == 4)?'selected':''}}>4</option>
                                            <option {{($search->sdults == 5)?'selected':''}}>5</option>
                                            <option {{($search->sdults == 6)?'selected':''}}>6</option>
                                        </select> 
                                        @if($errors->has('flight_adults'))
                                        <span style="color:red">{{  $errors->first('flight_adults') }}</span> 
                                        @endif
                                    </div>
                                    <div class="form-group  form-group-select-plus">
                                        <label>Childs</label>
                                        <select class="form-control" name="flight_childs" required>
                                            <option {{ (old('flight_childs') == 0)?'selected':'' }}>0</option>
                                            <option {{ (old('flight_childs') == 1)?'selected':'' }}>1</option>
                                            <option {{ (old('flight_childs') == 2)?'selected':'' }}>2</option>
                                            <option {{ (old('flight_childs') == 3)?'selected':'' }}>3</option>
                                            <option {{ (old('flight_childs') == 4)?'selected':'' }}>4</option>
                                            <option {{ (old('flight_childs') == 5)?'selected':'' }}>5</option>
                                            <option {{ (old('flight_childs') == 6)?'selected':'' }}>6</option>
                                        </select> 
                                        @if($errors->has('flight_childs'))
                                        <span style="color:red">{{  $errors->first('flight_childs') }}</span> 
                                        @endif
                                    </div>
                                    <div class="form-group  form-group-select-plus">
                                        <label>Nationality</label>
                                        <select class="form-control" name="nationality">
                                            <option selected value="NP">Nepalese</option>
                                            <option value="US">Others</option>
                                        </select> 
                                        @if($errors->has('nationality'))
                                        <span style="color:red">{{  $errors->first('nationality') }}</span> 
                                        @endif
                                    </div>
                                <input class="btn btn-primary" type="submit" value="Update Search">
                            </form>
                        </div>
                        <div class="tab-pane fade in {{ ($search->return_date == null)?'active':'' }}" id="tab-2">
                            <form class="booking-item-dates-change mb30" method="post" action="{{ route('flight.search') }}">
                                @csrf
                                <div class="form-group  form-group-select-plus">
                                    <label>Departure</label>
                                    <select class="form-control" name="flight_depart">

                                        @foreach($sectors as $key=>$value)
                                            <option value="{{$key}}" {{ ($search->location==$key)?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select> 
                                    @if($errors->has('flight_depart'))
                                    <span style="color:red">{{$errors->first('flight_depart')}}</span> 
                                    @endif
                                </div>
                                <div class="form-group  form-group-select-plus">
                                    <label>Arrival</label>
                            
                                    <select class="form-control" name="flight_arrival">

                                        @foreach($sectors as $key=>$value)
                                            <option value="{{$key}}" {{($search->destination==$key)?'selected':''}}>{{ $value }}</option>
                                        @endforeach
                                    </select> 
                                    @if($errors->has('flight_arrival'))
                                    <span style="color:red">{{ $errors->first('flight_arrival') }}</span> 
                                    @endif
                                </div>
                                <div class="form-group  form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Departing</label>
                                    <input class="date-pick form-control" name="flight_date" data-date-format="yyyy-mm-dd" type="text"> @if($errors->has('flight_date'))
                                    <span style="color:red">{{$errors->first('flight_date')}}</span> @endif
                                </div>
                                
                                <div class="form-group  form-group-select-plus">
                                    <label>Adults</label>
                                    <select class="form-control" name="flight_adults" required>
                                        <option {{($search->adults == 0)?'selected':''}}>0</option>
                                        <option {{($search->adults == 1)?'selected':''}}>1</option>
                                        <option {{($search->adults == 2)?'selected':''}}>2</option>
                                        <option {{($search->adults == 3)?'selected':''}}>3</option>
                                        <option {{($search->adults == 4)?'selected':''}}>4</option>
                                        <option {{($search->adults == 5)?'selected':''}}>5</option>
                                        <option {{($search->adults == 6)?'selected':''}}>6</option>
                                    </select> 
                                    @if($errors->has('flight_adults'))
                                    <span style="color:red">{{$errors->first('flight_adults')}}</span> 
                                    @endif
                                </div>
                                <div class="form-group form-group-lg form-group-select-plus">
                                    <label>Childs</label>
                                    <select class="form-control" name="flight_childs" required>
                                        <option {{($search->childs == 0)?'selected':''}}>0</option>
                                        <option {{($search->childs == 1)?'selected':''}}>1</option>
                                        <option {{($search->childs == 2)?'selected':''}}>2</option>
                                        <option {{($search->childs == 3)?'selected':''}}>3</option>
                                        <option {{($search->childs == 4)?'selected':''}}>4</option>
                                        <option {{($search->childs == 5)?'selected':''}}>5</option>
                                        <option {{($search->childs == 6)?'selected':''}}>6</option>
                                    </select> 
                                    @if($errors->has('flight_childs'))
                                    <span style="color:red">{{ $errors->first('flight_childs') }}</span> 
                                    @endif
                                </div>
                                <div class="form-group  form-group-select-plus">
                                    <label>Nationality</label>
                                    <select class="form-control" name="nationality">
                                        <option selected value="NP">Nepalese</option>
                                        <option value="US">Others</option>
                                    </select> 
                                    @if($errors->has('nationality'))
                                    <span style="color:red">{{  $errors->first('nationality') }}</span> 
                                    @endif
                                </div>
                                <input class="btn btn-primary" type="submit" value="Update Search">
                            </form>
                        </div>
                    </div>
                </div>
                <aside class="booking-filters text-white">

                    <ul class="list booking-filters-list">



                        <li>
                            <h5 class="booking-filters-title">Airlines </h5>
                           @foreach($airlines as $airline)
                            <div class="checkbox">
                                <label class="">
                                    <div class="i-check"><input class="i-check" type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>{{ $airline }}
                                </label>
                            </div>
                               @endforeach
                        </li>

                    </ul>
                </aside>

            </div>
            <div class="col-md-9">
                <div class="nav-drop booking-sort">
                    <h5 class="booking-sort-title"><a href="#">Sort: <i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                    <ul class="nav-drop-menu">
                        <li><a href="#" class="sort" id="hightolow">Price (high to low)</a>
                        </li>
                        <li><a href="#" class="sort" id="lowtohigh">Price (low to high)</a>
                        </li>
                        <li><a href="#" class="sort" id="airline">Airline(A-Z)</a>
                        </li>
                    </ul>

                </div>
                <ul class="booking-list">
                    @if(count($flights['in']) > 0) 
                        <form method="post" action="{{ route('flight.reserve') }}">
                            @csrf
                    @endif
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
                                    <div class="col-md-3"><span class="booking-item-price">{{$flight['currency']}} {{$flight['tafare']}}</span><span>/adult</span>
                                        <p class="booking-item-flight-class">Class: {{$flight['class']}}</p>

                                        @if(count($flights['in']) <= 0)
                                           <form method="post" action="{{route('flight.reserve')}}">
                                               @csrf
                                               <input type="hidden" name="outflightid" value="{{$flight['flightid']}}">
                                               <input type="submit" class="btn btn-primary" value="Book">
                                           </form>
                                        @endif
                                    </div>
                                </div>
                                @if(count($flights['in']) > 0) 
                                <input type="radio" name="outflightid" value="{{ $flight['flightid']}}"/> Select flight
                                @endif
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
                                            <li>Adult Base Fare: {{$flight['currency']}} {{$flight['afare']}}</li>
                                            <li>Child Base Fare: {{$flight['currency']}} {{$flight['cfare']}}</li>
                                            <li>Infant Base Fare: {{$flight['currency']}} {{$flight['ifare']}}</li>
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
                                            <div class="col-md-3"><span class="booking-item-price">{{$flight['currency']}} {{$flight['tafare']}}</span><span>/adult</span>
                                                <p class="booking-item-flight-class">Class: {{$flight['class']}}</p>
                                                {{--  <a class="btn btn-primary" href="#">Details</a>  --}}

                                            </div>
                                        </div>
                                        <input type="radio" name="returnflightid" value="{{ $flight['flightid']}}" /> Select flight
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
                                                    <li>Adult Base Fare: {{$flight['currency']}} {{$flight['afare']}}</li>
                                                    <li>Child Base Fare: {{$flight['currency']}} {{$flight['cfare']}}</li>
                                                    <li>Infant Base Fare: {{$flight['currency']}} {{$flight['ifare']}}</li>
                                                    <li>Fuel Surcharge: {{$flight['currency']}} {{$flight['fuel']}}</li>
                                                    <li>Tax: {{$flight['currency']}} {{$flight['tax']}}</li>
                                                    <li>Baggage: {{  $flight['baggage'] }}</li>
                                                    <li>Refundable: {{$flight['refund']}}</li>
                                                    <li>Duration: {{  \Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</li>
                                                </ul>
                                                <p>Total trip time: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}} mins</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                    @if(count($flights['in']) > 0)
                    <input type="submit" value="Reserve" class="btn btn-primary">
                    @endif
                </ul>
                <p class="text-right">Not what you are looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                </p>
            </div>
        </div>
        @else
            No Flights available
            @endif
        <div class="gap"></div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        let outbound = <?php echo $flights['out'] ?>;
        let inbound = <?php echo $flights['in'] ?>;
        $('.sort').on('click',function(){
            let sorttype = this.id;
            $.ajax({
                method: 'post',
                dataType: 'json',
                url: '{{ route('sortflight') }}',
                data: {outbound: outbound,inbound:inbound,sorttype:sorttype,_token:'{{ csrf_token() }}' },
                beforeSend: function(){
                  $('.booking-list').hide();
                },
                success : function(data){
                    $('.booking-list').html(data.output);
                    $('.booking-list').show();
                }
            });    
        });
        
    });
</script>
@endsection