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
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$loop->iteration}}">{{$bookingdetail->name}}</a></h4>
            </div>
            <div class="panel-collapse collapse in" id="collapse-{{$loop->iteration}}">
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Name: {{$bookingdetail->name}}</li>
                        <li class="list-group-item">Address: {{$bookingdetail->address}}</li>
                        <li class="list-group-item">Date of Birth: {{$bookingdetail->dob}}</li>
                        <li class="list-group-item">Gender: {{$bookingdetail->gender}}</li>
                        <li class="list-group-item">Contact: {{$bookingdetail->contact}}</li>
                    </ul>
                </div>
            </div>
            <div class="panel-footer">
               
                
            </div>
        </div>
        @endforeach
         <p><a href="{{route('viewtourinvoice',$booking->id)}}" class="btn btn-info">View Invoice</a>@if($booking->booking_status == 'pending') <a href="{{route('tour.confirm',$booking->id)}}" class="btn btn-success">Confirm</a> @endif @if($booking->booking_status == 'pending'||$booking->booking_status == 'confirmed') <a href="{{route('tour.cancel',$booking->id)}}" class="btn btn-danger">Cancel</a>@endif</p>
    </div>
</div>
    </div>
</div>
@endsection