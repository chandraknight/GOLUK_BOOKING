@component('mail::message')
# New Booking

You have a new vehicle booking to be confirmed.

@component('mail::table')
    | S.No          | Title                | Details  |
    | ------------- |:--------------------:| --------:|
    | 1             | Vehicle Code         | {{$vehicle->vehicle_code}}     |
    | 2             | Name                 | {{$booking->customer_name}}      |
    | 3             | Email                | {{$booking->customer_email}}      |
    | 4             | Contact              | {{$booking->customer_contact}}      |
    | 5             | Address              | {{$booking->customer_address}}      |
    | 6             | Booking From         | {{\Carbon\Carbon::parse($booking->from)->toFormattedDateString()}} |
    | 7             | Booking Till         | {{\Carbon\Carbon::parse($booking->to)->toFormattedDateString()}}   |
    | 8             | Pick Up              | {{$booking->location}} |
    | 9             | Drop Off             | {{$booking->destination}} |
    | 10            | Number of People     | {{$booking->no_of_passengers}} |
@endcomponent

@component('mail::button', ['url' => route('vehicle.booking',$vehicle->id)])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
