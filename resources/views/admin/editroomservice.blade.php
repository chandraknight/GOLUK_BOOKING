@extends('admin.layouts.main')
@section('content')
 <div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Add Room Services
            </h3>
        </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="form-horizontal" method="post" action="{{route('roomservice.update')}}">
                    {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$service->id}}">
                    <div class="form-group">
                      <label class="control-label" for="service_name">Service Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="service_name" name="service_name" value="{{$service->name}}">
                      </div>
                    </div>
    
                   
                    <div class="form-group">
                      <label class="control-label" for="service_description">Service Description:</label>
                      <div class="col-sm-10"> 
                        <textarea type="text" class="form-control" id="service_description" name="service_description">{{$service->description}}</textarea>
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