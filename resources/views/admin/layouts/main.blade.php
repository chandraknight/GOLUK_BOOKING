@include('admin.partials.header')

<body>
  <div class="container-scroller">
@include('admin.partials.nav')
@include('admin.partials.messages')
 <div class="container-fluid page-body-wrapper">
    @include('admin.partials.sidebar')
    
        @yield('content')
   </div>
        </div> 

@include('admin.partials.footer')