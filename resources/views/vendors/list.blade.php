@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="sidebodydi">
        <div class="sidebodyback my-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Vendor Master</h6>
            </div>
        </div>

        <form action="" method="post" class="myForm1" >
            @csrf
            <div class="accordion" id="accordionExample">
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accord1">
                            <h4 class="m-0">Vendor Master</h4>
                        </button>
                    </h2>
                    <div id="accord1" class="accordion-collapse collapse">
                        <div class="accordion-body maindiv">
                            <div class="container-fluid px-1">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="vendorcode">Project <span>*</span></label>
                                        <select class="form-select select2input" name="pro_id" id="project_name"
                                            required autofocus>
                                            <option value="" selected disabled>Select Values</option>
                                            @foreach ($project as $projects)
                                                <option value="{{$projects->id}}">{{$projects->pro_title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="date">Type <span>*</span></label>
                                        <select class="form-select" name="type" id="type"
                                            required autofocus>
                                            <option>vendor</option>
                                            <option>contractor</option>

                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="date">Date <span>*</span></label>
                                        <input type="date" class="form-control" name="ven_date" id="date"
                                            pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="vendorcode">Vendor Code <span>*</span></label>
                                        <input type="text" class="form-control" name="v_code" id="vendorcode"
                                            placeholder="Enter Vendor Code" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="vendorname">Vendor Name <span>*</span></label>
                                        <input type="text" class="form-control" name="v_name" id="vendorname"
                                            placeholder="Enter Vendor Name" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" rows="1" name="address" id="address"
                                            placeholder="Enter Address"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="gst">GST</label>
                                        <input type="text" class="form-control" name="gst" id="gst"
                                            placeholder="Enter GST">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="pan">Pan Card No <span>*</span></label>
                                        <input type="text" class="form-control" name="pan" id="pan"
                                            placeholder="Enter Pan Card No" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="aadhar">Aadhar Card No <span>*</span></label>
                                        <input type="number" class="form-control" name="aadhar" id="aadhar"
                                            oninput="validate_aadhar(this)" min="000000000000"
                                            max="999999999999" placeholder="Enter Aadhar Card No" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="bankname">Bank Name <span>*</span></label>
                                        <input type="text" class="form-control" name="bank" id="bankname"
                                            placeholder="Enter Bank Name" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="acctholder">Account Holder <span>*</span></label>
                                        <input type="text" class="form-control" name="ac_name"
                                            id="acctholder" placeholder="Enter Account Holder" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="bankacno">Bank A/C No <span>*</span></label>
                                        <input type="text" class="form-control" name="ac_no" id="bankacno"
                                            placeholder="Enter Bank A/C No" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="ifsccode">IFSC Code <span>*</span></label>
                                        <input type="text" class="form-control" name="ifsc" id="ifsccode"
                                            placeholder="Enter IFSC Code" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="branch">Branch <span>*</span></label>
                                        <input type="text" class="form-control" name="branch" id="branch"
                                            placeholder="Enter Branch" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="mobile">Mobile Number <span>*</span></label>
                                        <input type="number" class="form-control" name="mob" id="mobile"
                                            oninput="validate(this)" min="0000000000" max="9999999999"
                                            placeholder="Enter Mobile Number" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="email">Email ID <span>*</span></label>
                                        <input type="email" class="form-control" name="mail" id="email"
                                            placeholder="Enter Email ID" required>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                        <label for="trade">Trade <span>*</span></label>
                                        <input type="text" class="form-control" name="trade" id="trade"
                                            placeholder="Enter Trade" required>
                                    </div>
                                </div>
                                <div
                                    class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">

                                    <button type="submit" id="sub" class="formbtn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table -->
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
                        <a href="{{route('vendor.export')}}" data-bs-toggle="tooltip" data-bs-title="Export" id="export"><i
                                class="fa-solid fa-file-export"></i></a>
                        <a href="" data-bs-toggle="modal" data-bs-target="#import_venmaster" id="import"><i
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
                            <th>Type</th>
                            <th>Date</th>
                            <th>Vendor Code</th>
                            <th>Vendor Name</th>
                            <th>Address</th>
                            <th>GST</th>
                            <th>PAN</th>
                            <th>Aadhar</th>
                            <th>Bank Name</th>
                            <th>A/C Holder</th>
                            <th>Bank A/C No</th>
                            <th>IFSC</th>
                            <th>Branch</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Trade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($vendor as $vendors)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$vendors->pro_title}}</td>
                                    <td>{{$vendors->type}}</td>
                                    <td>{{$vendors->ven_date}}</td>
                                    <td>{{$vendors->v_code}}</td>
                                    <td>{{$vendors->v_name}}</td>
                                    <td>{{$vendors->address}}</td>
                                    <td>{{$vendors->gst}}</td>
                                    <td>{{$vendors->pan}}</td>
                                    <td>{{$vendors->aadhar}}</td>
                                    <td>{{$vendors->bank}}</td>
                                    <td>{{$vendors->ac_name}}</td>
                                    <td>{{$vendors->ac_no}}</td>
                                    <td>{{$vendors->ifsc}}</td>
                                    <td>{{$vendors->branch}}</td>
                                    <td>{{$vendors->mob}}</td>
                                    <td>{{$vendors->mail}}</td>
                                    <td>{{$vendors->trade}}</td>
                                    <td>
                                        <div class="d-flex gap-3">

                                            <a href="{{ route('vendors.edit', ['id' => $vendors->id]) }}">
                                                <i class="fa-solid fa-pen-to-square" data-bs-toggle="tooltip" data-bs-title="Edit"></i>
                                            </a>
                                            <a data-remote="{{ route('vendors.destroy', ['id' => $vendors->id]) }}" class="delete-confirm">
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

    <div class="modal fade" id="import_venmaster" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Vendor Master Import</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row" action="{{route('vendor.import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input hidden type="text" name="project_id" >
                    <div class="modal-body">
                        <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                        <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                            <label for="file">File</label>
                            <input type="file" class="form-control" name="vendor_file" id="file">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit"  class="modalbtn">Import</button>
                    </div>
                </form>
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
                    url: '{{ route('vendors.save') }}',
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
                                window.location.href = '{{route('vendors.index')}}';
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
