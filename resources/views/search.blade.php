@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="breadcrumb">
                <li><a href="{{route('welcome')}}">Home</a>
                </li>
                <li><a href="{{route('hotel.list')}}">Hotels</a>
                </li>
            </ul>
             <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Hotel</h3>
                <form method="get" action="{{route('hotelsearch.index')}}">
                	{{csrf_field()}}
                    <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                        <label>Where are you going?</label>
                        <input class="typeahead form-control" placeholder="City, Airport, Point of Interest, Hotel Name or U.S. Zip Code" name="destination" type="text">
                    </div>
                    <div class="input-daterange">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Check-in</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from_date" type="date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Check-out</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="till_date" type="date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-select-plus">
                                    <label>Rooms</label>
                                    <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                        <label class="btn btn-primary active">
                                            <input type="radio" name="no_childs">1</label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="no_childs">2</label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="no_childs">3</label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="no_childs">3+</label>
                                    </div>
                                    <select class="form-control hidden" name="no_childs">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option selected="selected">4</option>
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
                                    <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                        <label class="btn btn-primary">
                                            <input type="radio" name="no_adults">1</label>
                                        <label class="btn btn-primary active">
                                            <input type="radio" name="no_adults">2</label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="no_adults">3</label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="no_adults">3+</label>
                                    </div>
                                    <select class="form-control hidden" name="no_adults">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option selected="selected">4</option>
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
            <h3 class="booking-title">{{$hotels->count()}} hotels in {{$search->destination}} on {{\Carbon\Carbon::parse($search->from_date)->toFormattedDateString()}} - {{\Carbon\Carbon::parse($search->to_date)->toFormattedDateString()}} for {{$search->no_adults}} adult <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></small></h3>
            <div class="row">
               
                <div class="col-md-12">
                    
                    <ul class="booking-list">
                        @forelse($hotels as $hotel)
                        <li>
                            <a class="booking-item" href="{{route('hotel.show',$hotel->id)}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-img-wrap">
                                            <img src="{{URL::asset('img\hotel_2_800x600.jpg')}}" alt="Image Alternative text" title="hotel 2">
                                            <div class="booking-item-img-num"><i class="fa fa-picture-o"></i>10</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="booking-item-title">{{$hotel->name}}</h5>
                                        <p class="booking-item-address"><i class="fa fa-map-marker"></i> {{$hotel->address}}</p>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price-from">from</span><span class="booking-item-price">Rs {{collect($hotel->rooms)->min('room_flat_cost')}}</span><span>/night</span><span class="btn btn-primary">More</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        No Hotels Available
                        @endforelse
                    </ul>
                </div>
            </div>
    </div>
@endsection