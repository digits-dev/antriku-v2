
@extends('crudbooster::admin_template')
@push('head')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section('content')
    @if(g('return_url'))
        <p class="no-print"><a title="Return" href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @else
        <p class="no-print"><a title='Main Module' href='{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @endif
    <div class="panel panel-default" id="main-pannel">
        <!-- <div class="row"></div> -->
        <div class='panel-body'>    
            <div id="printableArea"> 
                <style> 
                    .table-bordered-display { border: 1px solid #B8B8B8 !important; } 
                    table.print-friendly { page-break-inside: avoid; }
                    p { margin: 0 0 3px !important; }

                    .customize-header {
                        width: 100%;
                        background: #595959;
                        color: white;
                        padding: 3px;
                        border: 1px solid #595959 !important;
                    }

                    .customize-header-2{
                        background: #B8B8B8 !important;
                    }

                    @media print {
                        .customize-header {
                            width: 100%;
                            background: #595959 !important;
                            border: 1px solid #595959 !important;
                            color: white !important;
                            padding: 3px !important;
                            -webkit-print-color-adjust: exact !important;
                            print-color-adjust: exact !important;
                        }

                        .customize-header-2{
                            background: #B8B8B8 !important;
                            -webkit-print-color-adjust: exact !important;
                            print-color-adjust: exact !important;
                        }
                    }
                </style>
                <table width="100%">
                    <thead>
                        <tr>
                            <th colspan="4" style="text-align:center;">
                                <img src="{{asset('img/btblogo.png')}}" style="align:middle;width:50%;height:auto;padding-bottom:20px">
                                <br>
                            </th>
                        </tr>   
                    </thead>
                    <tbody>
                        <tr>
                            <td width="35%" style="padding-right:50px;">
                                <div class="row">
                                    <span class="control-label col-md-12" id="left-label">{{ $data['Branch']->branch_name }}</span>
                                </div>
                                <div class="row">
                                    <span class="control-label col-md-12" id="left-label">{{ $data['Branch']->branch_address }}</span>
                                </div>
                                <div class="row">
                                    <span class="control-label col-md-12" id="left-label">
                                        {{ $data['Branch']->branch_contact1 }} / {{ $data['Branch']->branch_contact2 }} <br> 
                                        <a href="http://beyondthebox.ph/">http://beyondthebox.ph/</a>
                                    </span>
                                </div>
                            </td>
                            <td width="30%" colspan="2" style="text-align:center;">
                                <h4 style="margin-top: 17px;text-align-last: center;"><strong>RECEIVING FORM</strong></h4> 
                            </td>
                            <td width="100%" style="padding-left:110px;">
                                <div class="row">
                                    <span class="control-label col-md-12" id="right-label"><strong>Return Reference#: </strong> {{$data['transaction_details']->reference_no}} </span>
                                </div>
                                <div class="row">
                                    <span class="control-label col-md-12" id="right-label"><strong>Date Received: </strong>{{ date('Y-m-d') }}</span>
                                </div>
                                <div class="row">
                                    <span class="control-label col-md-12" id="right-label"><strong>Prepared By: </strong>{{ CRUDBooster::me()->first_name }}</span>
                                </div>
                            </td>
                        </tr> 
                    </tbody>
                </table>  

                <table class="print-friendly" width="100%">
                    <tr style="font-size: 18px;">
                        <td colspan="4" class="customize-header">
                            <label class="control-label col-md-12" id="left-label" style="margin-bottom:unset !important;color: white !important">Customer Information</label>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12" id="left-label"><strong>Full Name:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->last_name}}, {{$data['transaction_details']->first_name}}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12" id="left-label"><strong>Email Address:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->email}}</p>
                        </td>
                    </tr>                                  
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12" id="left-label"><strong>Contact#:<strong></label>
                        </td>
                        <td width="40%">
                            <p id="left-label">{{$data['transaction_details']->contact_no}}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12" id="left-label"><strong>Address:<strong></label>
                        </td>
                        <td width="40%">
                            <p id="left-label">{{$data['transaction_details']->address}}</p>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12" id="left-label"><strong>Customer Type:</strong></label>
                        </td>
                        <td width="40%">
                            <p id="left-label">{{$data['transaction_details']->customer_type}}</p>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        @if ($data['transaction_details']->customer_type == 'Enterprise')    
                            <td width="20%" style="vertical-align: top;">
                                <label class="control-label col-md-12" id="left-label"><strong>Company Name:<strong></label>
                            </td>
                            <td width="40%">
                                <p id="left-label">{{$data['transaction_details']->company_name}}</p>
                            </td>
                            <td width="25%" style="vertical-align: top;">
                                <label class="control-label col-md-12" id="left-label"><strong>Company Contact#:<strong></label>
                            </td>
                            <td width="40%">
                                <p id="left-label">{{$data['transaction_details']->company_contact_no}}</p>
                            </td>
                        @endif
                    </tr>
                    
                    <tr style="font-size:18px;">
                        <td colspan="4" class="customize-header">
                            <label class="control-label col-md-12" style="margin-bottom:unset !important;color: white !important">Service Details</label>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Date of Purchase:</strong></label>
                        </td>
                        <td>
                            <p>{{ date('Y-m-d', strtotime($data['transaction_details']->purchase_date)) }}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>{{ trans('labels.form-label.warranty_expiration_date') }}</strong></label>
                        </td>
                        <td>
                            <p>{{ date('Y-m-d', strtotime($data['transaction_details']->warranty_expiration_date)) }}</p>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Model:</strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $data['transaction_details']->model_name }}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Warranty Status:</strong></label>
                        </td>
                        <td>
                            <p>{{$data['transaction_details']->warranty_status}}</p>
                        </td>
                    </tr>  
                    <tr>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Unit Type:</strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $data['transaction_details']->unit_type }}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Store Purchase:</strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $data['transaction_details']->store_purchase }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Purchase / Invoice Number:</strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $data['transaction_details']->purchace_invoice_number }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Files Backed Up:</strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $data['transaction_details']->files_backed_up }}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>iCloud Signed Out:</strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $data['transaction_details']->icloud_sign_out }}</p>
                        </td>
                    </tr>
                    <br>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>VMI Remarks:</strong></label>
                        </td>
                        <td colspan="3">
                            <p>{{$data['transaction_details']->summary_of_concern}}</p>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Accessories Included Remarks:</strong></label>
                        </td>
                        <td colspan="3">
                            <p>{{$data['transaction_details']->accessories_included_remarks}}</p>
                        </td>
                    </tr>  
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Other Remarks:</strong></label>
                        </td>
                        <td colspan="3">
                            <p>{{$data['transaction_details']->other_remarks}}</p>
                        </td>
                    </tr> 
                </table>  
                <br>
                <table class="print-friendly" style="border-spacing:unset !important;width:100%;">
                    <thead class="customize-header-2">
                        <tr style="font-size: 13px;">
                            <th width="20%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 1px !important;padding:3px;">Digits Code</th>
                            <th width="20%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 1px !important;padding:3px;">UPC Code</th>
                            <th width="30%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;">{{ trans('labels.table.item_description') }}</th>
                            <th width="10%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;">{{ trans('labels.table.serial_no') }}</th>
                            <th width="40%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;">{{ trans('labels.table.problem_details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 13px;">
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important;padding:3px;text-align:center;">{{ $data['transaction_details']->header_digits_code }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important;padding:3px;text-align:center;">{{ $data['transaction_details']->header_upc_code }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;text-align:center;">{{ $data['transaction_details']->header_item_description }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;text-align:center;">{{ $data['transaction_details']->header_serial_no }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;text-align:center;">{{ $data['transaction_details']->problem_details }} @if(!empty($data['transaction_details']->problem_details_other)) ,<br> {{ $data['transaction_details']->problem_details_other }} @endif</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div style="page-break-after: always !important;"></div>
                <table style="page-break-inside: avoid !important;">
                    <table class="print-friendly" width="100%">
                        <thead>
                            <tr style="font-size: 18px;">
                                <th colspan="4" class="table-bordered-display customize-header">
                                    <label class="control-label col-md-12" style="margin-bottom:unset !important; color:white !important;">Device Inspection (for scratches, dents, damages)</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr> 
                                <td style="text-align:center;padding: 3px 0;" class="table-bordered-display">
                                    <div style="height:200px;padding:10px;">
                                        @if ($transaction_details->inspected_model_photo)
                                        <img src="{{ Storage::url($transaction_details->inspected_model_photo) }}" style="max-width: 50%;height: auto;max-height: 100%;">
                                        @else
                                            <img src="{{ URL::to('/') }}/{{$transaction_details->model_photo}}" style="max-width: 50%;height: auto;max-height: 100%;"/>
                                        @endif
                                    </div>
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                    <table width="100%">
                        <tr style="font-size:13px;">
                            <td>
                                <p>Note: Bags, cases, sleeves, and unneccessary accessories must be removed by the owner of the Apple product before 
                                the start of service. Beyond the Box will not be able liable for any damages cause by the removal of the accessories.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight: 500;">
                                <p>SEE REVERSE SIDE FOR TERMS AND CONDITIONS</p>
                            </td>
                        </tr>
                    </table>
                </table>
                {{-- <div style="page-break-after: always !important;"></div> --}}
                <div style="text-align:justify;font-size: 11px;">
                    {{-- <h4 align="center" style="margin-top: 17px; margin-bottom: 0px;"><strong>TERMS & CONDITIONS</strong></h4>  --}}
                    {{-- <br> --}}
                    @include('include.terms_and_condition')
                </div>
                <div style="page-break-after: always !important;"></div>
                {{-- <br> --}}
                <div style="text-align:justify;font-size: 11px;">
                    <h4 align="center" style="margin-top: 17px;"><strong>DATA PRIVACY CONSENT FORM</strong></h4> 
                    @include('include.data_privacy_act')
                        By signing this form, you acknowledge and consent to the collection and use of your personal data as described. If you have any questions, feel free to contact us at service@beyondthebox.ph.
                        <div style="display: none">
                            <br>
                            Customer Name: <span><u> {{$data['transaction_details']->last_name}}, {{$data['transaction_details']->first_name}} </u></span>
                            <br>
                            Signature: <span id="e_signed"></span>
                            <br>
                            Date: <span> <u>{{now()}}</u> </span>
                        </div>
                </div>

                <br><br>
                <div style="display: flex; align-items: center; justify-content: center;" id="signature_container">
                    <canvas id="signature-pad" class="signature-pad" width="500" height="130" 
                        style="border: 1px solid #ddd; margin: 0 auto;">
                    </canvas>
                </div>
                <center>
                    <b><p style="margin-bottom: 0px"> {{$data['transaction_details']->last_name}}, {{$data['transaction_details']->first_name}} / {{now()}}</p></b>
                    <p>Customer’s Signature over Printed Name</p> 
                    <button type="button" id="clear-signature" class="no-print">Clear Signature</button>
                    <input type="hidden" name="signatureData" id="signatureData">
                </center>
            </div>
            <div class='no-print' style="margin-top: 10px; border-top: 1px solid lightgrey; padding-top: 10px;">
                <form method="" id="myform" action="">
                    <input type="hidden" value="{{$data['transaction_details']->header_id}}" name="header_id">
                    <input type="hidden" value="1" name="print_form_type">
                    <a href="{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}" class="btn btn-default pull-left"><i class="fa fa-chevron-circle-left"></i> BACK</a>
                    <button class="btn btn-success pull-right" type="button" id="print" onclick="printDivision('printableArea')"> 
                        <i class="fa fa-print"></i> Print as PDF 
                    </button>
                </form>
                <button class="btn btn-primary" id="download-btn" style="display: none"></button>
            </div>         
        </div> 
    </div>
@endsection
    
@push('bottom')
<!-- signaturePad CDN -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script type="text/javascript">  
    document.addEventListener("DOMContentLoaded", function () {
        $('.main-footer').addClass("no-print");
        $('body').addClass("sidebar-collapse");
    });

    // Preven ctrl + p
    document.addEventListener("keydown", function (event) {
        if (event.ctrlKey && event.key === "p") {
            event.preventDefault();
        }
    });

    // Prevent right-click
    window.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });

    $("#download-btn").click(function () {
        let element = document.getElementById("printableArea");
        let button = document.getElementById("clear-signature");
        let canvas = document.getElementById("signature-pad");

        if (button) button.style.display = "none";
        if (canvas) canvas.style.width = "220px";
        if (canvas) {
            canvas.style.width = "220px";
            canvas.style.border = "none";
        }

        let contact_no = "{{$data['transaction_details']->contact_no}}";
        let first_name = "{{$data['transaction_details']->first_name}}";
        let last_name = "{{$data['transaction_details']->last_name}}";
        let email_add = "{{$data['transaction_details']->email}}";
        let file_name = "{{$data['transaction_details']->reference_no}}_RECEIVING_SIGNED_FORM.pdf";
        let form_type = "RECEIVING_SIGNED_FORM";

        let options = {
            margin: 7,
            filename: file_name,
            image: { type: "jpeg", quality: 0.98 },
            html2canvas: { scale: 2, scrollY: 0, useCORS: true, allowTaint: true },
            jsPDF: { unit: "mm", format: "letter", orientation: "portrait" }
        };

        html2pdf().from(element).set(options).outputPdf("blob").then((pdfBlob) => {
            let formData = new FormData();
            formData.append("contact_no", contact_no);
            formData.append("first_name", first_name);
            formData.append("last_name", last_name);
            formData.append("email", email_add);
            formData.append("pdf", pdfBlob, file_name);
            formData.append("form_type", form_type);
            
            // Save PDF to drive 
            $.ajax({
                url: "{{ route('upload_pdf') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    Swal.fire({
                        icon: "info",
                        title: "Saving PDF copy to Drive",
                        text: "Please wait...",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Upload Successful",
                        html: response.message + '<br>' + response.file_name + "<br> <br>Please wait again...",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 2000,
                        didOpen: () => Swal.showLoading()
                    });

                    setTimeout(() => {
                        // Send PDF to Email
                        $.ajax({
                            url: "{{ route('send_pdf_email') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function () {
                                Swal.fire({
                                    title: "Sending PDF copy via Email",
                                    text: "Please wait...",
                                    icon: "info",
                                    allowOutsideClick: false,
                                    didOpen: () => Swal.showLoading()
                                });
                            },
                            success: function (emailResponse) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Transaction Complete, Email Sent Successfully!",
                                    html: emailResponse.message + "<br>" + "<b>To: </b>" + emailResponse.email + "<br><br> <small>Closing, A moment again please...</small>",
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    didOpen: () => Swal.showLoading()
                                });
                                setTimeout(() => {
                                    window.location.href = `/admin/returns_header`;
                                }, 3000);
                            },
                            error: function () {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error Sending Email",
                                    text: "An error occurred while sending the email. Please try again.",
                                });
                            }
                        });
                    }, 2000);
                },
                error: function (xhr, error) {
                    // console.error(xhr.responseText);
                    Swal.close();
                    Swal.fire({
                        title: "Can't save this file again!",
                        html: xhr.responseJSON?.error + '<br>' + xhr.responseJSON?.file_name || "Something went wrong!",
                        icon: "error",
                        timer: 3000,
                        didOpen: () => Swal.showLoading()
                    });setTimeout(() => {
                    },3000)
                }
            });

            if (button) button.style.display = "block";
        });
    });

    let isSwalOpen = false;
    function printDivision() {
        isSwalOpen = true;
        alert('Please print 2 copies.');

        // Get the canvas element
        let canvas = document.getElementById("signature-pad");

        if (canvas) {
            let ctx = canvas.getContext("2d");
            let blank = document.createElement("canvas");
            blank.width = canvas.width;
            blank.height = canvas.height;

            // Check if the canvas is empty
            if (canvas.toDataURL() === blank.toDataURL()) {
                Swal.fire({
                    title: "Signature Requirement",
                    text: "Please sign before printing!",
                    icon: "warning",
                });
                return; 
            } else {
                window.print();
            }
        }
    }
    
    window.onafterprint = function() {
        $("#download-btn").trigger('click');
    };


    // update print status
    $(document).on('click', '#print', function(e) {
        var data = $('#myform').serialize();
        $.ajax
        ({
            type: 'GET',
            url: "{{ route('change-print-status') }}", 
            data: data,
            success: function( response ){
                console.log( response );     
            },
            error: function( e ) {
                console.log(e);
            }
        });
        return true;
    });  
    
    // for digital Signature
    document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("signature-pad");
    const clearButton = document.getElementById("clear-signature");
    const signatureDataInput = document.getElementById("signatureData");
    const form = document.getElementById("myform");
    const previewContainer = document.getElementById("e_signed");

    if (!canvas || !clearButton || !signatureDataInput || !form || !previewContainer) {
        console.error("Missing required elements for signature pad.");
        return;
    }

    if (typeof SignaturePad !== "undefined") {
        const signaturePad = new SignaturePad(canvas);

        // Create preview image element once
        const img = document.createElement("img");
        img.style.width = "100px";
        img.style.borderBottom = "1px solid black";
        img.style.marginTop = "0px";
        previewContainer.appendChild(img);

        // Function to update preview in real-time
        function updatePreview() {
            if (!signaturePad.isEmpty()) {
                img.src = signaturePad.toDataURL();
            } else {
                img.src = "";
            }
        }

        // Show clear button when user starts drawing
        canvas.addEventListener("mousedown", () => {
            clearButton.style.display = "inline-block";
        });
        canvas.addEventListener("touchstart", () => {
            clearButton.style.display = "inline-block";
        });

        // Real-time update
        canvas.addEventListener("mouseup", updatePreview);
        canvas.addEventListener("touchend", updatePreview);
        canvas.addEventListener("mousemove", updatePreview);
        canvas.addEventListener("touchmove", updatePreview);

        // Form submission validation
        form.addEventListener("submit", function (e) {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                Swal.fire("Signature Requirement", "Please sign before printing!", "warning");
            } else {
                const signatureImage = signaturePad.toDataURL();
                signatureDataInput.value = signatureImage;
            }
        });

        // Clear signature and mirror preview
        clearButton.addEventListener("click", function () {
            signaturePad.clear();
            img.src = ""; // Clear the preview
            clearButton.style.display = "none";
        });

    } else {
        console.error("SignaturePad library is not loaded.");
    }
});

</script>
@endpush


