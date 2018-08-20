@extends('layouts.app') 
@section('content')
 <div class="container">
    <h1 class="page-title">{{$room->room_no}}</h1>
</div>
 <div class="container">
    @include('partials.usersidebar')
    <div class="col-md-4">
        <form class="form-horizontal" method="post" action="{{route('room.update')}}" enctype="multipart/form-data">
        	{{csrf_field()}}
          <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-bounce"></i>
              <label>Room Name</label>
              <input class="form-control" name="room_no" value="{{$room->room_no}}" type="text">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-list-ol input-icon input-icon-bounce"></i>
              <label>Available Rooms</label>
              <input class="form-control" name="name" value="{{$room->no_of_rooms}}" type="text">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
              <label>Room Flat Cost</label>
              <input class="form-control" value="{{$room->room_flat_cost}}" name="room_flat_cost" type="text">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-navicon input-icon input-icon-bounce"></i>
              <label>Room Type</label>
              <select name="rooom_type" class="form-control">
              	@foreach($types as $type)
              	<option value="{{$type->name}}">{{$type->name}}</option>
             	@endforeach 
         	</select>
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-male input-icon input-icon-bounce"></i>
              <label>Number of Adults</label>
              <input class="form-control" value="{{$room->no_adults}}" name="no_adults" type="text">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-child input-icon input-icon-bounce"></i>
              <label>Number of Childs</label>
              <input class="form-control" value="{{$room->no_childs}}" name="no_childs" type="text">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-list-ol input-icon input-icon-bounce"></i>
              <label>Number of Beds</label>
              <input class="form-control" value="{{$room->no_beds}}" name="no_beds" type="text">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-list-ol input-icon input-icon-bounce"></i>
              <label>No of Adjustible Beds</label>
              <input class="form-control" value="{{$room->max_add_beds}}" name="max_add_beds" type="text">
          </div>
           <input type="hidden" name="id" value="{{$room->id}}">
           <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
              <label>Cost per Added Bed</label>
              <input class="form-control" value="{{$room->cost_per_add_bed}}" name="cost_per_add_bed" type="text">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
              <label>Cost AP Plan</label>
              <input class="form-control" name="cost_ap_plan" type="text" value="{{$room->cost_ap_plan}}">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
              <label>Cost CP Plan</label>
              <input class="form-control" name="cost_cp_plan" type="text" value="{{$room->cost_cp_plan}}">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
              <label>Cost EP Plan</label>
              <input class="form-control" name="cost_ep_plan" type="text" value="{{$room->cost_ep_plan}}">
          </div>
          <div class="form-group form-group-icon-left"><i class="fa fa-inr input-icon input-icon-bounce"></i>
              <label>Cost MAP Plan</label>
              <input class="form-control" name="cost_map_plan" type="text" value="{{$room->cost_map_plan}}">
          </div>
          <input type="submit" class="btn btn-primary" value="Update">
          
        </form>
    </div>
    <div class="col-md-4">
    	<h3>Room Galleries</h3>
    	<div class="tab-pane fade in active" id="tab-1">
            <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
				@forelse($room->roomgallery as $gallery)                
                <img src="{{url('/')}}/storage/rooms/{{$room->hotel_id}}/{{$gallery->image}}">
                @empty
                No Photos Uploaded
                @endforelse
            </div>
        </div>
        <div class="gap gap-small"></div>
        <h3>Add Room Gallery Image</h3>
        <form method="post" action="{{route('roomgallery.insert')}}" enctype="multipart/form-data">
        	{{csrf_field()}}
        	<div class="form-group form-group-icon-left"><i class="fa fa-image input-icon input-icon-bounce"></i>
              <label>Image</label>
              <input class="form-control" name="image" type="file">
          </div>
          <input type="hidden" name="room_id" value="{{$room->id}}">
          <input type="submit" class="btn btn-primary" value="Add">
        </form>
    </div>
          <div class="gap gap-small"></div>
</div>
@endsection