@include('layouts.header')

@php
$check_user_permissions = DB::table('project_teams')
    ->leftJoin('users', 'project_teams.mb_id', '=', 'users.id')
    ->where('project_teams.pro_id', $projectId)
    ->where('project_teams.status', 1)
    ->select('project_teams.*', 'users.emp_desg')
    ->get();
@endphp

@foreach ($check_user_permissions as $permission)
    @if ($permission->emp_access == 'Create' || $permission->emp_desg == 'Admin')
        <div class="accordion" id="accordionExample">
            <div class="accordion-item mt-3">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#accord13">
                        <h4 class="m-0">SC Bill</h4>
                    </button>
                </h2>
                <form action="" method="post" class="myForm1"
                    enctype="multipart/form-data">
                    @csrf
                    <input hidden name="pro_id" type="text" value="{{$projectId}}" class="form-control">

                    <div id="accord13" class="accordion-collapse collapse">
                        <div class="accordion-body maindiv">
                            <div class="container-fluid px-1">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="date">Date <span>*</span></label>
                                        <input type="date" class="form-control" name="sc_date" id="date"
                                            pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                                            required>
                                    </div>
                                    @php

                                        // $division = DB::table('divisions')
                                        //         ->leftJoin('boqs', 'divisions.boq', '=', 'boqs.id')
                                        //         ->where('divisions.pro_id', $projectId)
                                        //         ->where('divisions.status', 1)
                                        //         ->select(
                                        //             'divisions.*',
                                        //             'boqs.code as boq_code')
                                        //         ->get();
                                        $division = DB::table('divisions')
                                            ->leftJoin('boqs', function ($join) use ($projectId) {
                                                $join->on('divisions.boq', '=', 'boqs.id')
                                                    ->where('boqs.pro_id', $projectId);
                                            })
                                            ->where('divisions.pro_id', $projectId)
                                            ->where('divisions.status', 1)
                                            ->select(
                                                'divisions.*',
                                                'boqs.code as boq_code'
                                            )
                                            ->get();


                                      @endphp
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="boqcode">BOQ Code <span>*</span></label>
                                        <select class="form-select select2input" name="boq_code" id="boq_act_code" required>
                                            <option value="" selected disabled>Select Options</option>
                                            @foreach ($division  as $item)
                                                <option value="{{$item->id}}">{{$item->boq_code}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="boqdesp">BOQ Description</label>
                                        <textarea class="form-control" rows="1" name="des" id="boq_desc"
                                            placeholder="Enter BOQ Description" readonly></textarea>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="subdivcode">Sub Division Code <span>*</span></label>
                                        <!-- <input type="text" class="form-control" name="sub_code" id="sub_div_code"
                                            list="subcodes" placeholder="Sub Div Code"
                                            required> -->
                                        <select class="form-select select2input" name="sub_code" id="sub_div_code" required>

                                        </select>

                                    </div>

                                    @php
                                    $vendor = DB::table('vendors')->where('pro_id', $projectId)->where('status', 1)->get();
                                    @endphp
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="vendorname">Vendor Name <span>*</span></label>
                                        <select class="form-select select2input" name="v_name" id="vendor_name" required>
                                            <option value="" selected disabled>Select Options</option>
                                            @foreach ($vendor as $vendors)
                                                <option value="{{$vendors->id}}">{{$vendors->v_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                    $units = DB::table('units')->where('status', 1)->get();
                                   @endphp
                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="unit">Unit <span>*</span></label>
                                    <select class="form-select" name="unit" required>
                                        <option value="" selected>Select Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->unit}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="qty">Quantity <span>*</span></label>
                                    <input type="number" class="form-control" name="qty" id="qty" min="0"
                                        placeholder="Enter Quantity" oninput="sum_gst('qty','rate','amt')" value="0" required>
                                </div>

                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="rate">Rate <span>*</span></label>
                                    <input type="number" class="form-control" name="rate" id="rate" min="0"
                                        placeholder="Enter Rate" oninput="sum_gst('qty','rate','amt')" value="0" required>
                                </div>

                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="amt">Amount</label>
                                    <input type="number" class="form-control" name="amount" id="amt" min="0"
                                        placeholder="Enter Amount" value="0" readonly>
                                </div>

                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control" rows="1" name="remarks" id="remarks"
                                            placeholder="Enter Remarks"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="files">Files <span>*</span></label>
                                        <div class="inpflex">
                                            <input type="file" class="form-control border-0" name="sc_file" id="sc_file"
                                                required multiple>
                                            <div class="cameraIcon d-flex justify-content-center align-items-center"
                                                data-target="#sc_file">
                                                <i class="fas fa-camera"></i>
                                            </div>
                                        </div>
                                        <img class="imagePreview" src="" alt="Image Preview"
                                            style="display:none; width:100%; height:200px; background-color: #fff; margin-top: 10px;">
                                    </div>
                                    <div class="col-sm-12 col-md-4 mt-3 cameraOpt" style="display: none;">
                                        <div class="camerafnctn">
                                            <video class="video" width="200" height="200" autoplay></video>
                                            <input class="formbtn capture" type="button" value="Capture">
                                            <canvas class="canvas" style="display: none;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                                    <button type="submit" id="submitBtn" class="formbtn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endforeach



<!-- Table -->
<div class="container-fluid mt-2 listtable">
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select id="headerDropdown14" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput14" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_scbill" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>
    @php
          $scBills = DB::table('sc_bills')
        ->where('sc_bills.pro_id', $projectId)
        ->where('sc_bills.status', 1)
        ->orderBy('sc_bills.id', 'DESC')
        ->leftJoin('divisions', 'sc_bills.sub_code', '=', 'divisions.id')
        ->leftJoin('boqs', 'sc_bills.boq_code', '=', 'boqs.id')
        ->leftJoin('vendors', 'sc_bills.v_name', '=', 'vendors.id')
        ->leftJoin('units', 'sc_bills.unit', '=', 'units.id')
        ->select(
            'sc_bills.*',
            'divisions.sub_code as sub_code_name',
            'boqs.des as boq_description',
            'vendors.v_name as vendor_name',
            'units.unit as unit_name'
        )
        ->get();


    @endphp
    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table14">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>BOQ Code</th>
                    <th>Description</th>
                    <th>Sub Division Code</th>
                    <th>Vendor Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $amount1 = 0; @endphp
                @foreach($scBills as $index => $scBill)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($scBill->sc_date)->format('d-m-Y') }}</td>
                    <td>{{ $scBill->boq_code }}</td>
                    <td>{{ $scBill->boq_description }}</td>
                    <td>{{ $scBill->sub_code_name }}</td>
                    <td>{{ $scBill->vendor_name }}</td>
                    <td>{{ $scBill->unit_name }}</td>
                    <td>{{ $scBill->qty }}</td>
                    <td>{{ number_format($scBill->rate, 2) }}</td>
                    <td>{{ number_format($scBill->amount, 2) }}</td>
                    @php $amount1 += $scBill->amount; @endphp
                    <td>{{ $scBill->remarks }}</td>
                    <td>
                        <a href="{{ asset($scBill->sc_file) }}" download="{{ basename($scBill->sc_file) }}" title="Download image">Download</a>

                    </td>
                    <td>
                        <div class="d-flex gap-3">
                            <a href="{{ route('sc_bill.edit', ['id' => $scBill->id]) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @if(auth()->user()->emp_desg == 'Admin')
                                <a data-remote="{{ route('sc_bill.destroy', ['id' => $scBill->id]) }}" class="delete-confirm">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($amount1, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_scbill" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">SC Bill Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="imp_file1.php" method="POST" enctype="multipart/form-data">
                <input hidden type="text" name="project_id" >
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="exc_scbill" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" name="import_scbill" class="modalbtn">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="form.js"></script>

<script>
    $(document).ready(function() {
        function initTable(tableId, dropdownId, filterInputId) {
            var table = $(tableId).DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "order": [0, "asc"],
                "bDestroy": true,
                "info": false,
                "responsive": true,
                "pageLength": 30,
                "dom": '<"top"f>rt<"bottom"ilp><"clear">',
            });

            $(tableId + ' thead th').each(function(index) {
                var headerText = $(this).text();
                if (headerText != "" && headerText.toLowerCase() != "action") {
                    $(dropdownId).append('<option value="' + index + '">' + headerText + '</option>');
                }
            });

            $(filterInputId).on('keyup', function() {
                var selectedColumn = $(dropdownId).val();
                if (selectedColumn !== 'All') {
                    table.column(selectedColumn).search($(this).val()).draw();
                } else {
                    table.search($(this).val()).draw();
                }
            });

            $(dropdownId).on('change', function() {
                $(filterInputId).val('');
                table.search('').columns().search('').draw();
            });

            $(filterInputId).on('keyup', function() {
                table.search($(this).val()).draw();
            });

        }

        // Initialize each table
        initTable('#table14', '#headerDropdown14', '#filterInput14');
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2input').select2({
            placeholder: "Select Options",
            allowClear: true,
            width: '100%'
        }).prop('required', true);
    })


    $('#boq_act_code').on('change', function() {
    var boqId = $(this).val();

        $.ajax({
            url: '{{route('get_boq_details')}}',
            method: 'GET',
            data: { boq_id: boqId },
            success: function(response) {

                $('#boq_desc').val(response.des);
                var newOption = new Option(response.sub_code, response.id);

                $('#sub_div_code').append(newOption);
            },
            error: function(xhr, status, error) {
                console.log("Error fetching details:", error);
            }
        });
    });

</script>

<script>
    function sum_gst(qtyId, rateId, amtId) {
    var qty = parseFloat(document.getElementById(qtyId).value) || 0;
    var rate = parseFloat(document.getElementById(rateId).value) || 0;

    var amount = qty * rate;

    document.getElementById(amtId).value = amount.toFixed(2);
}

</script>
<!-- Script Camera Option -->
<script>
    const $video = $('.video');
    const $canvas = $('.canvas');
    $('.cameraIcon').on('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: {
                        ideal: "environment"
                    },
                }
            });
            $video[0].srcObject = stream;
            $('.cameraOpt').show();
        } catch (err) {
            console.error('Error accessing camera:', err);
        }

        $('.capture').on('click', () => {
            const context = $canvas[0].getContext('2d');
            $canvas.attr('width', $video[0].videoWidth).attr('height', $video[0].videoHeight);
            context.drawImage($video[0], 0, 0);

            const targetInput = $('.cameraIcon').data('target');
            $canvas[0].toBlob(blob => {
                if (blob) {
                    const file = new File([blob], 'captured-image.jpg', {
                        type: 'image/jpeg'
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    const $input = $('#in_img1');
                    if ($input.length > 0) {
                        $input[0].files = dataTransfer.files;
                    } else {
                        console.error('Input element #in_img1 not found.');
                    }
                    $(".imagePreview").attr('src', URL.createObjectURL(file)).show();
                    const stream = $video[0].srcObject;
                    if (stream) stream.getTracks().forEach(track => track.stop());
                    $video[0].srcObject = null;
                    $('.cameraOpt').hide();
                }
            }, 'image/jpeg');
        });
    });
</script>

<style>
    .swal2-toast .swal2-title.toast-title {
        color: rgb(235, 227, 227) !important;
    }
</style>
<script>

    $(document).ready(function () {
    $('.myForm1').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        const csrfToken = $('meta[name="csrf-token"]').attr('content');



        $.ajax({
            url: '{{ route('projects_sc_bill.sa') }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'json',
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    },
                    customClass: {
                        title: 'toast-title'
                    }
                });

                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });

                    $('.myForm1')[0].reset();

                    location.reload();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again later.'
                });
            }
        });
    });
});

</script>
<script>
    document.getElementById("sc_file").addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const imagePreview = document.querySelector(".imagePreview");

                imagePreview.src = e.target.result;

                imagePreview.style.display = "block";
            };

            reader.readAsDataURL(file);
        }
    });
</script>
@include('layouts.footer')
