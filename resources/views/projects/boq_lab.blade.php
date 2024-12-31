@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord7">
                <h4 class="m-0">BOQ Labour</h4>
            </button>
        </h2>
        <form action="" method="post" class="myForm1">
            @csrf
            <input hidden name="pro_id" type="text" value="{{$projectId}}" class="form-control">
            <div id="accord7" class="accordion-collapse collapse">
                <div class="accordion-body maindiv">
                    <div class="container-fluid px-1">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="lab_date" id="date"
                                    pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31" required>
                            </div>
                            @php
                                $boqs = DB::table('boqs')->where('pro_id', $projectId)->where('status', 1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqcode">BOQ Code <span>*</span></label>
                                <select class="form-select select2input" name="code" id="boq_act_code" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach($boqs as $boq)
                                        <option
                                            value="{{$boq->id}}"
                                            data-code="{{ $boq->code }}"
                                            data-des="{{ $boq->des }}"
                                            data-brate="{{ $boq->boq_rate }}"
                                            data-zrate="{{ $boq->zero_rate }}"
                                            data-des_work="{{ $boq->description }}"
                                        >
                                            {{ $boq->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="desp">Description</label>
                                <textarea class="form-control" rows="1" name="des" id="desp" placeholder="Enter Description" readonly></textarea>
                            </div>

                            @php
                                $vendor = DB::table('vendors')->where('pro_id', $projectId)->where('type','contractor')->where('status', 1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="vendorname">Contractor Name <span>*</span></label>
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
                                <select class="form-select" name="uom" required>
                                    <option value="" selected>Select Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="qty">Quantity <span>*</span></label>
                                <input type="number" class="form-control" name="qty" id="qty" min="0" placeholder="Enter Quantity" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="rate">Rate <span>*</span></label>
                                <input type="number" class="form-control" name="b_rate" id="rate" min="0" placeholder="Enter Rate" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="amt">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amt" min="0" placeholder="Amount" value="0" readonly>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gst">GST <span>*</span></label>
                                <input type="number" class="form-control" name="gst" id="gst" min="0" placeholder="Enter GST (%)" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gross">Gross <span>*</span></label>
                                <input type="number" class="form-control" name="gross" id="gross" min="0" placeholder="Gross Amount" value="0" readonly required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" rows="1" name="remark" id="remarks"
                                    placeholder="Enter Remarks"></textarea>
                            </div>
                        </div>
                        <div
                            class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                            <button type="submit" id="sub" class="formbtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="container-fluid mt-2 listtable">
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select id="headerDropdown8" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput8" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_lab" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>
    @php
    $labours = DB::table('labs')
    ->leftJoin('units', 'labs.uom', '=', 'units.id')
    ->leftJoin('boqs', 'labs.code', '=', 'boqs.id')
    ->leftJoin('vendors', 'labs.v_name', '=', 'vendors.id')
    ->where('labs.pro_id', $projectId)
    ->where('labs.status', 1)
    ->orderByDesc('labs.id')
    ->select('labs.*', 'units.unit as unit_name','vendors.v_name as vendor_name','boqs.code as lab_code')
    ->get();

    $totalAmount=0;


@endphp
    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table8">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Contractor Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>GST</th>
                    <th>Gross</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($labours as $item)
                @php
                     $purAmount = (float) str_replace(',', '', $item->amount);
                     $totalAmount += $purAmount;
                @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ date('d-m-Y', strtotime($item->lab_date)) }}</td>
                        <td>{{$item->lab_code}}</td>
                        <td>{{$item->des}}</td>
                        <td>{{$item->vendor_name}}</td>
                        <td>{{$item->unit_name}}</td>
                        <td>{{$item->qty}}</td>
                        <td>{{$item->b_rate}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->gst}}</td>
                        <td>{{$item->gross}}</td>
                        <td>{{$item->remark}}</td>
                        <td>
                            <div class="d-flex gap-3">
                                <!-- Edit Link -->
                                <a href="{{ route('boq_labour.edit', $item->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete Link -->
                                <a data-remote="{{ route('boq_labour.destroy', ['id' => $item->id]) }}" class="delete-confirm">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </a>

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
                    <td>{{ number_format($totalAmount, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_lab" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">BOQ Labour Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="imp_file1.php" method="POST" enctype="multipart/form-data">
                <input hidden type="text" name="project_id" value=">">
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="exc_lab" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" name="import_lab" class="modalbtn">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2input').select2();  // Apply Select2 to your select element
    });
</script>
<script>
    $(document).ready(function() {
        $('#boq_act_code').change(function() {
            var selectedOption = $(this).find('option:selected');

            // Retrieve the description from the selected option's data attribute
            var description = selectedOption.data('des');

            // Set the description in the textarea
            $('#desp').val(description);
        });
    });
</script>
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
        initTable('#table8', '#headerDropdown8', '#filterInput8');
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
</script>

<script>
    function calculateAmount() {
        let qty = parseFloat(document.getElementById('qty').value) || 0;
        let rate = parseFloat(document.getElementById('rate').value) || 0;

        let amount = qty * rate;
        document.getElementById('amt').value = amount.toFixed(2);

        calculateGST(amount);
    }

    function calculateGST(amount) {
        let gst = parseFloat(document.getElementById('gst').value) || 0;

        let gstAmount = (amount * gst) / 100;
        let gross = amount + gstAmount;

        document.getElementById('gross').value = gross.toFixed(2);
    }

    document.getElementById('qty').addEventListener('input', calculateAmount);
    document.getElementById('rate').addEventListener('input', calculateAmount);
    document.getElementById('gst').addEventListener('input', function() {
        let amount = parseFloat(document.getElementById('amt').value) || 0;
        calculateGST(amount);
    });
</script>
<style>
    .swal2-toast .swal2-title.toast-title {
        color: rgb(244, 239, 239) !important; /* Ensures the text is black */
    }
</style>
<script>
    $(document).ready(function () {
        $('.myForm1').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize();


            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('projects_boq_labour.sa') }}',
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
