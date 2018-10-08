<div class="row row-wrap">
    @forelse($tours as $tour)
        <div class="col-md-4">
            <div class="thumb">
                <header class="thumb-header">
                    <a class="hover-img" href="{{route('tour.show',$tour->id)}}">
                        <img src="{{url('/')}}/storage/tourpackage/{{$tour['image']}}" alt="{{$tour->name}}" title="{{$tour->name}}">
                        <h5 class="hover-title-center">Book Now</h5>
                    </a>
                </header>
                <div class="thumb-caption">

                    <h5 class="thumb-title"><a class="text-darken" href="{{route('tour.show',$tour->id)}}">{{$tour->name}}</a></h5>
                    <p class="mb0"><small><i class="fa fa-map-marker"></i> {{$tour->location}}</small>
                    </p>
                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">Rs {{$tour->price}}</span>  <small> /person</small>
                    </p>
                </div>
            </div>
        </div>
    @empty
        No Tours available
    @endforelse
</div>