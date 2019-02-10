@if(count($flights['in']) > 0)
<form method="post" action="{{ route('flight.reserve') }}">
  @csrf @endif @foreach($flights['out'] as $flight)
  <li>
    <div class="booking-item-container">
      <div class="booking-item">
        <div class="row">

          <div class="col-md-2">
            <div class="booking-item-airline-logo">
              <img src="{{$flight['logo']}}" alt="{{$flight['airline']}}" title="{{$flight['airline']}}">
              <p>{{$flight['airline']}}</p>
            </div>
          </div>
          <div class="col-md-5">
            <div class="booking-item-flight-details">
              <div class="booking-item-departure"><i class="fa fa-plane"></i>
                <h5>{{$flight['departuretime']}}</h5>
                <p class="booking-item-date">{{$flight['date']}}</p>
                <p class="booking-item-destination">{{$flight['departure']}}</p>
              </div>
              <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                <h5>{{$flight['arrivaltime']}}</h5>
                <p class="booking-item-date">{{$flight['date']}}</p>
                <p class="booking-item-destination">{{$flight['arrival']}}</p>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <h5>{{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
              mins</h5>
            <p>1 stop</p>
          </div>
          <div class="col-md-3"><span class="booking-item-price">{{$flight['currency']}} {{$flight['tafare']}}</span><span>/adult</span>
            <p class="booking-item-flight-class">Class: {{$flight['class']}}</p>

            @if(count($flights['in'])
            <=0 ) <form method="post" action="{{route('flight.reserve')}}">
              @csrf
              <input type="hidden" name="outflightid" value="{{$flight['flightid']}}">
              <input type="submit" class="btn btn-primary" value="Book">
</form>
@endif
</div>
</div>
@if(count($flights['in']) > 0)
<input type="radio" name="outflightid" value="{{ $flight['flightid']}}" /> Select flight @endif
</div>
<div class="booking-item-details">
  <div class="row">
    <div class="col-md-8">
      <p>Flight Details</p>
      <h5 class="list-title">{{$flight['departure']}} to {{$flight['arrival']}}</h5>
      <ul class="list">
        <li>{{$flight['flightno']}}</li>
        <li>{{$flight['class']}} / AirCraft Type : {{$flight['type']}}</li>
        <li>Depart {{$flight['departuretime']}} Arrive {{$flight['arrivaltime']}}</li>
        <li>Duration: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
          minutes</li>
      </ul>
      {{--
      <h5>Stopover: Charlotte (CLT) 7h 1m</h5>--}}
      <h5 class="list-title">Pricing</h5>
      <ul class="list">
        <li>Adult Base Fare: {{$flight['currency']}} {{$flight['afare']}}</li>
        <li>Child Base Fare: {{$flight['currency']}} {{$flight['cfare']}}</li>
        <li>Infant Base Fare: {{$flight['currency']}} {{$flight['ifare']}}</li>
        <li>Fuel Surcharge: {{$flight['currency']}} {{$flight['fuel']}}</li>
        <li>Tax: {{$flight['currency']}} {{$flight['tax']}}</li>
        <li>Baggage: {{$flight['baggage']}}</li>
        <li>Refundable: {{$flight['refund']}}</li>
        <li>Duration: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
          mins</li>
      </ul>
      <p>Total trip time: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
        mins</p>
    </div>
  </div>
</div>

</div>

</li>

@endforeach @if(count($flights['in']) > 0) @foreach($flights['in'] as $flight)
<li>
  <div class="booking-item-container">
    <div class="booking-item">
      <div class="row">
        <div class="col-md-2">
          <div class="booking-item-airline-logo">
            <img src="{{$flight['logo']}}" alt="{{$flight['airline']}}" title="{{$flight['airline']}}">
            <p>{{$flight['airline']}}</p>
          </div>
        </div>
        <div class="col-md-5">
          <div class="booking-item-flight-details">
            <div class="booking-item-departure"><i class="fa fa-plane"></i>
              <h5>{{$flight['departuretime']}}</h5>
              <p class="booking-item-date">{{$flight['date']}}</p>
              <p class="booking-item-destination">{{$flight['departure']}}</p>
            </div>
            <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
              <h5>{{$flight['arrivaltime']}}</h5>
              <p class="booking-item-date">{{$flight['date']}}</p>
              <p class="booking-item-destination">{{$flight['arrival']}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <h5>{{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
            mins</h5>
          <p>1 stop</p>
        </div>
        <div class="col-md-3"><span class="booking-item-price">{{$flight['currency']}} {{$flight['tafare']}}</span><span>/adult</span>
          <p class="booking-item-flight-class">Class: {{$flight['class']}}</p>
          {{-- <a class="btn btn-primary" href="#">Details</a> --}}

        </div>
      </div>
      <input type="radio" name="returnflightid" value="{{ $flight['flightid']}}" /> Select flight
    </div>
    <div class="booking-item-details">
      <div class="row">
        <div class="col-md-8">
          <p>Flight Details</p>
          <h5 class="list-title">{{$flight['departure']}} to {{$flight['arrival']}}</h5>
          <ul class="list">
            <li>{{$flight['flightno']}}</li>
            <li>{{$flight['class']}} / AirCraft Type : {{$flight['type']}}</li>
            <li>Depart {{$flight['departuretime']}} Arrive {{$flight['arrivaltime']}}</li>
            <li>Duration: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
              minutes</li>
          </ul>
          {{--
          <h5>Stopover: Charlotte (CLT) 7h 1m</h5>--}}
          <h5 class="list-title">Pricing</h5>
          <ul class="list">
            <li>Adult Base Fare: {{$flight['currency']}} {{$flight['afare']}}</li>
            <li>Child Base Fare: {{$flight['currency']}} {{$flight['cfare']}}</li>
            <li>Infant Base Fare: {{$flight['currency']}} {{$flight['ifare']}}</li>
            <li>Fuel Surcharge: {{$flight['currency']}} {{$flight['fuel']}}</li>
            <li>Tax: {{$flight['currency']}} {{$flight['tax']}}</li>
            <li>Baggage: {{ $flight['baggage'] }}</li>
            <li>Refundable: {{$flight['refund']}}</li>
            <li>Duration: {{ \Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
              mins</li>
          </ul>
          <p>Total trip time: {{\Carbon\Carbon::parse($flight['departuretime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['arrivaltime']))}}
            mins</p>
        </div>
      </div>
    </div>
  </div>
</li>
@endforeach @endif @if(count($flights['in']) > 0)
<input type="submit" value="Reserve" class="btn btn-primary"> @endif