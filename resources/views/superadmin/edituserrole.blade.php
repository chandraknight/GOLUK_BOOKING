@extends('superadmin.layouts.main')
@section('content')
	<form method="post" action="{{route('assignrole')}}">
        {{csrf_field()}}
        <legend>Update Role</legend>
        <div class="form-group">
            <label for="user">User:</label>
               <input type="text" disabled  class="form-control" value="{{$user->name}}">
                <input type="hidden"  value="{{$user->id}}" name="user_id">
               
        </div>
        <div class="form-group">
         @foreach($roles as $role)<div class="form-check">
               
                    <label class="form-check-label">
                              <input type="checkbox" name="role_id[]" value="{{$role->id}}"
                              @foreach($user->roles as $r)  
                              	{{($r->id == $role->id)?'checked':''}}
                              @endforeach
                              >
                              {{$role->name}}
                            </label>
                
        </div>@endforeach
    </div>
        <a><button type="submit"  class="btn btn-primary">Update</button></a>
    </form>
@endsection