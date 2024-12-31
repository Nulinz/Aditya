
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit Sub Division Form</h6>
            </div>
        </div>
        <form action="{{route('division.update',['id'=>$sub_division->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="sidebodyhead my-3">
                <h4 class="m-0">Sub Division Details</h4>
            </div>
            <div class="container-fluid maindiv bg-white">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="itemcode">Project <span>*</span></label>
                        <select class="form-select select2input" name="pro_id" id="pro_id"
                            required>
                            <option value="" selected true disabled>Select Options</option>
                           @foreach ($project as $projects)
                               <option value="{{ $projects->id }}" 
                                {{ $projects->id == $sub_division->pro_id ? 'selected' : '' }}>
                                {{ $projects->pro_title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="boqcode">BOQ Code <span>*</span></label>
                        <select class="form-select select2input" name="boq" id="boqcode"
                            required>
                            <option value="" selected true disabled>Select Options</option>
                            @foreach ($boq as $boqs)
                               <option value="{{ $boqs->id }}" 
                                {{ $boqs->id == $sub_division->pro_id ? 'selected' : '' }}>
                                {{ $boqs->code }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="subdivcode">Sub Division Code <span>*</span></label>
                        <input type="text" class="form-control" name="sub_code"
                            id="subdivcode" placeholder="Enter Sub Division Code" required value="{{$sub_division->sub_code}}">
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                        <label for="desp">Description</label>
                        <textarea class="form-control" rows="1" name="des" id="desp"
                            placeholder="Enter Description">{{$sub_division->des}}</textarea>
                    </div>
                </div>
            </div>

           

            <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
                <button type="submit" id="sub" class="formbtn">Update</button>
            </div>
        </form>
       
    </div>
   

@endsection