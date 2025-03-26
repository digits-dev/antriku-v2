
@extends('crudbooster::admin_template')
@push('head')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section('content')
    {{-- @if(g('return_url'))
        <p class="no-print"><a title="Return" href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @else
        <p class="no-print"><a title='Main Module' href='{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @endif --}}
    <div class="panel panel-default" id="main-pannel">
        <div class='panel-heading no-print'>Print Technical Report</div>
        <div class='panel-body' id="printableArea">    
            <div> 
                <style> 
                    .table-bordered-display { border: 1px solid #B8B8B8 !important; } 
                    table.print-friendly { page-break-inside: avoid; }
                    p { margin: 0 0 3px !important; }
                </style>
                <table width="100%">
                    <tr>
                        <th colspan="4" style="text-align:center;">
                            <img src="{{asset('img/btblogo.png')}}" style="align:middle;width:450px;height:auto;">
                        </th>
                    </tr>   
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
                                    {{ $data['Branch']->branch_contact1 }} / {{ $data['Branch']->branch_contact2 }} / {{ $data['Branch']->branch_contact3 }} <br>
                                    http://beyondthebox.ph/
                                </span>
                            </div>
                        </td>
                        <td width="30%" colspan="2" style="text-align:center;">
                            <h4 style="margin-top: 17px;text-align-last: center;"><strong>TECHNICAL REPORT</strong></h4> 
                        </td>
                        <td width="100%" style="padding-left:110px;">
                            <div class="row">
                                <span class="control-label col-md-12" id="right-label"><strong>Return Reference#: </strong>{{$data['transaction_details']->reference_no}}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12" id="right-label"><strong>Date Received: </strong>{{ date('Y-m-d', strtotime($data['transaction_details']->created_at)) }}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12" id="right-label"><strong>Prepared By: </strong>{{ CRUDBooster::myName() }}</span>
                            </div>
                        </td>
                    </tr> 
                </table>  

                <table class="print-friendly" width="100%">
                    <tr style="font-size: 18px;">
                        <td colspan="4" style="width:100%;background:#595959;color:white;padding:3px;">
                            <label class="control-label col-md-12" style="margin-bottom:unset !important;">Customer Information</label>
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
                    <tr style="font-size:18px;">
                        <td colspan="4" style="width:100%;background:#595959;color:white;padding:3px;">
                            <label class="control-label col-md-12" style="margin-bottom:unset !important;">Service Details</label>
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
                    <tbody>
                        <tr style="font-size: 13px;">
                            <th width="20%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 1px !important;padding:3px;">UPC Code</th>
                            <th width="30%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;">{{ trans('labels.table.item_description') }}</th>
                            <th width="10%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;">{{ trans('labels.table.serial_no') }}</th>
                            <th width="40%" class="text-center table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;">{{ trans('labels.table.problem_details') }}</th>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important;padding:3px;text-align:center;">{{ $data['transaction_details']->header_upc_code }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;text-align:center;">{{ $data['transaction_details']->header_item_description }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;text-align:center;">{{ $data['transaction_details']->header_serial_no }}</td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;text-align:center;">{{ $data['transaction_details']->problem_details }} @if(!empty($data['transaction_details']->problem_details_other)) ,<br> {{ $data['transaction_details']->problem_details_other }} @endif</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="print-friendly" width="100%">
                    <tbody> 
                        <tr style="font-size: 18px;">
                            <td colspan="4" style="width:100%;background:#595959;color:white;padding:3px;">
                                <label class="control-label col-md-12" style="margin-bottom:unset !important;">Device Inspection (for scratches, dents, damages)</label>
                            </td>
                        </tr> 
                        <tr> 
                            <td style="text-align:center; border: 1px solid slategray; padding: 3px 0;">
                                <div style="height:200px;padding:10px;">
                                    <img src="{{ URL::to('/') }}/{{$transaction_details->model_photo}}" style="max-width: 50%;height: auto;max-height: 100%;"/>
                                </div>
                            </td>
                        </tr>  
                    </tbody>
                </table>
                <br>
                <table class="print-friendly" width="100%" style="border-spacing:unset !important;"> 
                    <tbody> 
                        <tr style="font-size:18px;">
                            <td colspan="4" style="width:100%;background:#595959;color:white;padding:3px;"> 
                                <label class="control-label col-md-12" style="margin-bottom:unset !important;">Technical Report</label>
                            </td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td width="15%" class="table-bordered-display" style="border-width: 1px 1px 1px 1px !important;padding:3px;">
                                <label class="control-label col-md-12"><strong>Device Issue Description:</strong></label>
                            </td>
                            <td width="40%" colspan="2" class="table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;">
                                <p>{{ $data['transaction_details']->device_issue_description }}</p>
                            </td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td width="15%" class="table-bordered-display" style="border-width: 0 1px 1px 1px !important;padding:3px;">
                                <label class="control-label col-md-12"><strong>Diagnostic Results:</strong></label>
                                <br>
                                <p class="control-label col-md-12">* Passed<br>* Warning<br>* Failed<br>* N/A</p>
                            </td>
                             <?php 
                                $test_type = explode(',', $data['diagnostic_test'][0]->test_type);

                                $counter1 = 0; 
                                $counter2 = 0; 
                                $test_result_key = 0;
                                $test_result = []; 
                                $test_type_key = 0;
                                $test_type_arr = []; 
                                $test_result_array = explode(',', $data['diagnostic_test'][0]->test_result); 

                                foreach ($test_result_array as $key=>$tra){
                                    if($tra != 4){
                                        $test_result[$test_result_key++] = $tra;
                                        $test_type_arr[$test_type_key++] = $test_type[$key];
                                    }
                                }
                            ?>
                            <td class="table-bordered-display" style="border-width: 0 0 1px 0 !important;padding:3px;">
                                @if(count($test_type_arr)>0)
                                    @foreach($data['TechTesting'] as $key=>$dr)
                                        <?php $ModelGroupTech = explode(",", $dr->model_group_id); ?>
                                        @if(in_array($dr->id, $test_type_arr) && in_array($data['transaction_details']->model_group, $ModelGroupTech))
                                            @if($counter1 % 2 == 0)
                                                @foreach($data['TechTestingResult'] as $tr)
                                                    @if($tr->id == $test_result[$counter1])
                                                        <p>{{$dr->description}} = <b>{{$tr->test_result_name}}</b></p>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <?php $counter1++; ?>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;">
                                @if(count($test_type_arr)>0)
                                    @foreach($data['TechTesting'] as $key=>$dr)
                                        <?php $ModelGroupTech = explode(",", $dr->model_group_id); ?>
                                        @if(in_array($dr->id, $test_type_arr) && in_array($data['transaction_details']->model_group, $ModelGroupTech))
                                            @if($counter2 % 2 != 0)
                                                @foreach($data['TechTestingResult'] as $tr)
                                                    @if($tr->id == $test_result[$counter2]) 
                                                        <p>{{$dr->description}} = <b>{{$tr->test_result_name}}</b></p>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <?php $counter2++; ?>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td width="15%" class="table-bordered-display" style="border-width: 0 1px 1px 1px !important;padding:3px;">
                                <label class="control-label col-md-12"><strong>Findings:</strong></label>
                            </td>
                            <td colspan="2" class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;">
                                <p>{{$data['transaction_details']->findings}}</p>
                            </td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td width="15%" class="table-bordered-display" style="border-width: 0 1px 1px 1px !important;padding:3px;">
                                <label class="control-label col-md-12"><strong>Resolution:</strong></label>
                            </td>
                            <td colspan="2" class="table-bordered-display" style="border-width: 0 1px 1px 0 !important;padding:3px;">
                                <p>{{$data['transaction_details']->resolution}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="print-friendly" width="100%" style="border-spacing:unset !important;">
                    <tbody> 
                        <tr style="font-size:18px;">
                            <td colspan="4" style="width:100%;background:#595959;color:white;padding:3px;"> 
                                <label class="control-label col-md-12" style="margin-bottom:unset !important;">Quotation of Repair/Product/Parts</label>
                            </td>
                        </tr>
                        <tr style="font-size:13px;">
                            <td width="20%" class="table-bordered-display" style="border-width: 1px !important;padding:3px;text-align:center;">
                                <label class="control-label col-md-12"><strong>Item Description</strong></label>
                            </td>
                            <td width="20%" class="table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;text-align:center;">
                                <label class="control-label col-md-12"><strong>Digits Code</strong></label>
                            </td>
                            <td width="20%" class="table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;text-align:center;">
                                <label class="control-label col-md-12"><strong>Price</strong></label>
                            </td>
                            <td width="20%" class="table-bordered-display" style="border-width: 1px 1px 1px 0 !important;padding:3px;text-align:center;">
                                <label class="control-label col-md-12"><strong>Total Amount</strong></label>
                            </td>
                        </tr>
                        @if(count($data['Quotation'])>0)
                            @foreach($data['Quotation'] as $qt)
                                <tr style="font-size:13px;">
                                    <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important; padding:3px; text-align:center;">
                                        <p>{{$qt->item_description}}</p>
                                    </td>
                                    <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important; padding:3px; text-align:center;">
                                        <p>{{$qt->digits_code}}</p>
                                    </td>
                                    <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important; padding:3px; text-align:center;">
                                        <p>₱{{number_format($qt->cost, 2, '.', '')}}</p>
                                    </td>
                                    <td class="table-bordered-display" style="border-width: 0 1px 1px 0 !important; padding:3px; text-align:center;">
                                        <p>₱{{number_format($qt->cost, 2, '.', '')}}</p>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="font-size:13px;">
                                <td class="table-bordered-display" style="border-width: 0 1px 1px 1px !important; padding:3px; text-align:center;background-color:#DDDDDD" colspan="4">
                                    <p>No item listed!</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <br>
                <table class="print-friendly" width="100%">
                    <tr style="font-size:13px;">
                        <td colspan="2">
                            <p>Note: Price quotation is only valid for five days, and may be
                                subject to change. Down payment may be settled via over the
                                counter (OTC) bank deposit or via credit card online. For OTC,
                                please deposit payment to Boxtalks Inc. (BDO - Wilson Branch)
                                with <br> Account# 658-008-8361. Please scan the deposit slip and
                                send to service@beyondthebox.ph immediately for verification.
                                For online payment, login to your Customer Dashboard at
                                http://appointment.beyondthebox.ph. 
                            </p>
                        </td>
                    </tr>
                    <tr style="font-size:13px;">
                        <td style="padding-top: 20px;vertical-align: top;">
                            <label class="control-label col-md-12" style="width: 30px;"><strong>Conforme:<strong></label>
                        </td>
                        <td width="10%" style="padding-top:20px;">
                            <div style="display: flex; align-items: center; justify-content: center;" id="signature_container_release_form">
                                <canvas id="signature-pad-release-form" class="signature-pad-release-form" width="500" height="130" 
                                    style="border: 1px solid #ddd; margin: 0 auto;">
                                </canvas>
                            </div>
                        </td>
                    </tr>     
                    <tr style="font-size: 13px;">
                        <td width="1%" style="vertical-align:top;">
                            <label class="control-label col-md-12" style="width: 0px;"><strong><strong></label>
                        </td>
                        <td width="10%">
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
            <input type="hidden" value="2" name="print_form_type">
            <!-- <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">Cancel</a> -->
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
</script>

<script>
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
        let file_name = "{{$data['transaction_details']->reference_no}}_TECHNICAL_REPORT_SIGNED_FORM.pdf";

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
                        let header_id = $('input[name="header_id"]').val();

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
                                    html: `${emailResponse.message}<br><b>To: </b>${emailResponse.email}<br><br><p>Redirecting to Release Form, please wait...</p>`,
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    timer: 1500, // Adjusted for better visibility
                                });

                                setTimeout(() => {
                                    window.location.href = `/admin/to_close/PrintReleaseForm/${header_id}`;
                                }, 1500); // Matches the Swal timer

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