@extends('layouts.app')
@section('content')
 <div class="container">
    <h1 class="page-title">Hotels</h1>
</div>
 <div class="container">
    <div class="row">
        @include('partials.usersidebar')
         <div class="col-md-9">
                 <h5 class="booking-sort-title"><a href="{{route('hotel.register')}}">Add Hotel<i class="fa fa-building-o"></i></a></h5>
            <ul class="booking-list booking-list-wishlist">
            	@forelse($hotels as $hotel)
                <li><span class="booking-item-wishlist-title"><i class="fa fa-building-o"></i> Hotel <span>added on {{\Carbon\Carbon::parse($hotel->created_at)->toFormattedDateString()}}</span></span>
                   
                    <a class="booking-item" href="{{route('hotel.view',$hotel->id)}}">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" alt="{{$hotel->name}}" title="{{$hotel->name}}">
                            </div>
                            <div class="col-md-6">
                                <h5 class="booking-item-title">{{$hotel->name}}</h5>
                                <p class="booking-item-address"><i class="fa fa-map-marker"></i> {{$hotel->address}}</p>
                            </div>
                            <div class="col-md-3"><span class="btn btn-primary">View</span>
                            </div>
                        </div>
                    </a>
                </li>
                @empty
                No Hotels Yet
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection