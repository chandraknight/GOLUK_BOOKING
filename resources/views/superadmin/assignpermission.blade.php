@extends('superadmin.layouts.main')
@section('content')
    <form method="post" action="{{route('assignpermission')}}">
        {{csrf_field()}}
        <legend>Assign Role</legend>
        <div class="form-group">
            <label for="user">Select User:</label>
            <select class="form-control" name="user_id">
                @foreach($users as $user)
                    <option value="{{$user->id}}" >{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="user">Select User:</label>
            <select class="form-control" name="permission_id">
                @foreach($permissions as $permission)
                    <option value="{{$permission->id}}">{{ucfirst($permission->name)}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" ><a class="btn btn-success">Grant</a></button>
    </form>
@endsection