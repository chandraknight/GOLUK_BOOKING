@component('mail::message')
# Booking Confirmed

Your Booking has been Confirmed

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
