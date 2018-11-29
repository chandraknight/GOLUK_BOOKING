@extends('layouts.app')
@section('content')
    <div class="container">
            <h1 class="page-title">Search for Rental Cars</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        <form method="get" action="{{route('vehiclesearch')}}">
                            <div class="input-daterange" data-date-format="m/d">
                                <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                    <label>Pickup Location</label>
                                    <input class="form-control"  name="vehiclelocation" type="text" value="{{old('vehiclelocation')}}">
                                    @if($errors->has('vehiclelocation'))
                                        <span style="color:red">{{$errors->first('vehiclelocation')}}</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                            <label>Check in</label>
                                            <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="vehiclefrom_date" type="text">
                                            @if($errors->has('vehiclefrom_date'))
                                                <span style="color:red">{{$errors->first('vehiclefrom_date')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                                            <label>Pick up Time</label>
                                            <input class="form-control time-pick" name="vehiclepickup_time" type="text" value="{{old('vehiclepickup_time')}}">
                                            @if($errors->has('vehiclepickup_time'))
                                                <span style="color:red">{{$errors->first('vehiclepickup_time')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                    <label>Drop off Location</label>
                                    <input class="form-control"  placeholder="Same as pickup" name="vehicledestination" type="text">
                                    @if($errors->has('vehicledestination'))
                                        <span style="color:red">{{$errors->first('vehicledestination')}}</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                            <label>Check out</label>
                                            <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="vehicletill_date" type="text">
                                            @if($errors->has('vehicletill_date'))
                                                <span style="color:red">{{$errors->first('vehicletill_date')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                                            <label>Drop off Time</label>
                                            <input class="form-control time-pick" name="vehicledropoff_time" type="text">
                                            @if($errors->has('vehicledropoff_time'))
                                                <span style="color:red">{{$errors->first('vehicledropoff_time')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group form-group-icon-left"><i class="fa fa-male input-icon input-icon-hightlight"></i>
                                            <label>Passenger</label>
                                            <input class="form-control" name="vehiclepassenger" type="text">
                                            @if($errors->has('vehiclepassenger'))
                                                <span style="color:red">{{$errors->first('vehiclepassenger')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-primary mt10" type="submit" value="Search for Rental Cars">
                        </form>
                    </aside>
                </div>
                <div class="col-md-9">
                    <h3 class="mb20">Vehicles in Popuplar Destinations</h3>
                    
                    <div class="gap"></div>
                    @foreach($vehicles->chunk(3) as $v)
                    <div class="row row-wrap">
                        @forelse($v as $vehicle)
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img curved" href="{{route('vehicle.show',$vehicle->id)}}">
                                        <img src="{{url('/')}}/storage/vehicle/{{$vehicle['image']}}" alt="{{$vehicle->name}}" title="{{$vehicle->name}}"  height="160px">
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <h5 class="thumb-title"><a class="text-darken" href="{{route('vehicle.show',$vehicle->id)}}">{{$vehicle->name}}</a></h5><small>{{$vehicle->types['type_name']}}</small>
                                    <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                                        <li rel="tooltip" data-placement="top" title="{{ucfirst($vehicle->fuel)}} Vehicle" ><i class="im im-diesel"></i><span class="booking-item-feature-sign">{{$vehicle->fuel}}</span>
                                        </li>

                                        <li rel="tooltip" data-placement="top" title="Number of Passengers - {{$vehicle->no_of_people}} " ><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$vehicle->no_of_people}}</span>
                                        </li>

                                        

                                        <li rel="tooltip" data-placement="top" title="Drive Train - {{$vehicle->drive_train}}" ><i class="im im-car-wheel " ></i><span class="booking-item-feature-sign">{{$vehicle->drive_train}}</span>
                                        </li>

                                        <li title="" data-original-title="Car with Driver" data-placement="top" rel="tooltip" ><i class="im im-driver"></i> <span class="booking-item-feature-sign">Yes</span>
                                        </li>

                                        <li title="" data-original-title="Satellite Navigation - {{ucfirst($vehicle->gps)}}" data-placement="top" rel="tooltip" ><i class="im im-satellite"></i> <span class="booking-item-feature-sign">{{$vehicle->gps}}</span>
                                        </li>

                                        <li rel="tooltip" data-placement="top" title="Vehicle Origin location - {{ucfirst($vehicle->location)}}"><i class="fa fa-map-marker"></i><span class="booking-item-feature-sign">{{ucfirst($vehicle->location)}}</span>
                                        </li>

                                    </ul>
                                    <p class="text-darken mb0 text-color">Rs {{$vehicle->rate_per_day}}<small> /day</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Vehicles Available
                        @endforelse
                    </div>
                    @endforeach
                    <div class="gap gap-small"></div>
                </div>
            </div>
        </div>
@endsection