@extends('layouts.app') 
@section('content')
 <div class="container">
    <h1 class="page-title"> Bookings Details</h1>
</div>
 <div class="container">
    <div class="row">
    @include('partials.usersidebar')
    <div class="col-md-9">
    <div class="panel-group" id="accordion">
        @foreach($bookingdetails as $bookingdetail)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$loop->iteration}}">{{$bookingdetail->guest_name}}</a></h4>
            </div>
            <div class="panel-collapse collapse in" id="collapse-{{$loop->iteration}}">
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Name: {{$bookingdetail->guest_name}}</li>
                        <li class="list-group-item">Address: {{$bookingdetail->address}}</li>
                        <li class="list-group-item">Date of Birth: {{$bookingdetail->date_of_birth}}</li>
                        <li class="list-group-item">Gender: {{$bookingdetail->gender}}</li>
                        <li class="list-group-item">Remarks: {{$bookingdetail->remarks}}</li>
                    </ul>
                </div>
            </div>
            <div class="panel-footer">
               
                
            </div>
        </div>
        @endforeach
         <p><a href="{{route('invoice.view',$booking->id)}}" class="btn btn-info">View Invoice</a>@if($booking->status == 'pending') <a href="{{route('book.confirm',$booking->id)}}" class="btn btn-success">Confirm</a> @endif @if($booking->status == 'pending'||$booking->status == 'confirmed') <a href="{{route('booking.cancel',$booking->id)}}" class="btn btn-danger">Cancel</a>@endif</p>
    </div>
</div>
    </div>
</div>
@endsection