@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <form action="{{route('room.register')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <legend class="legend-control">Add Room</legend>
                    <div class="form-group">
                        <label for="room no">Room Name: </label>
                        <input type="text" name="room_no" class="form-control" placeholder="Enter Room Number">
                    </div>
                    <div class="form-group">
                        <label for="room no">Available Rooms: </label>
                        <input type="number" name="no_of_rooms" class="form-control" placeholder="Enter Number of Available Room">
                    </div>
                    <div class="form-group">
                        <label for="room cost">Room Cost: </label>
                        <input type="text" name="room_flat_cost" class="form-control" placeholder="Enter Room Cost">
                    </div>
                    <div class="form-group">
                        <label for="room type">Room Type: </label>
                        <select name="room_type" class="form-control">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Adults">No of Adults: </label>
                        <input type="text" name="no_adults" class="form-control" placeholder="Enter number of adults">
                    </div>
                    <div class="form-group">
                        <label for="room cost">No of Childs: </label>
                        <input type="text" name="no_childs" class="form-control" placeholder="Enter number of childs">
                    </div>
                    <div class="form-group">
                        <label for="no_beds">No of Beds: </label>
                        <input type="text" name="no_beds" class="form-control" placeholder="Enter number of beds">
                    </div>
                    <div class="form-group">
                        <label for="max_add_beds">No of adjustable Beds: </label>
                        <input type="text" name="max_add_beds" class="form-control"
                               placeholder="Enter number of added beds">
                    </div>
                    <div class="form-group">
                        <label for="cost per bed">Cost Per Added Bed: </label>
                        <input type="text" name="cost per add bed" class="form-control"
                               placeholder="Enter cost per added bed ">
                    </div>
                    <div class="form-group">
                        <label for=" cost ep plan">Cost EP Plan: </label>
                        <input type="text" name="cost_ep_plan" class="form-control" placeholder="Enter EP plan ">
                    </div>
                    <div class="form-group">
                        <label for="cost cp plan">Cost CP Plan: </label>
                        <input type="text" name="cost_cp_plan" class="form-control" placeholder="Enter CP Plan">
                    </div>
                    <div class="form-group">
                        <label for="cost ap plan">Cost AP Plan: </label>
                        <input type="text" name="cost_ap_plan" class="form-control" placeholder="Enter AP plan">
                    </div>
                    <div class="form-group">
                        <label for="cost map plan">MAP cost Plan: </label>
                        <input type="text" name="cost_map_plan" class="form-control" placeholder="Enter MAP Plan">
                    </div>
                    <div class="form-group">
                        <label for="image">Image: </label>
                        <input type="file" name="image" class="form-control" placeholder="select Image">
                    </div>
                    <input type="hidden" name="hotel_id" value="{{$hotel->id}}">

            </div>
            <div class="col-md-5">
                <legend>Select Room Services</legend>
                @foreach($roomservices as $roomservice)
                    <div class="checkbox">
                        <label><input type="checkbox" name="roomservices[]" value="{{$roomservice->id}}">{{$roomservice->name}}</label>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Add">
        </div>
        </form>
    </div>


@endsection