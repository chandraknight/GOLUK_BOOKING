@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="page-title">{{$hotel->name}}</h1>
</div>
 <div class="container">
        @include('partials.usersidebar')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <legend>Add Room Service</legend>
                <form method="post" action="{{route('roomservice.add')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Room Service: </label>
                        <input type="text" class="form-control" name="service_name">
                    </div>
                    <div class="form-group">
                        <label>Description: </label>
                        <textarea class="form-control" name="service_description"></textarea>
                    </div>
                    <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
            </div>
            <div class="col-md-4">
                <h3>Available Room Services</h3>
                <ul class="list-group">
                    @forelse($roomservices as $roomservice)
                    <li class="list-group-item">{{$roomservice->name}} <a href="{{route('roomservice.edit',$roomservice->id)}}"><i class="fa fa-pencil pull-right" aria-hidden="true"></i></a>
                        <a href="{{route('roomservice.delete',$roomservice->id)}}"><i class="fa fa-minus-square pull-right" aria-hidden="true"></i></a></li>
                        <li class="list-group-item">
                            <ul class="list-group">
                                <li class="list-group-item">{{$roomservice->description}}</li>
                            </ul>
                        </li>
                    @empty
                        No Services Available
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection