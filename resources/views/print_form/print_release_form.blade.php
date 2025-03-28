
@extends('crudbooster::admin_template')
@push('head')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .page-break {
      display: block;
      page-break-before: always;
    }
  
    .print-friendly, canvas {
      page-break-inside: avoid;
    }
  </style>
@endpush
@section('content')
    {{-- @if(g('return_url'))
        <p class="no-print"><a title="Return" href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @else
        <p class="no-print"><a title='Main Module' href='{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @endif --}}

    <div class="panel panel-default" id="main-pannel">
        <div class='panel-heading no-print'>Print Release Form</div>
        <div class='panel-body' id="printableArea">    
            <div> 
                <style> 
                    .table-bordered-display { border: 1px solid #B8B8B8 !important; } 
                    table.print-friendly { page-break-inside: avoid; }
                </style>
                <table width="100%">
                    <tr>
                        <th colspan="4" style="text-align:center;">
                            <img src="{{asset('img/btblogo.png')}}" id="antriku-logo" style="align:middle;width:450px;height:auto;">
                        </th>
                    </tr>   
                    <tr>
                        <td width="35%" style="padding-right:50px;">
                            <div class="row">
                                <span class="control-label col-md-12" id="left-label" >{{ $data['Branch']->branch_name }}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12" id="left-label">{{ $data['Branch']->branch_address }}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12" id="left-label">
                                    {{ $data['Branch']->branch_contact1 }} / {{ $data['Branch']->branch_contact2 }} / {{ $data['Branch']->branch_contact3 }} <br>
                                    http://beyondthebox.ph/
                                </span>
                            </div>
                        </td>
                        <td width="30%" colspan="2" style="text-align:center;">
                            <h4 style="margin-top: 17px;text-align-last: center;"><strong>RELEASE FORM</strong></h4> 
                        </td>
                        <td width="100%" style="padding-left:110px;">
                            <div class="row">
                                <span class="control-label col-md-12" id="right-label"><strong>Return Reference#: </strong>{{$data['transaction_details']->reference_no}}</span>
                            </div>
                            <div class="row"> 
                                <span class="control-label col-md-12" id="right-label"><strong>Date Received: </strong>{{date('Y-m-d', strtotime($data['transaction_details']->updated_at))}}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12" id="right-label"><strong>Date Released: </strong>{{ date('Y-m-d') }}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12" id="right-label"><strong>Prepared By: </strong>{{ CRUDBooster::myName() }}</span>
                            </div>
                        </td>
                    </tr> 
                </table>  

                <table width="100%" class="print-friendly">
                    <tr style="font-size: 18px;">
                        <td colspan="4" style="width:100%;background:#595959;color:white;padding:5px;"> 
                            <label style="margin-bottom:unset !important;">Customer Information</label>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Full Name:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->last_name}}, {{$data['transaction_details']->first_name}}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Email Address:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->email}}</p>
                        </td>
                    </tr>                                  
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Contact#:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->contact_no}}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Address:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->address}}</p>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Company Name:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->company_name}}</p>
                        </td>
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Company Contact#:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{$data['transaction_details']->company_contact_no}}</p>
                        </td>
                    </tr>
                    <tr></tr>
                    <tr style="font-size: 18px;">
                        <td colspan="4" style="width:100%;background:#595959;color:white;padding:5px;"> 
                            <label style="margin-bottom:unset !important;">Service Details</label>
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
                    <br>
                    <tr style="font-size: 13px;">
                        <td width="20%" style="vertical-align: top;">
                            <label class="control-label col-md-12"><strong>Summary of Concern:</strong></label>
                        </td>
                        <td colspan="3">
                            <p>{{$data['transaction_details']->summary_of_concern}}</p>
                        </td>
                    </tr>  
                </table>  
                <br>
                <table class="print-friendly" style="border-spacing:unset !important;width:100%;">
                    <tbody>
                        <tr style="font-size: 13px;">
                            <th width="20%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 1px !important;padding:5px;">UPC Code</th>
                            <th width="30%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:5px;">{{ trans('labels.table.item_description') }}</th>
                            <th width="10%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:5px;">{{ trans('labels.table.serial_no') }}</th>
                            <th width="40%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:5px;">{{ trans('labels.table.problem_details') }}</th>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important;padding:5px;text-align:center;">{{ $data['transaction_details']->header_upc_code }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:5px;text-align:center;">{{ $data['transaction_details']->header_item_description }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:5px;text-align:center;">{{ $data['transaction_details']->header_serial_no }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:5px;text-align:center;">{{ $data['transaction_details']->problem_details }} @if(!empty($data['transaction_details']->problem_details_other)) ,<br> {{ $data['transaction_details']->problem_details_other }} @endif</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="print-friendly" width="100%" style="border-spacing:unset !important;"> 
                    <tbody> 
                        <tr style="font-size:18px;">
                            <td colspan="4" style="width:100%;background:#595959;color:white;padding:5px;"> 
                                <label style="margin-bottom:unset !important;">Technical Report</label>
                            </td>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td width="20%" style="padding:5px;" class="text-center table-bordered-display">
                                <label class="control-label col-md-12"><strong>Device Issue Description</strong></label>
                            </td>
                            <td width="20%" style="padding:5px;" class="text-center table-bordered-display">
                                <label class="control-label col-md-12"><strong>Findings</strong></label>
                            </td>
                            <td width="20%" style="padding:5px;" class="text-center table-bordered-display">
                                <label class="control-label col-md-12"><strong>Resolution</strong></label>
                            </td>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td width="20%" style="padding:5px;" class="text-center table-bordered-display">
                                <p class="control-label col-md-12">{{ $data['transaction_details']->device_issue_description }}</p>
                            </td>
                            <td width="20%" style="padding:5px;" class="text-center table-bordered-display">
                                <p class="control-label col-md-12">{{$data['transaction_details']->findings}}</p>
                            </td>
                            <td width="20%" style="padding:5px;" class="text-center table-bordered-display">
                                <p class="control-label col-md-12">{{$data['transaction_details']->resolution}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="print-friendly" width="100%" style="border-spacing:unset !important;">
                    <tbody> 
                        <tr style="font-size: 18px;">
                            <td colspan="4" style="width:100%;background:#595959;color:white;padding:5px;"> 
                                <label style="margin-bottom:unset !important;">Summary of Charges</label>
                            </td>
                        </tr>
                        <tr style="font-size: 13px;">
                             <td width="20%" class="table-bordered-display" style="border-width: 1px !important;padding:5px;text-align:center;">
                                <label class="control-label col-md-12"><strong>Apple Serial</strong></label>
                            </td>
                            <td width="20%" class="table-bordered-display" style="border-width: 1px !important;padding:5px;text-align:center;">
                                <label class="control-label col-md-12"><strong>Item Description</strong></label>
                            </td>
                            <td width="20%" class="table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:5px;text-align:center;">
                                <label class="control-label col-md-12"><strong>Price</strong></label>
                            </td>
                        </tr>
                        @if(count($data['Quotation'])>0)
                            @foreach($data['Quotation'] as $qt)
                                <tr style="font-size: 13px;">
                                     <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important; padding:5px; text-align:center;">
                                        <p>{{$qt->serial_number}}</p>
                                    </td>
                                    <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important; padding:5px; text-align:center;">
                                        <p>{{$qt->item_description}}</p>
                                    </td>
                                    
                                    <?php $downpayment = ($qt->cost)*0.5; ?>
                                    <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important; padding:5px; text-align:center;">
                                        @if(CRUDBooster::getCurrentMethod() == 'PrintSameDayReleaseForm')
                                            <p>₱{{number_format($qt->cost, 2, '.', '')}}</p>
                                        @else
                                            <p>₱{{number_format($downpayment, 2, '.', '')}}</p>
                                        @endif      
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="font-size: 13px;">
                                <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important; padding:5px; text-align:center;background-color:#DDDDDD" colspan="4">
                                    <p>No item listed!</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <br>
                <table width="100%" class="print-friendly">
                    <tr style="font-size: 13px;">
                        <td colspan="2" style="text-align: center;">
                            <p>Warranty & Limitation of Liability. For all Service Repairs, Beyond the Box warrants that (1) services performed will conform to their description for ninety (90) days from the date of payment receipt, (2) except for batteries described in the subsection below, all parts or products used in service will be free from defects in materials and workmanship for ninety (90) days from the date of payment receipt, and (3) batteries installed as part of Apple’s battery replacement service for Apple portable Mac computers will be free from defects in materials and workmanship for one year from the date of service. If non-conforming service is provided or a defect arises in a replacement part or product during the applicable warranty period, Beyond the Box will at its option, either (a) re-perform services to conform to their description (b) repair or replace the part or product, using parts or products that are new or equivalent to new in performance and reliability, or (c) refund the sums paid to Beyond the Box for service.</p>
                        </td>
                    </tr>
                    <tr style="font-size: 13px;">
                        <td width="100%" style="text-align: center;">
                            <b>I acknowledge the details above and have received the device in good, working condition.</b>
                            <br><br>
                            <div style="display: flex; align-items: center; justify-content: center;" id="signature_container_release_form">
                                <canvas id="signature-pad-release-form" class="signature-pad-release-form" width="500" height="130" 
                                    style="border: 1px solid #ddd; margin: 0 auto;">
                                </canvas>
                            </div>
                            <center> 
                                <b><p style="margin-bottom: 0px"> {{$data['transaction_details']->last_name}}, {{$data['transaction_details']->first_name}} / {{now()}}</p></b>
                                <p>Signature over Printed Name and Date</p>
                                <button type="button" id="clear-signature" class="no-print">Clear Signature</button>
                                <input type="hidden" name="signatureData" id="signatureData">
                            </center>
                        </td>
                    </tr>     
                </table>
            </div>
        </div>          
    </div>
    <div class='panel-footer no-print'>            
        <form method="" id="myform" action="">
            <input type="hidden" value="{{$data['transaction_details']->header_id}}" name="header_id">
            <input type="hidden" value="3" name="print_form_type">
            <a href="{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}" class="btn btn-default">Cancel</a>
            <button class="btn btn-primary pull-right" type="button" id="print" onclick="printDivision('printableArea')"> 
                <i class="fa fa-print"></i> Print as PDF 
            </button>
        </form>   
        <button class="btn btn-primary" id="download-btn" style="display: none"></button>
    </div>
@endsection

@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '#print', function(e){
        var data = $('#myform').serialize();
        let print_technical_report = "{{$data['transaction_details']->print_technical_report}}";
        
        if(print_technical_report === 'NO'){
            Swal.fire({
                title: "Technical Report is not yet printed.",
                text: "Please print the report first befor printing this release form!",
                icon: "warning",
            });
            return;
        }

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

    let isSwalOpen = false;
    function printDivision() {

        let print_technical_report = "{{$data['transaction_details']->print_technical_report}}";
        if(print_technical_report === 'NO'){
            Swal.fire({
                title: "Technical Report is not yet printed.",
                text: "Please print the report first befor printing this release form!",
                icon: "warning",
            });
            return;
        }

        isSwalOpen = true;
        alert('Please print 2 copies.');

        // Get the canvas element
        let canvas = document.getElementById("signature-pad-release-form");

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

    $("#download-btn").click(function () {
        let element = document.getElementById("printableArea");
        let button = document.getElementById("clear-signature");
        let canvas = document.getElementById("signature-pad-release-form");
        element.style.width = "100%";

        if (button) button.style.display = "none";
        if (canvas) {
            canvas.style.width = "220px";
            canvas.style.border = "none";
        }

        let contact_no = "{{$data['transaction_details']->contact_no}}";
        let first_name = "{{$data['transaction_details']->first_name}}";
        let last_name = "{{$data['transaction_details']->last_name}}";
        let email_add = "{{$data['transaction_details']->email}}";
        let file_name = "{{$data['transaction_details']->reference_no}}_RELEASED_SIGNED_FORM.pdf";

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
                                    title: "Email Sent Successfully!",
                                    html: emailResponse.message + "<br>" + "<b>To: </b>" + emailResponse.email,
                                }, function(){
                                    window.location.href = window.location.origin+"/admin/call_out/edit/"+header_id;
                                });
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

    // for digital Signature
    document.addEventListener("DOMContentLoaded", function () {
        const canvas = document.getElementById("signature-pad-release-form");
        const clearButton = document.getElementById("clear-signature");
        const signatureDataInput = document.getElementById("signatureData");
        const form = document.getElementById("myform");

        if (!canvas || !clearButton || !signatureDataInput || !form) {
            console.error("Missing required elements for signature pad.");
            return;
        }

        // Initialize SignaturePad
        if (typeof SignaturePad !== "undefined") {
            const signaturePad = new SignaturePad(canvas);

            // Hide clear button initially
            clearButton.style.display = "none";

            // Show clear button when user starts drawing
            canvas.addEventListener("mousedown", () => {
                clearButton.style.display = "inline-block"; 
            });

            // Show clear button when drawing on mobile (touch event)
            canvas.addEventListener("touchstart", () => {
                clearButton.style.display = "inline-block"; 
            });

            // Form submission validation
            form.addEventListener("submit", function (e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    Swal.fire("Signature Requirement", "Please sign before printing!", "warning");
                } else {
                    const signatureImage = signaturePad.toDataURL(); // Converts to Base64
                    signatureDataInput.value = signatureImage; // Store in hidden input
                }
            });

            // Clear signature and hide button
            clearButton.addEventListener("click", function () {
                signaturePad.clear();
                clearButton.style.display = "none"; // Hide button after clearing
            });

        } else {
            console.error("SignaturePad library is not loaded.");
        }
    });
</script>
@endpush