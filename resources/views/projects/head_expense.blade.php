@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord10">
                <h4 class="m-0">Overhead Expense</h4>
            </button>
        </h2>
        <form action="" method="post" class="myForm1">
            @csrf
            <input hidden name="pro_id" type="text" value="{{$projectId}}" class="form-control">
            <div id="accord10" class="accordion-collapse collapse">
                <div class="accordion-body maindiv">
                    <div class="container-fluid px-1">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="head_date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                                     required>
                            </div>
                            @php
                                $headcode=DB::table('overheads')->where('pro_id',$projectId)->where('status',1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="hmcode">Head Master Code <span>*</span></label>
                                <select class="form-select select2input" name="boq_code" id="boq_act_code" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($headcode as $items)
                                        <option value="{{$items->id}}">
                                            {{$items->item_code}}
                                        </option>
                                    @endforeach

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
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="desp">Activity Description</label>
                                <textarea class="form-control" rows="1" name="des" id="desp"
                                    placeholder="Enter Activity Description"></textarea>
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
                                <input type="number" class="form-control" name="qty" id="qty" min="0" placeholder="Enter Quantity"
                                    oninput="updateAmountAndGross()" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="rate">Rate <span>*</span></label>
                                <input type="number" class="form-control" name="rate" id="rate" min="0" placeholder="Enter Rate"
                                    oninput="updateAmountAndGross()" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="amt">Amount</label>
                                <input type="number" class="form-control" name="amt" id="amt" min="0" placeholder="Enter Amount" readonly
                                    value="0">
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gst">GST (%) <span>*</span></label>
                                <input type="number" class="form-control" name="gst" id="gst" placeholder="Enter GST"
                                    oninput="updateGross()" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gross">Gross <span>*</span></label>
                                <input type="number" class="form-control" name="gross" id="gross" min="0" placeholder="Enter Gross"
                                    readonly value="0" required>
                            </div>
                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" rows="1" name="remark" id="remarks"
                                        placeholder="Enter Remarks"></textarea>
                                </div>
                        </div>
                        <div class=" col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center
                                    align-items-center">
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
            <select id="headerDropdown11" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput11" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_headexpense" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>
    @php
    $head_expenses = DB::table('head_expenses')
    ->leftJoin('units', 'head_expenses.uom', '=', 'units.id')
    ->leftJoin('overheads', 'head_expenses.boq_code', '=', 'overheads.id')
    ->leftJoin('vendors', 'head_expenses.v_name', '=', 'vendors.id')
    ->where('head_expenses.pro_id', $projectId)
    ->where('head_expenses.status', 1)
    ->orderByDesc('head_expenses.id')
    ->select('head_expenses.*', 'units.unit as unit_name','vendors.v_name as vendor_name','overheads.item_code')
    ->get();

    $totalAmount=0;


@endphp
    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table11">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Head Master Code</th>
                    <th>Description</th>
                    <th>Vendor Name</th>
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
                @foreach ($head_expenses as $item)
                @php
                     $purAmount = (float) str_replace(',', '', $item->amt);
                     $totalAmount += $purAmount;
                @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ date('d-m-Y', strtotime($item->head_date)) }}</td>
                        <td>{{$item->item_code}}</td>
                        <td>{{$item->des}}</td>
                        <td>{{$item->vendor_name}}</td>
                        <td>{{$item->unit_name}}</td>
                        <td>{{$item->qty}}</td>
                        <td>{{$item->rate}}</td>
                        <td>{{$item->amt}}</td>
                        <td>{{$item->gst}}</td>
                        <td>{{$item->gross}}</td>
                        <td>{{$item->remark}}</td>
                        <td>
                            <div class="d-flex gap-3">
                                <!-- Edit Link -->
                                <a href="{{ route('head_expenses.edit', $item->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete Link -->
                                <a data-remote="{{ route('head_expenses.destroy', ['id' => $item->id]) }}" class="delete-confirm">
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
            </tbody>
        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_headexpense" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Over Head Expense Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="imp_file1.php" method="POST" enctype="multipart/form-data">
                <input hidden type="text" name="project_id" >
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="exc_overexp" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit"  name="import_exp" class="modalbtn">Import</button>
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
        initTable('#table11', '#headerDropdown11', '#filterInput11');
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
    function updateAmountAndGross() {
        const qty = parseFloat(document.getElementById('qty').value) || 0;
        const rate = parseFloat(document.getElementById('rate').value) || 0;
        const amount = qty * rate;

        document.getElementById('amt').value = amount.toFixed(2);

        updateGross();
    }

    function updateGross() {
        const amount = parseFloat(document.getElementById('amt').value) || 0;
        const gst = parseFloat(document.getElementById('gst').value) || 0;

        const gstAmount = amount * gst / 100;
        const gross = amount + gstAmount;

        document.getElementById('gross').value = gross.toFixed(2);
    }
</script>
<style>
    .swal2-toast .swal2-title.toast-title {
        color: rgb(236, 228, 228) !important; /* Ensures the text is black */
    }
</style>
<script>
    $(document).ready(function () {
        $('.myForm1').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize();


            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('projects_head_expenses.sa') }}',
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
