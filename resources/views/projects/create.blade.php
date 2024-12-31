@extends('layouts.app')
@section('content')
    <div class="sidebodydiv">
        <div class="sidebodyback" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Add Project Form</h6>
            </div>
        </div>
        <form action="{{route('projects.save')}}" method="post" id="myForm1" >
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">Project Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="prjtcode">Project Code <span>*</span></label>
                        <input type="text" class="form-control" name="pro_code" id="prjtcode"
                            placeholder="Enter Project Code" required autofocus>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="prjttitle">Project Title <span>*</span></label>
                        <input type="text" class="form-control" name="pro_title" id="prjttitle"
                            placeholder="Enter Project Title" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="buildtype">Building Type <span>*</span></label>
                        <input type="text" class="form-control" name="bul_type" id="buildtype"
                            placeholder="Enter Building Type" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="totalconstarea">Total Construction Area <span>*</span></label>
                        <div class="inpflex">
                            <input type="number" class="form-control border-0" name="tlt_area"
                                id="totalconstarea" min="0" placeholder="Enter Total Construction Area"
                                required>
                            <button type="button" class="m-0 text-center">Sq.ft</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="prjtcost">Project Cost <span>*</span></label>
                        <input type="number" class="form-control" name="pro_cost" id="prjtcost" min="0"
                            placeholder="Enter Project Cost" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="remarks">Remarks</label>
                        <textarea rows="1" class="form-control" name="remarks" id="remarks"
                            placeholder="Enter Remarks"></textarea>
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
                        <input type="text" class="form-control" name="city" id="city" placeholder="Enter City"
                            required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="district">District <span>*</span></label>
                        <input type="text" class="form-control" name="district" id="district"
                            placeholder="Enter District" required>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="state">State <span>*</span></label>
                        <input type="text" class="form-control" name="state" id="state"
                            placeholder="Enter State" required>
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
                {{-- <input hidden type="text" name="add_project"> --}}
                <button type="submit" id="sub" class="formbtn ">Save</button>
            </div>
        </form>
    </div>
    <script>
        function goBack() {
            window.location.href = '{{route('projects.index')}}'; 
        }
    </script>

@endsection