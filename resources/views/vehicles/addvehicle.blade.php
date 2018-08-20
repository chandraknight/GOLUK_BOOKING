@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="page-title">Register Vehicle</h1>
</div>
 <div class="container">
        @include('partials.usersidebar')

        <form class="form-horizontal" method="post" action="{{route('register.vehicle')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Name: </label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Description: </label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Location: </label>
                        <input type="text" name="location" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Contact: </label>
                        <input type="tel" class="form-control" name="contact">
                    </div>

                    <div class="form-group">
                        <label>Email: </label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="form-group">
                        <label for="sel1">Select Type: </label>
                        <select class="form-control" name="type">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->type_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Number of People: </label>
                        <input type="number" min="1" class="form-control" name="no_of_people">
                    </div>
                    <div class="form-group">
                        <label>Rate per Day: </label>
                        <input type="number" name="rate_per_day" class="form-control">
                    </div>
                    <div class="from-group">
                        <label>Sit Pattern: </label>
                        <input type="file" class="form-control" name="sit-pattern">
                    </div>
                    <div class="form-group">
                        <label for="fuel">Select Fuel Type: </label>
                        <div class="radio">
                            <label><input type="radio" value="diesel" name="fuel">Diesel</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="petrol" name="fuel">Petrol</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Image: </label>
                        <input type="file" class="form-control" name="image">
                    </div>
                     <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <div class="col-md-4">
                    <legend>Vehicle Services</legend>
                    @forelse($vehicleservices as $vehicleservice)
                        <div class="checkbox">
                            <label><input type="checkbox" name="services[]"
                                          value="{{$vehicleservice->id}}">{{$vehicleservice->service_name}}
                            </label>
                            <input type="number" class="form-control" name="services_cost[]"  placeholder="Service Cost">
                        </div>
                    @empty
                        No vehicle Services Registered
                    @endforelse
                </div>
            </div>
           
        </form>

</div>
<div class="gap gap-small"></div>
@endsection
