@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="sidebodydiv">
    <div class="sidebodyback mb-3" onclick="goBack()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Designation</h6>
        </div>
    </div>

    <form action="" method="post" class="myForm1" >
        @csrf
        <div class="accordion" id="accordionExample">
            <div class="accordion-item mt-3">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#accord1">
                        <h4 class="m-0">Designation</h4>
                    </button>
                </h2>
                <div id="accord1" class="accordion-collapse collapse">
                    <div class="accordion-body maindiv">
                        <div class="container-fluid px-1">
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="designation">Designation <span>*</span></label>
                                    <input type="text" class="form-control" name="designation"
                                        id="designation" placeholder="Enter Designation" autofocus required>
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

    <!-- <div class="sidebodyhead mt-4">
        <h4 class="m-0">In Process | <span class="txtgray">Designation List</span></span></h4>
    </div> -->

    <div class="container-fluid mt-3 listtable">
        <div class="filter-container row mb-3">
            <div class="custom-search-container col-sm-12 col-md-8">
                <select class="headerDropdown form-select filter-option">
                    <option value="All" selected>All</option>
                </select>
                <input type="text" id="customSearch" class="form-control filterInput" placeholder=" Search">
            </div>

            <div class="select1 col-sm-12 col-md-4 mx-auto">
                <div class="d-flex gap-3">
                    <a href="" id="print" data-bs-toggle="tooltip" data-bs-title="Print"><i
                            class="fa-solid fa-print"></i></a>
                    <a href="" id="excel" data-bs-toggle="tooltip" data-bs-title="Excel"><i
                            class="fa-solid fa-file-csv"></i></a>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="example table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Designation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($des as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->designation}}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#modal1" data-id="{{ $item->id }}">
                                        <i class="fa-solid fa-pen-to-square" data-bs-toggle="tooltip" data-bs-title="Edit"></i>
                                    </a>
                                    <a data-remote="{{ route('desgination.destroy', ['id' => $item->id]) }}" class="delete-confirm">
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
 <div class="modal fade" id="modal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Update Designation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="unitForm" class="row">
                    @csrf
                    <input type="hidden" id="des_id" name="des_id"> 

                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="designation" class="col-form-label">Designation <span>*</span></label>
                        <input type="text" class="form-control" id="des" placeholder="Enter Designation"
                            required>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit" id="sub" class="modalbtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 

<script>
    $(document).ready(function () {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.edit-btn').on('click', function () {
            var row = $(this).closest('tr');
            var desId = $(this).data('id');
            var designation = row.find('td').eq(1).text();

            $('#des_id').val(desId);
            $('#des').val(designation);

            $('#modal1').modal('show');
        });

        $('#unitForm').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize(); 

            const csrfToken = $('meta[name="csrf-token"]').attr('content'); 

            var desId = $('#des_id').val(); 
            var actionUrl = '{{ route('desgination.update', ':id') }}'.replace(':id', desId);

            $.ajax({
                url: actionUrl,
                type: 'post', 
                data: formData, 
                headers: {
                    'X-CSRF-TOKEN': csrfToken  
                },
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
                    window.location.href = '{{route('desgination.index')}}'; 
                }, 1000);  

                $('#modal1').modal('hide'); 
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
    $(document).ready(function () {
        $('.myForm1').on('submit', function (e) {
            e.preventDefault();  

            const formData = $(this).serialize(); 

            const csrfToken = $('meta[name="csrf-token"]').attr('content');  

            $.ajax({
                url: '{{ route('desgination.save') }}',  
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
                            window.location.href = '{{route('desgination.index')}}'; 
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