@extends('layouts.app')
@section('content')
    <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('welcome')}}">Home</a>
                </li>
                
                
                <li><a href="{{route('listtour')}}">Tours</a>
                </li>
                <li class="active">{{$tour->name}}</li>
            </ul>
            <div class="booking-item-details">
                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em">{{$tour->name}}</h2>
                            <p class="lh1em text-small"><i class="fa fa-map-marker"></i>{{$tour->location}}</p>
                            <ul class="list list-inline text-small">
                                <li><a href="#"><i class="fa fa-envelope"></i> {{$tour->email}}</a>
                                </li>
                                <li><a href="#"><i class="fa fa-home"></i>{{$tour->provider}}</a>
                                </li>
                                <li><i class="fa fa-phone"></i>{{$tour->contact}}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <p class="booking-item-header-price"><small>price</small>  <span class="text-lg">Rs {{$tour->price}}</span><small>/person</small>
                            </p>
                        </div>
                    </div>
                </header>
                <div class="row">
                    <div class="col-md-7">
                        <div class="tabbable booking-details-tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                                </li>
                                 <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-bars"></i>Description</a>
                                </li>
                                 <li><a href="#tab-3" data-toggle="tab"><i class="fa fa-clock"></i>Itenary</a>
                                </li>
                                <li><a href="#tab-4" data-toggle="tab"><i class="fa fa-clock"></i>Information</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-1">
                                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                                        @foreach($galleries as $gallery)
                                        <img src="{{url('/')}}/storage/tourgallery/{{$gallery->image}}" alt="{{$tour->name}}" title="{{$tour->name}}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2">
                                    {!!$tour->description!!}
                                </div>
                                <div class="tab-pane fade" id="tab-3">
                                    {!!$tour->itenary!!}
                                </div>  
                                <div class="tab-pane fade" id="tab-4">
                                    {!!$tour->info!!}
                                </div>    
                                                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="booking-item-meta">
                            <h2 class="lh1em mt40">Exeptional!</h2>
                        </div>
                        <div class="gap gap-small">
                           <div>
                            <i class="fa fa-fire box-icon-large box-icon-left box-icon-warning box-icon-to-danger animate-icon-border-fadein"></i>  
                            <ul class="list dis-table">
                                <li>For Groups</li>
                                <li>Size: {{$tour->group_size}}</li>
                                <li>Group Rate: <p class="booking-item-header-price"><small>price</small>  <span class="text-md">Rs {{$tour->group_price}}</span><small>/person</small>
                            </p> </li>
                            </ul>
                        </div>
                        </div>
                        @if(session()->has('search_tour_id'))
                        <a href="{{route('booktour',$tour->id)}}" class="btn btn-primary btn-lg">Add to Trip</a>
                        @else
                            <a class="popup-text btn btn-primary" href="#search-dialog" data-effect="mfp-zoom-out">Reserve</a>
                        @endif
                    </div>
                </div>
            </div>
                
<div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Book {{$tour->name}}</h3>
                <form action="{{route('tour.book.session')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="tour_id" value="{{$tour->id}}">
                    <div class="input-daterange" data-date-format="MM d, D">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-lg form-group-icon-left">
                                    <i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                                    <label>Location</label>
                                    <input class="form-control" placeholder="" type="text" value="{{$tour->location}}" name="destination">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>From</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="from" type="text" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Till</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="till" type="text" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-male input-icon input-icon-highlight"></i>
                                    <label>People</label>
                                    <input class="form-control " name="people" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg" type="submit">Book</button>
                </form>
            </div>                           
            
            <div class="gap gap-small"></div>
        </div>
@endsection