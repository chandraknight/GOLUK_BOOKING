@extends('admin.layouts.main')
@section('content')
<div class="col-md-9">
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>
              #
            </th>
            <th>
              Agent Name
            </th>
            <th>
              Email
            </th>
            <th>
              Join Date
            </th>
            <th>
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          
         @forelse($users as $user)
         
          <tr  class="table-danger"> 

            <td>
              {{$loop->iteration}}
            </td>
            <td>
             <a href="{{route('admin.agent.details',$user->id)}}"><h4>{{$user->name}}</h4> </a>
            </td>
            <td>
              {{$user->email}}
            </td>
            <td>
              {{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}
            </td>
            <td>
              <a class="btn btn-primary" href="{{route('admin.agent.booking',$user->id)}}">Bookings</a>
              <a class="btn btn-success" href="{{route('admin.agent.details',$user->id)}}">Assign Commission</a>
            </td>
            
          </tr>
       
         @empty
         No Agents Registered
          @endforelse
        </tbody>
      </table>
    </div>
@endsection