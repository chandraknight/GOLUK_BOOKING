@extends('layouts.app') 
@section('content')
 <div class="container">
    <h1 class="page-title">{{$hotel->name}}</h1>
</div>
 <div class="container">
        @include('partials.usersidebar')
        <div class="container">
            <div class="booking-item-details">
                <header class="booking-item-header">
                        <div class="col-md-6">
                            <h2 class="lh1em">{{$hotel->name}}<small>Hotel Code: {{$hotel->hotel_code}}</small></h2>
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
                            @if($hotel->flag == 1)
                            <p class="booking-item-header-price"><a href="{{route('hotel.edit',$hotel->id)}}" class="btn btn-ghost btn-warning">Edit Details</a>  </p>
                             <p class="booking-item-header-price"><a href="{{route('hotel.bookings',$hotel->id)}}" class="btn btn-ghost btn-warning">View Bookings</a>  </p>
                             <p class="booking-item-header-price"><a href="{{route('service.index',$hotel->id)}}" class="btn btn-ghost btn-warning">Add Hotel Services</a></p>
                             <p class="booking-item-header-price"><a href="{{route('roomservices.index',$hotel->id)}}" class="btn btn-ghost btn-warning">Add Room Services</a></p>
                             @endif
                        </div>
                </header>
                    <div class="col-md-6">
                        <div class="tabbable booking-details-tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                                </li>
                                <li><a href="#add-photo" data-toggle="tab"><i class="fa fa-image"></i>Add Photo</a>
                                </li>
                                
                                <li><a href="#room-services" data-toggle="tab"><i class="fa fa-image"></i>Room Services</a>
                                </li>
                                
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-1">
                                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                                        @foreach($hotel->photos as $photo)                                        
                                        <img src="{{url('/')}}/storage/hotel_photos/{{$hotel->id}}/{{$photo->photo}}" alt="Image Alternative text" title="hotel 1">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="add-photo">
                                    <form method="post" action="{{route('photo.upload')}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                         <div class="form-group form-group-icon-left"><i class="fa fa-font input-icon input-icon-bounce"></i>
                                          <label>Title</label>
                                          <input class="form-control" name="title" type="text">
                                      </div>
                                       <div class="form-group form-group-icon-left"><i class="fa fa-font input-icon input-icon-bounce"></i>
                                          <label>Description</label>
                                          <textarea class="form-control" name="description"></textarea>
                                      </div>
                                      <input type="hidden" value="{{$hotel->id}}" name="id">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-image input-icon input-icon-bounce"></i>
                                          <label>Select Image</label>
                                          <input class="form-control" name="photo" type="file">
                                      </div>
                                      <input type="submit" class="btn btn-primary" value="Add">
                                    </form>
                                </div>
                                
                                <div class="tab-pane fade" id="room-services">
                                    <h3>Available Room Services</h3>
                                    <ul class="list-group">
                                        @forelse($roomservices as $service)
                                            <li>{{$service->name}}<br>{{$service->description}}</li>
                                        @empty 
                                        No room Services Added 
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="add-room-service">
                <form method="post" action="{{route('roomservice.add')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Room Service: </label>
                        <input type="text" class="form-control" name="service_name">
                    </div>
                    <div class="form-group">
                        <label>Description: </label>
                        <textarea class="form-control" name="service_description"></textarea>
                    </div>
                    <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                <div class="gap"></div>
                <h3>Available Rooms</h3>
                <div class="row">
                    <div class="col-md-9">
                        <div class="gap gap-small"></div>
                        <ul class="booking-list">
                            @forelse($hotel->rooms as $room)
                            <li>
                                <a class="booking-item" href="{{route('room.edit',$room->id)}}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="{{url('/')}}/storage/rooms/{{$room->hotel_id}}/{{$room->image}}" alt="Image Alternative text" title="The pool">
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="booking-item-title">{{$room->room_no}}</h5>
                                            <p class="text-small">Sit cras diam nec morbi erat mi at quam consectetur praesent litora mauris</p>
                                            <ul class="booking-item-features booking-item-features-sign clearfix">
                                                <li rel="tooltip" data-placement="top" title="Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$room->no_adults}}</span>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Beds"><i class="im im-bed"></i><span class="booking-item-feature-sign">x{{$room->no_beds}}</span>
                                                </li>
                                               
                                            </ul>
                                            
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">Rs {{$room->room_flat_cost}}<small>/night</small></span><span class="btn btn-primary">Edit</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @empty
                            No Rooms registered
                            @endforelse
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>About the Hotel</h4>
                        <p class="mb30">{!!$hotel->description!!}</h4>
                        <ul class="booking-item-features booking-item-features-expand mb30 clearfix">
                            @forelse($hotel->hotelservices as $service)
                            <li><i class="fa fa-sm fa-hand-o-right"></i><span class="booking-item-feature-title">{{$service->service_name}}</span>
                            </li>
                            @empty
                            No Services Registered
                            @endforelse
                        </ul>
                         @if($hotel->flag == 1)
                        <p> <a  class=" btn btn-primary" href="{{route('room.add',$hotel->id)}}">Add Room</a></p>
                        @endif
                    </div>
                </div>
            </div>
             
            <div class="gap gap-small"></div>
        </div>
</div>

@endsection