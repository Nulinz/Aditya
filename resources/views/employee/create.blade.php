
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Add Employee Form</h6>
            </div>
        </div>
        <form action="{{route('employee.save')}}" method="post" class="myForm1" >
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">Employee Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="empcode">Employee Code <span>*</span></label>
                        <input type="text" class="form-control" name="emp_code" id="empcode"
                            placeholder="Enter Employee Code" autofocus
                            required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="empname">Employee Name <span>*</span></label>
                        <input type="text" class="form-control" name="vemp_name" id="empname"
                            placeholder="Enter Employee Name" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="designation">Select Designation <span>*</span></label>
                        <select class="form-select" name="emp_desg" id="designation" required>
                            
                            <option value="Admin">Admin</option>
                            <option value="Sub Admin">Sub Admin</option>
                            <option value="Employee">Employee</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="contactno">Contact Number <span>*</span></label>
                        <input type="number" class="form-control" name="contactno" id="contactno"
                             oninput="validate(this)" min="0000000000"
                            max="9999999999" placeholder="Enter Contact Number" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="altcontactno">Alternate Contact Number</label>
                        <input type="number" class="form-control" name="alt_ph_no" id="altcontactno"
                           oninput="validate(this)" min="0000000000"
                            max="9999999999" placeholder="Enter Alternate Contact Number">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="email">Email ID</label>
                        <input type="email" class="form-control" name="emp_mail" id="email"
                             placeholder="Enter Email ID">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="password">Password <span>*</span></label>
                        <div class="inpflex">
                            <input type="password" class="form-control border-0" name="password" id="password"
                                placeholder="Enter Password" required>
                            <i class="fa-solid fa-eye text-center" id="passShow_1"
                                onclick="togglePasswordVisibility('password')" style="cursor:pointer;"></i>
                            <i class="fa-solid fa-eye-slash text-center" id="passHide_1"
                                onclick="togglePasswordVisibility('password')"
                                style="display:none; cursor:pointer;"></i>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="bloodgrp">Blood Group</label>
                        <input type="text" class="form-control" name="b_grp" id="bloodgrp"
                             placeholder="Enter Blood Group">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="salary">Salary <span>*</span></label>
                        <input type="text" class="form-control" name="salary" id="salary"
                             placeholder="Enter Salary" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="experience">Experience</label>
                        <input type="text" class="form-control" name="experience" id="experience"
                             placeholder="Enter Experience">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="joindate">Date Of Joining</label>
                        <input type="date" class="form-control" name="doj" id="joindate"
                            pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31">
                    </div>
                </div>
            </div>

            <div class="sidebodyhead my-3">
                <h4 class="m-0">Address Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="address1">Address Line 1 <span>*</span></label>
                        <input type="text" class="form-control" name="ad1" id="address1"
                             placeholder="Enter Address Line 1" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="address2">Address Line 2</label>
                        <input type="text" class="form-control" name="ad2" id="address2"
                             placeholder="Enter Address Line 2">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="city">City <span>*</span></label>
                        <input type="text" class="form-control" name="city" id="city"
                            placeholder="Enter City" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="district">District <span>*</span></label>
                        <input type="text" class="form-control" name="district" id="district"
                            placeholder="Enter District" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="state">State</label>
                        <input type="text" class="form-control" name="state" id="state"
                             placeholder="Enter State">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="pincode">Pincode <span>*</span></label>
                        <input type="number" class="form-control" name="pin" id="pincode"
                            oninput="validate_pin(this)" min="000000" max="999999" placeholder="Enter Pincode"
                            required>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
                <button type="submit" id="sub" class="formbtn">Save</button>
            </div>
        </form>
    </div>
    <script>
        function goBack() {
            window.location.href = '{{route('employee.index')}}'; 
        }
    </script>

@endsection