@extends('hotels.layouts.main')
@section('content')
<div class="container">
	<div class="row">
		@forelse($hotels as $hotel)
		<div class="col-md-3">
			<div class="panel panel-primary">
				<div class="panel-heading">{{$hotel['name']}}</div>
			  <div class="panel-body">
			   		 <ul class="list-group">		
							<li class="list-group-item"><h4>{{$hotel['email']}}</h4></li>
							<li class="list-group-item">{{$hotel['address']}}</li>
						 	<li class="list-group-item">{{$hotel['website']}}</li>
							<li class="list-group-item">{{$hotel['contact']}}</li>
										
					</ul>
						<img class="thumbnail" height="220" width="220" src="storage/hotel_logo/{{$hotel['logo']}}">
					<ul class="list-group">
							@foreach($hotel->hotelservices as $service )
							<li class="list-group-item">{{$service->service_name}}</li>
							@endforeach
					</ul>
			  </div>
				<div class="panel-footer">
					<a class="btn btn-primary" href="{{route('hotel.view',$hotel->id)}}">View</a>
					@role('admin','hotelowner','superadmin')
					<a class="btn btn-success" href="{{route('hotel.edit',$hotel->id)}}">Edit</a>
					<a class="btn btn-danger" href="{{route('hotel.delete',$hotel->id)}}">Delete</a>
					@endrole
				</div>
			</div>			
		</div>
		@empty
			{{'No Hotels available'}} 
		@endforelse
	</div>
	<div class="clearfix"></div>
</div>
@endsection