@extends('admin.layouts.main')
@section('content')
<div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update User</li>
              </ol>
            </nav>
          </div>
           <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update User</h4>
                  <p class="card-description">
                    {{$user->name}}
                  </p>
                  <form class="forms-sample" method="post" action="{{route('admin.user.update')}}">
                  	{{csrf_field()}}
                    <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" class="form-control" name="name" value="{{$user->name}}">
                      <input type="hidden" name="user_id" value="{{$user->id}}">
                    </div>
                    <div class="form-group">
                      <label>Email address</label>
                      <input type="email" class="form-control" name="email" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password"  placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" class="form-control" name="password_confirmation" placeholder="Password">
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                    <a class="btn btn-light" href="{{route('admin.users')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
            
      </div>
  </div>

@endsection