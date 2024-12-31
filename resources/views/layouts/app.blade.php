@include('layouts.header')

<div class="main">
@include('layouts.sidebar')

    <div class="side-body">
        @include('layouts.navbar')

        <div class="sidebodydiv px-5 py-1">
            @yield('content')
        </div>

    </div>

</div>

@include('layouts.footer')


