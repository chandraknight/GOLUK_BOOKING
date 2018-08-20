@component('mail::message')
# Introduction

Your booking has been confirmed.

{{$vehicle->name}}
{{$booking->from}} to {{$booking->to}}

@component('mail::button', ['url' => ''])
Booking Confirmed
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
