@component('mail::message')
# New Booking

Your Tour Activity has new Booking.

@component('mail::table')
    | S.No          | Title                | Details  |
    | ------------- |:--------------------:| --------:|
    | 1             | Activity Code        | {{$tour->code}}     |
    | 2             | Name                 | {{$booking->customer_name}}      |
    | 3             | Email                | {{$booking->customer_email}}      |
    | 4             | Contact              | {{$booking->customer_contact}}      |
    | 5             | Address              | {{$booking->customer_address}}      |
    | 6             | Booking From         | {{\Carbon\Carbon::parse($booking->starting_from)->toFormattedDateString()}} |
    | 7             | Booking Till         | {{\Carbon\Carbon::parse($booking->till_date)->toFormattedDateString()}}   |
    | 8             | Number of People     | {{$booking->no_of_people}} |
@endcomponent

@component('mail::button', ['url' => route('tour.book.details',[$booking->id])])
view
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
