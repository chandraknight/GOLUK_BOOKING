@extends('layouts.app')
@section('content')
    @php $i = 0; @endphp

   

     <div class="container">
            <div class="row row-wrap">
               
                <form method="post" action="{{route('book.register')}}">
                    <div class="col-md-4"> 

                        <div class="gap"></div>
                   
                        <legend>Adult Details</legend>
                            @for($i=1;$i<=2;$i++)
                            <div class="form-group">
                                <label>Name</label>
                                 
                                <input class="form-control" placeholder="Full Name" type="text">
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input class="form-control"  type="date">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender">Male</label>
                                </div>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender" value="">Female</label>
                                </div>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender" value="">Unspecified</label>
                                </div>
                            </div>
                        <hr>
                        @endfor
                        
                        <input class="btn btn-primary" type="submit" value="Book">
                    </form>
                </div>

                <div class="col-md-4">
                    <div class="gap"></div>
                    <legend>Your Details</legend>
                    <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Full Name">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Address">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="example@mail.com">
                    </div>

                    <div class="form-group">
                        <label>Contact</label>
                        <input type="tel" class="form-control" placeholder="Phone Number">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="gap"></div>
                    <div class="booking-item-payment">
                        <header class="clearfix">
                            <a class="booking-item-payment-img" href="{{route('hotel.show',$hotel->id)}}" target="_blank">
                                <img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" alt="Image Alternative text" title="hotel 1">
                            </a>
                            <h5 class="booking-item-payment-title"><a href="{{route('hotel.show',$hotel->id)}}" target="_">{{$hotel->name}}</a></h5>
                            
                        </header>
                        <ul class="booking-item-payment-details">
                            <li>
                                <h5>Booking for 7 nights</h5>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day">April, 26</p>
                                    <p class="booking-item-payment-date-weekday">Saturday</p>
                                </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day">May, 3</p>
                                    <p class="booking-item-payment-date-weekday">Saturday</p>
                                </div>
                            </li>
                            <li>
                                <h5>Room</h5>
                                @foreach($room as $r)
                                <p class="booking-item-payment-item-title">{{$r['room_type']}} </p>
                                <div class="booking-item-payment-date">
                                
                                <p class="booking-item-payment-item-title">Plan </p>
                            </div>
                            <i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                   <div class="booking-item-payment-date">
                                       <p class="booking-item-payment-item-title">{{strtoupper($r['plan'])}} </p> 
                                   </div>
                                     
                                <ul class="booking-item-payment-price">
                                    <li>
                                        <p class="booking-item-payment-price-title">7 Nights</p>
                                        <p class="booking-item-payment-price-amount">$150<small>/per day</small>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="booking-item-payment-price-title">Taxes</p>
                                        <p class="booking-item-payment-price-amount">$15<small>/per day</small>
                                        </p>
                                    </li>
                                </ul>
                                @endforeach
                            </li>
                        </ul>
                        <p class="booking-item-payment-total">Total trip: <span>$1,155</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
        </div>


@endsection