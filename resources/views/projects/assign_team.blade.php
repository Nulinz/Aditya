@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord12">
                <h4 class="m-0">Assign Team</h4>
            </button>
        </h2>
        <form action="" method="post" class="myForm1" >
            @csrf
            <input hidden name="pro_id" type="text" value="{{$projectId}}" class="form-control">
            <div id="accord12" class="accordion-collapse collapse">
                <div class="accordion-body maindiv">
                    <div class="container-fluid px-1">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="assign_date" id="date"
                                     pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31"
                                    required>
                            </div>
                            @php
                              $employee = DB::table('users')->where('status', 1)->get();

                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="employee">Select Team Member<span>*</span></label>
                                <select class="form-select select2input" name="mb_id" id="employee" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($employee as $employees)
                                       <option value="{{$employees->id}}">{{$employees->vemp_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                                $desgination=DB::table('destinations')->where('status',1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="designation">Select Designation <span>*</span></label>
                                <select class="form-select" name="desg" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($desgination as $des)
                                       <option value="{{$des->id}}">{{$des->designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="access">Access <span>*</span></label>
                                <select class="form-select" name="emp_access" id="access" required>
                                    <option value="" selected disabled>Select Options</option>
                                    <option value="Create">Create</option>
                                    <option value="Recommend">Recommend</option>
                                    <option value="Verify">Verify</option>
                                    <option value="Approve">Approve</option>
                                </select>
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

<!-- Table -->
<div class="container-fluid mt-2 listtable">
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select id="headerDropdown13" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput13" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <!-- <a data-bs-toggle="modal" data-bs-target="#import_assignteam" id="import"><i
                        class="fa-solid fa-file-import"></i></a> -->
            </div>
        </div>
    </div>
    @php

        $assgin_team = DB::table('project_teams')
                    ->leftJoin('destinations', 'project_teams.desg', '=', 'destinations.id')
                    ->leftJoin('users', 'project_teams.mb_id', '=', 'users.id')
                    ->where('project_teams.pro_id', $projectId)
                    ->where('project_teams.status', 1)
                    ->orderByDesc('project_teams.id')
                    ->select('project_teams.*', 'destinations.designation','users.vemp_name')
                    ->get();
    @endphp
    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table13">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <!-- <th>Project Code</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($assgin_team as $team)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$team->assign_date}}</td>
                            <td>{{$team->vemp_name}}</td>
                            <td>{{$team->designation}}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('assgin_team.edit', $team->id) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <a data-remote="{{ route('assgin_team.destroy', ['id' => $team->id]) }}" class="delete-confirm">
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
<div class="modal fade" id="import_assignteam" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Assign Team Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                <form class="row">
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="file" id="file">
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center align-items-center">
                <button type="button" class="modalbtn">Import</button>
            </div>
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
        initTable('#table13', '#headerDropdown13', '#filterInput13');
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

<script>
    $(document).ready(function () {
        $('.myForm1').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize();


            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('projects_assgin_team.sa') }}',
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
