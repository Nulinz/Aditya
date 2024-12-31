
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit BOQ Labour Form</h6>
            </div>
        </div>

        <form action="{{route('assgin_team.update',['id'=>$assign_team->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="assign_date" id="date"
                         pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                        required value="{{$assign_team->assign_date}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="employee">Select Team Member<span>*</span></label>
                    <select class="form-select select2input" name="mb_id" id="employee" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($employee as $employees)
                           <option value="{{$employees->id}}" {{ $employees->id == $assign_team->mb_id ? 'selected' : '' }}>{{$employees->vemp_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="designation">Select Designation <span>*</span></label>
                    <select class="form-select" name="desg" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($desgination as $des)
                           <option value="{{$des->id}}" {{ $des->id == $assign_team->desg ? 'selected' : '' }}>{{$des->designation}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="access">Access <span>*</span></label>
                    <select class="form-select" name="emp_access" id="access" required>
                        <option value="" disabled {{ $assign_team == '' || $assign_team == null ? 'selected' : '' }}>Select Options</option>
                        <option value="Create" {{ $assign_team->emp_access == 'Create' ? 'selected' : '' }}>Create</option>
                        <option value="Recommend" {{ $assign_team->emp_access == 'Recommend' ? 'selected' : '' }}>Recommend</option>
                        <option value="Verify" {{ $assign_team->emp_access== 'Verify' ? 'selected' : '' }}>Verify</option>
                        <option value="Approve" {{ $assign_team->emp_access == 'Approve' ? 'selected' : '' }}>Approve</option>
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
