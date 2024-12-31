<nav class="navbar px-4">
    <div class="icons login col-sm-12 col-md-12">
        <button class="border-0 m-0 p-0 responsive_button" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span id="navigation-icon" style=" font-size:25px;cursor:pointer">&#9776;</span>
        </button>
        <div class="navlogo">
            <a href="./index.php" class="mx-auto"><img src="{{asset('assets/images/logo.png')}}" alt="" height="40px" class="mx-auto"></a>
        </div>
        <div class="headimg">
            <a href="{{route('change_password.index')}}"><img src="{{asset('assets/images/setting.png')}}" height="25px" alt=""></a>
        </div>
        <div class="headimg">
            <a href=""><img src="{{asset('assets/images/bell.png')}}" height="25px" alt=""></a>
        </div>
        <div class="user">
            <img src="{{asset('assets/images/avatar.png')}}" height="40px" class="rounded-5" alt="">
            <h6 class="bg-dark px-3 py-1 m-0 rounded-2">{{ Auth::user()->vemp_name }}
        </h6>
        </div>
    </div>
</nav>
