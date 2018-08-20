@extends('layouts.app')
@section('content')
 <div class="container">
    <h1 class="page-title">Tours</h1>
</div>
 <div class="container">
    <div class="row">
        @include('partials.usersidebar')
        <div class="col-md-9">
          <div class="booking-item-details">
                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em">{{$package->name}}<small>Tour Code: {{$package->tour_package_code}}</small></h2>
                            <p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$package->location}}</p>
                            <ul class="list list-inline text-small">
                                <li><a href="#"><i class="fa fa-envelope"></i>{{$package->email}}</a>
                                </li>
                                <li><a href="#"><i class="fa fa-home"></i> Owner Website</a>
                                </li>
                                <li><i class="fa fa-phone"></i>{{$package->contact}}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            @if($package->flag == 1)
                            <p class="booking-item-header-price"><a href="{{route('editpackage',$package->id)}}" class="btn btn-primary">Edit Details</a></p>
                            <p class="booking-item-header-price"><a href="{{route('tour.booking',$package->id)}}" class="btn btn-primary">Bookings</a></p>
                            @endif
                        </div>
                    </div>
                </header>
                <div class="row">
                    <div class="col-md-7">
                        <div class="tabbable booking-details-tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                                </li>
                                <li><a href="#add-photo" data-toggle="tab"><i class="fa fa-image"></i>Add Photo</a>
                                </li>
                                <li><a href="#details" data-toggle="tab"><i class="fa fa-image"></i>Details</a>
                                </li>
                                <li><a href="#itenary" data-toggle="tab"><i class="fa fa-image"></i>Itenary</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-1">
                                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                                        @foreach($package->tourGallery as $gallery)                                        
                                        <img src="{{url('/')}}/storage/tourgallery/{{$gallery->image}}" alt="{{$package->name}}" title="{{$package->name}}">
                                       @endforeach
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="add-photo">
                                    <div class="gap gap-small"></div>
                                    <form method="post" action="{{route('packagegallery.insert')}}">
                                        {{csrf_field()}}
                                        <div class="form-group form-group-icon-right"><i class="fa fa-image input-icon"></i>
                                        <label>Select File</label>
                                        <input type="file" name="image" class="form-control">
                                        </div>
                                        <input type="hidden" name="tour_package_id" value="{{$package->id}}">
                                    </form>
                                </div>
                                <div class="tab-pane fade" id=details>
                                    {!!$package->description!!}
                                </div>
                                <div class="tab-pane fade" id="itenary">
                                    {!!$package->itenary!!}
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
                                <li>Size: {{$package->group_size}}</li>
                                <li>Group Rate: <p class="booking-item-header-price"><small>price</small>  <span class="text-md">Rs {{$package->group_price}}</span><small>/person</small>
                            </p> </li>
                            </ul>
                        </div>
                        </div>
                            @if($package->flag == 1)
                            <small><a class="btn btn-primary" href="{{route('tour.booking',$package->id)}}">View Bookings</a></small>
                            @endif
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
<div class="gap gap-small"></div>
@endsection