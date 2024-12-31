
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit BOQ Form</h6>
            </div>
        </div>
        <form action="{{route('sales.update',['id'=>$project_sales->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">BOQ Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="date">Date <span>*</span></label>
                        <input type="date" class="form-control" name="pro_date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                             required value="{{$project_sales->pro_date}}">
                    </div>
                    
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqcode">BOQ Code <span>*</span></label>
                        <select class="form-select select2input" name="code" id="boq_act_code" required onchange="updateDescription()">
                            <option value="" selected disabled>Select Options</option>
                            @foreach ($boq as $boqs)
                                <option value="{{ $boqs->id }}" data-des="{{ $boqs->des }}" data-description="{{ $boqs->description }}" {{ $boqs->id == $project_sales->code ? 'selected' : '' }}>{{ $boqs->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqdesp">BOQ Description</label>
                        <textarea class="form-control" rows="1" name="des" id="boq_desc"
                            placeholder="Enter BOQ Description" readonly>{{$project_sales->des}}</textarea>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="despworkmaterial">Description of Work/Material</label>
                        <input type="text" class="form-control" name="work" id="boq_work"
                            placeholder="Enter Description of Work/Material" readonly value="{{$project_sales->work}}">
                    </div>
                   
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="unit">Unit <span>*</span></label>
                        <select class="form-select" name="unit" required>
                            <option value="" selected disabled>Select Unit</option>
                            @foreach ($unit as $units)
                            <option value="{{ $units->id }}" {{ $units->id == $project_sales->unit ? 'selected' : '' }}>
                                {{ $units->unit }}
                            </option>
                        @endforeach
                        
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="qty">Quantity <span>*</span></label>
                        <input type="number" class="form-control" name="qty" id="q_boq" min="0" placeholder="Enter Quantity" oninput="sumAmounts()" required value="{{$project_sales->qty}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqrate">BOQ Rate <span>*</span></label>
                        <input type="number" class="form-control" name="pro_sale_rate"  id="boq_rate" min="0" placeholder="Enter BOQ Rate" oninput="sumAmounts()" required value="{{$project_sales->pro_sale_rate}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="zerocostrate">Zero Cost Rate <span>*</span></label>
                        <input type="number" class="form-control" name="pro_zero_rate"  id="zero_rate" min="0" placeholder="Enter Zero Cost Rate" oninput="sumAmounts()" required value="{{$project_sales->pro_zero_rate}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqamt">BOQ Amount</label>
                        <input type="number" class="form-control" name="pro_sale_amt" id="amount_boq"  min="0" readonly value="{{$project_sales->pro_sale_amt}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="zerocostamt">Zero Cost Amount</label>
                        <input type="number" class="form-control" name="pro_zero_amt" id="amount_zero"  min="0" readonly value="{{$project_sales->pro_zero_amt}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="1" name="remarks" id="remarks"
                            placeholder="Enter Remarks">{{$project_sales->remarks}}</textarea>
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