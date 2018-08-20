@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">{{$hotel->name}}</h1>
                <p class="lead text-muted">{{$hotel->contact}}<span class="badge">{{$hotel->email}}</span></p>
                </p>
            </div>
        </section>
        <section>
            <form method="post" action="{{route('room.book')}}">
                {{csrf_field()}}
                @php $i = 0; @endphp
                @foreach($roomtypes as $roomtype )
                    @if($roomtype->rooms->where('hotel_id',$hotel->id)->count() > 0)
                    <div class="panel panel-primary">
                        <div class="panel-heading">{{$roomtype->name}}</div>
                        <div class="panel-body">
                            @foreach($roomtype->rooms as $room)
                            @if($room->hotel_id == $hotel->id)
                            <div class="panel panel-default">
                                <div class="panel-heading">{{$room->room_no}}</div>
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><img class="img img-responsive"
                                                                         src="{{url('/')}}/storage/rooms/{{$hotel->id}}/{{$room->image}}"></li>
                                        <li class="list-group-item">Available : {{$room->no_of_rooms}}</li>
                                        <li class="list-group-item">
                                            <div class="form-group">
                                                <label>Select number of rooms:</label>
                                                <input type="hidden" name="room[]" value="{{$room->id}}">
                                                <input type="number" min="1" size="5" max="{{$room->no_of_rooms}}" name="no_rooms[]" class="form-control">
                                                <input type="hidden" name="room_type[]" value="{{$room->room_no}}">
                                                <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            Select Plan:
                                            <label class="radio-inline">
                                                <input type="radio" name="plan[{{$i}}]" checked value="null">None (Rs: {{$room->room_flat_cost}})
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="plan[{{$i}}]"  value="ap">American Plan (Rs: {{$room->cost_ap_plan}})
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="plan[{{$i}}]" value="cp">Continental Plan (Rs: {{$room->cost_cp_plan}})
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="plan[{{$i}}]" value="ep">European Plan (Rs: {{$room->cost_ep_plan}})
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="plan[{{$i}}]" value="map">Mixed American Plan (Rs: {{$room->cost_map_plan}})
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                                @endif
                                @php $i++ ; @endphp
                                @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
                <input type="submit" class="btn btn-success" value="Book">
            </form>


        </section>

    </div>

@endsection