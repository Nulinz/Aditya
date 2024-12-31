
@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord2">
                <h4 class="m-0">Progress Sales Rate</h4>
            </button>
        </h2>
        <div id="accord2" class="accordion-collapse collapse">
            <div class="accordion-body maindiv">
                <div class="container-fluid px-1">
                    <form action="" method="post" class="myForm1" >
                        @csrf
                        <input hidden name="pro_id" type="text" value="{{$projectId }}" class="form-control">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="pro_date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                                     required>
                            </div>
                            @php
                                $boq=DB::table('boqs')->select('id','code','description','des')->where('pro_id',$projectId)->where('status',1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqcode">BOQ Code <span>*</span></label>
                                <select class="form-select select2input" name="code" id="boq_act_code" required onchange="updateDescription()">
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($boq as $boqs)
                                        <option value="{{ $boqs->id }}" data-des="{{ $boqs->des }}" data-description="{{ $boqs->description }}">{{ $boqs->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqdesp">BOQ Description</label>
                                <textarea class="form-control" rows="1" name="des" id="boq_desc"
                                    placeholder="Enter BOQ Description" readonly></textarea>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="despworkmaterial">Description of Work/Material</label>
                                <input type="text" class="form-control" name="work" id="boq_work"
                                    placeholder="Enter Description of Work/Material" readonly>
                            </div>
                            @php
                                $unit=DB::table('units')->select('id','unit')->where('status',1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="unit">Unit <span>*</span></label>
                                <select class="form-select" name="unit" required>
                                    <option value="" selected disabled>Select Unit</option>
                                    @foreach ($unit as $units)
                                           <option value="{{$units->id}}">{{$units->unit}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="qty">Quantity <span>*</span></label>
                                <input type="number" class="form-control" name="qty" id="q_boq" min="0" placeholder="Enter Quantity" oninput="sumAmounts()" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqrate">BOQ Rate <span>*</span></label>
                                <input type="number" class="form-control" name="pro_sale_rate" value="0" id="boq_rate" min="0" placeholder="Enter BOQ Rate" oninput="sumAmounts()" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="zerocostrate">Zero Cost Rate <span>*</span></label>
                                <input type="number" class="form-control" name="pro_zero_rate" value="0" id="zero_rate" min="0" placeholder="Enter Zero Cost Rate" oninput="sumAmounts()" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqamt">BOQ Amount</label>
                                <input type="number" class="form-control" name="pro_sale_amt" id="amount_boq" value="0" min="0" readonly>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="zerocostamt">Zero Cost Amount</label>
                                <input type="number" class="form-control" name="pro_zero_amt" id="amount_zero" value="0" min="0" readonly>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" rows="1" name="remarks" id="remarks"
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
            <select id="headerDropdown3" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput3" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <!-- //export -->
                <a href="{{route('process.export',['projectId'=>$projectId])}}" id="export"><i
                        class="fa-solid fa-file-export"></i></a>
                <!-- import -->
                <a data-bs-toggle="modal" data-bs-target="#import_pro_sales" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>
    @php
    $projectSales = DB::table('project_sales')
        ->leftJoin('boqs', 'project_sales.code', '=', 'boqs.id')
        ->leftJoin('units', 'project_sales.unit', '=', 'units.id')
        ->where('project_sales.pro_id', $projectId)
        ->where('project_sales.status', 1)
        ->orderByDesc('project_sales.id')
        ->select('project_sales.*', 'units.unit as unit_name','boqs.code')
        ->get();

    $zeroAmountTotal = 0;
    $saleAmountTotal = 0;

    foreach ($projectSales as $sale) {
        // Process amounts and ensure they're floats
        $zeroAmount = (float) str_replace(',', '', $sale->pro_zero_amt ?? 0);
        $saleAmount = (float) str_replace(',', '', $sale->pro_sale_amt ?? 0);

        $zeroAmountTotal += $zeroAmount;
        $saleAmountTotal += $saleAmount;

        // Use unit_name or fallback to 'N/A'
        $unitName = $sale->unit_name ?? 'N/A';
    }
@endphp

    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>BOQ Code</th>
                    <th>BOQ Description</th>
                    <th>Description of Work/ Material</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Sales Rate</th>
                    <th>Zero Rate</th>
                    <th>Sales Amount</th>
                    <th>Zero Amount</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectSales as $items)

                    <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ \Carbon\Carbon::parse($items->pro_date)->format('d-m-Y') }}</td>
                            <td>{{ $items->code }}</td>
                            <td>{{ $items->des ?? 'No data' }}</td>
                            <td>{{ $items->work ?? 'No data' }}</td>
                            <td>{{ $items->unit_name ?? 'N/A' }}</td>
                            <td>{{ $items->qty ?? 0 }}</td>
                            <td>{{ $items->pro_sale_rate ?? 0 }}</td>
                            <td>{{ $items->pro_zero_rate ?? 0 }}</td>
                            <td>
                                {{ number_format($items->pro_sale_amt ?? 0) }}
                            </td>
                            <td>
                                {{ number_format($items->pro_zero_amt ?? 0) }}
                            </td>
                            <td>{{ $items->remarks ?? '' }}</td>
                            <td>
                                <div class="d-flex gap-3">

                                    <a href="{{ route('sales.edit', ['id' => $items->id]) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a data-remote="{{ route('sales.destroy', ['id' => $items->id]) }}" class="delete-confirm">
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
                    <td></td>
                    <td>{{number_format($saleAmountTotal)}}</td>
                    <td>{{number_format($zeroAmountTotal)}}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_pro_sales" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Progress Sales Zero Cost Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="{{route('process.import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input hidden type="text" name="pro_id" value="{{$projectId}}">

                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a
                            href=""
                            download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="process_file" id="file">
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
    $(document).ready(function () {
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

            $(tableId + ' thead th').each(function (index) {
                var headerText = $(this).text();
                if (headerText != "" && headerText.toLowerCase() != "action") {
                    $(dropdownId).append('<option value="' + index + '">' + headerText + '</option>');
                }
            });

            $(filterInputId).on('keyup', function () {
                var selectedColumn = $(dropdownId).val();
                if (selectedColumn !== 'All') {
                    table.column(selectedColumn).search($(this).val()).draw();
                } else {
                    table.search($(this).val()).draw();
                }
            });

            $(dropdownId).on('change', function () {
                $(filterInputId).val('');
                table.search('').columns().search('').draw();
            });

            $(filterInputId).on('keyup', function () {
                table.search($(this).val()).draw();
            });

        }

        // Initialize each table
        initTable('#table3', '#headerDropdown3', '#filterInput3');
    });
</script>

<script>
    $(document).ready(function () {
        $('.select2input').select2({
            placeholder: "Select Options",
            allowClear: true,
            width: '100%'
        }).prop('required', true);

        $('.select2input').on('change',function(){


            $('#boq_desc').val($(this).find('option:selected').data('des'));
            $('#boq_work').val($(this).find('option:selected').data('work'));
            $('#boq_rate').val($(this).find('option:selected').data('brate'));
            $('#zero_rate').val($(this).find('option:selected').data('zrate'));
        });
    })
</script>

<script>
    function updateDescription() {
    const boqCodeSelect = document.getElementById('boq_act_code');
    const selectedOption = boqCodeSelect.options[boqCodeSelect.selectedIndex];
    const description = selectedOption.getAttribute('data-description');
    document.getElementById('boq_desc').value = description || '';

    const des = selectedOption.getAttribute('data-des');
    document.getElementById('boq_work').value = des || '';
}

</script>

<script>
    function sumAmounts() {
        var qty = parseFloat(document.getElementById('q_boq').value) || 0;
        var boqRate = parseFloat(document.getElementById('boq_rate').value) || 0;
        var zeroRate = parseFloat(document.getElementById('zero_rate').value) || 0;

        var boqAmount = qty * boqRate;
        var zeroAmount = qty * zeroRate;

        document.getElementById('amount_boq').value = boqAmount.toFixed(2);
        document.getElementById('amount_zero').value = zeroAmount.toFixed(2);
    }
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

            const formData = $(this).serialize();


            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('projects_sales.sa') }}',
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
@include('layouts.footer')
