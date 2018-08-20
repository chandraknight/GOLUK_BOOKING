@extends('admin.layouts.main')
@section('content')
 <div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Add Vehicle Service
            </h3>
           
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('vehicle.service.register')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label>Vehicle Service Name</label>
                      <input type="text" class="form-control"  name="service_name">
                    </div>
                    <div class="form-group">
                      <label>Vehicle Service Description</label>
                      <textarea class="form-control" name="service_description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Add</button>
                  </form>
                </div>
              </div>
            </div> @forelse($services as $service)
            <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{$service->service_name}}</h4>
                      <p>
                        {{$service->service_description}}
                      </p>
                      <a  href="{{route('vehicle.service.edit',$service->id)}}"><button class="btn btn-gradient-primary btn-rounded btn-icon">
                          <i class="mdi mdi-tooltip-edit"></i></button>
                        </a>
                        <a  href="{{route('vehicle.service.delete',$service->id)}}"><button class="btn btn-gradient-danger btn-rounded btn-icon"><i class="mdi mdi-delete"></i></button></a>
                          
                        
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