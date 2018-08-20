@extends('superadmin.layouts.main')
@section('content')
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
                        Actions
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
                            <a href="{{route('admin.user.edit',$user->id)}}"><i class="mdi  mdi-pencil-box"></i></a>
                            <a href="{{route('admin.user.delete',$user->id)}}"><i class="mdi mdi-delete-forever"></i></a>
                        </td>
                      </tr>
                     @empty
                     No Users available
                      @endforelse
                    </tbody>
                  </table>
@endsection