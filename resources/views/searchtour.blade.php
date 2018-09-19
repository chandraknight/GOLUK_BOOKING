@extends('layouts.app')
@section('content')
   <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('welcome')}}">Home</a>
                </li>
               
                <li class="active">Things to Do in {{$search->destination}}</li>
            </ul>
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Activity</h3>
                <form action="{{route('toursearch')}}" method="get">
                    <div class="input-daterange" data-date-format="MM d, D">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                                    <label>Location</label>
                                    <input class="form-control" placeholder="City" type="text" name="destination">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>From</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>To</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="till" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>People</label>
                                    <input class="form-control" name="people" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg" type="submit">Search for Activities</button>
                </form>
            </div>
            <h3 class="booking-title">{{$tours->count()}} things to do in {{$search->destination}} on {{\Carbon\Carbon::parse($search->from)->toFormattedDateString()}} -{{\Carbon\Carbon::parse($search->to)->toFormattedDateString()}} <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></small></h3>
            <div class="row">
                
                <div class="col-md-9">
                   
                    <div class="row row-wrap">
                       @forelse($tours as $tour) 
                       <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{route('tour.show',$tour->id)}}">
                                        <img src="{{url('/')}}/storage/tourpackage/{{$tour['image']}}" alt="{{$tour->name}}" title="{{$tour->name}}">
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    
                                    <h5 class="thumb-title"><a class="text-darken" href="{{route('tour.show',$tour->id)}}">{{$tour->name}}</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> {{$tour->location}}</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">Rs {{$tour->price}}</span>  <small> /person</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Tours available
                        @endforelse
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            
                        </div>
                        <div class="col-md-6 text-right">
                            <p>Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
        </div>
@endsection