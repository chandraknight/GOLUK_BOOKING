<header id="main-header">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a class="logo" href="{{route('welcome')}}">
                        <h4 style="color:#fff">Yatritime</h4> <!--<img src="{{URL::asset('/img/logo-invert.png')}}" alt="Image Alternative text" title="Image Title">-->
                    </a>
                </div>
                <div class="col-md-3 col-md-offset-2">

                </div>
                <div class="col-md-4">
                    <div class="top-user-area clearfix">
                        <ul class="top-user-area-list list list-horizontal list-border">
                            @if(Auth::guest())
                                <li><a href="{{ route('login') }}">{{ __('Login') }}/{{ __('Register') }}</a></li>
                            @endif
                            @if(Auth::user())
                                <li class="top-user-area-avatar">
                                    <a href="{{route('profile',Auth::user()->id)}}">
                                        <img class="origin round" src="{{URL::asset('/img/amaze_40x40.jpg')}}" alt="Image Alternative text" title="AMaze">{{ Auth::user()->name }}</a>
                                </li>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="nav">
            <ul class="slimmenu" id="slimmenu">
                <li class="{{Request::is('/') ? 'active' : ''}}"><a href="{{route('welcome')}}">Home</a>
                </li>
                <li class="{{Request::is('hotels') ? 'active' : ''}}"><a href="{{route('hotel.list')}}">Hotels</a>
                </li>
                <li class="{{Request::is('vehicle/list') ? 'active' : ''}}"><a href="{{route('vehicle.list')}}">Vehicles</a>
                </li>
                <li class="{{Request::is('tours') ? 'active' : ''}}"><a href="{{route('listtour')}}">Tours</a>
                </li>


                @role('hotelowner','tourowner','vehicleowner')
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Bookings {{ Auth::user()->unreadnotifications->count() }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @forelse( Auth::user()->unreadnotifications as $notification)
                            <div class="well well-sm dropdown-item">
                                @if($notification->type == 'App\Notifications\RoomBooked')
                                    <a href="{{route('view.booking',$notification->data['booking_id'])}}">{{$notification->data['data']}}</a>
                                @endif

                                @if($notification->type == 'App\Notifications\TourBookedNotification')
                                    <a href="{{route('tour.book.details',$notification->data['booking_id'])}}">{{$notification->data['data']}}</a>
                                @endif

                                @if($notification->type == 'App\Notifications\VehicleBooked')
                                    <a href="{{route('viewvehicleinvoice',$notification->data['booking_id'])}}">{{$notification->data['data']}}</a>
                                @endif

                                <a href="{{route('notify.read',$notification->id)}}">Mark as read</a></div>
                        @empty
                            No new bookings yet.
                        @endforelse
                    </div>
                </li>
                @endrole

                @role('hotelowner','tourowner','vehicleowner')
                <li><a href="{{route('profile',Auth::user()->id)}}">Dashboard</a>
                </li>

                @endrole

                @role('superadmin')
                <li><a href="{{route('roles')}}">SuperAdmin</a></li>
                @endrole

                @role('admin')
                <li><a href="{{route('admin.index')}}">Admin</a> </li>
                @endrole
            </ul>
        </div>
    </div>
</header>