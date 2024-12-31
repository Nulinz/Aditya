@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord5">
                <h4 class="m-0">Add Petty Cash</h4>
            </button>
        </h2>
        <div id="accord5" class="accordion-collapse collapse">
            <div class="accordion-body maindiv">
                <div class="container-fluid px-1">
                    <form action="" method="post" class="myForm1" >
                        @csrf
                        <input hidden name="pro_id" type="text" value="{{$projectId}}" class="form-control">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date"  class="form-control" name="date" id="date" pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                                     required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="amt">Amount <span>*</span></label>
                                <input type="number" class="form-control" name="amount" id="amt" min="0" required>
                            </div>
                            @php
                              $employee = DB::table('users')->where('status', 1)->get();

                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="employee">Select Employee <span>*</span></label>
                                <select class="form-select select2input" name="emp_id" id="employee" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($employee as $employees)
                                       <option value="{{$employees->id}}">{{$employees->vemp_name}}</option>
                                    @endforeach
                                </select>
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
            <select id="headerDropdown6" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput6" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_add_petty" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table6">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Employee</th>
                    <th>Action</th>
                </tr>
            </thead>
            @php
                $petty_cash = DB::table('petty_cashes')
                    ->leftJoin('users', 'petty_cashes.emp_id', '=', 'users.id')
                    ->where('petty_cashes.pro_id', $projectId)
                    ->where('petty_cashes.status', 1)
                    ->orderByDesc('petty_cashes.id')
                    ->select(
                        'petty_cashes.*',
                        'users.vemp_name as emp_name'
                    )
                    ->get();
            @endphp
            <tbody>
                @foreach ($petty_cash as $cash)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ date('d-m-Y', strtotime($cash->date)) }}</td>
                        <td>{{$cash->amount}}</td>
                        <td>{{$cash->emp_name}}</td>
                        <td>
                            <div class="d-flex gap-3">
                                <!-- Edit Link -->
                                <a href="{{ route('pettycash.edit', $cash->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete Link -->
                                <a data-remote="{{ route('pettycash.destroy', ['id' => $cash->id]) }}" class="delete-confirm">
                                    <i class="fa-solid fa-trash text-danger" data-bs-toggle="tooltip" data-bs-title="Delete"></i>
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
<div class="modal fade" id="import_add_petty" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Add Petty Cash Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="imp_file1.php" method="POST" enctype="multipart/form-data">
            <input hidden type="text" name="project_id" value="">
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="exc_add_petty" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" name="import_add_petty" class="modalbtn">Import</button>
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
        initTable('#table6', '#headerDropdown6', '#filterInput6');
    });
</script>

<script>
    $(document).ready(function () {
        $('.select2input').select2({
            placeholder: "Select Options",
            allowClear: true,
            width: '100%'
        }).prop('required', true);
    })
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
                url: '{{ route('projects_pettycash.sa') }}',
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
