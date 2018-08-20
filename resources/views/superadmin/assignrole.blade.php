@extends('superadmin.layouts.main')
@section('content')
<div class="cotainer">
<div class="col-md-12">
    <form method="post" action="{{route('assignrole')}}">
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
         @foreach($roles as $role)<div class="form-check">
               
                    <label class="form-check-label">
                              <input type="checkbox" name="role_id[]" value="{{$role->id}}" >
                              {{$role->name}}
                            </label>
                
        </div>@endforeach
    </div>
        <a><button type="submit"  class="btn btn-primary">Assign</button></a>
    </form>
</div>
<div class="col-md-12">
<table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          User Name
                        </th>
                        <th>
                          Email
                        </th>
                        <th>
                          Join Date
                        </th>
                        <th>
                          Role
                        </th>
                        <th>
                        Edit Roles
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     @forelse($users as $user)
                      <tr>
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          <h4>{{$user->name}}</h4>
                        </td>
                        <td>
                          {{$user->email}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          @foreach($user->roles as $role)
                          {{$role->name}},
                          @endforeach
                        </td>
                        <td>
                            <a href="{{route('edituserrole',$user->id)}}"><i class="mdi  mdi-pencil-box"></i></a>
                        </td>
                      </tr>
                     @empty
                     No Users available
                      @endforelse
                    </tbody>
                  </table>
</div>
</div>
@endsection