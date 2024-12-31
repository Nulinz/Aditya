
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit Overhead Expenses Form</h6>
            </div>
        </div>

        <form action="{{route('head_expenses.update',['id'=>$expenses->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="head_date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                         required value="{{$expenses->head_date}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="hmcode">Head Master Code <span>*</span></label>
                    <select class="form-select select2input" name="boq_code" id="boq_act_code" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($headcode as $items)
                            <option value="{{$items->id}}" {{ $items->id == $expenses->boq_code ? 'selected' : '' }}>
                                {{$items->item_code}}
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="vendorname">Vendor Name <span>*</span></label>
                    <select class="form-select select2input" name="v_name" id="vendor_name" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($vendor as $vendors)
                            <option value="{{$vendors->id}}" {{ $vendors->id == $expenses->v_name ? 'selected' : '' }}>{{$vendors->v_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="desp">Activity Description</label>
                    <textarea class="form-control" rows="1" name="des" id="desp"
                        placeholder="Enter Activity Description">{{$expenses->des}}</textarea>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="unit">Unit <span>*</span></label>
                    <select class="form-select" name="uom" required>
                        <option value="" selected>Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}" {{ $unit->id == $expenses->uom ? 'selected' : '' }}>{{$unit->unit}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="qty">Quantity <span>*</span></label>
                    <input type="number" class="form-control" name="qty" id="qty" min="0" placeholder="Enter Quantity"
                        oninput="updateAmountAndGross()" value="{{$expenses->qty}}" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="rate">Rate <span>*</span></label>
                    <input type="number" class="form-control" name="rate" id="rate" min="0" placeholder="Enter Rate"
                        oninput="updateAmountAndGross()" value="{{$expenses->rate}}" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="amt">Amount</label>
                    <input type="number" class="form-control" name="amt" id="amt" min="0" placeholder="Enter Amount" readonly
                        value="{{$expenses->amt}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="gst">GST (%) <span>*</span></label>
                    <input type="number" class="form-control" name="gst" id="gst" placeholder="Enter GST"
                        oninput="updateGross()" value="{{$expenses->gst}}" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="gross">Gross <span>*</span></label>
                    <input type="number" class="form-control" name="gross" id="gross" min="0" placeholder="Enter Gross"
                        readonly value="{{$expenses->gross}}" required>
                </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="1" name="remark" id="remarks"
                            placeholder="Enter Remarks">{{$expenses->remark}}</textarea>
                    </div>
            </div>
            <div
                class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                <button type="submit" id="sub" class="formbtn">Save</button>
            </div>
        </form>

    </div>



    <script>
        $(document).ready(function() {
            $('.select2input').select2({
                placeholder: "Select Options",
                allowClear: true,
                width: '100%'
            }).prop('required', true);
        })
    </script>

<script>
    function updateAmountAndGross() {
        const qty = parseFloat(document.getElementById('qty').value) || 0;
        const rate = parseFloat(document.getElementById('rate').value) || 0;
        const amount = qty * rate;

        document.getElementById('amt').value = amount.toFixed(2);

        updateGross();
    }

    function updateGross() {
        const amount = parseFloat(document.getElementById('amt').value) || 0;
        const gst = parseFloat(document.getElementById('gst').value) || 0;

        const gstAmount = amount * gst / 100;
        const gross = amount + gstAmount;

        document.getElementById('gross').value = gross.toFixed(2);
    }
</script>
@endsection
