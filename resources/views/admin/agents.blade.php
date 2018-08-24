@extends('admin.layouts.main')
@section('content')
<div class="col-md-9">
    <table id="agents" class="table table-bordered">
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
          
         {{--  @forelse($users as $user)
         
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
          @endforelse  --}}
        </tbody>
      </table>
    </div>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  
                    <script>
                        $('#agents').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                              "url":"{{route('admin.agent.list.data')}}",
                              "dataType":"json",
                              "type":"POST",
                              "data":{"_token":"<?= csrf_token(); ?>"}
                            },
                            "columns":[
                              {"data":"id","searchable":false,"orderable":false},
                              {"data":"name"},
                              {"data":"email"},
                              {"data":"created_at"},
                              {"data":"actions","searchable":false,"orderable":false}
                            ],
                            language: {
                              searchPlaceholder: "By Name,Email"
                          }
                        } );
                    
                    </script>
@endsection