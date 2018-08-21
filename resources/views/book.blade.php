@extends('layouts.app')
@section('content')
    @php $i = 0;$total=0; @endphp

     <div class="container">
            <div class="row row-wrap">
               
                <form method="post" action="{{route('book.register')}}">
                    {{csrf_field()}}
                    <div class="col-md-4"> 
                    <input type="hidden" name="no_adults" value="{{$search->no_adults}}">
                    <input type="hidden" name="no_childs" value="{{$search->no_childs}}">
                    <input type="hidden"  name="till_date" value="{{$search->to_date}}">
                     <input type="hidden" name="from_date" value="{{$search->from_date}}">
                     <input type="hidden" name="hotel_id" value="{{$hotel->id}}"> 
                     <input type="hidden" name="no_rooms" value="{{$no_rooms}}">
                        <div class="gap"></div>
                   
                        <legend>Adult Details</legend>
                            @for($i=1;$i<=$search->no_adults;$i++)
                            <div class="form-group">
                                <label>Name</label>
                                 
                                <input class="form-control" placeholder="Full Name" name="guest[]" type="text">
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="dob[]" type="text">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" name="address[]" type="text">
                            </div>
                            <input type="hidden" name="adult_child[]" value="a">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender[{{$i}}]" value="m">Male</label>
                                </div>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender[{{$i}}]" value="f">Female</label>
                                </div>
                                <div class="radio-inline radio-stroke">
                                <label>
                                    <input class="i-radio" type="radio" name="gender[{{$i}}]" value="o">Unspecified</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea name="remarks[]" class="form-control"></textarea>
                            </div>
                        <hr>
                        @endfor
                </div>

                <div class="col-md-4">
                    <div class="gap"></div>
                    <legend>Your Details</legend>
                    <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="customer_name" 
                       value="{{(Auth::user())?Auth::user()->name:''}}" placeholder="Your Name"
                    >
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="customer_address"  placeholder="Address">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="customer_email" value="{{(Auth::user())?Auth::user()->email:''}}" placeholder="example@mail.com" >
                    </div>

                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="tel" class="form-control" name="customer_number" placeholder="Phone Number">
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
                                <h5>Booking for {{$days}} nights</h5>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day">{{$start->format('F')}},{{$start->day}} </p>
                                    <p class="booking-item-payment-date-weekday">{{$start->format('l')}}</p>
                                </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                <div class="booking-item-payment-date">
                                    <p class="booking-item-payment-date-day">{{$end->format('F')}},{{$end->day}} </p>
                                    <p class="booking-item-payment-date-weekday">{{$end->format('l')}}</p>
                                </div>
                            </li>
                           
                                <h4>Rooms</h4>
                                @foreach($room as $r)
                                 <input type="hidden"  name="room[]" value="{{$r['room']}}">
                                <input type="hidden"  name="roomtype[]" value="{{$r['room_type']}}">
                                 <input type="hidden" name="no_of_rooms[]" value="{{$r['no_rooms']}}">
                                 <input type="hidden" name="plan[]" value="{{$r['plan']}}">
                                <li> <p class="booking-item-payment-item-title">{{$r['room_type']}} </p>
                           
                                <div class="booking-item-payment-date">
                                 <p class="booking-item-payment-item-title">Plan </p>
                                </div>
                                <i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                <div class="booking-item-payment-date">
                                   <p class="booking-item-payment-item-title">{{strtoupper($r['plan'])}}</p> 
                                 </div>

                               </li>
                               <li>
                                   <div class="booking-item-payment-date">
                                 <p class="booking-item-payment-item-title">Number of Rooms </p>
                                </div>
                                <i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
                                <div class="booking-item-payment-date">
                                   <p class="booking-item-payment-item-title">{{$r['no_rooms']}}</p> 
                                 </div>
                               </li>
                                 <li> 
                                <ul class="booking-item-payment-price">
                                    <li>

                                       @foreach($rooms as $room)
                                       @if($room->id == $r['room'])
                                        <p class="booking-item-payment-price-title">{{$days}} Nights</p>
                                        @if($r['plan']=="none")
                                       @php

                                        $total = $total + ($room->room_flat_cost*$days*$r['no_rooms']);
                                        
                                        @endphp
                                        <input type="hidden" name="rate[]" value="{{$room->room_flat_cost}}">
                                        <p class="booking-item-payment-price-amount">Rs {{$room->room_flat_cost}}<small>/per day</small>
                                        </p>
                                        @elseif($r['plan']=='ap')
                                         @php
                                        $total = $total + ($room->cost_ap_plan*$days*$r['no_rooms']);
                                        @endphp
                                        <input type="hidden" name="rate[]" value="{{$room->cost_ap_plan}}">
                                        <p class="booking-item-payment-price-amount">Rs {{$room->cost_ap_plan}}<small>/per day</small>
                                        </p>
                                         @elseif($r['plan']=='ep')
                                         @php
                                        $total = $total + ($room->cost_ep_plan*$days*$r['no_rooms']);
                                        @endphp
                                        <input type="hidden" name="rate[]" value="{{$room->cost_ep_plan}}">
                                        <p class="booking-item-payment-price-amount">Rs {{$room->cost_ep_plan}}<small>/per day</small>
                                        </p>
                                         @elseif($r['plan']=='cp')
                                          @php
                                        $total = $total + ($room->cost_cp_plan*$days*$r['no_rooms']);
                                        @endphp
                                        <input type="hidden" name="rate[]" value="{{$room->cost_cp_plan}}">
                                        <p class="booking-item-payment-price-amount">Rs {{$room->cost_cp_plan}}<small>/per day</small>
                                        </p>
                                         @else
                                          @php
                                        $total = $total + ($room->cost_map_plan*$days*$r['no_rooms']);
                                        @endphp
                                        <input type="hidden" name="rate[]" value="{{$room->cost_map_plan}}">
                                        <p class="booking-item-payment-price-amount">Rs {{$room->cost_map_plan}}<small>/per day</small>
                                        </p>
                                        @endif
                                        @endif
                                        @endforeach
                                    </li>
                                    
                                </ul>
                            </li>
                                @endforeach
                            
                        </ul>
                        <p class="booking-item-payment-total"><span>Total: Rs {{$total}}</span>
                        </p>
                    </div>
                </div>
            </div>
             <input class="btn btn-primary" type="submit" value="Book">
                    </form>
            <div class="gap"></div>
        </div>


@endsection