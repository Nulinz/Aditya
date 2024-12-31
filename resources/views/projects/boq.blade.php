@include('layouts.header')



<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord1">
                <h4 class="m-0">BOQ</h4>
            </button>
        </h2>
        <div id="accord1" class="accordion-collapse collapse">
            <div class="accordion-body maindiv">
                <form action="" method="post" class="myForm1">
                    @csrf
                    <div class="container-fluid px-1">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="activitycode">BOQ Code <span>*</span></label>
                                <input name="pro_id" type="hidden" value="{{ $projectId }}" class="form-control">

                                <input type="text" class="form-control" name="code" id="activitycode"
                                    placeholder="Enter Activity Code" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqdesp">BOQ Description <span>*</span></label>
                                <textarea class="form-control" rows="1" name="des" id="boqdesp" placeholder="Enter BOQ Description"
                                    required></textarea>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="despworkmaterial">Description of Work/Material</label>
                                <input type="text" class="form-control" name="description" id="despworkmaterial"
                                    placeholder="Enter Description of Work/Material">
                            </div>
                            @php
                                $unit = DB::table('units')->select('id', 'unit')->where('status', 1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="unit">Unit <span>*</span></label>
                                <select class="form-select" name="unit" required>
                                    <option value="" selected disabled>Select Unit</option>
                                    @foreach ($unit as $units)
                                        <option value="{{ $units->id }}">{{ $units->unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="qty">Quantity <span>*</span></label>
                                <input type="number" class="form-control" name="qty" id="q_boq" min="0"
                                    placeholder="Enter Quantity" oninput="sumAmounts()" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqrate">BOQ Rate <span>*</span></label>
                                <input type="number" class="form-control" name="boq_rate" value="0" id="boq_rate"
                                    min="0" placeholder="Enter BOQ Rate" oninput="sumAmounts()" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="zerocostrate">Zero Cost Rate <span>*</span></label>
                                <input type="number" class="form-control" name="zero_rate" value="0"
                                    id="zero_rate" min="0" placeholder="Enter Zero Cost Rate"
                                    oninput="sumAmounts()" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqamt">BOQ Amount</label>
                                <input type="number" class="form-control" name="boq_amount" id="amount_boq"
                                    value="0" min="0" readonly>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="zerocostamt">Zero Cost Amount</label>
                                <input type="number" class="form-control" name="zero_amount" id="amount_zero"
                                    value="0" min="0" readonly>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" rows="1" name="remarks" id="remarks" placeholder="Enter Remarks"></textarea>
                            </div>
                        </div>
                        <div
                            class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                            <button type="submit" id="sub" class="formbtn">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@php
    $boqs = DB::table('boqs')
        ->leftJoin('units', 'boqs.unit', '=', 'units.id')
        ->where('boqs.pro_id', $projectId)
        ->where('boqs.status', 1)
        ->orderByDesc('boqs.id')
        ->select('boqs.*', 'units.unit as unit_name')
        ->get();

    $boq_amount1 = 0;
    $zero_amount1 = 0;

    foreach ($boqs as $d_boq) {
        // Use unit_name directly since it's already selected in the query
    $unit_name = $d_boq->unit_name ?? 'N/A';

    $boq_amount1 += (float) str_replace(',', '', $d_boq->boq_amount);
    $zero_amount1 += (float) str_replace(',', '', $d_boq->zero_amount);
    }
@endphp

<!-- Table -->
<div class="container-fluid mt-2 listtable">
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select id="headerDropdown2" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput2" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="{{ route('boq.export', ['projectId' => $projectId]) }}" id="export"><i
                        class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_boq" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>BOQ Code</th>
                    <th>BOQ Description</th>
                    <th>Description of Work/Material</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>BOQ Rate</th>
                    <th>Zero Rate</th>
                    <th>BOQ Amount</th>
                    <th>Zero Amount</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($boqs as $index => $d_boq)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $d_boq->code }}</td>
                        <td>{{ $d_boq->des }}</td>
                        <td>{{ $d_boq->description }}</td>
                        <td>{{ $d_boq->unit_name ?: 'No Unit' }}</td>
                        <td>{{ $d_boq->qty }}</td>
                        <td>{{ $d_boq->boq_rate }}</td>
                        <td>{{ $d_boq->zero_rate }}</td>
                        <td>{{ number_format($d_boq->boq_amount ?? 0, 2) }}</td>
                        <td>{{ number_format($d_boq->zero_amount ?? 0, 2) }}</td>
                        <td>{{ $d_boq->remarks }}</td>
                        <td>
                            <div class="d-flex gap-3">

                                <a href="{{ route('boq.edit', ['id' => $d_boq->id]) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a data-remote="{{ route('boq.destroy', ['id' => $d_boq->id]) }}"
                                    class="delete-confirm">
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
                    <td>{{ number_format($boq_amount1) }}</td>
                    <td>{{ number_format($zero_amount1) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_boq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">BOQ Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="{{ route('boq.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input hidden type="text" name="pro_id" value="{{ $projectId }}">
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                    <form class="row">
                        <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                            <label for="file">File</label>
                            <input type="file" name="boq_file" class="form-control" id="file">
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
        initTable('#table2', '#headerDropdown2', '#filterInput2');
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
        color: rgb(244, 239, 239) !important;
        /* Ensures the text is black */
    }
</style>
<script>
    $(document).ready(function() {
        $('.myForm1').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();


            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('projects_boq.sa') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal
                            .stopTimer);
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer);
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
                error: function(xhr, status, error) {
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
