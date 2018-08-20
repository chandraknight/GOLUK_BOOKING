@extends('layouts.app')
@section('content')
   @php $total=0; @endphp

    <div class="container">
           <form action="{{route('tourbook')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="tour_package_id" value="{{$tour->id}}">
                 <input type="hidden" name="no_of_people" value="{{$search->people}}">
 <input type="hidden"  name="starting_from" value="{{$search->from}}">
 <input type="hidden"  name="till_date" value="{{$search->to}}">
             <div class="col-md-12">
                <h3>Guest Details</h3>
                            @for($i=0;$i<=$search->people-1;$i++)
                                 <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>First & Last Name</label>
                                    <input class="form-control" name="name[]" type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="form-control" name="contact[]" type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input class="form-control" name="dob[]" type="date">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control" name="address[]" type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                     <label>Gender</label>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender[{{$i}}]" value="male">Male</label>
                                </div>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender[{{$i}}]" value="female">Female</label>
                                </div>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender[{{$i}}]" value="other">Other</label>
                                </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                            @endfor
                            
                        </div>

                         <div class="row">
                <div class="col-md-8">
                    <h3>Customer</h3>
                    
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
                        </div>
                        
                    
                    <hr>
                    <div class="row">
                       

                       
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="booking-item-payment">
                        <header class="clearfix">
                            <a class="booking-item-payment-img" href="{{route('tour.show',$tour->id)}}">
                                <img src="{{url('/')}}/storage/tourpackage/{{$tour['image']}}" alt="{{$tour->name}}" title="4 Strokes of Fun">
                            </a>
                            <h5 class="booking-item-payment-title"><a href="{{route('tour.show',$tour->id)}}">{{$tour->name}}</a></h5>
                            
                        </header>
                        <ul class="booking-item-payment-details">
                            <li>
                                <h5>{{$start->toFormattedDateString()}}</h5>
                            </li>
                            <li>
                                <h5>Event ({{$search->people}} Guests)</h5>
                                <ul class="booking-item-payment-price">
                                    @if($search->people < $tour->group_size)
                                    @php $total = $total + ($search->people * $tour->price); @endphp
                                    <li>
                                        <p class="booking-item-payment-price-title">{{$search->people}} guests</p>
                                        <p class="booking-item-payment-price-amount">${{$tour->price}}<small>/per guest</small>
                                        </p>
                                    </li>
                                    @else
                                    @php $total = $total + ($search->people * $tour->group_price); @endphp
                                        <li>
                                        <p class="booking-item-payment-price-title">{{$search->people}} guests</p>
                                        <p class="booking-item-payment-price-amount">${{$tour->group_price}}<small>/per guest</small>
                                        </p>

                                    </li>
                                    @endif

                                </ul>
                            </li>

                        </ul>
                        <p class="booking-item-payment-total">Total trip: <span>${{$total}}</span>
                        </p>
                        <input type="submit" class="btn btn-primary btn-block" value="Confirm">
                    </div>
                        
                </div>

            </div>
        </form>
            <div class="gap"></div>
        </div>
@endsection