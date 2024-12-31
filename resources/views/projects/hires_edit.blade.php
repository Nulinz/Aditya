
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit BOQ Form</h6>
            </div>
        </div>
        <form action="{{route('hire.update',['id'=>$hires->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">BOQ Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="date">Date <span>*</span></label>
                        <input type="date" class="form-control" name="hire_date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                           required value="{{$hires->hire_date}}">
                    </div>
                   
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqcode">BOQ Code <span>*</span></label>
                        <select class="form-select select2input" name="code" id="boq_act_code" required onchange="updateDescription()">
                            <option value="" selected disabled>Select Options</option>
                            @foreach ($boq as $boqs)
                                <option value="{{ $boqs->id }}" data-des="{{ $boqs->des }}" {{ $boqs->id == $hires->code ? 'selected' : '' }}>{{ $boqs->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="desp">Description</label>
                        <textarea class="form-control" rows="1" name="des" id="desp"
                            placeholder="Enter Description" readonly>{{$hires->des}}</textarea>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="billno">Bill No <span>*</span></label>
                        <input type="text" class="form-control" name="bill" id="billno"
                            placeholder="Enter Bill No" required value="{{$hires->bill}}">
                    </div>
                  
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="contractorname">Contractor Name <span>*</span></label>
                        <select class="form-select select2input" name="con_name" id="contractorname" required>
                            <option value="" selected true>Select Options</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ $vendor->id == $hires->con_name ? 'selected' : '' }}>{{ $vendor->v_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                     <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="assetcode">Asset Code<span>*</span></label>
                        <select class="form-select select2input assetcode" name="a_code" id="assetcode" required onchange="updateDes()">
                            <option value="" selected disabled>Select Options</option>
                            @foreach ($assets as $asset)
                                <option value="{{ $asset->id }}" data-assetdes="{{ $asset->des }}" {{ $asset->id == $hires->a_code ? 'selected' : '' }}>{{ $asset->asset_code}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="assettype">Asset Description<span>*</span></label>
                        <input type="text" class="form-control" name="type" id="asset"
                            placeholder="Enter Type Of Asset" required readonly  value="{{$hires->type}}">
                    </div>
                   
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="unit">Unit <span>*</span></label>

                        <select class="form-select" name="unit" required>
                            <option value="" selected true>Select Options</option>
                            @foreach ($unit as $units)
                            <option value="{{$units->id}}" {{ $units->id == $hires->unit ? 'selected' : '' }}>{{$units->unit}}</option>
                         @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="qty">Quantity <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               name="qty" 
                               id="qty" 
                               min="0" 
                               placeholder="Enter Quantity" 
                               oninput="calculateTotals()" 
                               required value="{{$hires->qty}}">
                    </div>
                    
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="rate">Rate <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               name="u_rate" 
                               id="rate" 
                               min="0" 
                               placeholder="Enter Rate" 
                               oninput="calculateTotals()" 
                               required value="{{$hires->u_rate}}">
                    </div>
                    
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="amt">Amount</label>
                        <input type="number" 
                               class="form-control" 
                               name="amount" 
                               id="amt" 
                               placeholder="Enter Amount" 
                               readonly value="{{$hires->amount}}">
                    </div>
                    
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="gst">GST (%) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               name="gst" 
                               id="gst" 
                               placeholder="Enter GST" 
                               oninput="calculateTotals()" 
                               required value="{{$hires->gst}}">
                    </div>
                    
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="gross">Gross</label>
                        <input type="number" 
                               class="form-control" 
                               name="gross" 
                               id="gross" 
                               placeholder="Enter Gross" 
                               readonly value="{{$hires->gross}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="1" name="remark" id="remarks"
                            placeholder="Enter Remarks">{{$hires->remark}}</textarea>
                    </div>
                </div>
            </div>

           

            <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
                <button type="submit" id="sub" class="formbtn">Update</button>
            </div>
        </form>
       
    </div>
   
    <script>
        function calculateTotals() {
            const qty = parseFloat(document.getElementById('qty').value) || 0;
            const rate = parseFloat(document.getElementById('rate').value) || 0;
            const gst = parseFloat(document.getElementById('gst').value) || 0;
    
            const amount = qty * rate;
            document.getElementById('amt').value = amount.toFixed(2);
    
            const gross = amount + (amount * gst / 100);
            document.getElementById('gross').value = gross.toFixed(2);
        }
    </script>
    <script>
        function updateDescription() {
        const boqCodeSelect = document.getElementById('boq_act_code');
        const selectedOption = boqCodeSelect.options[boqCodeSelect.selectedIndex];
       
    
        const des = selectedOption.getAttribute('data-des');
        document.getElementById('desp').value = des || '';
    }
    
    
    
    </script>
    
    <script>
        function updateDes() {
        const assetCodeSelect = document.getElementById('assetcode');
        const selectedOption = assetCodeSelect.options[assetCodeSelect.selectedIndex];
       
    
        const asset_des = selectedOption.getAttribute('data-assetdes');
    
        document.getElementById('asset').value = asset_des || '';
    }
    </script>

@endsection