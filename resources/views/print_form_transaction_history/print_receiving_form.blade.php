
@extends('crudbooster::admin_template')
@push('head')
@endpush
@section('content')
    @if(g('return_url'))
        <p class="noprint"><a title="Return" href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @else
        <p class="noprint"><a title='Main Module' href='{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
    @endif
    <div class="panel panel-default">
        <div class='panel-heading'>
            <div class="row">
                <div class="col-md-8">
                    Print Receiving Form
                </div>
                <div class="col-md-4">
                    <form method="" id="myform" action="">
                        <input type="hidden" value="{{$data['transaction_details']->header_id}}" name="header_id">
                        <input type="hidden" value="1" name="print_form_type">
                        <!-- <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default pull-right">Cancel</a> -->
                        <a href="{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}" class="btn btn-default pull-right">Cancel</a>
                        <button class="btn btn-primary pull-right" style="margin-right: 18px;" type="submit" id="print" onclick="printDivision('printableArea')"> 
                            <i class="fa fa-print"></i> Print as PDF 
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="row"></div> -->
        <div class='panel-body'>    
            <div id="printableArea"> 
                <style> 
                    .table-bordered-display { border: 1px solid #B8B8B8 !important; } 
                    table.print-friendly { page-break-inside: avoid; }
                    p { margin: 0 0 3px !important; }
                </style>
                <table width="100%">
                    <tr>
                        <th colspan="4" style="text-align:center;">
                            <img src="{{asset('img/btblogo.png')}}" style="align:middle;width:40%;height:auto;">
                        </th>
                    </tr>   
                    <tr>
                        <td width="35%" style="padding-right:50px;">
                            <div class="row">
                                <span class="control-label col-md-12">{{ $data['Branch']->branch_name }}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12">{{ $data['Branch']->branch_address }}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12">
                                    {{ $data['Branch']->branch_contact1 }} / {{ $data['Branch']->branch_contact2 }} / {{ $data['Branch']->branch_contact3 }} <br>
                                    http://beyondthebox.ph/
                                </span>
                            </div>
                        </td>
                        <td width="30%" colspan="2" style="text-align:center;">
                            <h4 style="margin-top: 17px;text-align-last: center;"><strong>RECEIVING FORM</strong></h4> 
                        </td>
                        <td width="100%" style="padding-left:110px;">
                            <div class="row">
                                <span class="control-label col-md-12"><strong>Return Reference#: </strong>{{$data['transaction_details']->reference_no}}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12"><strong>Date Received: </strong>{{ date('Y-m-d') }}</span>
                            </div>
                            <div class="row">
                                <span class="control-label col-md-12"><strong>Prepared By: </strong>{{ CRUDBooster::myName() }}</span>
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
                <table style="page-break-inside: avoid !important;">
                    <table class="print-friendly" width="100%">
                        <tbody> 
                            <tr style="font-size: 18px;">
                                <td colspan="4" style="width:100%;background:#595959;color:white;padding:3px;">
                                    <label class="control-label col-md-12" style="margin-bottom:unset !important;">Device Inspection (for scratches, dents, damages)</label>
                                </td>
                            </tr>
                            <tr> 
                                <!--<td style="text-align:center; border: 1px solid slategray; padding: 5px 0;">-->
                                <!--    <img src="{{ URL::to('/') }}/{{$transaction_details->model_photo}}" style="width:30%;min-width:20%;height:auto;"/>-->
                                <!--</td>-->
                                <td style="text-align:center; border: 1px solid slategray; padding: 3px 0;">
                                    <div style="height:200px;padding:10px;">
                                        <img src="{{ URL::to('/') }}/{{$transaction_details->model_photo}}" style="max-width: 50%;height: auto;max-height: 100%;"/>
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
                <div style="page-break-after: always !important;"></div>
                <div style="text-align:justify;font-size: 11px;">
                    <h4 align="center" style="margin-top: 17px;"><strong>TERMS & CONDITIONS</strong></h4> 
                    @include('include.terms_and_condition')
                </div>
                <div style="page-break-after: always !important;"></div>
                <div style="text-align:justify;font-size: 11px;">
                    <h4 align="center" style="margin-top: 17px;"><strong>DATA PRIVACY CONSENT FORM</strong></h4> 
                    @include('include.data_privacy_act')
                </div>
            </div>
        </div>          
    </div>
    <div class='panel-footer'>                         
        
    </div>

   
@endsection

@push('bottom')
<script type="text/javascript">
    function printDivision(divName) {
        alert('Please print 2 copies!');
        var generator = window.open(",'printableArea,");
        var layertext = document.getElementById(divName);
        generator.document.write(layertext.innerHTML.replace("Print Me"));
        generator.document.close();
        generator.print();
        generator.close();
    }      

</script>
@endpush


