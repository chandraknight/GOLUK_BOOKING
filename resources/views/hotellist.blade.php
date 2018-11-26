@extends('layouts.app')
@section('content')
   <div class="container">
            <h1 class="page-title">Popular Hotels</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        <form  method="get" action="{{route('hotelsearch.index')}}">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Where</label>
                                <input class="form-control" placeholder="City, Hotel Name" type="text" name="hoteldestination" required>
                                @if($errors->has('hoteldestination'))
                                    <span style="color:red">{{$errors->first('hoteldestination')}}</span>
                                @endif
                            </div>
                            <div class="input-daterange" data-date-format="MM d, D">
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check in</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="hotelfrom_date" type="text" required>
                                    @if($errors->has('hotelfrom_date'))
                                        <span style="color:red">{{$errors->first('hotelfrom_date')}}</span>
                                    @endif
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check out</label>
                                    <input class="form-control date-pick" data-date-format="yyyy-mm-dd" name="hoteltill_date" type="text" required>
                                    @if($errors->has('hoteltill_date'))
                                        <span style="color:red">{{$errors->first('hoteltill_date')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group form-group- form-group-select-plus">
                                <label>Guests</label>
                                
                                <select class="form-control" name="hotelno_adults" required>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                </select>
                                @if($errors->has('hotelno_adults'))
                                    <span style="color:red">{{$errors->first('hotelno_adults')}}</span>
                                @endif
                            </div>
                            <div class="form-group form-group-select-plus">
                                <label>Children</label>
                               
                                <select class="form-control" name="hotelno_childs">
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                </select>
                                @if($errors->has('hotelno_childs'))
                                    <span style="color:red">{{$errors->first('hotelno_childs')}}</span>
                                @endif
                            </div>
                            <input class="btn btn-primary mt10" type="submit" value="Search for Hotels">
                        </form>
                    </aside>
                </div>
                <div class="col-md-9">
                    @foreach($hotels->chunk(3) as $h)
                    <div class="row row-wrap">
                        @foreach($h as $hotel)
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img curved" href="{{route('hotel.show',$hotel->id)}}">
                                        <img src="{{url('/')}}/storage/hotel_logo/{{$hotel['logo']}}" alt="{{$hotel->name}}" title="{{$hotel->name}}"  height="160px">
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                   
                                    <h5 class="thumb-title"><a class="text-darken" href="#">{{$hotel->name}}</a></h5>
                                    <p class="mb0"><small>{{$hotel->address}}</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">Rs {{collect($hotel->rooms)->min('room_flat_cost')}}</span><small> /night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    <div class="gap"></div>
                    
                </div>
            </div>
        </div>
        <div class="gap"></div>
@endsection