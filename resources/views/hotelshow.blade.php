@extends('layouts.app')
@section('content')
@php $i=0; @endphp
<div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('welcome')}}">Home</a>
                </li>
                <li><a href="{{route('hotel.list')}}">Hotel</a></li>
                <li class="active">{{$hotel->name}}</li>
            </ul>
            <div class="booking-item-details">
                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em">{{$hotel->name}}</h2>
                            <p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$hotel->address}}</p>
                            <ul class="list list-inline text-small">
                                @if($hotel->email)
                                <li><a href="#"><i class="fa fa-envelope"></i> {{$hotel->email}}</a>
                                    @endif
                                </li>
                                @if($hotel->website)
                                <li><a href="http://{{$hotel->website}}" target="_blank"><i class="fa fa-home"></i> {{$hotel->website}}</a>
                                </li>
                                @endif
                                <li><i class="fa fa-phone"></i>{{$hotel->contact}}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <p class="booking-item-header-price"><small>price from</small>  <span class="text-lg">Rs {{$min}}</span>/night</p>
                        </div>
                    </div>
                </header>
                <div class="row">
                    <div class="col-md-8">
                        <div class="tabbable booking-details-tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                                </li>
                                <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-info-circle"></i>About</a>
                                </li>
                               
                                <li><a href="#tab-5" data-toggle="tab"><i class="fa fa-asterisk"></i>Facilities</a>
                                </li>
                               
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-1">
                                    <!-- START LIGHTBOX GALLERY -->
                                    <div class="row row-no-gutter" id="popup-gallery">
                                        @foreach($photos as $photo) 
                                        <div class="col-md-2">
                                           
                                            <a class="hover-img popup-gallery-image" href="{{url('/')}}/storage/hotel_photos/{{$hotel->id}}/{{$photo->photo}}" data-effect="mfp-zoom-out">
                                                <img src="{{url('/')}}/storage/hotel_photos/{{$hotel->id}}/{{$photo->photo}}" alt="Image Alternative text" title="hotel PORTO BAY SERRA GOLF living room"><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                                            </a>

                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- END LIGHTBOX GALLERY -->
                                </div>
                                <div class="tab-pane fade" id="tab-2">
                                    <div class="mt20">
                                        <p>{!! $hotel->description !!}</p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="google-map-tab">
                                    <div id="map-canvas" style="width:100%; height:400px;"></div>
                                </div>
                               
                                <div class="tab-pane fade" id="tab-5">
                                    <div class="row mt20">
                                        <div class="col-md-4">
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
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="booking-item-features booking-item-features-expand mb30 clearfix">
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
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="booking-item-features booking-item-features-expand mb30 clearfix">
                                                <li><i class="im im-children"></i><span class="booking-item-feature-title">Children Activites</span>
                                                </li>
                                                <li><i class="im im-casino"></i><span class="booking-item-feature-title">Casino & Gambling</span>
                                                </li>
                                                <li><i class="im im-bar"></i><span class="booking-item-feature-title">Bar/Lounge</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    

                </div>
                <div class="gap gap-small"></div>
                <h3>Available Rooms</h3>
                <div class="row">
                    <div class="col-md-9">
                        <ul class="booking-list">
                            <form method="post" action="{{route('room.book')}}"> 
                                {{csrf_field()}}
                            @foreach($hotel->rooms as $room)
                            <li>
                               
                                    <div class="row booking-item">
                                            <a class="" href="{{route('room.show',$room->id)}}" target="_blank">
                                        <div class="col-md-3">
                                            <img src="{{url('/')}}/storage/rooms/{{$room->hotel_id}}/{{$room->image}}" alt="Image Alternative text" title="The pool">
                                        </div>
                                    </a>
                                        <div class="col-md-6">
                                            <h5 class="booking-item-title">{{$room->room_no}}</h5>
                                            <p class="text-small">{!!$room->roomType->description!!}</p>
                                            <ul class="booking-item-features booking-item-features-sign clearfix">
                                                <li rel="tooltip" data-placement="top" title="Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$room->no_adults}}</span>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Beds"><i class="im im-bed"></i><span class="booking-item-feature-sign">x {{$room->no_beds}}</span>
                                                </li>
                                            
                                            </ul>
                                            <ul class="booking-item-features booking-item-features-small clearfix">
                                                <li rel="tooltip" data-placement="top" title="Flat Screen TV"><i class="im im-tv"></i>
                                                </li>
                                               
                                               
                                            </ul>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">Rs {{$room->room_flat_cost}}<small>/night</small></span>

                                       
                                         <div class="form-group form-group-sm">
                                    <h3>{{$room->roomType->name}}<small> Room</small></h3>
                                   <label>Enter Required rooms</label>
                                <input class="form-control" type="number" max="{{$room->no_of_rooms}}" placeholder="{{$room->no_of_rooms}} Available" name="no_rooms[]">
                                <input type="hidden" name="room_type[]" value="{{$room->roomType->name}}">
                                <input type="hidden" name="room[]" value="{{$room->id}}">
                                <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                                <div class="gap-mini"></div>
                                <label>Select Plan</label>
                                 <div class="radio-inline checked radio-stroke">
                                <label>
                                    <input class="i-radio" checked=""  type="radio" name="plan[{{$i}}]" value="none">None<small> Rs {{$room->room_flat_cost}}/night</small></label>

                                </div>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="plan[{{$i}}]" value="ep">EP<small> Rs {{$room->cost_ep_plan}}/night</small></label>
                                </div>
                                 <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="plan[{{$i}}]" value="cp">CP<small> Rs {{$room->cost_cp_plan}}/night</small></label>
                                </div>
                                 <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="plan[{{$i}}]" value="map">MAP<small> Rs {{$room->cost_map_plan}}/night</small></label>
                                </div>
                                 <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="plan[{{$i}}]" value="ap">AP<small> Rs {{$room->cost_ap_plan}}/night</small></label>
                                </div>
                            </div>
                                </div>
                                    </div>
                                 
                                
                            </li>
                            <div class="gap-small"></div>
                            @php $i++ ; @endphp
                            @endforeach
                       
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <div class="booking-item-dates-change">
                          @if(session()->has('search_id'))
                                <div class="booking-item-deails-date-location">
                            <ul>
                                <li>
                                    <h5>Hotel</h5>
                                    <p>{{$hotel->name}}</p>
                                    <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i>{{$hotel->address}}</p>
                                </li>
                                <li>
                                    <h5>Check In:</h5>
                                   
                                    <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>{{$from->toFormattedDateString()}}</p>
                                </li>
                                <li>
                                    <h5>Check Out:</h5>
                                    
                                    <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>{{$till->toFormattedDateString()}}</p>
                                </li>
                                <li>
                                    <h5>Adults:</h5>
                                    
                                    <p><i class="fa fa-male box-icon-inline box-icon-gray"></i>{{$search->no_adults}}</p>
                                </li>
                                @if($search->no_childs>0)
                                <li>
                                    <h5>Children</h5>
                                    
                                    <p><i class="fa fa-child box-icon-inline box-icon-gray"></i>{{$search->no_childs}}</p>
                                </li>
                                @endif
                            </ul>
                        </div>
                        
                          <input type="submit" class="btn btn-group-select-num btn-primary btn-block" value="Book">
                           @else 
                            <a class="btn btn-primary popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Confirm Details</a></small>
                            @endif
                        </div>
                    </div>
 </form>
                </div>
            </div>
            <div class="gap gap-small"></div>
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
             <form method="post" action="{{route('hotel.reserve.session')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                    <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                        <label>Where are you going?</label>
                        <input class="typeahead form-control" placeholder="City, Airport, Point of Interest, Hotel Name or U.S. Zip Code" name="destination" value="{{$hotel->address}}" type="text">
                    </div>
                    <div class="input-daterange" >
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
                    <button class="btn btn-primary btn-lg" type="submit">Reserve</button>
                </form>
            </div>
        </div>

@endsection