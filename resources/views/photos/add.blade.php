@extends('hotels.layouts.main')
@section('content')
	<div class="container">
		<form action="{{route('photo.upload')}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<legend class="">Upload Photo</legend>
			<div class="form-group">
				<label class="label-control" for="title">Title: </label>
				<input type="text" class="form-control" name="title" placeholder="Enter Title">
			</div>
			<div class="form-group">
				<label for="description">Description: </label>
				<textarea name="description" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<label class="label-control" for="photo">Select Image: </label>
				<input type="file" class="form-control" name="photo" placeholder="Select Photo">
			</div>
			<input type="hidden" name="id" value="{{$id}}">
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="submit" value="Upload">
			</div>

		</form>
	</div>
@endsection