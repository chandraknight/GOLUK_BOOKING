@component('mail::message')
# Booking Confirmed

Your booking has been confirmed.

{{$vehicle->name}}
{{$booking->from}} to {{$booking->to}}



Thanks,<br>
{{ config('app.name') }}
@endcomponent
