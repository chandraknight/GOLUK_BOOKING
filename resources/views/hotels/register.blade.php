@extends('layouts.app') 
@section('content')
 <div class="container">
    <h1 class="page-title">Register Hotel</h1>
</div>
 <div class="container">
        @include('partials.usersidebar')
        <form class="form-horizontal" method="post" action="{{route('hotel.store')}}" enctype="multipart/form-data">
          {{csrf_field()}}
         <div class="col-md-4">
              <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-bounce"></i>
                  <label>Email</label>
                  <input class="form-control" name="email" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-building-o input-icon input-icon-bounce"></i>
                  <label>Name</label>
                  <input class="form-control" name="name"  type="text">
              </div>
               <div class="form-group form-group-icon-left"><i class="fa fa-building-o input-icon input-icon-bounce"></i>
                  <label>Description</label>
                  <textarea class="form-control" name="description"></textarea>
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-gear input-icon input-icon-bounce"></i>
                  <label>Website</label>
                  <input class="form-control"  name="website" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-bounce"></i>
                  <label>Address</label>
                  <input class="form-control"  name="address" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-caret-square-o-right input-icon input-icon-bounce"></i>
                  <label>Number of Rooms</label>
                  <input class="form-control"  name="no_rooms" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon input-icon-bounce"></i>
                  <label>Contact Number</label>
                  <input class="form-control"  name="contact" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon input-icon-bounce"></i>
                  <label>Contact Person Name</label>
                  <input class="form-control"  name="agent_name" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon input-icon-bounce"></i>
                  <label>Contact Person Number</label>
                  <input class="form-control"  name="agent_contact" type="text">
              </div>
               <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-bounce"></i>
                  <label>Check out Time</label>
                  <input class="form-control time-pick"  name="check_out_time" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-image input-icon input-icon-bounce"></i>
                  <label>Logo</label>
                  <input class="form-control" name="logo" type="file">
              </div>
              <input type="submit" class="btn btn-primary" value="Register">
          </div>
         
        
         <div class="col-md-4">
            <h3>Add Hotel Services</h3>
            @forelse($hotelservice as $service)
                 <div class="checkbox checkbox-small">
                      <label>
                     <input class="i-check" type="checkbox" value="{{$service->id}}"> {{$service->service_name}}</label>
                      <p>{{$service->service_description}}</p>
                  </div>
            @empty
            No Services Available      
            @endforelse
          </div>
           </form>
          <div class="gap gap-small"></div>
@endsection
