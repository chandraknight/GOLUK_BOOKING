<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="{{URL::asset('admin/images/faces/face1.jpg')}}" alt="profile">
                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">{{Auth::user()->name}}</span>
                <span class="text-secondary text-small">{{Auth::user()->role}}</span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.index')}}">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('roles')}}">
              <span class="menu-title">Roles</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('permissions')}}">
              <span class="menu-title">Permission</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('roleassign')}}">
              <span class="menu-title">Assign Role</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('permissionassign')}}">
              <span class="menu-title">Grant Permission</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>

           <li class="nav-item">
            <a class="nav-link" href="{{route('users')}}">
              <span class="menu-title">Users</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>
         
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.hotel')}}">
              <span class="menu-title">Hotels</span>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.vehicle')}}">
              <span class="menu-title">Vehicles</span>
              <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.tour')}}">
              <span class="menu-title">Tours</span>
              <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('vehicle.type.index')}}">
              <span class="menu-title">Vehicle Type</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('vehicle.service.index')}}">
              <span class="menu-title">Vehicle Services</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('roomtype.index')}}">
              <span class="menu-title">Hotel Room Types</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.agent.list')}}">
              <span class="menu-title">Agents</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
              <span class="menu-title">Bookings</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-medical-bag menu-icon"></i>
            </a>
            <div class="collapse" id="general-pages">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.hotel.booking')}}"> Hotel Bookings </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.vehicle.booking')}}"> Vehicle Bookings </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.tour.booking')}}"> Tour Bookings </a></li>
              </ul>
              </div>
          </li>
          
         
        </ul>
      </nav>