@extends('admin.layouts.main')
@section('content')
<div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              {{$user->name}}
            </h3>
        </div>
    	<div class="col-md-9">
    		<form action="{{route('update.agent.vehicle.commission')}}" method="post">
    		{{csrf_field()}}
                <h6>Update Commission</h6>
                <div class="form-group">
                    <label>Vehicle:</label>
                    <input type="hidden" name="vehicle_id" value="{{$commission->vehicle->id}}">
                    <input type="hidden" name="commission_id" value="{{$commission->id}}">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="text" class="form-control" disabled value="{{$commission->vehicle->name}}">
                </div>
                <div class="form-group">
                    <label for="user">Commission(in Percentage)</label>
                    <input type="text" class="form-control" name="commission_percent" value="{{$commission->commission_percent}}">
                </div>
                <a><button type="submit"  class="btn btn-primary">Update</button></a>	
    		</form>
    	</div>
    </div>
</div>
@endsection