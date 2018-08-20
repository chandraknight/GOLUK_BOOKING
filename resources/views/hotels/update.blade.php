@extends('layouts.app') 
@section('content')
 <div class="container">
    <h1 class="page-title">{{$hotel->name}}</h1>
</div>
 <div class="container">
        @include('partials.usersidebar')
        <form class="form-horizontal" method="post" action="{{route('hotel.update')}}" enctype="multipart/form-data">
          {{csrf_field()}}
         <div class="col-md-4">
              <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-bounce"></i>
                  <label>Email</label>
                  <input class="form-control" name="email" value="{{$hotel->email}}" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-building-o input-icon input-icon-bounce"></i>
                  <label>Name</label>
                  <input class="form-control" name="name" value="{{$hotel->name}}" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-building-o input-icon input-icon-bounce"></i>
                  <label>Description</label>
                  <textarea class="form-control" name="description">{{$hotel->description}}</textarea>
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-gear input-icon input-icon-bounce"></i>
                  <label>Website</label>
                  <input class="form-control" value="{{$hotel->website}}" name="website" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-bounce"></i>
                  <label>Address</label>
                  <input class="form-control" value="{{$hotel->address}}" name="address" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-caret-square-o-right input-icon input-icon-bounce"></i>
                  <label>Number of Rooms</label>
                  <input class="form-control" value="{{$hotel->no_rooms}}" name="no_rooms" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon input-icon-bounce"></i>
                  <label>Contact</label>
                  <input class="form-control" value="{{$hotel->contact}}" name="contact" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon input-icon-bounce"></i>
                  <label>Agent Name</label>
                  <input class="form-control" value="{{$hotel->agent_name}}" name="contact" type="text">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon input-icon-bounce"></i>
                  <label>Agent Contact</label>
                  <input class="form-control" value="{{$hotel->agent_contact}}" name="contact" type="text">
              </div>
               <input type="hidden" name="id" value="{{$hotel->id}}">
               <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-bounce"></i>
                  <label>Check out Time</label>
                  <input class="form-control" value="{{$hotel->check_out_time}}" name="check_out_time" type="time">
              </div>
              <div class="form-group form-group-icon-left"><i class="fa fa-image input-icon input-icon-bounce"></i>
                  <label>Logo</label>
                  <input class="form-control" name="logo" type="file">
              </div>
              <input type="submit" class="btn btn-primary" value="Update">
          </div>
         
        
         <div class="col-md-4">
            <h3>Available Hotel Services</h3>
            @foreach($services as $service)
                 <div class="checkbox checkbox-small">
                      <label>
                      <input class="i-check" type="checkbox" value="{{$service->id}}"
                      @foreach($hotel->hotelservices as $s)
                      {{($s->id == $service->id)?'checked':''}}
                      @endforeach >{{$service->service_name}}</label>
                      <p>{{$service->service_description}}</p>
                  </div>
            @endforeach
          </div>
           </form>
          <div class="gap gap-small"></div>
@endsection