@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="sidebodydiv">
        <div class="sidebodyback my-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Material Master</h6>
            </div>
        </div>

        <form action="" method="post" class="myForm1">
            @csrf
            <div class="accordion" id="accordionExample">
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accord9">
                            <h4 class="m-0">Material Master</h4>
                        </button>
                    </h2>
                    <div id="accord9" class="accordion-collapse collapse">
                        <div class="accordion-body maindiv">
                            <div class="container-fluid px-1">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="itemcode">Project <span>*</span></label>
                                        <select class="form-select select2input" name="pro_id" id="project" required>
                                            <option value="" selected true disabled>Select Options</option>
                                            @foreach ($project as $projects)
                                                <option value="{{$projects->id}}">{{$projects->pro_title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="itemcode">Item Code <span>*</span></label>
                                        <input type="text" class="form-control" name="item_code" id="itemcode"
                                            placeholder="Enter Item Code" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="desp">Description</label>
                                        <textarea class="form-control" rows="1" name="des" id="desp"
                                            placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                                <div
                                    class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">

                                    <button type="submit" id="submitBtn" class="formbtn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="container-fluid mt-2 listtable">
            <div class="filter-container row mb-3">
                <div class="custom-search-container col-sm-12 col-md-8">
                    <select class="headerDropdown form-select filter-option">
                        <option value="All" selected>All</option>
                    </select>
                    <input type="text" id="customSearch" class="form-control filterInput" placeholder=" Search">
                </div>
                <div class="select1 col-sm-12 col-md-4 mx-auto">
                    <div class="d-flex gap-3">
                        <a href="{{route('material.export')}}" id="export" data-bs-toggle="tooltip" data-bs-title="Export"><i
                                class="fa-solid fa-file-export"></i></a>
                        <a href="" id="import" data-bs-toggle="modal" data-bs-target="#import_matmaster"><i
                                class="fa-solid fa-file-import"></i></a>
                    </div>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="example table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Item Code</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($material as $materials)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$materials->pro_title}}</td>
                                <td>{{$materials->item_code}}</td>
                                <td>{{$materials->des}}</td>
                                <td>
                                    <div class="d-flex gap-3">

                                        <a href="{{ route('material.edit', ['id' => $materials->id]) }}">
                                            <i class="fa-solid fa-pen-to-square" data-bs-toggle="tooltip" data-bs-title="Edit"></i>
                                        </a>
                                        <a data-remote="{{ route('material.destroy', ['id' => $materials->id]) }}" class="delete-confirm">
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

    </div>

     <!-- Popup -->
     <div class="modal fade" id="import_matmaster" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Material Master Import</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row" action="{{route('material.import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input hidden type="text" name="project_id" >
                    <div class="modal-body">
                        <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                        <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                            <label for="file">File</label>
                            <input type="file" class="form-control" name="material_file" id="file">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit" name="import_material" class="modalbtn">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup -->
    <div class="modal fade" id="import_mat_master" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Material Master Import</h4>
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
            $('.myForm1').on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();

                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route('material.save') }}',
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

                            setTimeout(function() {
                                window.location.href = '{{route('material.index')}}';
                            }, 1000);

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
@endsection
