@component('mail::message')
# Introduction

You have a vehicle booking to be confirmed.

{{$vehicle->name}}
{{$vehiclebooking->customer_name}}

@component('mail::button', ['url' => ''])
Confirm Vehicle Booking
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
