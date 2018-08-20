@extends('layouts.app')
@section('content')
 <div class="container">
    <h1 class="page-title">{{$package->name}}</h1>
</div>
<div class="container">
    <div class="row">
        @include('partials.usersidebar')
        <div class="col-md-5">
            <form method="post" action="{{route('updatepackage')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <legend>Edit TourPackage</legend>
                <div class="form-group">
                    <label>Tour Name</label>
                    <input type="text" name="name" class="form-control" value="{{$package->name}}">
                </div>
                 <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="name" class="form-control" value="{{$package->location}}">
                </div>
                <input type="hidden" value="{{$package->id}}" name="id">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"  cols="30" rows="10" class="form-control">{{$package->description}}</textarea>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{$package->email}}">
                </div>
                <div class="form-group">
                    <label>Contact</label>
                    <input type="tel" name="contact" class="form-control" value="{{$package->contact}}>
                </div>
                <div class="form-group">
                    <label>Provider</label>
                    <input type="text" name="provider" class="form-control" value="{{$package->provider}}">
                </div>
                <div class="form-group">
                    <label>Provider Location</label>
                    <input type="text" name="provider_location" class="form-control" value="{{$package->provider_location}}">
                </div>
                <div class="form-group">
                    <label for="tag">Tags</label>
                    <input type="text" name="tag" class="form-control" value="{{$package->tag}}">
                </div>

                <div class="form-group">
                    <label>Itenary</label>
                    <textarea name="itenary"  cols="30" rows="10" class="form-control">{{$package->itenary}}</textarea>
                </div>

                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" class="form-control" name="duration" value="{{$package->duration}}">
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" min="1" class="form-control" name="price" value="{{$package->price}}">
                </div>

                <div class="form-group">
                    <label>Group Price</label>
                    <input type="number" min="1" class="form-control" name="group_price" value="{{$package->group_price}}">
                </div>

                <div class="form-group">
                    <label>Group Size</label>
                    <input type="number" min="1" class="form-control" name="group_size" value="{{$package->group_size}}">
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <input type="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </div>
</div>
<div class="gap gap-small"></div>
    
@endsection