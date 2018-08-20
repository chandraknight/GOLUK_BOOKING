@extends('layouts.app')
@section('content')
 <div class="container">
    <h1 class="page-title">Tours</h1>
</div>
 <div class="container">
    <div class="row">
        @include('partials.usersidebar')
        <div class="col-md-9">
             <h5 class="booking-sort-title"><a href="{{route('addpackage')}}">Add Tour<i class="fa fa-building-o"></i></a></h5>
            <ul class="booking-list">
            @forelse($packages as $tour)
           <li><span class="booking-item-wishlist-title"><i class="fa fa-building-o"></i> Tour <span>added on {{\Carbon\Carbon::parse($tour->created_at)->toFormattedDateString()}}</span></span>
            <a class="booking-item" href="{{route('viewpackage',$tour->id)}}">
                <div class="row">
                    
                    <div class="col-md-4">
                        <img src="{{url('/')}}/storage/tourpackage/{{$tour['image']}}"" alt="{{$tour->name}}" title="{{$tour->name}}">
                    </div>
                    <div class="col-md-5">
                       
                        <h5 class="booking-item-title">{{$tour->name}}</h5>
                        <p class="booking-item-address"><i class="fa fa-map-marker"></i> {{$tour->location}}</p>
                        <p class="booking-item-description">{{substr($tour->description,0,100)}}....</p>
                    </div>
                    <div class="col-md-3"><span class="btn btn-primary">Edit</span>
                    </div>
                </div>
            </a>
             </li>
            @empty
            No Tours Registered
            @endforelse
            </ul>
        </div>
    </div>
    @endsection