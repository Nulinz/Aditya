@extends('layouts.app')
@section('content')

<div class="sidebodydiv">
    <div class="sidebodyback my-3" onclick="goBack()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Unit</h6>
        </div>
    </div>

    
    <form action="" method="post" class="myForm1">
        @csrf
        <div class="accordion" id="accordionExample">
            <div class="accordion-item mt-3">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#accord1">
                        <h4 class="m-0">Unit</h4>
                    </button>
                </h2>
                <div id="accord1" class="accordion-collapse collapse">
                    <div class="accordion-body maindiv">
                        <div class="container-fluid px-1">
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="type">Type <span>*</span></label>
                                    <input type="text" class="form-control" name="unit" id="prjtcode"
                                        placeholder="Enter Type" autofocus required>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                    <label for="desp">Description <span>*</span></label>
                                    <textarea class="form-control" rows="1" name="des" id="desp"
                                        placeholder="Enter Description" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                                <button type="submit" id="sub" class="formbtn">Save</button>
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
            <!-- <div class="select1 col-sm-12 col-md-4 mx-auto">
                <div class="d-flex gap-3">
                    <a href="" data-bs-toggle="tooltip" data-bs-title="Export" id="export"><i
                            class="fa-solid fa-file-export"></i></a>
                    <a href="" data-bs-toggle="tooltip" data-bs-title="Import" id="import"><i
                            class="fa-solid fa-file-import"></i></a>
                </div>
            </div> -->
        </div>

        <div class="table-wrapper">
            <table class="example table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Unit Type</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unit as $units)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$units->unit}}</td>
                            <td>{{$units->des}}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a class="edit-btn" data-bs-toggle="modal" data-bs-target="#modal1" data-id="{{ $units->id }}">
                                        <i class="fa-solid fa-pen-to-square" data-bs-toggle="tooltip" data-bs-title="Edit"></i>
                                    </a>
                                    <a data-remote="{{ route('unit.destroy', ['id' => $units->id]) }}" class="delete-confirm">
                                        <i class="fa-solid fa-trash text-danger" data-bs-toggle="tooltip" data-bs-title="Delete"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Popup -->
        <div class="modal fade" id="modal1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="exampleModalLabel">Update Unit</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="unitForm" class="row">
                            @csrf
                            <input type="hidden" id="unit_id" name="unit_id"> 
        
                            <div class="col-sm-12 col-md-6 col-xl-6 mb-3">
                                <label for="type">Type <span>*</span></label>
                                <input type="text" class="form-control" name="unit" id="type" placeholder="Enter Type" autofocus required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6 mb-3">
                                <label for="desp">Description <span>*</span></label>
                                <textarea class="form-control" rows="1" name="des" id="descr" placeholder="Enter Description" required></textarea>
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
            var unitId = $(this).data('id');
            var unit = row.find('td').eq(1).text();
            var description = row.find('td').eq(2).text();

            $('#unit_id').val(unitId);
            $('#type').val(unit);
            $('#descr').val(description);

            $('#modal1').modal('show');
        });

        $('#unitForm').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize(); 

            const csrfToken = $('meta[name="csrf-token"]').attr('content'); 

            var unitId = $('#unit_id').val(); 
            var actionUrl = '{{ route('units.update', ':id') }}'.replace(':id', unitId);

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
                    window.location.href = '{{route('unit.index')}}'; 
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
            console.error('AJAX Error:', error);
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
                url: '{{ route('unit.save') }}',  
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
                            window.location.href = '{{route('unit.index')}}'; 
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
                    console.error('AJAX Error:', error);
                }
            });
        });
    });
</script>
@endsection