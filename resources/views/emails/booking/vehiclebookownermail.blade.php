@component('mail::message')
# New Booking

You have a new vehicle booking to be confirmed.

@component('mail::table')
    | S.No          | Title                | Details  |
    | ------------- |:--------------------:| --------:|
    | 1             | Vehicle Code         | {{$vehicle->vehicle_code}}     |
    | 2             | Name                 | {{$vehiclebooking->customer_name}}      |
    | 3             | Email                | {{$vehiclebooking->customer_email}}      |
    | 4             | Contact              | {{$vehiclebooking->customer_contact}}      |
    | 5             | Address              | {{$vehiclebooking->customer_address}}      |
    | 6             | Booking From         | {{\Carbon\Carbon::parse($vehiclebooking->from)->toFormattedDateString()}} |
    | 7             | Booking Till         | {{ \Carbon\Carbon::parse($vehiclebooking->to)->toFormattedDateString()}}   |
    | 8             | Pick Up              | {{$vehiclebooking->location}} |
    | 9             | Drop Off             | {{$vehiclebooking->destination}} |
    | 10            | Number of People     | {{$vehiclebooking->no_of_passengers}} |
@endcomponent

@component('mail::button', ['url' => route('vehicle.booking',$vehicle->id)])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
