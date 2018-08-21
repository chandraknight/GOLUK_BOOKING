@extends('layouts.app')
@section('content')
   <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('welcome')}}">Home</a>
                </li>
                
                <li><a href="{{route('hotel.show',$hotel->id)}}">{{$hotel->name}}</a>
                </li>
                <li class="active">{{$room->room_no}}</li>
            </ul>
            <div class="booking-item-details">
                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em">{{$hotel->name}}-{{$room->room_no}}</h2>
                            <p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$hotel->address}}</p>
                            <ul class="list list-inline text-small">
                                <li><a href="#"><i class="fa fa-envelope"></i>{{$hotel->email}}</a>
                                </li>
                                <li><a href="#"><i class="fa fa-home"></i>{{$hotel->website}}</a>
                                </li>
                                <li><i class="fa fa-phone"></i> {{$hotel->contact}}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <p class="booking-item-header-price"><small>price from</small>  <span class="text-lg">Rs {{$room->room_flat_cost}}</span>/night</p>
                        </div>
                    </div>
                </header>
                <div class="row">
                    <div class="col-md-6">
                        <div class="tabbable booking-details-tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                                </li>
                               
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-1">
                                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                                        @foreach($roomgalleries as $roomgallery)                                       
                                        <img src="{{url('/')}}/storage/rooms/{{$room->hotel_id}}/{{$roomgallery->image}}" alt="Image Alternative text" title="{{$hotel->name}}">
                                        @endforeach
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-2">
                        <h4>About the Hotel</h4>
                        <p class="mb30">{!!$hotel->description!!}</p>
                    </div>
                   
                </div>
            </div>
                <div class="gap"></div>
                <h3>Available Rooms</h3>
                <div class="row">
                    <div class="col-md-9">
                        <ul class="booking-list">
                            @foreach($otherrooms as $otherroom)
                            <li>
                                <a class="booking-item" href="{{route('room.show',$otherroom->id)}}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="{{url('/')}}/storage/rooms/{{$otherroom->hotel_id}}/{{$otherroom->image}}" alt="Image Alternative text" title="The pool">
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="booking-item-title">{{$otherroom->room_no}}</h5>
                                            <p class="text-small">Sit cras diam nec morbi erat mi at quam consectetur praesent litora mauris</p>
                                            <ul class="booking-item-features booking-item-features-sign clearfix">
                                                <li rel="tooltip" data-placement="top" title="Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$otherroom->no_adults}}</span>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Beds"><i class="im im-bed"></i><span class="booking-item-feature-sign">x {{$otherroom->no_beds}}</span>
                                                </li>
                                                
                                            </ul>
                                            <ul class="booking-item-features booking-item-features-small clearfix">
                                                <li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Flat Screen TV"><i class="im im-tv"></i>
                                                </li>
                                               
                                               
                                                <li rel="tooltip" data-placement="top" title="Terrace"><i class="im im-terrace"></i>
                                                </li>
                                               
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">Rs {{$otherroom->room_flat_cost}}<small>/night</small></span><span class="btn btn-primary">More</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                       
                        
                       
                    
                    <div class="col-md-3">
                        
                        <h4>Hotel Facilities</h4>
                        <ul class="booking-item-features booking-item-features-expand mb30 clearfix">
                            <li><i class="im im-wi-fi"></i><span class="booking-item-feature-title">Wi-Fi Internet</span>
                            </li>
                            <li><i class="im im-parking"></i><span class="booking-item-feature-title">Parking</span>
                            </li>
                            <li><i class="im im-plane"></i><span class="booking-item-feature-title">Airport Transport</span>
                            </li>
                            <li><i class="im im-bus"></i><span class="booking-item-feature-title">Shuttle Bus Service</span>
                            </li>
                            <li><i class="im im-fitness"></i><span class="booking-item-feature-title">Fitness Center</span>
                            </li>
                            <li><i class="im im-pool"></i><span class="booking-item-feature-title">Pool</span>
                            </li>
                            <li><i class="im im-spa"></i><span class="booking-item-feature-title">SPA</span>
                            </li>
                            <li><i class="im im-restaurant"></i><span class="booking-item-feature-title">Restaurant</span>
                            </li>
                            <li><i class="im im-wheel-chair"></i><span class="booking-item-feature-title">Wheelchair Access</span>
                            </li>
                            <li><i class="im im-business-person"></i><span class="booking-item-feature-title">Business Center</span>
                            </li>
                            <li><i class="im im-children"></i><span class="booking-item-feature-title">Children Activites</span>
                            </li>
                            <li><i class="im im-casino"></i><span class="booking-item-feature-title">Casino & Gambling</span>
                            </li>
                            <li><i class="im im-bar"></i><span class="booking-item-feature-title">Bar/Lounge</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
            <div class="gap gap-small"></div>
        </div>
@endsection