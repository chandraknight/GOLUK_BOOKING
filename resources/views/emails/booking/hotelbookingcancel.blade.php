@component('mail::message')
# Booking Canceled

We are extremely sorry for letting you know that your booking from {{$booking->from_date}} to {{$booking->till_date}} on {{$booking->hotel['name']}} has been Canceled.

Please contact us for further information.

Email: {{$booking->hotel['email']}}<br>
Contact Number: {{$booking->hotel['contact']}}



Thanks,<br>
{{ config('app.name') }}
@endcomponent
