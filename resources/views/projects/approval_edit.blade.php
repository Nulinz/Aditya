
@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit Rate Approval Form</h6>
            </div>
        </div>

        <form action="{{route('rate_approval.update',['id'=>$rate_approval->id])}}" method="post" class="myForm1" >
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="rate_date" id="date"
                         pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                        required value="{{$rate_approval->rate_date}}">
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="boqcode">BOQ Code <span>*</span></label>
                    <select class="form-select select2input" name="boq_code" id="boq_act_code" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($boqs as $boq)
                            <option data-code="{{ $boq->code }}" data-des="{{ $boq->des }}"
                                    data-brate="{{ $boq->boq_rate }}" data-zrate="{{ $boq->zero_rate }}"
                                    data-des_work="{{ $boq->description }}"  {{ $boq->id == $rate_approval->boq_code ? 'selected' : '' }}>
                                {{ $boq->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="subdivcode">Sub Division Code <span>*</span></label>
                    <select class="form-select select2input" name="sub_code" id="sub_div_code" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($sub_code as $items)
                            <option value="{{$items->id}}" {{ $items->id == $rate_approval->sub_code ? 'selected' : '' }}>{{$items->sub_code}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="unit">Unit <span>*</span></label>
                    <select class="form-select" name="unit" required>
                        <option value="" selected>Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id}}"  {{ $unit->id == $rate_approval->unit ? 'selected' : '' }}>{{$unit->unit}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="mhrate">MH Rate <span>*</span></label>
                    <input type="number" class="form-control" name="mh_rate" id="mhrate" min="0"
                        placeholder="Enter MH Rate" required value="{{$rate_approval->mh_rate}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="unitrate">Unit Rate <span>*</span></label>
                    <input type="number" class="form-control" name="unit_rate" id="unitrate" min="0"
                        placeholder="Enter Unit Rate" required value="{{$rate_approval->unit_rate}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="totalrate">Total Rate <span>*</span></label>
                    <input type="number" class="form-control" name="tlt_rate" id="totalrate" min="0"
                        placeholder="Enter Total Rate" required value="{{$rate_approval->tlt_rate}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="contractorprofit">Contractor Profit <span>*</span></label>
                    <input type="number" class="form-control" name="cont_profit" id="contractorprofit" min="0"
                        placeholder="Enter Contractor Profit" required value="{{$rate_approval->cont_profit}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="recommdrate">Recommended Rate <span>*</span></label>
                    <input type="number" class="form-control" name="rcm_rate" id="recommdrate" min="0"
                        placeholder="Enter Recommended Rate" required value="{{$rate_approval->rcm_rate}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" rows="1" name="remarks" id="remarks"
                        placeholder="Enter Remarks">{{$rate_approval->remarks}}</textarea>
                </div>
            </div>
            <div
                class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                <button type="submit" id="sub" class="formbtn">Save</button>
            </div>
        </form>


    </div>


@endsection
