@component('mail::message')
# Booking Canceled

We are extremely sorry to let you know that your booking of {{$booking->vehicle['name']}} from {{$booking->from}} to {{$booking->to}} has been canceled.

Please contact us for further information.
Email::{{$booking->vehicle['email']}}<br>
Contact Number:: {{$booking->vehicle['contact']}}<br>
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
