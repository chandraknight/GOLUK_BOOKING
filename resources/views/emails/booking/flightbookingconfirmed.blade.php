@component('mail::message')
# Introduction

Your Flight Tickets has been confirmed.

@component('mail::button', ['url' =>  route('welcome') ])
Yatritime
@endcomponent

@component('mail::table')
| Pax Name      |    Pax Type   | Pax Nationality |   Airline/Sector  |   Flight No |  Date/Time    |            PNR/Ticket   |     Price/Fuel/Tax    |    
| ------------- |:-------------:| ---------------:| ----------------: | ----------: | ------------: | -------------: | ------------------: |
@foreach ($booking->details as $detail)
| {{ $detail->passenger_title }} {{ $detail->passenger_name }}{{ $detail->passenger_surname }} | {{ $detail->passenger_type }} | {{ $detail->passenger_nationality }} | {{ $detail->airline }} / {{ $detail->sector }} | {{ $detail->flight_no }} | {{ $detail->flight_date }}/{{ $detail->flight_time }} | {{ $detail->pnr }}/{{ $detail->ticket }} | {{ $detail->currency }} {{ $detail->price }}/{{ $detail->fuel_surcharge }}/{{ $detail->tax }}   
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
