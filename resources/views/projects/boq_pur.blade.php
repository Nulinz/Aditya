@include('layouts.header')

<div class="accordion" id="accordionExample">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#accord6">
                <h4 class="m-0">BOQ Purchase</h4>
            </button>
        </h2>
        <div id="accord6" class="accordion-collapse collapse"> <!-- Ensure this collapse is opened by default -->
            <div class="accordion-body maindiv">
                <div class="container-fluid px-1">
                    <form action="" method="post" class="myForm1">
                        @csrf
                        <input hidden name="pro_id" type="text" value="{{$projectId}}" class="form-control">

                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="date">Date <span>*</span></label>
                                <input type="date" class="form-control" name="pur_date" id="date"
                                    pattern="\d{4}-\d{2}-\d{2}" max="9999-12-31" required>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="billno">Bill No <span>*</span></label>
                                <input type="text" class="form-control" name="pur_bill" id="billno"
                                    placeholder="Enter Bill No" required>
                            </div>

                            @php
                                $boqs = DB::table('boqs')->where('pro_id', $projectId)->where('status', 1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="boqcode">BOQ Code <span>*</span></label>
                                <select class="form-select select2input" name="code" id="boq_act_code" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach($boqs as $boq)
                                        <option
                                            data-code="{{ $boq->code }}"
                                            data-des="{{ $boq->des }}"
                                            data-brate="{{ $boq->boq_rate }}"
                                            data-zrate="{{ $boq->zero_rate }}"
                                            data-des_work="{{ $boq->description }}">
                                            {{ $boq->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $vendor = DB::table('vendors')->where('pro_id', $projectId)->where('type','contractor')->where('status', 1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="vendorname">Vendor Name <span>*</span></label>
                                <select class="form-select select2input" name="ven_name" id="vendor_name" required>
                                    <option value="" selected disabled>Select Options</option>
                                    @foreach ($vendor as $vendors)
                                        <option value="{{$vendors->id}}">{{$vendors->v_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $materials = DB::table('materials')->where('pro_id', $projectId)->where('status', 1)->get();
                            @endphp
                           <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                            <label for="itemcode">Material Code <span>*</span></label>
                            <select class="form-select select2input" name="item_code" id="item_codes" required>
                                <option value="" selected disabled>Select Options</option>
                                @foreach($materials as $material)
                                    <option data-des="{{ $material->des }}" data-code="{{ $material->item_code }}" value="{{ $material->id }}">
                                        {{ $material->item_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                            <label for="material">Material Description</label>
                            <textarea class="form-control" rows="1" name="material" id="material" placeholder="Enter Material" readonly></textarea>
                        </div>

                            @php
                                $units = DB::table('units')->where('status', 1)->get();
                            @endphp
                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="unit">Unit <span>*</span></label>
                                <select class="form-select" name="uom" required>
                                    <option value="" selected>Select Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->unit}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="qty">Quantity <span>*</span></label>
                                <input type="number" class="form-control" name="qty" id="qty" min="0"
                                    placeholder="Enter Quantity" oninput="sum_gst('qty', 'rate', 'gst', 'amt', 'gross')" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="rate">Rate <span>*</span></label>
                                <input type="number" class="form-control" name="b_rate" id="rate" min="0"
                                    placeholder="Enter Rate" oninput="sum_gst('qty', 'rate', 'gst', 'amt', 'gross')" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="amt">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amt" min="0"
                                    placeholder="Enter Amount" value="0" readonly>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gst">GST <span>*</span></label>
                                <input type="text" class="form-control" name="gst" id="gst" placeholder="Enter GST"
                                    oninput="sum_gst('qty', 'rate', 'gst', 'amt', 'gross')" value="0" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="gross">Gross <span>*</span></label>
                                <input type="text" class="form-control" name="gross" id="gross"
                                    placeholder="Enter Gross" value="0" readonly required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" rows="1" name="remarks" id="remarks"
                                    placeholder="Enter Remarks"></textarea>
                            </div>

                            <div class="col-sm-12 col-md-12 col-xl-12 mt-1 d-flex justify-content-center align-items-center">
                                <button type="submit" id="sub" class="formbtn">Save</button>
                            </div>
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
            <select id="headerDropdown7" class="form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="filterInput7" class="form-control" placeholder=" Search">
        </div>
        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <!-- //export -->
                <a href="" id="export"><i
                        class="fa-solid fa-file-export"></i></a>
                <!-- import -->
                <a data-bs-toggle="modal" data-bs-target="#import_pro_sales" id="import"><i
                        class="fa-solid fa-file-import"></i></a>
            </div>
        </div>
    </div>
    @php
            $purchases = DB::table('purchases')
            ->leftJoin('units', 'purchases.uom', '=', 'units.id')
            ->leftJoin('vendors', 'purchases.ven_name', '=', 'vendors.id')
            ->leftJoin('materials', 'purchases.item_code', '=', 'materials.id')
            ->where('purchases.pro_id', $projectId)
            ->where('purchases.status', 1)
            ->orderByDesc('purchases.id')
            ->select('purchases.*', 'units.unit as unit_name','vendors.v_name as vendor_name','materials.item_code as m_code','materials.des')
            ->get();

            $totalAmount=0;


    @endphp
    <div class="table-wrapper">
        <table class="table table-hover table-striped" id="table7">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Bill</th>
                    <th>Code</th>
                    <th>Vendor Name</th>
                    <th>Material Code</th>
                    <th>Material Description</th>
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
                @foreach ($purchases as $item)
                @php
                     $purAmount = (float) str_replace(',', '', $item->amount);
                     $totalAmount += $purAmount;
                @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ date('d-m-Y', strtotime($item->pur_date)) }}</td>
                        <td>{{$item->pur_bill}}</td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->vendor_name}}</td>
                        <td>{{$item->m_code}}</td>
                        <td>{{$item->des}}</td>
                        <td>{{$item->unit_name}}</td>
                        <td>{{$item->qty}}</td>
                        <td>{{$item->b_rate}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->gst}}</td>
                        <td>{{$item->gross}}</td>
                        <td>{{$item->remarks}}</td>
                        <td>
                            <div class="d-flex gap-3">
                                <!-- Edit Link -->
                                <a href="{{ route('boq_purchase.edit', $item->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Delete Link -->
                                <a data-remote="{{ route('boq_purchase.destroy', ['id' => $item->id]) }}" class="delete-confirm">
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
                    <td></td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
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
<div class="modal fade" id="import_pro_sales" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Progress Sales Zero Cost Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row" action="imp_file1.php" method="POST" enctype="multipart/form-data">
                <input hidden type="text" name="project_id" >
                <div class="modal-body">
                    <h6 class="mb-3 fw-semibold">Sample File - <a
                            href=""
                            download>Download</a></h6>
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="p_sales" id="file">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="submit" name="p_sales_import" class="modalbtn">Import</button>
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

        initTable('#table7', '#headerDropdown7', '#filterInput7');
    });
</script>

<style>
    .swal2-toast .swal2-title.toast-title {
        color: rgb(244, 239, 239) !important; /* Ensures the text is black */
    }
</style>

<script>
    function sum_gst(qtyId, rateId, gstId, amtId, grossId) {
        var qty = parseFloat(document.getElementById(qtyId).value) || 0;
        var rate = parseFloat(document.getElementById(rateId).value) || 0;
        var gst = parseFloat(document.getElementById(gstId).value) || 0;

        var amount = qty * rate;

        var gstAmount = (amount * gst) / 100;

        var gross = amount + gstAmount;

        document.getElementById(amtId).value = amount.toFixed(2);
        document.getElementById(grossId).value = gross.toFixed(2);
    }
    </script>
    <script>
        document.getElementById('item_codes').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var materialDescription = selectedOption.getAttribute('data-des');
            document.getElementById('material').value = materialDescription;
        });
        </script>
        <script>
            $(document).ready(function () {
                $('.myForm1').on('submit', function (e) {
                    e.preventDefault();

                    const formData = $(this).serialize();

                    console.log(formData);

                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: '{{ route('projects_boq_purchase.sa') }}',
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
