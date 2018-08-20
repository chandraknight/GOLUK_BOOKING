@include('superadmin.partials.header')

<body>
  <div class="container-scroller">
@include('superadmin.partials.navbar')
@include('superadmin.partials.messages')
 <div class="container-fluid page-body-wrapper">
    @include('superadmin.partials.sidebar')
    
        @yield('content')
   </div>
        </div> 

@include('superadmin.partials.footer')