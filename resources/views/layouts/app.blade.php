@include('partials._header')
@include('partials.messages')
    <div id="app">
        @include('partials._navigation')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
@include('partials._footer')