@include('layouts.header')


<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord3">
                <h4 class="m-0">Hire</h4>
            </button>
        </h2>
        <div id="accord3" class="accordion-collapse collapse">
            <div class="accordion-body maindiv">
                <div class="container-fluid px-1">
                    <form action="" method="post" class="myForm1" >
                        @csrf
                        <input hidden name="pro_id" type="text" value="{{$projectId }}" class="form-control">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="hire_date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                                   required>
                            </div>
                            @php
                                $boq=DB::table('boqs')->select('id','code','des')->where('pro_id',$projectId)->where('status',1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqcode">BOQ Code <span>*</span></label>
                                <select class="form-select select2input" name="code" id="boq_act_code" required onchange="updateDescription()">
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($boq as $boqs)
                                        <option value="{{ $boqs->id }}" data-des="{{ $boqs->des }}" >{{ $boqs->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="desp">Description</label>
                                <textarea class="form-control" rows="1" name="des" id="desp"
                                    placeholder="Enter Description" readonly></textarea>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="billno">Bill No <span>*</span></label>
                                <input type="text" class="form-control" name="bill" id="billno"
                                    placeholder="Enter Bill No" required>
                            </div>
                            @php
                                $vendors=DB::table('vendors')->select('id','v_name','type')->where('type', 'contractor')->where('pro_id',$projectId)->where('status',1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="contractorname">Contractor Name <span>*</span></label>
                                <select class="form-select select2input" name="con_name" id="contractorname" required>
                                    <option value="" selected true>Select Options</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" >{{ $vendor->v_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                                $assets=DB::table('asset_codes')->select('id','des','asset_code')->where('pro_id',$projectId)->where('status',1)->get();
                            @endphp
                             <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="assetcode">Asset Code<span>*</span></label>
                                <select class="form-select select2input assetcode" name="a_code" id="assetcode" required onchange="updateDes()">
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($assets as $asset)
                                        <option value="{{ $asset->id }}" data-assetdes="{{ $asset->des }}" >{{ $asset->asset_code}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="assettype">Asset Description<span>*</span></label>
                                <input type="text" class="form-control" name="type" id="asset"
                                    placeholder="Enter Type Of Asset" required readonly>
                            </div>
                            @php
                                $unit=DB::table('units')->select('id','unit')->where('status',1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="unit">Unit <span>*</span></label>

                                <select class="form-select" name="unit" required>
                                    <option value="" selected true>Select Options</option>
                                    @foreach ($unit as $units)
                                    <option value="{{$units->id}}">{{$units->unit}}</option>
                                 @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="qty">Quantity <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control"
                                       name="qty"
                                       id="qty"
                                       min="0"
                                       placeholder="Enter Quantity"
                                       value="0"
                                       oninput="calculateTotals()"
                                       required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="rate">Rate <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control"
                                       name="u_rate"
                                       id="rate"
                                       min="0"
                                       placeholder="Enter Rate"
                                       value="0"
                                       oninput="calculateTotals()"
                                       required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="amt">Amount</label>
                                <input type="number"
                                       class="form-control"
                                       name="amount"
                                       id="amt"
                                       placeholder="Enter Amount"
                                       value="0"
                                       readonly>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gst">GST (%) <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control"
                                       name="gst"
                                       id="gst"
                                       placeholder="Enter GST"
                                       value="0"
                                       oninput="calculateTotals()"
                                       required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gross">Gross</label>
                                <input type="number"
                                       class="form-control"
                                       name="gross"
                                       id="gross"
                                       placeholder="Enter Gross"
                                       value="0"
                                       readonly>
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

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="container-fluid mt-2 listtable">
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select id="headerDropdown4" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput4" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_hire" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>BOQ Code</th>
                    <th>Description</th>
                    <th>Bill No</th>
                    <th>Contrator name</th>
                    <th>Asset Code</th>
                    <th>Asset Description</th>
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
                @php
                    $hires = DB::table('hires')
                        ->leftJoin('units', 'hires.unit', '=', 'units.id')
                        ->leftJoin('vendors', 'hires.con_name', '=', 'vendors.id')
                        ->leftJoin('asset_codes', 'hires.a_code', '=', 'asset_codes.id')
                        ->where('hires.pro_id', $projectId)
                        ->where('hires.status', 1)
                        ->orderByDesc('hires.id')
                        ->select(
                            'hires.*',
                            'units.unit as unit_name',
                            'vendors.v_name as vendor_name',
                            'asset_codes.asset_code as asset_code',
                            'asset_codes.des as asset_description'
                        )
                        ->get();

                    $totalAmount = 0;
                @endphp

                @foreach ($hires as $index => $hire)
                    @php
                        $hireAmount = (float) str_replace(',', '', $hire->amount);
                        $totalAmount += $hireAmount;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d-m-Y', strtotime($hire->hire_date)) }}</td>
                        <td>{{ $hire->code }}</td>
                        <td>{{ $hire->des ?? 'No data' }}</td>
                        <td>{{ $hire->bill }}</td>
                        <td>{{ $hire->vendor_name ?? 'No data' }}</td>
                        <td>{{ $hire->asset_code ?? 'No code' }}</td>
                        <td>{{ $hire->asset_description ?? 'No data' }}</td>
                        <td>{{ $hire->unit_name ?? 'No data' }}</td>
                        <td>{{ $hire->qty }}</td>
                        <td>{{ number_format($hire->u_rate, 2) }}</td>
                        <td>{{ number_format($hireAmount, 2) }}</td>
                        <td>{{ $hire->gst }}</td>
                        <td>{{ $hire->gross }}</td>
                        <td>{{ $hire->remark }}</td>
                        <td>

                            <div class="d-flex gap-3">
                                <!-- Edit Link -->
                                <a href="{{ route('hire.edit', $hire->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete Link -->
                                @if (Auth::user()->emp_desg == 'Admin')

                                    <a data-remote="{{ route('hire.destroy', ['id' => $hire->id]) }}" class="delete-confirm">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </a>
                                @endif

                            </div>

                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td>Total</td>
                    <td colspan="10"></td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                    <td colspan="4"></td>
                </tr>
            </tbody>

        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_hire" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Hire Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="{{route('hire.import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input hidden type="text" name="project_id" value="{{$projectId}}">
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>

                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="hire_file" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" class="modalbtn">Import</button>
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
        initTable('#table4', '#headerDropdown4', '#filterInput4');
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2input').select2({
            placeholder: "Select Options",
            allowClear: true,
            width: '100%'
        }).prop('required', true);

            $('#assetcode').on('change', function(){
                    $('#assettype').val($(this).find('option:selected').data('des'));
            });

            $('#boq_act_code').on('change', function(){

                    $('#desp').val($(this).find('option:selected').data('des'));
            });
    })
</script>

<style>
    .swal2-toast .swal2-title.toast-title {
        color: rgb(244, 239, 239) !important; /* Ensures the text is black */
    }
</style>
<script>
    function calculateTotals() {
        const qty = parseFloat(document.getElementById('qty').value) || 0;
        const rate = parseFloat(document.getElementById('rate').value) || 0;
        const gst = parseFloat(document.getElementById('gst').value) || 0;

        const amount = qty * rate;
        document.getElementById('amt').value = amount.toFixed(2);

        const gross = amount + (amount * gst / 100);
        document.getElementById('gross').value = gross.toFixed(2);
    }
</script>
<script>
    $(document).ready(function () {
        $('.myForm1').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize();

            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('projects_hire.sa') }}',
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
    function updateDescription() {
    const boqCodeSelect = document.getElementById('boq_act_code');
    const selectedOption = boqCodeSelect.options[boqCodeSelect.selectedIndex];


    const des = selectedOption.getAttribute('data-des');
    document.getElementById('desp').value = des || '';
}



</script>

<script>
    function updateDes() {
    const assetCodeSelect = document.getElementById('assetcode');
    const selectedOption = assetCodeSelect.options[assetCodeSelect.selectedIndex];


    const asset_des = selectedOption.getAttribute('data-assetdes');

    document.getElementById('asset').value = asset_des || '';
}
</script>
@include('layouts.footer')
