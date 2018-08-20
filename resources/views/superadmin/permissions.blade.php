@extends('superadmin.layouts.main')
@section('content')
<div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Add User Permission
            </h3>
           
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('addpermission')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label>Permission Name</label>
                      <input type="text" class="form-control"  name="name">
                    </div>
                    <div class="form-group">
                      <label>Permission Description</label>
                      <textarea class="form-control" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Add</button>
                  </form>
                </div>
              </div>
            </div> @forelse($permissions as $permission)
            <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">{{$permission->name}}</h4>
                      <p>
                        {{$permission->description}}
                      </p>
                      <a  href="{{route('editpermission',$permission->id)}}" class="btn btn-gradient-primary btn-rounded btn-icon">
                          <i class="mdi mdi-tooltip-edit"></i>
                        </a>
                        <a  href="{{route('deletepermission',$permission->id)}}" class="btn btn-gradient-danger btn-rounded btn-icon">
                          <i class="mdi mdi-delete"></i>
                        </a>
                    </div>
                  </div>
              </div>
                  @empty
                  No Permission Available
                  @endforelse
        </div>
    </div>
</div>
@endsection
