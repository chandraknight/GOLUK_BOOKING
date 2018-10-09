@forelse($hotels as $hotel)
    @if($hotel->rooms->count()>0)
    <li>
        <a class="booking-item" href="{{route('hotel.show',$hotel->id)}}">
            <div class="row">
                <div class="col-md-3">
                    <div class="booking-item-img-wrap">
                        <img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" alt="{{$hotel->name}}" title="{{$hotel->name}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="booking-item-title">{{$hotel->name}}</h5>
                    <p class="booking-item-address"><i class="fa fa-map-marker"></i> {{$hotel->address}}</p>
                </div>
                <p>
                <div class="col-md-3">
                    <span class="booking-item-price-from">from</span>
                    <span class="booking-item-price">Rs {{collect($hotel->rooms)->min('room_flat_cost')}}
                        <small>/night</small>
                                            </span>
                </div>
                </p>
                <p><span class="btn btn-primary">More</span></p>
            </div>
        </a>
    </li>
    @endif
@empty
    No Hotels Available
@endforelse
