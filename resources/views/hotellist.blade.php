@extends('layouts.app')
@section('content')
   <div class="container">
            <h1 class="page-title">Search for Hotels</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        <form  method="get" action="{{route('hotelsearch.index')}}">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Where</label>
                                <input class="typeahead form-control" placeholder="City, Hotel Name or U.S. Zip Code" type="text" name="destination">
                            </div>
                            <div class="input-daterange" data-date-format="MM d, D">
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check in</label>
                                    <input class="form-control date-pick" name="from_date" type="text">
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check out</label>
                                    <input class="form-control date-pick" name="till_date" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group- form-group-select-plus">
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
                            <div class="form-group form-group-select-plus">
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
                            <input class="btn btn-primary mt10" type="submit" value="Search for Hotels">
                        </form>
                    </aside>
                </div>
                <div class="col-md-9">
                    <h3 class="mb20">Hotels in Popular Destinations</h3>
                    @foreach($hotels->chunk(3) as $h)
                    <div class="row row-wrap">
                        @foreach($h as $hotel)
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{route('hotel.show',$hotel->id)}}">
                                    <img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" alt="Image Alternative text" title="{{$hotel->name}}">
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>{{$hotel->name}}</h5>
                                            <p>{{$hotel->contact}}</p>
                                            <p class="mb0">{{$hotel->email}}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    <div class="gap"></div>
                    
                </div>
            </div>
        </div>
@endsection