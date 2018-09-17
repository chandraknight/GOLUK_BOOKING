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
                  <form class="form-horizontal" method="post" action="{{route('roomservice.add')}}">
                    {{csrf_field()}}
    
                    <div class="form-group">
                      <label class="control-label" for="service_name">Service Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Enter Service Name">
                      </div>
                    </div>
    
                   
                    <div class="form-group">
                      <label class="control-label" for="service_description">Service Description:</label>
                      <div class="col-sm-10"> 
                        <textarea type="text" class="form-control" id="service_description" name="service_description" placeholder="Enter Service Description"></textarea>
                      </div>
                    </div>
                    
       
                    <div class="form-group"> 
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                  </form>
                </div>
              </div>
            </div> 
            @forelse($services as $service)
            <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{$service->name}}</h4>
                      <p>
                        <h5>Service Description</h5>
                        {{$service->description}}
                      </p>
                      
                      <a  href="{{route('admin.editroomservice',$service->id)}}"><button class="btn btn-gradient-primary btn-rounded btn-icon">
                          <i class="mdi mdi-tooltip-edit"></i></button>
                        </a>
                        <a  href="{{route('roomservice.delete',$service->id)}}"><button class="btn btn-gradient-danger btn-rounded btn-icon">
                          <i class="mdi mdi-delete"></i></button>
                        </a>
                    </div>
                  </div>
              </div>    
            </div>
            @empty
            No Hotel Services Available
            @endforelse
        
    </div>
</div>

@endsection