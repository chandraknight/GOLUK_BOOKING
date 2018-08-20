@extends('superadmin.layouts.main')
@section('content')
    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Hotel Name
                        </th>
                        <th>
                          Address
                        </th>
                        <th>
                          Join Date
                        </th>
                        <th>
                          Email
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     @forelse($hotels as $hotel)
                      <tr class="table-danger">
                        <td>
                          {{$loop->iteration}}
                        </td>
                        <td>
                          <h4><a href="{{route('admin.hotel.view',$hotel->id)}}"> {{$hotel->name}}</a></h4>
                        </td>
                        <td>
                          {{$hotel->address}}
                        </td>
                        <td>
                          {{\Carbon\Carbon::parse($hotel->created_at)->toFormattedDateString()}}
                        </td>
                        <td>
                          {{$hotel->email}}
                        </td>
                      </tr>
                     @empty
                     No Hotels available
                      @endforelse
                    </tbody>
                  </table>
@endsection