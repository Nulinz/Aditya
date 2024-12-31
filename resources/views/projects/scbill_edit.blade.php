
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit BOQ Form</h6>
            </div>
        </div>
        <form action="{{route('sc_bill.update',['id'=>$sc_bill->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">BOQ Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="date">Date <span>*</span></label>
                        <input type="date" class="form-control" name="sc_date" id="date"
                            pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                            required>
                    </div>

                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqcode">BOQ Code <span>*</span></label>
                        <select class="form-select select2input" name="boq_code" id="boq_act_code" required>
                            <option value="" selected disabled>Select Options</option>
                            @foreach ($division  as $item)
                                <option value="{{$item->id}}">{{$item->boq_code}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqdesp">BOQ Description</label>
                        <textarea class="form-control" rows="1" name="des" id="boq_desc"
                            placeholder="Enter BOQ Description" readonly></textarea>
                    </div>

                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="subdivcode">Sub Division Code <span>*</span></label>
                        <!-- <input type="text" class="form-control" name="sub_code" id="sub_div_code"
                            list="subcodes" placeholder="Sub Div Code"
                            required> -->
                        <select class="form-select select2input" name="sub_code" id="sub_div_code" required>

                        </select>

                    </div>

                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="vendorname">Vendor Name <span>*</span></label>
                        <select class="form-select select2input" name="v_name" id="vendor_name" required>
                            <option value="" selected disabled>Select Options</option>
                            @foreach ($vendor as $vendors)
                                <option value="{{$vendors->id}}">{{$vendors->v_name}}</option>
                            @endforeach
                        </select>
                    </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="unit">Unit <span>*</span></label>
                    <select class="form-select" name="unit" required>
                        <option value="" selected>Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}">{{$unit->unit}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="qty">Quantity <span>*</span></label>
                    <input type="number" class="form-control" name="qty" id="qty" min="0"
                        placeholder="Enter Quantity" oninput="sum_gst('qty','rate','amt')" value="0" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="rate">Rate <span>*</span></label>
                    <input type="number" class="form-control" name="rate" id="rate" min="0"
                        placeholder="Enter Rate" oninput="sum_gst('qty','rate','amt')" value="0" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="amt">Amount</label>
                    <input type="number" class="form-control" name="amount" id="amt" min="0"
                        placeholder="Enter Amount" value="0" readonly>
                </div>

                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="1" name="remarks" id="remarks"
                            placeholder="Enter Remarks"></textarea>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="files">Files <span>*</span></label>
                        <div class="inpflex">
                            <input type="file" class="form-control border-0" name="sc_file" id="sc_file"
                                required multiple>
                            <div class="cameraIcon d-flex justify-content-center align-items-center"
                                data-target="#sc_file">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <img class="imagePreview" src="" alt="Image Preview"
                            style="display:none; width:100%; height:200px; background-color: #fff; margin-top: 10px;">
                    </div>
                    <div class="col-sm-12 col-md-4 mt-3 cameraOpt" style="display: none;">
                        <div class="camerafnctn">
                            <video class="video" width="200" height="200" autoplay></video>
                            <input class="formbtn capture" type="button" value="Capture">
                            <canvas class="canvas" style="display: none;"></canvas>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
                <button type="submit" id="sub" class="formbtn">Update</button>
            </div>
        </form>

    </div>

    <script>
        function sumAmounts() {
            var qty = parseFloat(document.getElementById('q_boq').value) || 0;
            var boqRate = parseFloat(document.getElementById('boq_rate').value) || 0;
            var zeroRate = parseFloat(document.getElementById('zero_rate').value) || 0;

            var boqAmount = qty * boqRate;
            var zeroAmount = qty * zeroRate;

            document.getElementById('amount_boq').value = boqAmount.toFixed(2);
            document.getElementById('amount_zero').value = zeroAmount.toFixed(2);
        }
    </script>

<script>
    function updateDescription() {
    const boqCodeSelect = document.getElementById('boq_act_code');
    const selectedOption = boqCodeSelect.options[boqCodeSelect.selectedIndex];
    const description = selectedOption.getAttribute('data-description');
    document.getElementById('boq_desc').value = description || '';

    const des = selectedOption.getAttribute('data-des');
    document.getElementById('boq_work').value = des || '';
}

</script>
@endsection
