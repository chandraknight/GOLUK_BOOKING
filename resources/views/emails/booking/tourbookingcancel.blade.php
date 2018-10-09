@component('mail::message')
# Booking Canceled

<p>We are sorry to let you know that your booking of {{$booking->tourPackage['name']}} from {{$booking->starting_from}} to {{$booking->till_date}} has been canceled.</p>

<p>Please contact us for further information</p>
Email:: {{$booking->tourPackage['email']}}<br>
Contact Number:: {{$booking->tourPackage['contact']}}<br>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
