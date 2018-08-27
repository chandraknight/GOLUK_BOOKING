@extends('layouts.app')
@section('content')
 <div class="container">
            <h1 class="page-title">Travel Profile</h1>
        </div>
        <div class="container">
            <div class="row">
                @include('partials.usersidebar')
                
                <div class="col-md-9">
                    <h4>Total Traveled</h4>
                    <ul class="list list-inline user-profile-statictics mb30">
                        <li><i class="fa fa-building user-profile-statictics-icon"></i>
                            <h5>{{$user->hotelBooking->count()}}</h5>
                            <p>Hotel Bookings</p>
                        </li>
                        <li><i class="fa fa-car user-profile-statictics-icon"></i>
                            <h5>{{$user->vehicleBooking->count()}}</h5>
                            <p>Vehicle Bookings</p>
                        </li>
                        <li><i class="fa fa-bars user-profile-statictics-icon"></i>
                            <h5>{{$user->tourPackageBooking->count()}}</h5>
                            <p>Tour Bookings</p>
                        </li>
                        
                    </ul>
                   
                </div>
            </div>
        </div>
@endsection