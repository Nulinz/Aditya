<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aditya ERP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

     <!-- Stylesheet -->
     <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">
     <link rel="stylesheet" href="{{asset('assets/css/list.css')}}">

     <!-- Favicon -->
 <link rel="icon" href="{{asset('assets/images/favicon.png')}}" sizes="32*32" type="image/png">

 <!-- Bootstrap CDN -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

 <!-- Font / Icons -->
 <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link
     href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
     rel="stylesheet">

 <!-- jQuery UI -->
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

 <!-- AOS -->
 <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

 <!-- Datatables -->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

 <!-- Select2 -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

 <!-- Stylesheets -->
 <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/navbar.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/aside.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/buttons.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/colors.css')}}">
 <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/register.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        .inpflex {
            width: 100%;
            border: 1px solid #eee;
            border-radius: 0.375rem;
        }

        .inpflex input {
            width: 89%;
            border-right: 1px solid #000 !important;
            border-radius: 0.375rem 0px 0px 0.375rem;
        }

        .inpflex i {
            width: 11%;
            text-align: center;
        }
    </style>

</head>

<body>

    <div class="container" id="container">

        <!-- Sign Up Div -->
        {{-- <div class="form-container sign-up">
            <form action="{{route('register.submit')}}" method="POST">
                @csrf
                <h1>Registration</h1>
                <div class="col-12 mb-2">
                    <input type="text" name="cmpname" id="cmpname" placeholder="Enter Company Name">
                    @error('cmpname')
                      <h6 class="errormsg">{{ $message }}</h6>
                    @enderror
                </div>
                <div class="col-12 mb-2">
                    <input type="text" name="name" id="name" placeholder="Enter Name">
                    @error('name')
                        <h6 class="errormsg">{{ $message }}</h6>
                    @enderror
                </div>
                <div class="col-12 mb-2">
                    <input type="email" name="email" id="email" placeholder="Enter Email ID">
                    @error('email')
                        <h6 class="errormsg">{{ $message }}</h6>
                    @enderror
                </div>
                <div class="col-12 mb-2">
                    <input type="number" name="contactno" id="regcontactno" placeholder="Enter Contact Number"
                        oninput="validate(this)" min="0000000000" max="9999999999">
                        @error('contactno')
                            <h6 class="errormsg">{{ $message }}</h6>
                        @enderror
                </div>
                <div class="col-12 mb-2">
                    <div class="d-flex justify-content-between align-items-center inpflex">
                        <input type="password" class="form-control m-0" name="password" id="regpassword"
                            placeholder="Enter Password">
                        <i class="fa-solid fa-eye-slash" id="reghide"
                            onclick="togglePasswordVisibility('regpassword', 'regshow', 'reghide')"
                            style="display:none; cursor:pointer;"></i>
                        <i class="fa-solid fa-eye" id="regshow"
                            onclick="togglePasswordVisibility('regpassword', 'regshow', 'reghide')"
                            style="cursor:pointer;"></i>
                    </div>
                </div>
                @error('contactno')
                    <h6 class="errormsg">{{ $message }}</h6>
                @enderror
                <button type="submit">Register</button>
            </form>
        </div> --}}

        <!-- Sign In Div -->
        <div class="form-container sign-in">
            <form id="from_datas" action="{{route('login.submit')}}" method="POST">
                @csrf
                <h1>Sign In</h1>
                <div class="col-12 mb-2">
                    <input type="number" name="contactno" id="logincontactno" placeholder="Enter Contact Number"
                        oninput="validate(this)" min="0000000000" max="9999999999">
                        @error('contactno')
                            <h6 class="errormsg">{{ $message }}</h6>
                        @enderror
                </div>
                <div class="col-12 mb-2">
                    <div class="d-flex justify-content-between align-items-center inpflex">
                        <input type="password" class="form-control m-0" name="password" id="loginpassword"
                            placeholder="Enter Password">
                        <i class="fa-solid fa-eye-slash" id="loginhide"
                            onclick="togglePasswordVisibility('loginpassword', 'loginshow', 'loginhide')"
                            style="display:none; cursor:pointer;"></i>
                        <i class="fa-solid fa-eye" id="loginshow"
                            onclick="togglePasswordVisibility('loginpassword', 'loginshow', 'loginhide')"
                            style="cursor:pointer;"></i>

                    </div>

                </div>
                @error('password')
                       <h6 class="errormsg">{{ $message }}</h6>
                    @enderror
                <div class="col-12 d-flex justify-content-end align-items-center">
                    <a href="#">Forget Password ?</a>
                </div>
                <button type="submit">Log In</button>
            </form>
        </div>

        <!-- Toggle Container Left / Right -->
        <div class="toggle-container">
            <div class="toggle">
                {{-- <div class="toggle-panel toggle-left">
                    <h1>Welcome To <br>Aditya Infrastructure</h1>
                    <button class="hidden" id="login">Log In</button>
                </div> --}}
                <div class="toggle-panel toggle-right">
                    <h1>Welcome To <br>Aditya Infrastructure</h1>
                    {{-- <button class="hidden" id="register">Registeration</button> --}}
                </div>
            </div>
        </div>

    </div>


<style>
    .swal2-toast .swal2-title.toast-title {
        color: black !important; /* Ensures the text is black */
    }
</style>

{{-- Script CDN --}}
<!-- Script -->
<script src="{{asset('assets/js/script1.js')}}"></script>
<script src="{{asset('assets/js/script2.js')}}"></script>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

{{-- Sweet Alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

<script>
    function togglePasswordVisibility(inputId, showId, hideId) {
        let $input = $('#' + inputId);
        let $passShow = $('#' + showId);
        let $passHide = $('#' + hideId);

        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $passShow.hide();
            $passHide.show();
        } else {
            $input.attr('type', 'password');
            $passShow.show();
            $passHide.hide();
        }
    }
</script>

<script>
    function validate(input) {
        const value = input.value;

        if (value.length > 10) {
            input.value = value.slice(0, 10);
        }
    }
</script>

<script>
    const container = document.getElementById("container");
    const registerBtn = document.getElementById("register");
    const loginBtn = document.getElementById("login");

    registerBtn.addEventListener("click", () => {
        container.classList.add("active");
    })

    loginBtn.addEventListener("click", () => {
        container.classList.remove("active");
    })
</script>

<script>
    @if(Session::has('status'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            },
            customClass: {
                title: 'toast-title'
            }
        });

        Toast.fire({
            icon: "{{ Session::get('status') }}",
            title: "{{ Session::get('message') }}"
        });
    @endif
</script>

</html>
