 @extends('layouts.app')
@section('content')
   

   <div class="container">
    <div class="gap"></div>
           <form action="{{route('vehiclereserve')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}">
                 <input type="hidden" name="passenger" value="{{$search->passengers}}">
                 <input type="hidden" name="location" value="{{$search->location}}">
                 <input type="hidden"  name="destination" value="{{$search->destination}}">
                 <input type="hidden"  name="from" value="{{$search->from}}">
                 <input type="hidden"  name="till" value="{{$search->till}}">
                 <input type="hidden"  name="pickup_time" value="{{$search->pickup_time}}">
                 <input type="hidden"  name="dropoff_time" value="{{$search->dropoff_time}}">

                <div class="row">
                <div class="col-md-8">
                    
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input class="form-control" name="customer_name" type="text" value="{{(Auth::user())?Auth::user()->name:''}}" placeholder="Your Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" name="customer_contact" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" name="customer_email" type="email" value="{{(Auth::user())?Auth::user()->email:''}}" placeholder="Your Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control" name="customer_address" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks"></textarea>
                                </div>
                            </div>
                        </div>
                        
                    
                    <hr>
                    <div class="row">
                       

                       
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="booking-item-payment">
                        <header class="clearfix">
                            <a class="booking-item-payment-img" href="#">
                                <img src="{{url('/')}}/storage/vehicle/{{$vehicle->image}}" alt="{{$vehicle->name}}" title="{{$vehicle->name}}">
                            </a>
                            <h5 class="booking-item-payment-title"><a href="#">{{$vehicle->name}}</a></h5>
                        </header>
                        <ul class="booking-item-payment-details">
                            <li>
                                <h5>Rent for {{$days}} days</h5>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day">{{$from->format('F')}}, {{$from->day}}</p>
                                    <p class="booking-item-payment-date-weekday">{{$from->format('l')}}</p>
                                    <p class="booking-item-payment-date-weekday">{{$search->pickup_time}}</p>
                                </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day">{{$till->format('F')}}, {{$till->day}}</p>
                                    <p class="booking-item-payment-date-weekday">{{$till->format('l')}}</p>
                                    <p class="booking-item-payment-date-weekday">{{$search->dropoff_time}}</p>
                                </div>
                            </li>
                            <li>
                                <h5>{{$vehicle->types->type_name}} ({{$search->passengers}} Passengers)</h5>
                                <ul class="booking-item-payment-price">
                                    
                                    <li>
                                        <p class="booking-item-payment-price-title">Rate per Day</p>
                                        <p class="booking-item-payment-price-amount">${{$vehicle->rate_per_day}}<small>/per day</small>
                                        </p>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <p class="booking-item-payment-total">Total trip: <span>${{$vehicle->rate_per_day*$days}}</span>
                        </p><input class="btn btn-primary btn-block" type="submit" value="Book">
                    </div>
                </div>

            </div>
            <div class="col-md-7">
                                <div class="booking-item-price-calc">
                                    <div class="row row-wrap">
                                        <div class="col-md-6">
                                            @forelse($vehicle->vehicleServiceCost as $servicecost)
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" name="service[]" value="{{$servicecost->vehicleService->id}}">{{$servicecost->vehicleService->service_name}}<span class="pull-right">${{$servicecost->cost_per_day}}</span>
                                                    <input type="hidden" class="form-control" name="service_cost[]" value="{{$servicecost->cost_per_day}}">
                                                </label>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
        </form>
            <div class="gap"></div>
        </div>
@endsection