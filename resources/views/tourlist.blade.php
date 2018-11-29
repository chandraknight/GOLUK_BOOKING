@extends('layouts.app')
@section('content')
     <div class="container">
            <h1 class="page-title">Search for Activities</h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        <form method="get" action="{{route('toursearch')}}">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Where</label>
                                <input class="form-control" placeholder="City" type="text" name="activitydestination" value="{{old('activitydestination')}}">
                                @if($errors->has('activitydestination'))
                                    <span style="color:red">{{$errors->first('activitydestination')}}</span>
                                @endif
                            </div>
                            <div class="input-daterange" data-date-format="MM d, D">
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check in</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="activityfrom"  type="text" value="{{old('activityfrom')}}">
                                    @if($errors->has('activityfrom'))
                                        <span style="color:red">{{$errors->first('activityfrom')}}</span>
                                    @endif
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check Out</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="activitytill"  type="text" value="{{old('activitytill')}}">
                                    @if($errors->has('activitytill'))
                                        <span style="color:red">{{$errors->first('activitytill')}}</span>
                                    @endif
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-male input-icon input-icon-hightlight"></i>
                                    <label>People</label>
                                    <input class="form-control" name="activitypeople" type="text" value="{{old('activitypeople')}}">
                                    @if($errors->has('activitypeople'))
                                        <span style="color:red">{{$errors->first('activitypeople')}}</span>
                                    @endif
                                </div>
                            </div>
                            <input class="btn btn-primary mt10" type="submit" value="Search for Activities">
                        </form>
                    </aside>
                </div>
                <div class="col-md-9">
                    <h3 class="mb20">Activities in Popular Destinations</h3>
                    
                    <div class="gap"></div>
                   @foreach($tours->chunk(3) as $t)
                    <div class="row row-wrap">
                        @forelse($t as $tour)
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img curved" href="{{route('tour.show',$tour->id)}}">
                                        <img src="{{url('/')}}/storage/tourpackage/{{$tour['image']}}" alt="{{$tour->name}}" title="{{$tour->name}}"  height="160px">
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    
                                    <h5 class="thumb-title"><a class="text-darken" href="#">{{$tour->name}}</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i>{{$tour->location}}</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">Rs {{$tour->price}}</span><small> /person</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Tours available
                        @endforelse
                    </div>
                    @endforeach
                    <div class="gap gap-small"></div>
                </div>
            </div>
        </div>
        
@endsection