@extends('layouts.app')
@section('content')
    <div class="sidebodydiv ">
        <div class="sidebodyhead my-3">
            <h4 class="m-0">Settings</h4>
        </div>

        {{-- <!-- Tabs -->
        <div class="proftabs">
            <ul class="nav nav-tabs d-flex justify-content-start align-items-center gap-md-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="listbtn active" id="password-tab" role="tab" data-bs-toggle="tab" type="button"
                        data-bs-target="#password-track" aria-controls="password" aria-selected="false">Password</button>
                </li>
            </ul>
        </div> --}}

        <div class="tab-content mt-3" id="myTabContent">

            <!-- Password Tab -->
            <div class="tab-pane fade show active" id="password-track" role="tabpanel" aria-labelledby="password-tab">
                <form action="{{route('change_password.update')}}" method="post" >
                    @csrf
                    <div class="container-fluid maindiv bg-white">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 px-2 inputs">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="vemp_name" id="name"
                                    placeholder="Enter Your Name" value="{{ Auth::user()->vemp_name }}">
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 px-2 inputs">
                                <label for="email">Email ID</label>
                                <input type="email" class="form-control" name="emp_mail" id="email"
                                    placeholder="Enter Your Email ID" value="{{ Auth::user()->emp_mail }}">
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 px-2 inputs">
                                <label for="contact">Contact Number</label>
                                <input type="number" class="form-control" name="contactno" id="contact"
                                    oninput="validate(this)" min="0000000000" max="9999999999"
                                    placeholder="Enter Your Contact Number" value="{{ Auth::user()->contactno }}">
                            </div>


                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 px-2 inputs">
                                <label for="password1">New Password</label>
                                <div class="d-flex justify-content-between align-items-center inpflex">
                                    <input type="password"  id="password1" minlength="6" class="form-control border-0"
                                        placeholder="Enter New Password" required>
                                    <i class="fa-solid fa-eye-slash" id="passHide_1"
                                        onclick="togglePasswordVisibility('password1', 'passShow_1', 'passHide_1')"
                                        style="display:none; cursor:pointer;"></i>
                                    <i class="fa-solid fa-eye" id="passShow_1"
                                        onclick="togglePasswordVisibility('password1', 'passShow_1', 'passHide_1')"
                                        style="cursor:pointer;"></i>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 px-2 inputs">
                                <label for="password2">Confirm New Password</label>
                                <div class="d-flex justify-content-between align-items-center inpflex">
                                    <input type="password" name="password" id="password2" minlength="6" class="form-control border-0"
                                        placeholder="Enter Confirm New Password" required onchange="pass_same()">
                                    <i class="fa-solid fa-eye-slash" id="passHide_2"
                                        onclick="togglePasswordVisibility('password2', 'passShow_2', 'passHide_2')"
                                        style="display:none; cursor:pointer;"></i>
                                    <i class="fa-solid fa-eye" id="passShow_2"
                                        onclick="togglePasswordVisibility('password2', 'passShow_2', 'passHide_2')"
                                        style="cursor:pointer;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
                        <button type="submit" id="submitBtn" class="formbtn">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

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
    function pass_same() {
        const password1 = document.getElementById('password1').value;
        const password2 = document.getElementById('password2').value;

        if (password1 !== password2) {
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
                icon: 'error',
                title: 'Passwords do not match. Please try again.'
            });

            document.getElementById('password2').value = '';
        }
    }
</script>



@endsection
