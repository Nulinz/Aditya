@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord14">
                <h4 class="m-0">Rate Approval</h4>
            </button>
        </h2>
        <form action="" method="post" class="myForm1">
            @csrf
            <input hidden name="pro_id" type="text" value="{{$projectId}}" class="form-control">
            <div id="accord14" class="accordion-collapse collapse">
                <div class="accordion-body maindiv">
                    <div class="container-fluid px-1">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="rate_date" id="date"
                                     pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                                    required>
                            </div>
                            @php
                                $boqs = DB::table('boqs')->where('pro_id', $projectId)->where('status', 1)->get();

                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqcode">BOQ Code <span>*</span></label>
                                <select class="form-select select2input" name="boq_code" id="boq_act_code" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($boqs as $boq)
                                        <option data-id="{{ $boq->id }}"
                                         data-code="{{ $boq->code }}" data-des="{{ $boq->des }}"
                                                data-brate="{{ $boq->boq_rate }}" data-zrate="{{ $boq->zero_rate }}"
                                                data-des_work="{{ $boq->description }}">
                                            {{ $boq->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                                $sub_code = DB::table('divisions')->where('pro_id', $projectId)->where('status', 1)->get();

                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="subdivcode">Sub Division Code <span>*</span></label>
                                <select class="form-select select2input" name="sub_code" id="sub_div_code" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($sub_code as $items)
                                        <option value="{{$items->id}}">{{$items->sub_code}}</option>
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
                                <label for="mhrate">MH Rate <span>*</span></label>
                                <input type="number" class="form-control" name="mh_rate" id="mhrate" min="0"
                                    placeholder="Enter MH Rate" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="unitrate">Unit Rate <span>*</span></label>
                                <input type="number" class="form-control" name="unit_rate" id="unitrate" min="0"
                                    placeholder="Enter Unit Rate" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="totalrate">Total Rate <span>*</span></label>
                                <input type="number" class="form-control" name="tlt_rate" id="totalrate" min="0"
                                    placeholder="Enter Total Rate" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="contractorprofit">Contractor Profit <span>*</span></label>
                                <input type="number" class="form-control" name="cont_profit" id="contractorprofit" min="0"
                                    placeholder="Enter Contractor Profit" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="recommdrate">Recommended Rate <span>*</span></label>
                                <input type="number" class="form-control" name="rcm_rate" id="recommdrate" min="0"
                                    placeholder="Enter Recommended Rate" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" rows="1" name="remarks" id="remarks"
                                    placeholder="Enter Remarks"></textarea>
                            </div>
                        </div>
                        <div
                            class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                            <input type="hidden" name="add_appreq">
                            <button type="submit" id="sub" class="formbtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@php
    $rate_approval = DB::table('approve_reqs')
                        ->leftJoin('units', 'approve_reqs.unit', '=', 'units.id')
                        ->leftJoin('divisions', 'approve_reqs.sub_code', '=', 'divisions.id')
                        ->leftJoin('boqs', 'approve_reqs.boq_code', '=', 'boqs.id')
                        ->where('approve_reqs.pro_id', $projectId)
                        ->where('approve_reqs.status', 1)
                        ->select(
                            'approve_reqs.*',
                            'units.unit as unit_name',
                            'boqs.code',
                            'divisions.sub_code'
                        )
                        ->get();
@endphp
<!-- Table -->
<div class="container-fluid mt-2 listtable">
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select id="headerDropdown15" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput15" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_rateapproval" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table15">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>BOQ Code</th>
                    <th>Sub Div Code</th>
                    <th>Unit</th>
                    <th>MH Rate</th>
                    <th>Unit Rate</th>
                    <th>Total Rate</th>
                    <th>Recommended Rate</th>
                    <th>Contractor Profit</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($rate_approval as $rate)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$rate->rate_date}}</td>
                            <td>{{$rate->code}}</td>
                            <td>{{$rate->sub_code}}</td>
                            <td>{{$rate->unit_name}}</td>
                            <td>{{$rate->mh_rate}}</td>
                            <td>{{$rate->unit_rate}}</td>
                            <td>{{$rate->tlt_rate}}</td>
                            <td>{{$rate->rcm_rate}}</td>
                            <td>{{$rate->cont_profit}}</td>
                            <td>{{$rate->remarks}}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <!-- Edit Link -->
                                    <a href="{{ route('rate_approval.edit', $rate->id) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>


                                        <a data-remote="{{ route('rate_approval.destroy', ['id' => $rate->id]) }}" class="delete-confirm">
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </a>


                                </div>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_rateapproval" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Rate Approval Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="imp_file1.php" method="POST" enctype="multipart/form-data">
                <input hidden type="text" name="project_id" value="">
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="exc_rate" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" name="import_rate" class="modalbtn">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
        initTable('#table15', '#headerDropdown15', '#filterInput15');
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

        // alert("hello");


        var boq = $(this).val();






    });
</script>

<script>
    $(document).ready(function () {
        $('.myForm1').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize();

            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('projects_rate_approval.sa') }}',
                method: 'POST',
                data: formData,
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
@include('layouts.footer')
