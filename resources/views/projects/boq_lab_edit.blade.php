
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit BOQ Labour Form</h6>
            </div>
        </div>

        <form action="{{route('boq_labour.update',['id'=>$labour->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="lab_date" id="date"
                        pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31" required value="{{$labour->lab_date}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="boqcode">BOQ Code <span>*</span></label>
                    <select class="form-select select2input" name="code" id="boq_act_code" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach($boqs as $boq)
                            <option
                                value="{{$boq->id}}"
                                data-code="{{ $boq->code }}"
                                data-des="{{ $boq->des }}"
                                data-brate="{{ $boq->boq_rate }}"
                                data-zrate="{{ $boq->zero_rate }}"
                                data-des_work="{{ $boq->description }}"
                                {{ $boq->id == $labour->code ? 'selected' : '' }}>
                                {{ $boq->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="desp">Description</label>
                    <textarea class="form-control" rows="1" name="des" id="desp" placeholder="Enter Description" readonly>{{$labour->des}}</textarea>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="vendorname">Contractor Name <span>*</span></label>
                    <select class="form-select select2input" name="v_name" id="vendor_name" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($vendor as $vendors)
                            <option value="{{$vendors->id}}"  {{ $vendors->id == $labour->v_name ? 'selected' : '' }}>{{$vendors->v_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="unit">Unit <span>*</span></label>
                    <select class="form-select" name="uom" required>
                        <option value="" selected>Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}" {{ $unit->id == $labour->uom ? 'selected' : '' }}>{{$unit->unit}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="qty">Quantity <span>*</span></label>
                    <input type="number" class="form-control" name="qty" id="qty" min="0" placeholder="Enter Quantity" value="{{$labour->qty}}" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="rate">Rate <span>*</span></label>
                    <input type="number" class="form-control" name="b_rate" id="rate" min="0" placeholder="Enter Rate" value="{{$labour->b_rate}}" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="amt">Amount</label>
                    <input type="number" class="form-control" name="amount" id="amt" min="0" placeholder="Amount" value="{{$labour->amount}}" readonly>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="gst">GST <span>*</span></label>
                    <input type="number" class="form-control" name="gst" id="gst" min="0" placeholder="Enter GST (%)" value="{{$labour->gst}}" required>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="gross">Gross <span>*</span></label>
                    <input type="number" class="form-control" name="gross" id="gross" min="0" placeholder="Gross Amount" value="{{$labour->gross}}" readonly required>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" rows="1" name="remark" id="remarks"
                        placeholder="Enter Remarks">{{$labour->remark}}</textarea>
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
    $(document).ready(function() {
        $('#boq_act_code').change(function() {
            var selectedOption = $(this).find('option:selected');

            var description = selectedOption.data('des');

            $('#desp').val(description);
        });
    });
</script>

<script>
    function calculateAmount() {
        let qty = parseFloat(document.getElementById('qty').value) || 0;
        let rate = parseFloat(document.getElementById('rate').value) || 0;

        let amount = qty * rate;
        document.getElementById('amt').value = amount.toFixed(2);

        calculateGST(amount);
    }

    function calculateGST(amount) {
        let gst = parseFloat(document.getElementById('gst').value) || 0;

        let gstAmount = (amount * gst) / 100;
        let gross = amount + gstAmount;

        document.getElementById('gross').value = gross.toFixed(2);
    }

    document.getElementById('qty').addEventListener('input', calculateAmount);
    document.getElementById('rate').addEventListener('input', calculateAmount);
    document.getElementById('gst').addEventListener('input', function() {
        let amount = parseFloat(document.getElementById('amt').value) || 0;
        calculateGST(amount);
    });
</script>
@endsection
