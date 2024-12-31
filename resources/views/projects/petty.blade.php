@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord4">
                <h4 class="m-0">Petty Cash</h4>
            </button>
        </h2>
        <div id="accord4" class="accordion-collapse collapse">
            <div class="accordion-body maindiv">
                <div class="container-fluid px-1">

                    <form action="" method="post" class="myForm1" enctype="multipart/form-data">
                        @csrf
                            @php
                            $boqs = DB::table('boqs')->where('pro_id', $projectId)->where('status', 1)->get();
                            $vendors = DB::table('vendors')->where('pro_id', $projectId)->where('status', 1)->get();
                            $units = DB::table('units')->where('status', 1)->get();
                            $pettyCash = DB::table('petty_cashes')->where('pro_id', $projectId)->where('status', 1)->get();

                            $totalAmount = DB::table('petty_cashes')->where('pro_id', $projectId)->where('status', 1)->sum('amount');

                            $voc_no = 'V' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

                            $cashRecords = DB::table('petty_cashes')->where('pro_id', $projectId)->where('status', 1)->get();
                            $cash1 = $cashRecords->sum('amount');

                            $clblncRecords = DB::table('petties')->where('pro_id', $projectId)->where('status', 1)->get();
                            $clblnc1 = $clblncRecords->sum('amount');

                            $close_balance = ($clblnc1 == 0) ? $cash1 : ($cash1 - $clblnc1);
                        @endphp
                        <input hidden name="pro_id" type="text" value="{{ $projectId }}" class="form-control">
                        <div class="row">

                            <!-- Date -->
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="date" id="date" required>
                            </div>

                            <!-- Voucher No -->
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="voucherno">Voucher No</label>
                                <input type="text" class="form-control" name="v_no" id="voucherno" value="{{ $voc_no }}">
                            </div>

                            <!-- BOQ Code -->
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqcode">BOQ Code <span>*</span></label>
                                <select class="form-select select2input" name="code" id="boq_act_code" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach($boqs as $boq)
                                        <option value="{{ $boq->id }}" data-code="{{ $boq->code }}" data-des="{{ $boq->des }}" data-brate="{{ $boq->boq_rate }}" data-zrate="{{ $boq->zero_rate }}" data-des_work="{{ $boq->des }}">
                                            {{ $boq->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqdesp">BOQ Description</label>
                                <textarea class="form-control" rows="1" name="des" id="boq_desc"
                                    placeholder="Enter BOQ Description" readonly></textarea>
                            </div>

                            <!-- Vendor Name -->
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="vendorname">Vendor Name <span>*</span></label>
                                <select class="form-select" name="v_name" id="vendorname" required>
                                    <option value="" selected>Select Options</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->v_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Unit -->
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="unit">Unit <span>*</span></label>
                                <select class="form-select" name="unit" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="qty">Quantity <span>*</span></label>
                                <input type="number" class="form-control" name="qty" id="qty" min="0"
                                    placeholder="Enter Quantity" oninput="sum_gst('qty','rate','amt')" value="0" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="rate">Rate <span>*</span></label>
                                <input type="number" class="form-control" name="rate" id="rate" min="0"
                                    placeholder="Enter Rate" oninput="sum_gst('qty','rate','amt')" value="0" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="amt">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amt" min="0"
                                    placeholder="Enter Amount" value="0" readonly>
                            </div>


                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="openblnce">Opening Balance <span>*</span></label>
                                <input type="number" class="form-control" name="open_blnc" id="openblnce" min="0"
                                    placeholder="Enter Opening Balance" value="{{$close_balance}}" required readonly>
                            </div>

                            <!-- Remarks -->
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" rows="1" name="remark" id="remarks"></textarea>
                            </div>

                            <!-- File Upload -->
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="files">Files <span>*</span></label>
                                <div class="inpflex">
                                    <input type="file" class="form-control border-0" name="in_img1" id="in_img1" required>
                                    <div class="cameraIcon d-flex justify-content-center align-items-center" data-target="#in_img">
                                        <i class="fas fa-camera text-center"></i>
                                    </div>
                                </div>
                                <img class="imagePreview" src="" alt="Image Preview" style="display:none; width:100%; height:200px; background-color: #fff; margin-top: 10px;">
                            </div>
                            <div class="col-sm-12 col-md-4 mt-3 cameraOpt" style="display: none;">
                                <div class="camerafnctn">
                                    <video class="video" width="200" height="200" autoplay></video>
                                    <input class="formbtn capture" type="button" value="Capture">
                                    <canvas class="canvas" style="display: none;"></canvas>
                                </div>
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
            <select id="headerDropdown5" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput5" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="" id="export"><i class="fa-solid fa-file-export"></i></a>
                <a data-bs-toggle="modal" data-bs-target="#import_petty" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>
    @php
    $totalPetty = DB::table('petty_cashes')
        ->where('pro_id', $projectId)
        ->sum('amount');

    $petty_cash = DB::table('petties')
        ->leftJoin('units', 'petties.unit', '=', 'units.id')
        ->leftJoin('vendors', 'petties.v_name', '=', 'vendors.id')
        ->leftJoin('boqs', 'petties.code', '=', 'boqs.id')
        ->where('petties.pro_id', $projectId)
        ->where('petties.status', 1)
        ->select('petties.*', 'units.unit as unit_name', 'vendors.v_name', 'boqs.code', 'boqs.des')
        ->get();

    $amount1 = 0;
    $previous_opening_balance = $totalPetty;
@endphp

    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Voucher No</th>
                    <th>BOQ Code</th>
                    <th>BOQ Description</th>
                    <th>Vendor Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>Opening</th>
                    <th>Closing</th>
                    <th>Remarks</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach($petty_cash as $index => $petty)
                    @php
                        $amount = (float)str_replace(',', '', $petty->amount);
                        $open_bl=(float)str_replace(',', '', $petty->open_blnc);
                        $cl_balance = $previous_opening_balance - $amount;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($petty->date)->format('d-m-Y') }}</td>
                        <td>{{ $petty->v_no }}</td>
                        <td>{{ $petty->code }}</td>
                        <td>{{ $petty->des ?? 'No data' }}</td>
                        <td>{{ $petty->v_name ?? 'No data' }}</td>
                        <td>{{ $petty->unit_name ?? 'No data' }}</td>
                        <td>{{ $petty->qty }}</td>
                        <td>{{ number_format($petty->rate, 2) }}</td>
                        <td>{{ number_format($amount, 2) }}</td>
                        <td>{{ number_format($open_bl, 2) }}</td>
                        <td>{{ number_format($cl_balance, 2) }}</td>
                        <td>{{ $petty->remark }}</td>
                        <td>
                            <a href="{{ asset($petty->in_img1) }}" download="{{ basename($petty->in_img1) }}" title="Download image">Download</a>
                        </td>

                        <td>
                            <div class="d-flex gap-3">

                                <a href="{{ route('petty.edit', ['id' => $petty->id]) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a data-remote="{{ route('petty.destroy', ['id' => $petty->id]) }}" class="delete-confirm">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @php
                        $amount1 += $amount;
                        $previous_opening_balance = $cl_balance;

                    @endphp
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
                    <td></td>
                    <td>{{ number_format($amount1, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                </tbody>
        </table>
    </div>
</div>

<!-- Popup -->
<div class="modal fade" id="import_petty" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Petty Cash Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="imp_file1.php" method="POST" enctype="multipart/form-data">
            <input hidden type="text" name="project_id" value="">
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a href="" download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="exc_petty" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" name="import_petty" class="modalbtn">Import</button>
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
        initTable('#table5', '#headerDropdown5', '#filterInput5');
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

<!-- Script Camera Option -->
<script>
    const $video = $('.video');
    const $canvas = $('.canvas');
    $('.cameraIcon').on('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: {
                        ideal: "environment"
                    },
                }
            });
            $video[0].srcObject = stream;
            $('.cameraOpt').show();
        } catch (err) {
            console.error('Error accessing camera:', err);
        }

        $('.capture').on('click', () => {
            const context = $canvas[0].getContext('2d');
            $canvas.attr('width', $video[0].videoWidth).attr('height', $video[0].videoHeight);
            context.drawImage($video[0], 0, 0);

            const targetInput = $('.cameraIcon').data('target');
            $canvas[0].toBlob(blob => {
                if (blob) {
                    const file = new File([blob], 'captured-image.jpg', {
                        type: 'image/jpeg'
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    const $input = $('#in_img1');
                    if ($input.length > 0) {
                        $input[0].files = dataTransfer.files;
                    } else {
                        console.error('Input element #in_img1 not found.');
                    }
                    $(".imagePreview").attr('src', URL.createObjectURL(file)).show();
                    const stream = $video[0].srcObject;
                    if (stream) stream.getTracks().forEach(track => track.stop());
                    $video[0].srcObject = null;
                    $('.cameraOpt').hide();
                }
            }, 'image/jpeg');
        });
    });
</script>

<script>
    $(document).ready(function() {


        $('#boq_act_code').on('change', function() {


            $('#boq_desc').val($(this).find('option:selected').data('des'));

        });
    })
</script>

<script>
    function sum_gst(qtyId, rateId, amtId) {
    var qty = parseFloat(document.getElementById(qtyId).value) || 0;
    var rate = parseFloat(document.getElementById(rateId).value) || 0;

    var amount = qty * rate;

    document.getElementById(amtId).value = amount.toFixed(2);
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

        const formData = new FormData(this);

        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        const amount = parseFloat($('#amt').val());
            const closeBalance = parseFloat($('#openblnce').val());

            if (closeBalance === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error',
                    text: 'The Opening Balance is zero. You cannot proceed.',
                });
                return;
            }
            if (amount > closeBalance) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error',
                    text: 'The entered amount exceeds the available Opening balance.',
                });
                return;
            }

        $.ajax({
            url: '{{ route('projects_petty.sa') }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
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
<script>
    document.getElementById("in_img1").addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const imagePreview = document.querySelector(".imagePreview");

                imagePreview.src = e.target.result;

                imagePreview.style.display = "block";
            };

            reader.readAsDataURL(file);
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const amountInput = document.getElementById("amt");
        const closeBalance = parseFloat(document.getElementById("openblnce").value);

        amountInput.addEventListener("input", function () {
            const amount = parseFloat(this.value);
            if (amount > closeBalance) {
                alert("The entered amount exceeds the available closing balance!");
            }
        });
    });
</script>
@include('layouts.footer')
