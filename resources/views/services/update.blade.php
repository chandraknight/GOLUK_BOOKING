@extends('layouts.app')
@section('content')
<div class="container">
  <form class="form-horizontal" method="post" action="{{route('service.update')}}">
    {{csrf_field()}}
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_name">Service Name:</label>
      <div class="col-sm-10">
        <input type="name" class="form-control" id="service_name" name="service_name" value="{{$service['service_name']}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_type">Service Type:</label>
      <div class="col-sm-10"> 
        <select  class="form-control" id="service_type" name="service_type">
            <option value="Free">Free</option>
            <option value="Paid">Paid</option>           
        </select>       
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_time">Service Time:</label>
      <div class="col-sm-10"> 
        <input type="time" class="form-control" id="service_time" name="service_time" value="{{$service['service_time']}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_cost">Service Cost:</label>
      <div class="col-sm-10"> 
        <input type="text" class="form-control" id="service_cost" name="service_cost" value="{{$service['service_cost']}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_cost_unit">Service Cost Unit:</label>
      <div class="col-sm-10"> 
        <input type="text" class="form-control" id="service_cost_unit" name="service_cost_unit" value="{{$service['service_cost_unit']}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_description">Service Description:</label>
      <div class="col-sm-10"> 
        <textarea type="text" class="form-control" id="service_description" name="service_description">{{$service['service_description']}}</textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_remarks">Service Remarks:</label>
      <div class="col-sm-10"> 
        <input type="text" class="form-control" id="service_remarks" name="service_remarks" value="{{$service['service_remarks']}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="service_enable">Service Enabled:</label>
      <div class="col-sm-10"> 
        <select  class="form-control" id="service_enable" name="service_enable">
          <option value="enabled">Available</option>
          <option value="disabled">Not Available</option>         
        </select>
      </div>
    </div>
    <input type="hidden" name="id" value="{{$service['id']}}"> 
        
    <div class="form-group"> 
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Update</button>
      </div>
    </div>
  </form>
</div>
@endsection