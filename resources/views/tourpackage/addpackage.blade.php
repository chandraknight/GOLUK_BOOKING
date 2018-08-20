@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="page-title">Add Tour Package</h1>
</div>
<div class="container">
    @include('partials.usersidebar')
    <div class="container">
        <div class="col-md-5">
            <form method="post" action="{{route('registerpackage')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label>Tour Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                 <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"  cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="tel" name="contact" class="form-control">
                </div>
                <div class="form-group">
                    <label>Provider</label>
                    <input type="text" name="provider" class="form-control">
                </div>
                <div class="form-group">
                    <label>Provider Location</label>
                    <input type="text" name="provider_location" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tag">Tags</label>
                    <input type="text" name="tag" class="form-control">
                </div>

                <div class="form-group">
                    <label>Itenary</label>
                    <textarea name="itenary"  cols="30" rows="10" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" class="form-control" name="duration">
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" min="1" class="form-control" name="price">
                </div>

                <div class="form-group">
                    <label>Group Price</label>
                    <input type="number" min="1" class="form-control" name="group_price">
                </div>

                <div class="form-group">
                    <label>Group Size</label>
                    <input type="number" min="1" class="form-control" name="group_size">
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <input type="submit" class="btn btn-primary" value="Register">
            </form>
        </div>
    </div>
</div>
<div class="gap gap-small"></div>
@endsection