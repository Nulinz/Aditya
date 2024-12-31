
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit BOQ Form</h6>
            </div>
        </div>
        <form action="{{route('boq.update',['id'=>$boq->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">BOQ Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="activitycode">BOQ Code <span>*</span></label>

                        <input type="text" class="form-control" name="code" id="activitycode" placeholder="Enter Activity Code" required value="{{$boq->code}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqdesp">BOQ Description <span>*</span></label>
                        <textarea class="form-control" rows="1" name="des" id="boqdesp" placeholder="Enter BOQ Description" required>{{$boq->des}}</textarea>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="despworkmaterial">Description of Work/Material</label>
                        <input type="text" class="form-control" name="description" id="despworkmaterial" placeholder="Enter Description of Work/Material" value="{{$boq->description}}">
                    </div>
                   
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="unit">Unit <span>*</span></label>
                        <select class="form-select" name="unit" required>
                            <option value="" selected disabled>Select Unit</option>
                            @foreach ($unit as $units)
                            <option value="{{ $units->id }}" 
                                {{ $units->id == $boq->unit ? 'selected' : '' }}>
                                {{ $units->unit }}
                            </option>
                            @endforeach
                           
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="qty">Quantity <span>*</span></label>
                        <input type="number" class="form-control" name="qty" id="q_boq" min="0" placeholder="Enter Quantity" oninput="sumAmounts()" required   value="{{$boq->qty}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqrate">BOQ Rate <span>*</span></label>
                        <input type="number" class="form-control" name="boq_rate"  id="boq_rate" min="0" placeholder="Enter BOQ Rate" oninput="sumAmounts()" required  value="{{$boq->boq_rate}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="zerocostrate">Zero Cost Rate <span>*</span></label>
                        <input type="number" class="form-control" name="zero_rate"  id="zero_rate" min="0" placeholder="Enter Zero Cost Rate" oninput="sumAmounts()" required value="{{$boq->zero_rate}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqamt">BOQ Amount</label>
                        <input type="number" class="form-control" name="boq_amount" id="amount_boq"  min="0" readonly value="{{$boq->boq_amount}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="zerocostamt">Zero Cost Amount</label>
                        <input type="number" class="form-control" name="zero_amount" id="amount_zero"  min="0" readonly value="{{$boq->zero_amount}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" rows="1" name="remarks" id="remarks" placeholder="Enter Remarks">{{$boq->remarks}}</textarea>
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
@endsection