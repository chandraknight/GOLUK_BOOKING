@extends('admin.layouts.main')
@section('content')
 <div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Edit Hotel Services
            </h3>
           
        </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="form-horizontal" method="post" action="{{route('service.update')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$service->id}}">
                    <div class="form-group">
                      <label class="control-label" for="service_name">Service Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="service_name" name="service_name" value="{{$service->service_name}}">
                      </div>
                    </div>
    
                    <div class="form-group">
                      <label class="control-label" for="service_type">Service Type:</label>
                      <div class="col-sm-10"> 
                        <select  class="form-control" id="service_type" name="service_type">
                            <option value="Free" {{($service->service_type='Free')?'selected':''}}>Free</option>
                            <option value="Paid" {{($service->service_type='Paid')?'selected':''}}>Paid</option>           
                        </select>       
                      </div>
                    </div>
    
                    <div class="form-group">
                      <label class="control-label" for="service_time">Service Time:</label>
                      <div class="col-sm-10"> 
                        <input type="time" class="form-control" id="service_time" name="service_time" value="{{$service->service_time}}">
                      </div>
                    </div>
    
                    <div class="form-group">
                      <label class="control-label" for="service_cost">Service Cost:</label>
                      <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="service_cost" name="service_cost" value="{{$service->service_cost}}">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label" for="service_cost_unit">Service Cost Unit:</label>
                      <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="service_cost_unit" name="service_cost_unit" value="{{$service->service_cost_unit}}">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label" for="service_description">Service Description:</label>
                      <div class="col-sm-10"> 
                        <textarea type="text" class="form-control" id="service_description" name="service_description">{{$service->service_description}}</textarea>
                      </div>
                    </div>
    
                    <div class="form-group">
                      <label class="control-label" for="service_remarks">Service Remarks:</label>
                      <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="service_remarks" name="service_remarks" value="{{$service->service_remarks}}">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label" for="service_enable">Service Enabled:</label>
                      <div class="col-sm-10"> 
                        <select  class="form-control" id="service_enable" name="service_enable" placeholder="Select Service Enabled">
                          <option value="enabled" {{($service->service_enable='enabled')?'selected':''}}>Enabled</option>
                          <option value="disabled" {{($service->service_enable='disabled')?'selected':''}}>Disabled</option>         
                        </select>
                      </div>
                    </div>
       
                    <div class="form-group"> 
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div> 
    </div>
</div>

@endsection