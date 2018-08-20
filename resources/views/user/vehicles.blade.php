@extends('layouts.app')
@section('content')
 <div class="container">
    <h1 class="page-title">Vehicles</h1>
</div>
 <div class="container">
    <div class="row">
        @include('partials.usersidebar')
         <div class="col-md-9">
             <h5 class="booking-sort-title"><a href="{{route('vehicle.add')}}">Add Vehicle<i class="fa fa-building-o"></i></a></h5>
            <ul class="booking-list booking-list-wishlist">
            	@forelse($vehicles as $vehicle)
                <li><span class="booking-item-wishlist-title"><i class="fa fa-car"></i> vehicle <span>added on {{\Carbon\Carbon::parse($vehicle->created_at)->toFormattedDateString()}}</span></span>
                   
                    <a class="booking-item" href="{{route('vehicle.view',$vehicle->id)}}">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{url('/')}}/storage/vehicle/{{$vehicle['image']}}" alt="{{$vehicle->name}}" title="{{$vehicle->name}}">
                            </div>
                            <div class="col-md-6">
                                <h5 class="booking-item-title">{{$vehicle->name}}</h5>
                                <p class="booking-item-address"><i class="fa fa-map-marker"></i> {{$vehicle->location}}</p>
                            </div>
                            <div class="col-md-3"><span class="btn btn-primary">View</span>
                            </div>
                        </div>
                    </a>
                </li>
                @empty
                No vehicles Yet
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection