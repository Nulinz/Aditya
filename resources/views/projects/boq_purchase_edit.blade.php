
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit BOQ Form</h6>
            </div>
        </div>
        <form action="{{route('boq_purchase.update',['id'=>$purchase->id])}}" method="post" class="myForm1">
            @csrf

            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="pur_date" id="date"
                        pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31" required value="{{$purchase->pur_date}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="billno">Bill No <span>*</span></label>
                    <input type="text" class="form-control" name="pur_bill" id="billno"
                        placeholder="Enter Bill No" required value="{{$purchase->pur_bill}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="boqcode">BOQ Code <span>*</span></label>
                    <select class="form-select select2input" name="code" id="boq_act_code" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach($boqs as $boq)
                            <option
                                data-id="{{ $boq->id }}"
                                data-code="{{ $boq->code }}"
                                data-des="{{ $boq->des }}"
                                data-brate="{{ $boq->boq_rate }}"
                                data-zrate="{{ $boq->zero_rate }}"
                                data-des_work="{{ $boq->description }}" {{ $boq->id == $purchase->code ? 'selected' : '' }}>
                                {{ $boq->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="vendorname">Vendor Name <span>*</span></label>
                    <select class="form-select select2input" name="ven_name" id="vendor_name" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($vendor as $vendors)
                            <option value="{{$vendors->id}}" {{ $vendors->id == $purchase->ven_name ? 'selected' : '' }}>{{$vendors->v_name}}</option>
                        @endforeach
                    </select>
                </div>

               <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                <label for="itemcode">Material Code <span>*</span></label>
                <select class="form-select select2input" name="item_code" id="item_codes" required>
                    <option value="" selected disabled>Select Options</option>
                    @foreach($materials as $material)
                        <option data-des="{{ $material->des }}" data-code="{{ $material->item_code }}" value="{{ $material->id }}" {{ $material->id == $purchase->item_code ? 'selected' : '' }}>
                            {{ $material->item_code }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                <label for="material">Material Description</label>
                <textarea class="form-control" rows="1" name="material" id="material" placeholder="Enter Material" readonly>{{$purchase->material}}</textarea>
            </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="unit">Unit <span>*</span></label>
                    <select class="form-select" name="uom" required>
                        <option value="" selected>Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}" {{ $unit->id == $purchase->uom ? 'selected' : '' }}>{{$unit->unit}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="qty">Quantity <span>*</span></label>
                    <input type="number" class="form-control" name="qty" id="qty" min="0"
                        placeholder="Enter Quantity" oninput="sum_gst('qty', 'rate', 'gst', 'amt', 'gross')"  required value="{{$purchase->qty }}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="rate">Rate <span>*</span></label>
                    <input type="number" class="form-control" name="b_rate" id="rate" min="0"
                        placeholder="Enter Rate" oninput="sum_gst('qty', 'rate', 'gst', 'amt', 'gross')"  required value="{{$purchase->b_rate}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="amt">Amount</label>
                    <input type="number" class="form-control" name="amount" id="amt" min="0"
                        placeholder="Enter Amount"  readonly value="{{$purchase->amount}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="gst">GST <span>*</span></label>
                    <input type="text" class="form-control" name="gst" id="gst" placeholder="Enter GST"
                        oninput="sum_gst('qty', 'rate', 'gst', 'amt', 'gross')"  required value="{{$purchase->gst}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="gross">Gross <span>*</span></label>
                    <input type="text" class="form-control" name="gross" id="gross"
                        placeholder="Enter Gross"  readonly required value="{{$purchase->gross}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" rows="1" name="remarks" id="remarks"
                        placeholder="Enter Remarks">{{$purchase->remarks}}</textarea>
                </div>

                <div class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                    <button type="submit" id="sub" class="formbtn">Save</button>
                </div>
            </div>
        </form>

    </div>

    <script>
        function sum_gst(qtyId, rateId, gstId, amtId, grossId) {
            var qty = parseFloat(document.getElementById(qtyId).value) || 0;
            var rate = parseFloat(document.getElementById(rateId).value) || 0;
            var gst = parseFloat(document.getElementById(gstId).value) || 0;

            var amount = qty * rate;

            var gstAmount = (amount * gst) / 100;

            var gross = amount + gstAmount;

            document.getElementById(amtId).value = amount.toFixed(2);
            document.getElementById(grossId).value = gross.toFixed(2);
        }
        </script>
        <script>
            document.getElementById('item_codes').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var materialDescription = selectedOption.getAttribute('data-des');
                document.getElementById('material').value = materialDescription;
            });
        </script>
@endsection
