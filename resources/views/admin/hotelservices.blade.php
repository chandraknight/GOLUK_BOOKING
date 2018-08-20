@extends('admin.layouts.main')
@section('content')
 <div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Add Hotel Services
            </h3>
           
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 
                  <form class="form-horizontal" method="post" action="{{route('service.store')}}">
    {{csrf_field()}}
    
    <div class="form-group">
      <label class="control-label" for="service_name">Service Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Enter Service Name">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label" for="service_type">Service Type:</label>
      <div class="col-sm-10"> 
        <select  class="form-control" id="service_type" name="service_type">
            <option value="Free">Free</option>
            <option value="Paid">Paid</option>           
        </select>       
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label" for="service_time">Service Time:</label>
      <div class="col-sm-10"> 
        <input type="time" class="form-control" id="service_time" name="service_time" placeholder="">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label" for="service_cost">Service Cost:</label>
      <div class="col-sm-10"> 
        <input type="text" class="form-control" id="service_cost" name="service_cost" placeholder="Enter Service Cost">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label" for="service_cost_unit">Service Cost Unit:</label>
      <div class="col-sm-10"> 
        <input type="text" class="form-control" id="service_cost_unit" name="service_cost_unit" placeholder="Enter Unit of Cost">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label" for="service_description">Service Description:</label>
      <div class="col-sm-10"> 
        <textarea type="text" class="form-control" id="service_description" name="service_description" placeholder="Enter Service Description"></textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label" for="service_remarks">Service Remarks:</label>
      <div class="col-sm-10"> 
        <input type="text" class="form-control" id="service_remarks" name="service_remarks" placeholder="Enter Service Remarks">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label" for="service_enable">Service Enabled:</label>
      <div class="col-sm-10"> 
        <select  class="form-control" id="service_enable" name="service_enable" placeholder="Select Service Enabled">
          <option value="enabled">Available</option>
          <option value="disabled">Not Available</option>         
        </select>
      </div>
    </div>
       
    <div class="form-group"> 
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
  </form>
                </div>
              </div>
            </div> @forelse($services as $service)
            <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{$service->service_name}}</h4>
                      <p>
                        <h5>Service Description</h5>
                        {{$service->service_description}}
                      </p>
                      <p>
                        <h5>Service Cost</h5>
                        {{$service->service_cost}}
                      </p>
                      <p>
                        <h5>Service Cost Unit</h5>
                        {{$service->service_cost_unit}}
                      </p>
                      <a  href="{{route('service.edit',$service->id)}}"><button class="btn btn-gradient-primary btn-rounded btn-icon">
                          <i class="mdi mdi-tooltip-edit"></i></button>
                        </a>
                        <a  href="{{route('service.delete',$service->id)}}"><button class="btn btn-gradient-danger btn-rounded btn-icon">
                          <i class="mdi mdi-delete"></i></button>
                        </a>
                    </div>
                  </div>
              </div>
                  @empty
                  No Hotel Services Available
                  @endforelse
        </div>
    </div>
</div>

@endsection