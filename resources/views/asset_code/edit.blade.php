@extends('layouts.app')
@section('content')

<div class="sidebodydiv">
    <div class="sidebodyback mb-3" onclick="goBack()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Edit Asset Code</h6>
        </div>
    </div>
    <form action="{{route('asset_code.update',['id'=>$asset_code->id])}}" method="POST" >
        @csrf
        <div class="sidebodyhead my-3">
            <h4 class="m-0">Asset Code Details</h4>
        </div>

        <div class="container-fluid maindiv bg-white">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="itemcode">Project <span>*</span></label>
                    <select class="form-select select2input" name="pro_id" id="project" required>
                        <option value="" selected true disabled>Select Options</option>
                        @foreach ($project as $projects)
                        <option value="{{ $projects->id }}" 
                            {{ $projects->id == $asset_code->pro_id ? 'selected' : '' }}>
                            {{ $projects->pro_title }}
                        </option>
                    @endforeach
                    
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="asset_date" id="date"
                        pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31" required autofocus value="{{$asset_code->asset_date}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="itemcode">Asset Code<span>*</span></label>
                    <input type="text" class="form-control" name="asset_code" id="itemcode"
                        placeholder="Enter Item Code" value="{{$asset_code->asset_code}}" required>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="desp">Description</label>
                    <textarea class="form-control" rows="1" name="des" id="desp"
                        placeholder="Enter Description">{{$asset_code->des}}</textarea>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-xl-12 mt-3 d-flex justify-content-center align-items-center">
            <button type="submit" name="up_material" class="formbtn">Update</button>
        </div>
    </form>
</div>

@endsection