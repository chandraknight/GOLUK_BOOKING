<div class="row row-wrap">
@forelse($vehicles as $vehicle)
    <div class="col-md-4">
        <div class="thumb">
            <header class="thumb-header">
                <a href="{{route('vehicle.show',$vehicle->id)}}">
                    <img src="{{url('/')}}/storage/vehicle/{{$vehicle->image}}" alt="Image Alternative text" title="{{$vehicle->name}}">
                </a>
            </header>
            <div class="thumb-caption">
                <h5 class="thumb-title"><a class="text-darken" href="{{route('vehicle.show',$vehicle->id)}}">{{$vehicle->name}}</a></h5><small>{{$vehicle->types->type_name}}</small>
                <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$vehicle->no_of_people}}</span>
                    </li>

                    <li rel="tooltip" data-placement="top" title="Fuel Type"><i class="im im-electric"></i><span class="booking-item-feature-sign">{{$vehicle->fuel}}</span>
                    </li>

                    <li rel="tooltip" data-placement="top" title="Drive Train - {{$vehicle->drive_train}}" ><i class="im im-car-wheel " ></i><span class="booking-item-feature-sign">{{$vehicle->drive_train}}</span>
                    </li>

                    <li title="" data-original-title="Car with Driver" data-placement="top" rel="tooltip" ><i class="im im-driver"></i> <span class="booking-item-feature-sign">Yes</span>
                    </li>

                    <li title="" data-original-title="Satellite Navigation - {{ucfirst($vehicle->gps)}}" data-placement="top" rel="tooltip" ><i class="im im-satellite"></i> <span class="booking-item-feature-sign">{{$vehicle->gps}}</span>
                    </li>

                    <li rel="tooltip" data-placement="top" title="Vehicle Origin location - {{ucfirst($vehicle->location)}}"><i class="fa fa-map-marker"></i><span class="booking-item-feature-sign">{{ucfirst($vehicle->location)}}</span>
                    </li>

                </ul>
                <p class="text-darken mb0 text-color">Rs {{$vehicle->rate_per_day}}<small> /day</small>
                </p>
            </div>
        </div>
    </div>
@empty
    No Vehicles Available
@endforelse
</div>