@extends('layouts.app')
@section('content')

    <div class="sidebodydiv">
        <div class="sidebodyback mb-3" onclick="goBack()">
            <div class="backhead">
                <h5><i class="fas fa-arrow-left"></i></h5>
                <h6>Edit Petty Form</h6>
            </div>
        </div>

        <form action="{{route('petty.update',['id'=>$petty->id])}}" method="post" class="myForm1" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- Date -->
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="date">Date <span>*</span></label>
                    <input type="date" class="form-control" name="date" id="date" required value="{{$petty->date}}">
                </div>

                <!-- Voucher No -->
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="voucherno">Voucher No</label>
                    <input type="text" class="form-control" name="v_no" id="voucherno" value="{{$petty->v_no}}">
                </div>

                <!-- BOQ Code -->
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="boqcode">BOQ Code <span>*</span></label>
                    <select class="form-select select2input" name="code" id="boq_act_code" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach($boqs as $boq)
                            <option value="{{ $boq->id }}" data-code="{{ $boq->code }}" data-des="{{ $boq->des }}" data-brate="{{ $boq->boq_rate }}" data-zrate="{{ $boq->zero_rate }}" data-des_work="{{ $boq->des }}"  {{ $boq->id == $petty->code ? 'selected' : '' }}>
                                {{ $boq->code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="boqdesp">BOQ Description</label>
                    <textarea class="form-control" rows="1" name="des" id="boq_desc"
                        placeholder="Enter BOQ Description" readonly >{{$petty->des}}</textarea>
                </div>

                <!-- Vendor Name -->
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="vendorname">Vendor Name <span>*</span></label>
                    <select class="form-select select2input" name="v_name" id="vendorname" required>
                        <option value="" selected>Select Options</option>
                        @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}"
                            {{ $vendor->id == $petty->v_name ? 'selected' : '' }}>
                            {{ $vendor->v_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Unit -->
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="unit">Unit <span>*</span></label>
                    <select class="form-select select2input" name="unit" required>
                        <option value="" selected disabled>Select Options</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}"
                                {{ $unit->id == $petty->unit ? 'selected' : '' }}>
                                {{ $unit->unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="qty">Quantity <span>*</span></label>
                    <input type="number" class="form-control" name="qty" id="qty" min="0"
                        placeholder="Enter Quantity" oninput="sum_gst('qty','rate','amt')"  required value="{{$petty->qty}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="rate">Rate <span>*</span></label>
                    <input type="number" class="form-control" name="rate" id="rate" min="0"
                        placeholder="Enter Rate" oninput="sum_gst('qty','rate','amt')"  required value="{{$petty->rate}}">
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="amt">Amount</label>
                    <input type="number" class="form-control" name="amount" id="amt" min="0"
                        placeholder="Enter Amount"  readonly value="{{$petty->amount}}">
                </div>


                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="openblnce">Opening Balance <span>*</span></label>
                    <input type="number" class="form-control" name="open_blnc" id="openblnce" min="0"
                        placeholder="Enter Opening Balance"  required readonly value="{{$petty->open_blnc}}">
                </div>

                <!-- Remarks -->
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" rows="1" name="remark" id="remarks">{{$petty->remark}}</textarea>
                </div>

                <!-- File Upload -->
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="files">Files </label>
                    <div class="inpflex">
                        <input type="file" class="form-control border-0" name="in_img1" id="in_img1" >
                        <div class="cameraIcon d-flex justify-content-center align-items-center" data-target="#in_img">
                            <i class="fas fa-camera text-center"></i>
                        </div>
                    </div>
                    <img class="imagePreview" src="{{ asset($petty->in_img1) }}" alt="Image Preview" style="width:100%; height:200px; background-color: #fff; margin-top: 10px;"
                    @if($petty->in_img1) style="display:block;" @else style="display:none;" @endif>

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
@endsection
