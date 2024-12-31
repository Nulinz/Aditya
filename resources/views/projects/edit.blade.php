@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit Project Form</h6>
            </div>
        </div>
        <form action="{{route('projects.update',['id'=>$project->id])}}" method="post">
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">Project Details</h4>
            </div>
           
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="prjtcode">Project Code <span>*</span></label>
                        <input type="text" class="form-control" name="pro_code" id="prjtcode"
                            placeholder="Enter Project Code" required autofocus value="{{$project->pro_code}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="prjttitle">Project Title <span>*</span></label>
                        <input type="text" class="form-control" name="pro_title" id="prjttitle"
                            placeholder="Enter Project Title" required value="{{$project->pro_title}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="buildtype">Building Type <span>*</span></label>
                        <input type="text" class="form-control" name="bul_type" id="buildtype"
                            placeholder="Enter Building Type" required value="{{$project->bul_type}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="totalconstarea">Total Construction Area <span>*</span></label>
                        <div class="inpflex">
                            <input type="number" class="form-control border-0" name="tlt_area"
                                id="totalconstarea" min="0" placeholder="Enter Total Construction Area"
                                required value="{{$project->tlt_area}}">
                            <button type="button" class="m-0 text-center">Sq.ft</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="prjtcost">Project Cost <span>*</span></label>
                        <input type="number" class="form-control" name="pro_cost" id="prjtcost" min="0"
                            placeholder="Enter Project Cost" required value="{{$project->pro_cost}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="remarks">Remarks</label>
                        <textarea rows="1" class="form-control" name="remarks" id="remarks"
                            placeholder="Enter Remarks">{{$project->remarks}}</textarea>
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
                            placeholder="Enter Address Line 1" required value="{{$project->ad1}}" >
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="address2">Address Line 2</label>
                        <input type="text" class="form-control" name="ad2" id="address2"
                            placeholder="Enter Address Line 2" value="{{$project->ad2}}" >
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="city">City <span>*</span></label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="Enter City"
                            required value="{{$project->city}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="district">District <span>*</span></label>
                        <input type="text" class="form-control" name="district" id="district"
                            placeholder="Enter District" required value="{{$project->district}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="state">State <span>*</span></label>
                        <input type="text" class="form-control" name="state" id="state"
                            placeholder="Enter State" required value="{{$project->state}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="pincode">Pincode <span>*</span></label>
                        <input type="number" class="form-control" name="pin" id="pincode"
                            oninput="validate_pin(this)" min="000000" max="999999" placeholder="Enter Pincode"
                            required value="{{$project->pin}}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
                <button type="submit" name="edit_project" id="sub" class="formbtn">Update</button>
            </div>
        </form>
    </div>
@endsection