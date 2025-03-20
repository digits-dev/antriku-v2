@extends('crudbooster::admin_template')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
@include('include.css')
@endpush

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" >
                    <div class="form-group">
                        <h4 style="text-align: center;">Transaction Details</h4><br>
                        <div class="col-md-12">
                            @include('include.comment-box')
                        </div>
                    </div>
                </div>
            </div><br>
            @if(request()->segment(3) == "edit")
                @if($transaction_details->repair_status == 8)
                    <form method="post" action="{{CRUDBooster::mainpath('edit-transaction-process/'.$transaction_details->header_id)}}" id="SubmitTransactionForm">                    
                @else
                     <!-- <form method="post" action="{{CRUDBooster::mainpath('diagnose-transaction-process/'.$transaction_details->header_id)}}" id="SubmitTransactionForm">     -->
                    <form method="post" action="" id="SubmitTransactionForm">                
                @endif
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            @endif
            @include('transaction_details.customer_details')
            <br>
            @include('transaction_details.service_details')
            <br>
            @if($transaction_details->repair_status == 8 && request()->segment(3) == "detail" || CRUDBooster::getModulePath() == "returns_header")
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered-display">
                                    <tbody>
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Warranty Status:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <div class="col-md-12" style="margin-top:7px;">
                                                    @if($transaction_details->warranty_status == "OUT OF WARRANTY")
                                                        <span class="text-danger"><strong>{{ $transaction_details->warranty_status }}</strong></span>
                                                    @elseif($transaction_details->warranty_status == "IN WARRANTY")
                                                        <span class="text-success"><strong>{{ $transaction_details->warranty_status }}</strong></span>
                                                    @elseif($transaction_details->warranty_status == "SPECIAL")
                                                        <span class="text-warning"><strong>{{ $transaction_details->warranty_status }}</strong></span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;width:20%;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Memo Number:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;width:80%;">
                                                <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->memo_no ?? 'N/A' }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Problem Details:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->problem_details }}</div>
                                            </td>
                                        </tr>
                                        @if(!empty($transaction_details->problem_details_other))
                                            <tr>
                                                <td class="table-bordered-display" style="padding: 5px !important;">
                                                    <label class="control-label col-md-12" style="margin-top:7px;">Other Problem Details:</label>
                                                </td>
                                                <td class="table-bordered-display" style="padding: 5px !important;">
                                                    <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->problem_details_other}}</div>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Other Remarks:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->other_remarks ?? 'N/A' }}</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><br>
            @elseif($transaction_details->repair_status == 8 && request()->segment(3) == "getDetailView" || CRUDBooster::getModulePath() == "returns_header")
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered-display">
                                    <tbody>
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Warranty Status:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <div class="col-md-12" style="margin-top:7px;">
                                                    @if($transaction_details->warranty_status == "OUT OF WARRANTY")
                                                        <span class="text-danger"><strong>{{ $transaction_details->warranty_status }}</strong></span>
                                                    @elseif($transaction_details->warranty_status == "IN WARRANTY")
                                                        <span class="text-success"><strong>{{ $transaction_details->warranty_status }}</strong></span>
                                                    @elseif($transaction_details->warranty_status == "SPECIAL")
                                                        <span class="text-warning"><strong>{{ $transaction_details->warranty_status }}</strong></span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;width:20%;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Memo Number:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;width:80%;">
                                                <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->memo_no ?? 'N/A' }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Problem Details:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->problem_details }}</div>
                                            </td>
                                        </tr>
                                        @if(!empty($transaction_details->problem_details_other))
                                            <tr>
                                                <td class="table-bordered-display" style="padding: 5px !important;">
                                                    <label class="control-label col-md-12" style="margin-top:7px;">Other Problem Details:</label>
                                                </td>
                                                <td class="table-bordered-display" style="padding: 5px !important;">
                                                    <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->problem_details_other}}</div>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <label class="control-label col-md-12" style="margin-top:7px;">Other Remarks:</label>
                                            </td>
                                            <td class="table-bordered-display" style="padding: 5px !important;">
                                                <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->other_remarks ?? 'N/A' }}</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><br>
            @elseif($transaction_details->repair_status == 8 && CRUDBooster::getModulePath() == "pay_diagnostic" && request()->segment(3) == "edit")
            
                <div class="row">    
                    <div class="col-md-6">
                        <label class="require control-label col-md-4" style="margin-top:7px;">Memo Number:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="memo_number" id="memo_number" value="{{$transaction_details->memo_no}}" placeholder="Memo Number" required>
                        </div>
                    </div>
                     <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-12">
                                <label class="require control-label col-md-4" style="margin-top:7px;"><span class="requiredField">*</span>Diagnostic Fee:</label>
                                <div class="col-md-8 input-icon">
                                    <input type="hidden" value="{{ (!empty($Diagnostic_Fee)) ? number_format($Diagnostic_Fee, 2, '.', '') : 0 }}" id="diagnostic_original_cost" >
                                    <input name="diagnostic_cost" id="diagnostic_cost" value="{{ (!empty($transaction_details->diagnostic_cost)) ? number_format($transaction_details->diagnostic_cost, 2, '.', '') : 0 }}" onblur="AutoFormatDiagnosticPrice()" placeholder="Diagnostic Fee" type="text" class="form-control" required>
                                    <i>₱</i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6 pull-right">
                                    <button class="btn btn-primary pull-right" style="margin-top:5px" id="add_diagnostic_fee"><i class="fa fa-plus" aria-hidden="true"></i> Add Fee</button>
                                    <button class="btn btn-danger pull-right" style="margin-right:5px;margin-top:5px" id="reset_diagnostic_fee"><i class="fa fa-times" aria-hidden="true"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3" style="margin-top:7px;">
                            <label><span class="requiredField">*</span>Warranty Status:</label>
                        </div>
                        <input type="hidden" id="warranty_status" value="{{$transaction_details->warranty_status}}">
                        <div class="col-md-3" style="margin-top:7px;">
                            <label class="radio-inline control-label text-success"><input type="radio" name="warranty_status" value="IN WARRANTY" onchange="return WarrantyStatusChange(1)" required {{ $transaction_details->warranty_status == 'IN WARRANTY' ? 'checked' : ''}}><strong>IN WARRANTY</strong></label>
                            <br>
                        </div>
                        <div class="col-md-3" style="margin-top:7px;">
                            <label class="radio-inline control-label text-danger"><input type="radio" name="warranty_status" value="OUT OF WARRANTY" onchange="return WarrantyStatusChange(2)" required {{ $transaction_details->warranty_status == 'OUT OF WARRANTY' ? 'checked' : ''}}><strong>OUT OF WARRANTY</strong></label>
                            <br>
                        </div>
                        <div class="col-md-3" style="margin-top:7px;">
                            <label class="radio-inline control-label text-warning"><input type="radio" name="warranty_status" value="SPECIAL" onchange="return WarrantyStatusChange(3)" required {{ $transaction_details->warranty_status == 'SPECIAL' ? 'checked' : ''}}><strong>SPECIAL</strong></label>
                            <br>
                        </div>
                    </div>
                </div>
                <br>
                <?php $problem_details = explode(",", $transaction_details->problem_details); ?>
                @if(request()->segment(3) == "getDetailView" && CRUDBooster::getModulePath() == "transaction_history")
                <div class="row">
                    <div class="col-md-12">
                        <label class="require control-label col-md-2"><span class="requiredField">*</span>Problem Details:</label>
                        <div class="col-md-10" style="margin-top:7px;">
                            <select data-placeholder="Choose problem details here..." class="form-control limitedNumbSelect2" name="problem_details[]" id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100% !important;" required {{ $transaction_details->repair_status == 3 ? 'disabled' : ''}}>
                                @foreach($ProblemDetails as $key=>$pd)
                                    @if(in_array($pd->problem_details, $problem_details))
                                        <option value="{{$pd->problem_details}}" selected>{{$pd->problem_details}}</option>
                                    @else
                                        <option value="{{$pd->problem_details}}" >{{$pd->problem_details}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-md-12">
                        <label class="require control-label col-md-2"><span class="requiredField">*</span>Problem Details:</label>
                        <div class="col-md-10" style="margin-top:7px;">
                            <select data-placeholder="Choose problem details here..." class="form-control limitedNumbSelect2" name="problem_details[]" id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100% !important;" required {{ $transaction_details->repair_status == 3 ? 'disabled' : ''}}>
                                @foreach($data['ProblemDetails'] as $key=>$pd)
                                    @if(in_array($pd->problem_details, $problem_details))
                                        <option value="{{$pd->problem_details}}" selected>{{$pd->problem_details}}</option>
                                    @else
                                        <option value="{{$pd->problem_details}}" >{{$pd->problem_details}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @endif
                <br> 
                @if(!empty($transaction_details->problem_details_other))
                    <div class="row" id="show_other_problem">    
                        <div class="col-md-12">
                            <label class="require control-label col-md-2"><span class="requiredField">*</span>Other Problem Details:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <input type="text" class="form-control" name="problem_details_other" id="problem_details_other" value="{{$transaction_details->problem_details_other}}" placeholder="Type your other problem details here" required>
                            </div>
                        </div>
                    </div>
                    <br>
                @else
                    <div class="row" id="show_other_problem"></div><br>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <label class="require control-label col-md-2">Other Remarks:</label>
                        <div class="col-md-10" style="margin-top:7px;">
                            <textarea placeholder="Type your other remarks here" name="other_remarks" rows="2" class="form-control" {{ $transaction_details->repair_status != 8 ? 'readonly' : '' }}>{{ $transaction_details->other_remarks }}</textarea>
                        </div>
                    </div>
                </div><br>
            @endif

            @if($transaction_details->repair_status != 8)
                @include('transaction_details.technical_report')
                <br>
                @include('transaction_details.diagnostic_results')
                <br>
                @include('transaction_details.quotation')
                <br>
                @include('transaction_details.uploade_receipt')
            @endif
            {{-- <input required id="input-file" name="receipt" multiple type="file"> --}}
            <div class="panel-footer">
                @if(request()->segment(3) == "getDetailView" || CRUDBooster::getModulePath() == "returns_header")
                <a href="{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}" style="margin-left:20px;" class="btn btn-default pull-right"><i class="fa fa-chevron-circle-left"></i> BACK</a>
                @elseif(request()->segment(3) == "edit")
                
                    @if($transaction_details->repair_status == 2 && CRUDBooster::getModulePath() == "to_pay_parts" && CRUDBooster::myPrivilegeId() != 2)
                        <div class="col-md-12 alert alert-info" style="font-size:1.2vw;"><strong>Info! </strong>If the transaction is paid, please click Repair in Process button.</div>
                    @endif
                        
                    <a href="{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}" class="btn btn-default pull-left"><i class="fa fa-chevron-circle-left"></i> BACK</a>
                    <input type="hidden" value="{{$data['transaction_details']->header_id}}" name="header_id" id="header_id">
                   
                    @if($transaction_details->repair_status != 8)
                        <input type="hidden" name="mainpath" id="mainpath" value="{{CRUDBooster::mainpath()}}">
                        <input type="hidden" id="warranty_status" value="{{$transaction_details->warranty_status}}">
                        <input type="hidden" name="action" id="action" value="">
                        <input type="hidden" id="case_type" value="{{$transaction_details->case}}">
                    @endif

                    @if(CRUDBooster::myPrivilegeId() == 2 && $transaction_details->repair_status == 4 && CRUDBooster::getModulePath() == "repair_in_process")
                        <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
                    @endif
                    
                    @if(CRUDBooster::myPrivilegeId() == 4 && $transaction_details->repair_status == 2 && CRUDBooster::getModulePath() == "to_pay_parts")
                        <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
                    @endif
                    
                    @if(CRUDBooster::myPrivilegeId() == 2 && $transaction_details->repair_status == 7 && CRUDBooster::getModulePath() == "to_close")
                        <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
                    @endif
                    
                    @if($transaction_details->repair_status == 8 && CRUDBooster::getModulePath() == "pay_diagnostic")
                        <button type="submit" id="paid" onclick="return changeStatus(1)" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-check-square-o"></i> PAID</button>
                    @elseif($transaction_details->repair_status == 9 && CRUDBooster::getModulePath() == "to_diagnose")
                        <button type="submit" id="call_out_mail_in"  onclick="return validateBeforeChangeStatus(10)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px; {{ empty($transaction_details->case) || $transaction_details->case == 'CARRY-IN' ? 'display: none;' : '' }}">PENDING CUSTOMER'S APPROVAL</button>
                        <button type="submit" id="ongoing_repair" onclick="return validateBeforeChangeStatus(13)" class="btn btn-primary pull-right buttonSubmit"  style="margin-left: 20px; {{ $transaction_details->warranty_status != 'OUT OF WARRANTY' && $transaction_details->case == 'CARRY-IN' ? '' : 'display: none;' }}">ONGOING REPAIR</button>
                        <button type="submit" id="pending_spare_parts" onclick="return validateBeforeChangeStatus(14)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px; {{ $transaction_details->warranty_status != 'OUT OF WARRANTY' && $transaction_details->case == 'CARRY-IN' ? '' : 'display: none;' }}">PENDING SPARE PARTS</button>
                        <button type="submit" id="for_customer_payment" onclick="return validateBeforeChangeStatus(17)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px; {{ $transaction_details->warranty_status == 'OUT OF WARRANTY' && $transaction_details->case == 'CARRY-IN' ? '' : 'display: none;' }}">For Customer’s Payment</button>

                        <button type="submit" id="save"  buttonSubmit onclick="return validateBeforeChangeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
                        <button type="submit" id="reject" onclick="return changeStatus(3)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>
                        <button type="submit" id="repair" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> SEND QUOTATION</button>
                        <button type="submit" id="pay_diagnostic" onclick="return changeStatus(8)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-backward" aria-hidden="true"></i> REWIND</button>
                    @elseif($transaction_details->repair_status == 2 && CRUDBooster::getModulePath() == "to_pay_parts" && CRUDBooster::myPrivilegeId() != 2)
                        <button type="submit" id="reject" onclick="return changeStatus(3)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>
                        <button type="submit" id="repair_in_process" onclick="return changeStatus(4)" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> REPAIR IN PROCESS</button>
                    @elseif($transaction_details->repair_status == 4 && CRUDBooster::getModulePath() == "repair_in_process" && CRUDBooster::myPrivilegeId() != 2)
                        <button type="submit" id="pickup" onclick="return changeStatus(7)" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> TO PICK UP</button>
                    @elseif($transaction_details->repair_status == 3 && CRUDBooster::getModulePath() == "to_close" && CRUDBooster::myPrivilegeId() != 2)
                        <button type="submit" id="void" onclick="return changeStatus(5)" class="btn btn-danger pull-right buttonSubmit"/><i class="fa fa-check-square-o" aria-hidden="true"></i> CANCELLED/CLOSE</button>
                    @elseif($transaction_details->repair_status == 7 && CRUDBooster::getModulePath() == "to_close" && CRUDBooster::myPrivilegeId() != 2)
                        <button type="submit" id="close" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> CLOSE</button>
                    @endif 
                    @if($transaction_details->repair_status == 8 || $transaction_details->repair_status == 7)    
                        @if(CRUDBooster::myPrivilegeId() != 2)    
                            <button type="submit" id="send" onclick="return changeStatus('send')" class="btn btn-primary pull-right buttonSubmit"><i class="fa fa-envelope"></i> SEND PAYMENT LINK</button>
                        @endif 
                    @endif 
                    @if ($transaction_details->repair_status == 10 && CRUDBooster::getModulePath() == "call_out")
                        <button type="submit" id="save" onclick="return changeStatus(11)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> APPROVE</button>
                        <button type="submit" id="reject" onclick="return changeStatus(3)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>
                    @endif
                    @if ($transaction_details->repair_status == 11 && CRUDBooster::getModulePath() == "pending_mail_in_shipment")
                        @if ($transaction_details->warranty_status == 'IN WARRANTY')
                            <button type="submit" id="save" onclick="return changeStatus(12)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-paper-plane" aria-hidden="true"></i> MAIL-IN SHIPPED</button>
                        @else
                            <button type="submit" id="save" onclick="return changeStatus(16)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-paper-plane" aria-hidden="true"></i> SHIPPED</button>
                        @endif
                    @endif
                    @if ($transaction_details->repair_status == 12 && CRUDBooster::getModulePath() == "pending_mail_in_shipment")
                        <button type="submit" id="save" onclick="return changeStatus(21)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-phone" aria-hidden="true"></i> FOR CALL-OUT</button>
                    @endif
                    @if ($transaction_details->repair_status == 13 && CRUDBooster::getModulePath() == "pending_repair")
                        <button type="submit" id="save" onclick="return changeStatus(21)" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-check" aria-hidden="true"></i> Repair Completed</button>
                    @endif
                    @if ($transaction_details->repair_status == 14 && CRUDBooster::getModulePath() == "pending_spare_parts")
                        <button type="submit" id="save" onclick="return changeStatus(15)" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-check" aria-hidden="true"></i> Spare Parts Received</button>
                    @endif
                    @if ($transaction_details->repair_status == 15 && CRUDBooster::getModulePath() == "spare_parts_received")
                        <button type="submit" id="save" onclick="return changeStatus(13)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-circle-o" aria-hidden="true"></i> Ongoing Repair</button>
                    @endif
                    @if ($transaction_details->repair_status == 16 && CRUDBooster::getModulePath() == "to_diagnose")
                        <button type="submit" id="save" onclick="return changeStatus(17)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-circle-o" aria-hidden="true"></i> PENDING CUSTOMER'S PAYMENT</button>
                    @endif
                    @if ($transaction_details->repair_status == 17 && CRUDBooster::getModulePath() == "call_out")
                        @if ($transaction_details->case == 'CARRY-IN')                        
                            <button type="submit" id="save" onclick="return validateBeforeChangeStatus(18)" class="btn btn-success pull-right buttonSubmit available_btn" style="margin-left: 20px;"><i class="fa fa-money" style="margin-right: 3px" aria-hidden="true"></i> Replacement Parts Paid</button>
                            <button type="submit" id="save" onclick="return validateBeforeChangeStatus(19)" class="btn btn-primary pull-right buttonSubmit unavailable_btn" style="margin-left: 20px;"><i class="fa fa-money" style="margin-right: 3px" aria-hidden="true"></i> Replacement Parts Paid</button>
                        @else
                            <button type="submit" id="save" onclick="return validateBeforeChangeStatus(18)" class="btn btn-success pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-money" style="margin-right: 3px" aria-hidden="true"></i> Replacement Parts Paid</button>
                        @endif
                    @endif
                    @if ($transaction_details->repair_status == 18 && CRUDBooster::getModulePath() == "pending_repair")
                        @if ($transaction_details->warranty_status == 'OUT OF WARRANTY' && $transaction_details->case == 'CARRY-IN')
                        <button type="submit" id="save" onclick="return changeStatus(13)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-circle-o" style="margin-right: 3px" aria-hidden="true"></i> Ongoing Repair</button>
                        @else
                        <button type="submit" id="save" onclick="return changeStatus(22)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-circle-o" style="margin-right: 3px" aria-hidden="true"></i> Ongoing Repair</button>
                        @endif
                    @endif
                    @if ($transaction_details->repair_status == 19 && CRUDBooster::getModulePath() == "pending_repair")
                        <button type="submit" id="pending_spare_parts" onclick="return validateBeforeChangeStatus(14)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"> <i class="fa fa-circle-o"></i> PENDING SPARE PARTS</button>
                    @endif
                    @if ($transaction_details->repair_status == 22 && CRUDBooster::getModulePath() == "pending_good_unit")
                    <button type="submit" id="save" onclick="return changeStatus(21)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"> <i class="fa fa-circle-o"></i> FOR CALL-OUT (GOOD UNIT)</button>
                @endif
                @endif
            </div>
            @if(request()->segment(3) == "edit") </form> @endif 
        </div>
    </div>
@endsection

@push('bottom')
    @if($transaction_details->repair_status == 8)
        @include('frontliner.to_pay_diagnostic_transactions_script')
        @include('technician.quotation_script')
    @else
        @include('technician.to_diagnose_transaction_script')
    @endif 

    <script>
        $(document).ready(function() {
            let all_item_qty = $('.getqtyValue').map(function() {
                return $(this).val().trim().toLowerCase(); 
            }).get(); 

            if (all_item_qty.includes("unavailable")) {
                $('.unavailable_btn').show();
                $('.available_btn').hide();
            } else {
                $('.unavailable_btn').hide();
                $('.available_btn').show();
            }
        });
    </script>
@endpush