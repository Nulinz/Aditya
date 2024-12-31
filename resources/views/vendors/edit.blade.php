@extends('layouts.app')
@section('content')

<div class="sidebodydiv">
    <div class="sidebodyback mb-3" onclick="goBack()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Edit Vendor</h6>
        </div>
    </div>
    <form action="{{route('vendors.update',['id'=>$vendor->id])}}" method="POST" >
        @csrf
        <div class="sidebodyhead my-3">
            <h4 class="m-0">Vendor Details</h4>
        </div>

        <div class="container-fluid maindiv bg-white">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="vendorcode">Project <span>*</span></label>
                    <select class="form-select select2input" name="pro_id" id="project_name"
                        required autofocus>
                        <option value="" selected disabled>Select Values</option>
                        @foreach ($project as $projects)
                        <option value="{{ $projects->id }}" 
                            {{ $projects->id == $vendor->pro_id ? 'selected' : '' }}>
                            {{ $projects->pro_title }}
                        </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Type <span>*</span></label>
                    <select class="form-select" name="type" id="type" required autofocus>
                        <option value="vendor" {{ old('type', $vendor->type ?? '') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="contractor" {{ old('type', $vendor->type ?? '') == 'contractor' ? 'selected' : '' }}>Contractor</option>
                    </select>
                    
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="ven_date" id="date"
                        pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31" required value="{{$vendor->ven_date}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="vendorcode">Vendor Code <span>*</span></label>
                    <input type="text" class="form-control" name="v_code" id="vendorcode"
                        placeholder="Enter Vendor Code" required value="{{$vendor->v_code}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="vendorname">Vendor Name <span>*</span></label>
                    <input type="text" class="form-control" name="v_name" id="vendorname"
                        placeholder="Enter Vendor Name" required value="{{$vendor->v_name}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="address">Address</label>
                    <textarea class="form-control" rows="1" name="address" id="address"
                        placeholder="Enter Address">{{$vendor->address}}</textarea>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="gst">GST</label>
                    <input type="text" class="form-control" name="gst" id="gst"
                        placeholder="Enter GST" value="{{$vendor->gst}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="pan">Pan Card No <span>*</span></label>
                    <input type="text" class="form-control" name="pan" id="pan"
                        placeholder="Enter Pan Card No" required value="{{$vendor->pan}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="aadhar">Aadhar Card No <span>*</span></label>
                    <input type="number" class="form-control" name="aadhar" id="aadhar"
                        oninput="validate_aadhar(this)" min="000000000000"
                        max="999999999999" placeholder="Enter Aadhar Card No" required value="{{$vendor->aadhar}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="bankname">Bank Name <span>*</span></label>
                    <input type="text" class="form-control" name="bank" id="bankname"
                        placeholder="Enter Bank Name" required value="{{$vendor->bank}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="acctholder">Account Holder <span>*</span></label>
                    <input type="text" class="form-control" name="ac_name"
                        id="acctholder" placeholder="Enter Account Holder" required value="{{$vendor->ac_name}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="bankacno">Bank A/C No <span>*</span></label>
                    <input type="text" class="form-control" name="ac_no" id="bankacno"
                        placeholder="Enter Bank A/C No" required value="{{$vendor->ac_no}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="ifsccode">IFSC Code <span>*</span></label>
                    <input type="text" class="form-control" name="ifsc" id="ifsccode"
                        placeholder="Enter IFSC Code" required value="{{$vendor->ifsc}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="branch">Branch <span>*</span></label>
                    <input type="text" class="form-control" name="branch" id="branch"
                        placeholder="Enter Branch" required value="{{$vendor->branch}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="mobile">Mobile Number <span>*</span></label>
                    <input type="number" class="form-control" name="mob" id="mobile"
                        oninput="validate(this)" min="0000000000" max="9999999999"
                        placeholder="Enter Mobile Number" required value="{{$vendor->mob}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="email">Email ID <span>*</span></label>
                    <input type="email" class="form-control" name="mail" id="email"
                        placeholder="Enter Email ID" required value="{{$vendor->mail}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="trade">Trade <span>*</span></label>
                    <input type="text" class="form-control" name="trade" id="trade"
                        placeholder="Enter Trade" required value="{{$vendor->trade}}">
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
            <button type="submit"  class="formbtn">Update</button>
        </div>
    </form>
    
</div>

@endsection