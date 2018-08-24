@extends('admin.layouts.main')
@section('content')
    <table id="users" class="table table-bordered table-striped">
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
                      
                     {{--  @forelse($users as $user)
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
                          {{$user->roles->first()->name}}
                        </td>
                        <td>
                        	<a href="{{route('admin.user.edit',$user->id)}}"><i class="mdi  mdi-pencil-box"></i></a>
                        	<a href="{{route('admin.user.delete',$user->id)}}"><i class="mdi mdi-delete-forever"></i></a>
                        </td>
                      </tr>
                     @empty
                     No Users available
                      @endforelse  --}}
                    </tbody>
                  </table>
                  <script
                  src="https://code.jquery.com/jquery-3.3.1.min.js"
                  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                  crossorigin="anonymous"></script>
                  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                
                                  <script>
                                      $('#users').DataTable( {
                                          "processing": true,
                                          "serverSide": true,
                                          "ajax": {
                                            "url":"{{route('admin.user.data')}}",
                                            "dataType":"json",
                                            "type":"POST",
                                            "data":{"_token":"<?= csrf_token(); ?>"}
                                          },
                                          "columns":[
                                            {"data":"id","searchable":false,"orderable":false},
                                            {"data":"username"},
                                            {"data":"email"},
                                            {"data":"created_at","searchable":false,"orderable":false},
                                            {"data":"rolename"},
                                            {"data":"actions","searchable":false,"orderable":false}
                                          ],
                                          language: {
                                            searchPlaceholder: "By Name,Email or Role"
                                        }
                                      } );
                                  
                                  </script>
@endsection