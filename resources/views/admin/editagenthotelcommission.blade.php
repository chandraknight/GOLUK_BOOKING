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
    			<form method="post" action="{{route('update.agent.hotel.commission')}}">
                        {{csrf_field()}}
                        <h6>Update Commission</h6>
                        <div class="form-group">
                            <label>Hotel:</label>
                            <input type="hidden" name="hotel_id" value="{{$commission->hotel->id}}">
                            <input type="hidden" name="commission_id" value="{{$commission->id}}">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="text" class="form-control" disabled value="{{$commission->hotel->name}}">
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