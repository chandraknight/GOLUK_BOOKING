<div class="col-md-3">
    <aside class="user-profile-sidebar">
        <div class="user-profile-avatar text-center">
            <img src="{{URL::asset('img\amaze_300x300.jpg')}}" alt="Image Alternative text" title="AMaze">
            <h5>{{$user->name}}</h5>
            <p>Member Since {{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}</p>
        </div>
        <ul class="list user-profile-nav">
            <li><a href="{{route('profile',$user->id)}}"><i class="fa fa-user"></i>Overview</a>
                <li><a href="#"><i class="fa fa-credit-card"></i>Payment History</a>
            </li>
            </li>
            <li><a href="{{route('usersetting',$user->id)}}"><i class="fa fa-cog"></i>Settings</a>
            </li>
        	<li><a href="{{route('userbookinghistory',$user->id)}}"><i class="fa fa-clock-o"></i>Booking History</a>
        	</li>
            
            @role('hotelowner')
            <li><a href="{{route('hotel.index')}}"><i class="fa fa-credit-card"></i>My Hotels</a>
            </li>
            @endrole
            @role('vehicleowner')
            <li><a href="{{route('vehicle.index')}}"><i class="fa fa-credit-card"></i>My Vehicles</a>
            </li>
            @endrole
            @role('tourowner')
            <li><a href="{{route('indexpackage')}}"><i class="fa fa-credit-card"></i>My Tours</a>
            </li>
            @endrole
            @role('agent')
            <li><a href="{{route('commissions',$user->id)}}"><i class="fa fa-credit-card"></i>Commissions</a>
            </li>
            @endrole
        </ul>
    </aside>
</div>