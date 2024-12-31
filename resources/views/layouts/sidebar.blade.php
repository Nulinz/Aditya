{{-- Web View Sidebar --}}
<aside>
    <div class="flex-shrink-0 sidebar">
        <div class="nav col-md-11">
            <a href="./index.php" class="mx-auto"><img src="{{asset('assets/images/logo.png')}}" alt="" height="50px" class="mx-auto"></a>
        </div>
        <!-- Responsive navigation -->
        <ul class="list-unstyled mt-5 ps-0">
            <!-- Dashboard -->
            <li class="mb-1">
                <a href="{{route('dashboard')}}">
                    <button class="btn0 bn1 mx-auto btn-toggle collapsed {{ Request::routeIs('dashboard') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false">
                        <div class="btnname">
                            <i class="bx bxs-dashboard"></i> &nbsp;Dashboard
                        </div>
                    </button>
                </a>
            </li>

            <!-- Projects -->
            <li class="mb-1">
                <button class="btn0 bn2 mx-auto btn-toggle collapsed  {{ Request::routeIs('projects.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false">
                    <div class="btnname">
                        <i class="fa-solid fa-city"></i>
                        &nbsp;Projects
                    </div>
                    <div class="righticon">
                        <i class="fa-solid fa-angle-down toggle-icon"></i>
                    </div>
                </button>
                <div class="collapse" id="collapse2">
                    <ul class="btn-toggle-nav list-unstyled text-center px-0 pb-3">
                        <li><a href="{{route('projects.index')}}" class="d-inline-flex text-decoration-none rounded mt-3">Project List</a></li>
                    </ul>
                </div>
            </li>

            @if (Auth::user()->emp_desg == 'Admin')

                <li class="mb-1">
                    <button class="btn0 bn3 mx-auto btn-toggle collapsed {{ Request::routeIs('employee.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-user-group"></i> &nbsp;Employee
                        </div>
                        <div class="righticon">
                            <i class="fa-solid fa-angle-down toggle-icon"></i>
                        </div>
                    </button>
                    <div class="collapse" id="collapse3">
                        <ul class="btn-toggle-nav list-unstyled text-center px-0 pb-3">
                            <li><a href="{{route('employee.index')}}" class="d-inline-flex text-decoration-none rounded mt-3">Employee List</a></li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (Auth::user()->emp_desg == 'Admin')

                <!-- Designation -->
                <li class="mb-1">
                    <button class="btn0 bn4 mx-auto btn-toggle collapsed {{ Request::routeIs('desgination.index','desgination.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-briefcase"></i> &nbsp;Designation
                        </div>
                        <div class="righticon">
                            <i class="fa-solid fa-angle-down toggle-icon"></i>
                        </div>
                    </button>
                    <div class="collapse" id="collapse4">
                        <ul class="btn-toggle-nav list-unstyled text-center px-0 pb-3">
                            <li><a href="{{route('desgination.index')}}" class="d-inline-flex text-decoration-none rounded mt-3">Designation List</a></li>
                        </ul>
                    </div>
                </li>
            @endif
            <!-- Vendor Master -->
            <li class="mb-1">
                <a href="{{route('vendors.index')}}">
                    <button class="btn0 bn5 mx-auto btn-toggle collapsed {{ Request::routeIs('vendors.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-people-carry-box"></i> &nbsp;Vendor Master
                        </div>
                    </button>
                </a>
            </li>

            <!-- Material Master -->
            <li class="mb-1">
                <a href="{{route('material.index')}}">
                    <button class="btn0 bn6 mx-auto btn-toggle collapsed {{ Request::routeIs('material.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-magnifying-glass-chart"></i> &nbsp;Material Master
                        </div>
                    </button>
                </a>
            </li>

            <!-- Overhead Master -->
            <li class="mb-1">
                <a href="{{route('overhead.index')}}">
                    <button class="btn0 bn7 mx-auto btn-toggle collapsed {{ Request::routeIs('overhead.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-cable-car"></i> &nbsp;Overhead Master
                        </div>
                    </button>
                </a>
            </li>

            <!-- Asset Code -->
            <li class="mb-1">
                <a href="{{route('asset_code.index')}}">
                    <button class="btn0 bn8 mx-auto btn-toggle collapsed {{ Request::routeIs('asset_code.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-barcode"></i> &nbsp;Asset Code
                        </div>
                    </button>
                </a>
            </li>

            <!-- Sub Division Code -->
            <li class="mb-1">
                <a href="{{route('division.index')}}">
                    <button class="btn0 bn9 mx-auto btn-toggle collapsed {{ Request::routeIs('division.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-qrcode"></i> &nbsp;Sub Division Code
                        </div>
                    </button>
                </a>
            </li>

            <!-- Unit -->
            <li class="mb-1">
                <a href="{{route('unit.index')}}">
                    <button class="btn0 bn11 mx-auto btn-toggle collapsed {{ Request::routeIs('unit.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-weight-scale"></i> &nbsp;Unit
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{route('unit.index')}}">
                    <button class="btn0 bn11 mx-auto btn-toggle collapsed {{ Request::routeIs('unit.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-warehouse"></i> &nbsp;WareHouse Master
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{route('unit.index')}}">
                    <button class="btn0 bn11 mx-auto btn-toggle collapsed {{ Request::routeIs('unit.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-shopping-cart"></i> &nbsp;Purchase
                        </div>
                    </button>
                </a>
            </li>
        </ul>

        <!-- Logout -->
        <ul class="list-unstyled lgt">
            <li class="mb-1">
                <a href="{{route('logout')}}">
                    <button class="btn0 mx-auto btn-toggle collapsed " aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-right-from-bracket" style="color: red;"></i> &nbsp;Logout
                        </div>
                    </button>
                </a>
            </li>
        </ul>
    </div>
</aside>

{{-- Responsive Sidebar --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <div class="user ps-1">
            <img src="{{asset('assets/images/avatar.png')}}" height="40px" class="rounded-5" alt="">
            <h6 class="bg-dark px-3 py-1 m-0 rounded-2">{{ Auth::user()->name }}</h6>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="flex-shrink-0 sidebar">
            <ul class="list-unstyled mt-2 ps-0">

                    <li class="mb-1">
                        <a href="{{route('dashboard')}}">
                            <button class="btn0 bn1 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapse1" aria-expanded="false">
                                <div class="btnname">
                                    <i class="bx bxs-dashboard"></i> &nbsp;Dashboard
                                </div>
                            </button>
                        </a>
                    </li>

                <li class="mb-1">
                    <button class="btn0 bn2 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapse2" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-list-check"></i> &nbsp;Projects
                        </div>
                        <div class="righticon">
                            <i class="fa-solid fa-angle-down toggle-icon"></i>
                        </div>
                    </button>
                    <div class="collapse" id="collapse2">
                        <ul class="btn-toggle-nav list-unstyled text-center px-0 pb-3">
                            <li><a href="{{route('projects.index')}}"
                                    class="d-inline-flex text-decoration-none rounded mt-3">Project
                                    List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn0 bn3 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapse3" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-user-group"></i> &nbsp;Employee
                        </div>
                        <div class="righticon">
                            <i class="fa-solid fa-angle-down toggle-icon"></i>
                        </div>
                    </button>
                    <div class="collapse" id="collapse3">
                        <ul class="btn-toggle-nav list-unstyled text-center px-0 pb-3">
                            <li><a href="{{route('employee.index')}}"
                                    class="d-inline-flex text-decoration-none rounded mt-3">Employee List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn0 bn4 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapse4" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-briefcase"></i> &nbsp;Designation
                        </div>
                        <div class="righticon">
                            <i class="fa-solid fa-angle-down toggle-icon"></i>
                        </div>
                    </button>
                    <div class="collapse" id="collapse4">
                        <ul class="btn-toggle-nav list-unstyled text-center px-0 pb-3">
                            <li><a href="{{route('desgination.index')}}"
                                    class="d-inline-flex text-decoration-none rounded mt-3">Designation List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <a href="./project_profile_ven_master.php">
                        <button class="btn0 bn5 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-people-carry-box"></i> &nbsp;Vendor Master
                            </div>
                        </button>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{route('material.index')}}">
                        <button class="btn0 bn6 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-magnifying-glass-chart"></i> &nbsp;Material Master
                            </div>
                        </button>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{route('overhead.index')}}">
                        <button class="btn0 bn7 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-cable-car"></i> &nbsp;Overhead Master
                            </div>
                        </button>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{route('asset_code.index')}}">
                        <button class="btn0 bn8 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-barcode"></i> &nbsp;Asset Code
                            </div>
                        </button>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{route('division.index')}}">
                        <button class="btn0 bn9 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-qrcode"></i> &nbsp;Sub Division Code
                            </div>
                        </button>
                    </a>
                </li>
                {{-- <li class="mb-1">
                    <a href="./list_contractor.php">
                        <button class="btn0 bn10 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-users"></i> &nbsp;Contractor
                            </div>
                        </button>
                    </a>
                </li> --}}
                <li class="mb-1">
                    <a href="{{route('unit.index')}}">
                        <button class="btn0 bn11 mx-auto btn-toggle collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-weight-scale"></i> &nbsp;Unit
                            </div>
                        </button>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{route('unit.index')}}">
                        <button class="btn0 bn11 mx-auto btn-toggle collapsed {{ Request::routeIs('unit.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-warehouse"></i> &nbsp;WareHouse Master
                            </div>
                        </button>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="{{route('unit.index')}}">
                        <button class="btn0 bn11 mx-auto btn-toggle collapsed {{ Request::routeIs('unit.index') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-shopping-cart"></i> &nbsp;Purchase
                            </div>
                        </button>
                    </a>
                </li>
            </ul>

            <ul class="list-unstyled lgt">
                <li class="mb-1">
                    <a href="{{route('logout')}}">
                        <button class="btn0 mx-auto btn-toggle collapsed" aria-expanded="false">
                            <div class="btnname">
                                <i class="fa-solid fa-right-from-bracket" style="color: red;"></i> &nbsp;Logout
                            </div>
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
