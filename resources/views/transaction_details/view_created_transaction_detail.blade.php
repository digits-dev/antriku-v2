@extends('crudbooster::admin_template')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('include.css')
<style>
    .content{
       padding: 0;
    }
   
    .content-header{
       display: none;
    }
    
    .cust-ch{
        margin-top: 70px;
    }
    
    @media (max-width: 767px) {
        .cust-ch {
            margin-top: 110px;
        }
    }
</style>
@endpush

@section('content')

<div id="top-loader" style="display: none">
    <div class="top-loader">
        <div class="modal-cus">
        <div class="loader-container">
            <div class="loader-left">
            <div class="loader">
                <div class="spinner"></div>
                <div class="pulse"></div>
            </div>
            </div>
            
            <div class="loader-right">
            <div class="loading-text">LOADING YOUR REQUEST, PLEASE WAIT</div>
            
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
    <div class="panel panel-default" style="margin: 0; padding:0">
        <div class="panel-body">
            <div class="row cust-ch" style="margin-bottom: 0%">
                <div class="col-md-12" style="margin-bottom: 0%">
                    <div class="form-group" style="margin-bottom: 0rem">
                        <div class="transaction-card" style="border-bottom-left-radius: 0%; border-bottom-right-radius: 0%;">
                            <header class="page-header-cust">
                                <div class="header-left">
                                    <div style="background: rgba(255, 255, 255, 0.3); padding: 5px; border-radius: 20%">
                                        <img src="https://cdn-icons-png.flaticon.com/128/7711/7711811.png" width="40" alt="">
                                    </div>
                                    <div>
                                        <h1 style="margin: 0; font-size: 20px; color: white;">Transaction Details</h1>
                                        <div style="font-size: 11px; color: #c0c0c0; line-height: 1.4;">
                                            <div class="text-uppercase {{$transaction_details->fl_name == null ? 'hidden' : ''}}"><strong><i class="bi bi-person-workspace"></i> Frontliner:</strong> {{$transaction_details->fl_name}}</div>
                                            <div class="text-uppercase {{$transaction_details->tech_name == null ? 'hidden' : ''}}"><strong><i class="bi bi-person-fill-gear"></i> Technician:</strong> {{$transaction_details->tech_name}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reference-badge-cust">
                                    Reference:
                                    <strong style="margin-left: 4px;">{{$transaction_details->reference_no}}</strong>
                                    <span class="copy-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </span>
                                </div>
                            </header>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 0%">
                            @include('include.comment-box')
                        </div>
                    </div>
                </div>
            </div>
            @if(request()->segment(3) == "edit")
                <form method="post" action="" id="SubmitTransactionForm">                
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            @endif
            @include('transaction_details.customer_details')
            @include('transaction_details.service_details')

            @if ($manager_invoices_viewing_config == "SHOW")
                @include('transaction_details.uploade_invoice')
            @endif

                {{-- Technical Report --}}
            @if ($transaction_details->repair_status == 10)
                @include('transaction_details.technical_report')
            @elseif($transaction_details->case_status === 'MAIL-IN')
                @include('mail_in.technical_report')
            @elseif($transaction_details->case_status === 'CARRY-IN')
                @include('carry_in.technical_report')
            @endif

            {{-- Diagnostic Results hide on Frontliner and Spare Custodian --}}
            @if (!in_array(CRUDBooster::myPrivilegeId(), [3,9]))
                @if ($transaction_details->repair_status == 10)
                    @include('transaction_details.diagnostic_results')
                @elseif($transaction_details->case_status === 'MAIL-IN')
                    @include('mail_in.diagnostic_results')
                @elseif($transaction_details->case_status === 'CARRY-IN')
                    @include('carry_in.diagnostic_results')
                @endif
            @endif
            
            @if (!is_null($transaction_details->airwaybill_upload))
                {{-- Airwaybill is hidden on Technician --}}
                @if (!in_array(CRUDBooster::myPrivilegeId(), [4,8]))
                    @include('transaction_details.uploade_airwaybill')
                @endif

                @if ($manager_invoices_viewing_config == "SHOW")
                    @include('transaction_details.uploade_rpf')
                @endif
            @else
                @if ($manager_invoices_viewing_config == "SHOW")
                    @include('transaction_details.uploade_rpf')
                @endif
            
                {{-- Airwaybill is hidden on Technician --}}
                @if (!in_array(CRUDBooster::myPrivilegeId(), [4,8]))
                    @include('transaction_details.uploade_airwaybill')
                @endif
            @endif
            
            {{-- Quotation --}}
            @if ($transaction_details->repair_status == 10)
                @include('transaction_details.quotation')
            @elseif($transaction_details->case_status === 'MAIL-IN')
                @include('mail_in.quotation')
            @elseif($transaction_details->case_status === 'CARRY-IN')
                @include('carry_in.quotation')
            @endif
            
            @if ($manager_invoices_viewing_config == "SHOW")
                @include('transaction_details.uploade_final_invoice')
            @endif

            <section class="card-cust" style="border-radius: 0rem; padding: 1.2rem; border-top: 2px solid #e2e8f0">
              
                    <a href="{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}" class="btn btn-default pull-left"><i class="fa fa-chevron-circle-left"></i> BACK</a>
                    <input type="hidden" value="{{$data['transaction_details']->header_id}}" name="header_id" id="header_id">
                   
                    <input type="hidden" name="mainpath" id="mainpath" value="{{CRUDBooster::mainpath()}}">
                    <input type="hidden" name="current_status" id="current_status" value="{{$transaction_details->repair_status}}">
                    <input type="hidden" id="warranty_status" value="{{$transaction_details->warranty_status}}">
                    <input type="hidden" id="case_status" value="{{$transaction_details->case_status}}">
                    <input type="hidden" id="repair_status" value="{{ $transaction_details->repair_status }}">
                    <input type="hidden" name="action" id="action" value="">

                    <input type="hidden" name="second_marked_image_base64" id="second_marked_image_base64">
                    
                    @if (request()->segment(3) == "edit")
                        <div id="mailin" style="display: {{ $transaction_details->case_status === 'MAIL-IN' ? 'block' : 'none' }};">
                            @include('mail_in.mail_in_buttons')
                        </div>
                        <div id="carry-in" style="display: {{ $transaction_details->case_status === 'CARRY-IN' ? 'block' : 'none' }};">
                            @include('carry_in.carry_in_buttons')
                        </div>
                    @endif
                
                    @if($transaction_details->repair_status == 10 && CRUDBooster::getModulePath() == "to_diagnose")
                        <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
                        {{-- <button type="submit" id="reject" onclick="return changeStatus(3)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button> --}}
                    @elseif($transaction_details->repair_status == 3 && CRUDBooster::getModulePath() == "to_close" && CRUDBooster::myPrivilegeId() != 2)
                        <button type="submit" id="void" onclick="return changeStatus(5)" class="btn btn-danger pull-right buttonSubmit"/><i class="fa fa-check-square-o" aria-hidden="true"></i> CANCELLED/CLOSE</button>
                    @endif 

                    @if (request()->segment(3) == "edit" && in_array($transaction_details->repair_status, [13,19,22,28,38]))
                        <div>
                   
                            @if ($transaction_details->print_technical_report == "YES")
                            <button type="button" id="print_releasing_form" onclick="print_release_form()" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;> <i class="fa fa-print"></i> Print Releasing Form</button>
                            @else
                            <button type="button" onclick="print_technical_from_confirm()" class="btn btn-success pull-right" style="margin-left: 10px">
                                <i class="fa fa-print" aria-hidden="true"></i> Printing Technical Form
                            </button>
                                @if ($transaction_details->warranty_status === 'OUT OF WARRANTY')
                                    <button type="button" onclick="refund({{ $transaction_details->id }})" class="btn btn-danger pull-right" style="margin-left: 10px">
                                    <i class="fa fa-print" aria-hidden="true"></i> Refund
                                </button>
                                @endif
                            @endif
                             <button type="button" id="call_out" onclick="callOut({{ $transaction_details->repair_status }})"
                                class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
                                <i class="fa fa-phone"></i> CALL OUT ({{ $CallOutCount }})
                            </button>
                            @if (in_array($transaction_details->repair_status, [13,22,38]))
                                <button type="button" id="ntf" onclick="callOut({{ $transaction_details->repair_status }}, this)"
                                    class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;">
                                <i class="fa fa-phone"></i> CALL OUT NTF ({{ $CallOutCount }})
                            </button>
                            @endif
                            
                            <input type="hidden" value="{{$transaction_details->repair_status}}" id="transaction_status">
                        </div>
                    @endif

            </div>
            </section>
            @if(request()->segment(3) == "edit") </form> @endif 
        </div>
    </div>
@endsection

@push('bottom')
@include('technician.to_diagnose_transaction_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
      
<script>

        function toggleCaseStatus() {
            const selectedCase = $('input[name="case_status"]:checked').val() ?? $('#case_status').val();
            // Hide both initially
            $('#mailin').hide();
            $('#carry-in').hide();

            // Show based on selected case
            if (selectedCase === 'MAIL-IN') {
                $('#mailin').show();
            } else if (selectedCase === 'CARRY-IN') {
                $('#carry-in').show();
            }
        }

        function toggleWarrantyButton() {
            let status = $('input[name="warranty_status"]:checked').val() ?? $('#warranty_status').val();
            let selectedCase = $('input[name="case_status"]:checked').val() ?? $('#case_status').val();

            // Hide all
            $('#mailin-in-warranty, #mailin-out-warranty, #carryin-in-warranty, #carryin-out-warranty').hide();

            // Show based on both case and warranty
            if (selectedCase === 'MAIL-IN') {
                if (status === 'IN WARRANTY') {
                    $('#mailin-in-warranty').show();
                } else {
                    $('#mailin-out-warranty').show();
                }
            } else if (selectedCase === 'CARRY-IN') {
                if (status === 'IN WARRANTY') {
                    $('#carryin-in-warranty').show();
                } else {
                    $('#carryin-out-warranty').show();
                }
            }
        }

        

        $(document).ready(function() {
            @if(isset($lastCallOutNotice))
                Swal.fire({
                    icon: 'info',
                    title: 'Notice',
                    text: '{{ $lastCallOutNotice }}'
                });
            @endif
        

            $('.copy-icon').on('click', function() {
                var $icon = $(this);
                var reference = $icon.siblings('strong').text().trim();
        
                // Copy to clipboard
                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(reference).select();
                document.execCommand('copy');
                tempInput.remove();
        
                // Swap SVG to check icon
                var originalIcon = $icon.html();
                var checkIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        style="color: limegreen;">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                `;
                $icon.html(checkIcon).show();
    
                setTimeout(function() {
                    $icon.html(originalIcon);
                }, 1000);
            });

            const repairStatus = $('#repair_status').val();

            if (repairStatus == 10) {
            toggleCaseStatus();
            toggleWarrantyButton();
            }

            $('input[name="case_status"], input[name="warranty_status"], select[name="warranty_status"]').on('change', function () {
                toggleCaseStatus();
                toggleWarrantyButton();
            });
        });

        
    function print_release_form(){
        let header_id = $('#header_id').val();
        window.location.href = window.location.origin+"/admin/to_close/PrintReleaseForm/"+header_id;
    }

     
    function print_technical_from_confirm() {
        let header_id = $('#header_id').val();
        const finalInvoiceUploaded = @json($data['transaction_details']->final_invoice);

        var formData = new FormData();
        formData.append("header_id", header_id);
        
        if (finalInvoiceUploaded == null) {
            formData.append("final_invoice", $("#final_invoice")[0].files[0]);
        }
        let warranty_status = $('#warranty_status').val();
        if (warranty_status === 'OUT OF WARRANTY' && finalInvoiceUploaded == null) {
            let form = document.getElementById("SubmitTransactionForm");
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
        }
            Swal.fire({
                icon: 'question',
                title: "Confirmation!",
                text: "Are you sure you want to proceed printing Technical form?",
                confirmButtonText: "Yes, Please",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                    url: "{{ route('upload_final_invoice') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        window.location.href = window.location.origin + "/admin/to_close/PrintTechnicalReport/" + header_id;
                        }
                })
            }
            });
    }
</script>   

<script>
    $(document).ready(function () {
        $('#original_editable_model').on('click', function () {
            const imageUrl = $(this).attr('src');

            Swal.fire({
                html: `
                <div class="app-container" id="app">
                    <div class="app-header">
                        <h1 class="app-title">
                            <i class="fa fa-search"></i> Model Inspection
                        </h1>
                        <div class="mode-toggle">
                            <span class="mode-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mode-icon mark-icon"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                Mark
                            </span>
                            <label class="switch">
                                <input type="checkbox" id="eraseToggle">
                                <span class="slider"></span>
                            </label>
                            <span class="mode-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mode-icon erase-icon"><path d="M20 20H7L3 16a1 1 0 0 1 0-1.41l9.71-9.71a1 1 0 0 1 1.41 0l6.88 6.88a1 1 0 0 1 0 1.41L12.7 20"></path></svg>
                                Erase
                            </span>
                        </div>
                    </div>
                    <div id="canvas-container">
                        <canvas id="canvas"></canvas>
                        <div class="tooltip" id="tooltip"></div>
                    </div>
                </div>
                `,
                width: 1000,
                showCancelButton: true,
                showConfirmButton: true,
                allowOutsideClick: false,
                cancelButtonText: '<i class="fa fa-times"></i> No, Cancel',
                confirmButtonText: '<i class="fa fa-save"></i> Save Inspection',
                backdrop: true,
                customClass: {
                    popup: 'swal2-rounded'
                },
                willClose: () => {
                    if (window.activeCanvas) {
                        window.activeCanvas.dispose();
                        window.activeCanvas = null;
                    }
                },
                didOpen: () => {
                    const canvasEl = document.getElementById("canvas");
                    const appEl = document.getElementById("app");

                    if (window.activeCanvas) {
                        window.activeCanvas.dispose();
                    }

                    const canvas = new fabric.Canvas("canvas");
                    window.activeCanvas = canvas;

                    let isEraseMode = false;
                    const marks = [];

                    fabric.Image.fromURL(imageUrl, (imgObj) => {
                        const maxWidth = Math.min(window.innerWidth * 0.6, 800);
                        const scale = maxWidth / imgObj.width;

                        canvas.setWidth(imgObj.width * scale);
                        canvas.setHeight(imgObj.height * scale);

                        imgObj.scale(scale);
                        canvas.add(imgObj);

                        imgObj.set({ selectable: false, evented: false });
                        canvas.sendToBack(imgObj);
                    });

                    document.getElementById("eraseToggle").addEventListener("change", (event) => {
                        isEraseMode = event.target.checked;
                        updateMode();
                    });

                    function updateMode() {
                        if (isEraseMode) {
                            appEl.classList.add("erase-mode");
                            canvasEl.style.cursor = `url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg"...') 3 28, pointer`;
                        } else {
                            appEl.classList.remove("erase-mode");
                            canvasEl.style.cursor = `url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg"...') 1 30, pointer`;
                        }
                    }

                    canvas.on("mouse:down", (event) => {
                        const pointer = canvas.getPointer(event.e);
                        const x = pointer.x;
                        const y = pointer.y;

                        if (isEraseMode) {
                            let removed = false;
                            canvas.forEachObject((obj) => {
                                if (obj.type === "line" && obj.containsPoint(new fabric.Point(x, y))) {
                                    canvas.remove(obj);
                                    removed = true;
                                }
                            });
                            if (removed) showTooltip(x, y, "Mark removed!");
                        } else {
                            const line1 = new fabric.Line([x - 10, y - 10, x + 10, y + 10], {
                                stroke: "darkorange", strokeWidth: 3, strokeLineCap: "round"
                            });
                            const line2 = new fabric.Line([x + 10, y - 10, x - 10, y + 10], {
                                stroke: "darkorange", strokeWidth: 3, strokeLineCap: "round"
                            });
                            canvas.add(line1, line2);
                            marks.push(line1, line2);
                            canvas.bringToFront(line1);
                            canvas.bringToFront(line2);
                            showTooltip(x, y, "Mark placed!");
                        }
                    });

                    function showTooltip(x, y, message) {
                        const tooltip = document.getElementById("tooltip");
                        tooltip.textContent = message;
                        tooltip.style.left = `${x + 10}px`;
                        tooltip.style.top = `${y + 10}px`;
                        tooltip.style.opacity = "1";
                        setTimeout(() => { tooltip.style.opacity = "0"; }, 1500);
                    }

                    updateMode();
                    window.addEventListener("resize", () => {
                        const maxWidth = Math.min(window.innerWidth * 0.6, 800);
                        if (canvas.width > maxWidth) {
                            const scale = maxWidth / canvas.width;
                            canvas.setZoom(scale);
                            canvas.setDimensions({
                                width: canvas.width * scale,
                                height: canvas.height * scale,
                            });
                        }
                    });
                },
                preConfirm: () => {
                    if (window.activeCanvas) {
                        const base64Image = window.activeCanvas.toDataURL("image/png");
                        document.getElementById("second_marked_image_base64").value = base64Image;
                        jQuery("#second_marked_model").html(`<img src="${base64Image}" />`);
                        $('#saved_2nd_inpeted_model_photo').hide();
                    }
                },
                willClose: () => {
                    // Clean up when the modal closes
                    if (window.activeCanvas) {
                        window.activeCanvas.dispose()
                        window.activeCanvas = null
                    }
                },
            });
        });
    });
</script>

@endpush