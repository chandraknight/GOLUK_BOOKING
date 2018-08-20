@extends('admin.layouts.main')
@section('content')
 <div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Update Vehicle Service
            </h3>
           
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('vehicle.service.update')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label>Vehicle Service Name</label>
                      <input type="text" class="form-control"  name="service_name" value="{{$service->service_name}}">
                       <input type="hidden" name="id" value="{{$service->id}}">
                    </div>
                    <div class="form-group">
                      <label>Vehicle Service Description</label>
                      <textarea class="form-control" name="service_description">{{$service->service_description}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                  </form>
                </div>
              </div>
            </div> @forelse($otherservices as $otherservice)
            <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{$otherservice->service_name}}</h4>
                      <p>
                        {{$otherservice->service_description}}
                      </p>
                      <a  href="{{route('vehicle.service.edit',$otherservice->id)}}"><button class="btn btn-gradient-primary btn-rounded btn-icon">
                          <i class="mdi mdi-tooltip-edit"></i></button>
                        </a>
                        <a  href="{{route('vehicle.service.delete',$otherservice->id)}}"><button class="btn btn-gradient-danger btn-rounded btn-icon">
                          <i class="mdi mdi-delete"></i></button>
                        </a>
                    </div>
                  </div>
              </div>
                  @empty
                  No Vehicle Services Available
                  @endforelse
        </div>
    </div>
</div>

@endsection