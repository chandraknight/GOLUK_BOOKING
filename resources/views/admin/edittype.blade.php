@extends('admin.layouts.main')
@section('content')
   <div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Edit Vehicle Type
            </h3>
           
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('vehicle.type.update')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label>Vehicle Type Name</label>
                      <input type="text" class="form-control"  name="type_name" value="{{$type->type_name}}">
                      <input type="hidden" name="id" value="{{$type->id}}">
                    </div>
                    <div class="form-group">
                      <label>Vehicle Type Description</label>
                      <textarea class="form-control" name="type_description">{{$type->type_description}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                  </form>
                </div>
              </div>
            </div> @forelse($othertypes as $t)
            <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{$t->type_name}}</h4>
                      <p>
                        {{$t->type_description}}
                      </p>
                      <a  href="{{route('vehicle.type.edit',$type->id)}}"><button class="btn btn-gradient-primary btn-rounded btn-icon">
                          <i class="mdi mdi-tooltip-edit"></i></button>
                        </a>
                        <a  href="{{route('vehicle.type.delete',$type->id)}}"><button class="btn btn-gradient-danger btn-rounded btn-icon">
                          <i class="mdi mdi-delete"></i></button>
                        </a>
                    </div>
                  </div>
              </div>
                  @empty
                  No Vehicle Types Available
                  @endforelse
        </div>
    </div>
</div>
@endsection