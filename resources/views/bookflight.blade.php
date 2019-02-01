@extends('layouts.app')
@section('content')
    <div class="container">
        @if($response)
        <div class="row">
            <form method="post" action="{{route('bookflight')}}">
                @csrf
                <div class="col-md-8">
                    <h3>Customer</h3>
                    @if(!Auth::user())
                    <p>Sign in to your <a href="{{route('login')}}">Traveler account</a> for fast booking.</p>
                    @endif

                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First & Last Name</label>
                                    <input class="form-control" required name="customer_name" value="{{(Auth::user())?Auth::user()->name:old('customer_name')}}" type="text">
                                    @if($errors->has('customer_name'))
                                        {{$errors->first('customer_name')}}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" required name="customer_phone" value="{{old('customer_phone')}}" type="text">
                                    @if($errors->has('customer_phone'))
                                        {{$erros->first('customer_phone')}}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" required name="customer_email" value="{{(Auth::user())?Auth::user()->email:old('customer_email')}}" type="email">
                                    @if($errors->has('customer_email'))
                                        {{$errors->first('customer_email')}}
                                    @endif
                                </div>
                            </div>
                        </div>

                    <div class="gap gap-small"></div>
                    <h3>Passengers</h3>
                    <ul class="list booking-item-passengers">
                        @for($i=1;$i<=$search->adults+$search->childs;$i++)
                        <li>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Sex</label>
                                    <div class="radio-inline radio-small">
                                        <label>
                                            <input class="i-radio" checked type="radio" value="M" name="pax_gender[{{$i}}]">Male</label>
                                    </div>
                                    <div class="radio-inline radio-small">
                                        <label>
                                            <input class="i-radio" type="radio" value="F" name="pax_gender[{{$i}}]">Female</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-select-plus">
                                        <label>Title</label>

                                        <select class="form-control" required name="pax_title[]">
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Mis">Mis</option>
                                        </select>
                                        @if($errors->has('pax_title'))
                                            <span style="color:red">{{$errors->first('pax_title')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input class="form-control" required name="pax_name[]" type="text">
                                        @if($errors->has('pax_name'))
                                            {{$errors->first('pax_name')}}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Surname</label>
                                        <input class="form-control" required name="pax_surname[]" type="text">
                                        @if($errors->has('pax_surname'))
                                            {{$errors->first('pax_surname')}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-group-select-plus">
                                        <label>Natonality</label>

                                        <select class="form-control" required name="pax_nationality[]">
                                            <option value="NP">Nepali</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        @if($errors->has('pax_nationality'))
                                            <span style="color:red">{{$errors->first('pax_nationality')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-select-plus">
                                        <label>Type</label>

                                        <select class="form-control" required name="pax_type[]">
                                            <option value="ADULT">Adult</option>
                                            <option value="CHILD">Child</option>
                                        </select>
                                        @if($errors->has('pax_nationality'))
                                            <span style="color:red">{{$errors->first('pax_nationality')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-lg">
                                        <label>Remarks</label>
                                        <input class="form-control" name="pax_remarks[]" type="text">
                                    </div>
                                </div>
                            </div>

                        </li>
                        @endfor
                    </ul>

                    <div class="gap gap-small"></div>

                </div>
                <div class="col-md-4">
                    <div class="booking-item-payment">
                        {{--{{dd($details)}}--}}
                    @foreach($details as $detail)
                        <input type="hidden" name="flightid[]" value="{{$detail['flightid']}}">
                    <header class="clearfix">
                        <h5 class="mb0">PNR: {{$response[$loop->iteration-1]['pnr']}} Issue Before: {{$response[$loop->iteration-1]['ttltime']}}</h5>
                        <input type="hidden" name="pnr[]" value="{{$response[$loop->iteration-1]['pnr']}}">
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Flight Details</h5>
                            <div class="booking-item-payment-flight">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="booking-item-flight-details">
                                            <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                <h5>{{$detail['departuretime']}}</h5>
                                                <p class="booking-item-date">{{$detail['flightdate']}}</p>
                                                <p class="booking-item-destination">{{$detail['departure']}}</p>
                                            </div>
                                            <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                <h5>{{$detail['arrivaltime']}}</h5>
                                                <p class="booking-item-date">{{$detail['flightdate']}}</p>
                                                <p class="booking-item-destination">{{$detail['arrival']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="booking-item-flight-duration">
                                            <p>Duration</p>
                                            <h5>{{\Carbon\Carbon::parse($detail['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($detail['arrivaltime']))}} mins</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li>
                        <h5>Flight ({{$search->adults + $search->childs}} Passengers)</h5>
                        <ul class="booking-item-payment-price">
                            <li>
                                <p class="booking-item-payment-price-title">{{$search->adults}} Adult{{($search->adults>1)?'s':''}}</p>
                                <p class="booking-item-payment-price-amount">{{$detail['currency']}} {{$detail['afare']}}<small>/per adult</small>
                                </p>
                            </li>

                            @if($search->childs > 0 )
                            <li>
                                <p class="booking-item-payment-price-title">{{$search->childs}} Child{{($search->childs>1)?'ren':''}}</p>
                                <p class="booking-item-payment-price-amount">{{$detail['currency']}} {{$detail['cfare']}}<small>/per child</small>
                                </p>
                            </li>

                            @endif

                            <li>
                                <p class="booking-item-payment-price-title">Fuel Surcharge   </p>
                                <p class="booking-item-payment-price-amount"> &nbsp;   {{$detail['currency']}} {{$detail['fuel']}}<small>/per passenger</small>
                                </p>
                            </li>
                            <li>
                                <p class="booking-item-payment-price-title">Taxes</p>
                                <p class="booking-item-payment-price-amount">{{$detail['currency']}} {{$detail['tax']}}<small>/per passenger</small>
                                </p>
                            </li>
                        </ul>
                        </li>
                    </ul>
                    @endforeach
                        <input type="hidden" name="total" value="{{$price}}">
                    <p class="booking-item-payment-total">Total trip: <span>{{$detail['currency']}} {{$price}}</span>
                    </p>
                    </div>
                    <input type="submit" class="btn btn-block btn-success" value="Issue Ticket">
            </form>
                </div>

        </div>

        @else
        <h3>Error,Please Try Again</h3>
        @endif
        <div class="gap"></div>
    </div>
@endsection