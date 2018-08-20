@extends('layouts.app') 
@section('content')
 <div class="container">
    <h1 class="page-title">{{$vehicle->name}}</h1>
</div>
 <div class="container">
    <div class="row">
        @include('partials.usersidebar')
        <div class="col-md-9">
        <form method="post" action="{{route('vehicle.update')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-5">
                    {{csrf_field()}}
                    <legend>Edit Vehicle</legend>
                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon input-icon-bounce"></i>
                        <label>Name: </label>
                        <input type="text" class="form-control" name="name" value="{{$vehicle->name}}">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-bounce"></i>
                        <label>Email: </label>
                        <input type="email" class="form-control" name="email" value="{{$vehicle->email}}">
                    </div>
                    <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}">
                    <div class="form-group form-group-icon-left"><i class="fa fa-font input-icon input-icon-bounce"></i>
                        <label>Description: </label>
                        <textarea class="form-control" name="description">{{$vehicle->description}}</textarea>
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-bounce"></i>
                        <label>Location: </label>
                        <input type="text" name="location" class="form-control" value="{{$vehicle->location}}">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon input-icon-bounce"></i>
                        <label>Contact: </label>
                        <input type="tel" class="form-control" name="contact" value="{{$vehicle->contact}}">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-car input-icon input-icon-bounce"></i>
                        <label for="sel1">Select Type: </label>
                        <select class="form-control" name="type">
                            @foreach($types as $type)
                                {{--<option hidden>Select Type</option>--}}
                            @if($vehicle->type==$type)
                                <option  value="{{$type->id}}" selected="selected">{{$type->type_name}}</option>
                                @else
                                <option value="{{$type->id}}">{{$type->type_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-users input-icon input-icon-bounce"></i>
                        <label>Number of People: </label>
                        <input type="number" min="1" class="form-control" name="no_of_people" value="{{$vehicle->no_of_people}}">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
                        <label>Rate per Day: </label>
                        <input type="number" name="rate_per_day" class="form-control" value="{{$vehicle->rate_per_day}}">
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-image input-icon input-icon-bounce"></i>
                        <label>Sit Pattern: </label>
                        <input type="file" class="form-control" name="sit-pattern">
                    </div>
                    <div class="form-group">
                        <label for="fuel">Select Fuel Type: </label>
                        <div class="radio">
                            @if($vehicle->fuel == 'diesel')
                            <label><input type="radio" checked value="diesel" name="fuel">Diesel</label>
                                @else
                                <label><input type="radio"  value="diesel" name="fuel">Diesel</label>
                                @endif
                        </div>
                        <div class="radio">
                            @if($vehicle->fuel=='petrol')
                            <label><input type="radio" checked value="petrol" name="fuel">Petrol</label>
                                @else
                                <label><input type="radio"  value="petrol" name="fuel">Petrol</label>
                                @endif
                        </div>
                    </div>
                    <div class="form-group form-group-icon-left"><i class="fa fa-image input-icon input-icon-bounce"></i>
                        <label for="image">Image: </label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="col-md-4">
                    <legend>Vehicle Services Cost</legend>
                    @forelse($vehicle->services as $vehicleservice)
                        <div class="checkbox">
                            <label><input class="i-check"  type="checkbox"  name="services[]"
                                          value="{{$vehicleservice->id}}">
                      {{$vehicleservice->service_name}}
                            </label>
                     <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
                     <label>Service Cost</label>
                    
                    <input type="text" class="form-control" name="services_cost[]">
                </div>
                        </div>
                    @empty
                        No vehicle Services Registered
                    @endforelse
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <div class="gap gap-small"></div>
@endsection
