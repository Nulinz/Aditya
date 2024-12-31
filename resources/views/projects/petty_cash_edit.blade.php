
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit Petty Form</h6>
            </div>
        </div>
        <form action="{{route('pettycash.update',['id'=>$petty->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date"  class="form-control" name="date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                         required value="{{$petty->date}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="amt">Amount <span>*</span></label>
                    <input type="number" class="form-control" name="amount" id="amt" min="0" required value="{{$petty->amount}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="employee">Select Employee <span>*</span></label>
                    <select class="form-select select2input" name="emp_id" id="employee" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($employee as $employees)
                           <option value="{{$employees->id}}"  {{ $employees->id == $petty->emp_id ? 'selected' : '' }}>{{$employees->vemp_name}}</option>
                        @endforeach
                    </select>
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




@endsection
