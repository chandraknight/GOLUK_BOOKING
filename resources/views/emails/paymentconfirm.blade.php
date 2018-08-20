@component('mail::message')
    # Payment Confirmed

    Your payment has been confirmed.

    <div class="panel panel-primary">
        <div class="panel-heading">Room Details</div>
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item">Number of Rooms: {{$booking->no_rooms}}</li>
                <li class="list-group-item">
                    @foreach($booking->bookedRoom as $booked_room_detail)
                        <ul class="list-group">
                            <li class="list-group-item">Room Number: {{$booked_room_detail->rooms->room_no}}</li>
                            <li class="list-group-item">Room Type: {{$booked_room_detail->room_type}}</li>
                            <li class="list-group-item">Plan: {{$booked_room_detail->plan}}</li>
                        </ul>
                    @endforeach
                </li>
                <li class="list-group-item">Adults: {{$booking->no_adults}}</li>
                <li class="list-group-item">Children: {{$booking->no_childs}}</li>
                <li class="list-group-item">From: {{$booking->from_date}}</li>
                <li class="list-group-item">Till: {{$booking->till_date}}</li>
            </ul>


        </div>
    </div>



    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
