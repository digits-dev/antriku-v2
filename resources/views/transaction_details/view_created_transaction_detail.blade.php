@extends('crudbooster::admin_template')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@include('include.css')
<style>
    .content{
       padding: 0;
    }
   
    .content-header{
       display: none;
    }
    
    .cust-ch{
        margin-top: 50px;
    }
    
    @media (max-width: 767px) {
        .cust-ch {
            margin-top: 100px;
        }
    }
</style>
@endpush

@section('content')
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
                                    <h1>
                                        Transaction Details
                                    </h1>
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
                @if($transaction_details->repair_status == 8)
                    <form method="post" action="{{CRUDBooster::mainpath('edit-transaction-process/'.$transaction_details->header_id)}}" id="SubmitTransactionForm">                    
                @else
                     <!-- <form method="post" action="{{CRUDBooster::mainpath('diagnose-transaction-process/'.$transaction_details->header_id)}}" id="SubmitTransactionForm">     -->
                    <form method="post" action="" id="SubmitTransactionForm">                
                @endif
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            @endif
            @include('transaction_details.customer_details')
            @include('transaction_details.service_details')
            
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
            <section class="card-cust" style="border-radius: 0%;">
                <div class="row">    
                    <div class="col-md-6">
                        <label class="require label-cus col-md-4" style="margin-top:7px;">Memo Number:</label>
                        <div class="col-md-8">
                            <input type="text" class="input-cus" name="memo_number" id="memo_number" value="{{$transaction_details->memo_no}}" placeholder="Memo Number" required>
                        </div>
                    </div>
                     <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-12">
                                <label class="require label-cus col-md-4" style="margin-top:7px;"><span class="requiredField">*</span>Diagnostic Fee:</label>
                                <div class="col-md-8 input-icon">
                                    <input type="hidden" value="{{ (!empty($Diagnostic_Fee)) ? number_format($Diagnostic_Fee, 2, '.', '') : 0 }}" id="diagnostic_original_cost" >
                                    <input name="diagnostic_cost" id="diagnostic_cost" value="{{ (!empty($transaction_details->diagnostic_cost)) ? number_format($transaction_details->diagnostic_cost, 2, '.', '') : 0 }}" onblur="AutoFormatDiagnosticPrice()" placeholder="Diagnostic Fee" type="text" class="input-cus" required>
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
                    <div class="col-md-12" style="margin: 7px">
                        <label class="label-cus" style="margin: 0 5px 0 5px"><span class="requiredField">*</span>Warranty Status:</label>
                    </div>
                    <input type="hidden" id="warranty_status" value="{{$transaction_details->warranty_status}}">
                    <div class="col-md-12">
                        <div class="row" style="margin: 0 5px 0 5px">
                            <div class="col-md-4">
                                <label class="warranty-option-cus">
                                    <div class="radio-container-cus">
                                    <input type="radio" name="warranty_status" value="IN WARRANTY" onchange="return WarrantyStatusChange(1)" required {{ $transaction_details->warranty_status == 'IN WARRANTY' ? 'checked' : ''}}>
                                    <span class="radio-custom"></span>
                                    </div>
                                    <div class="option-content-cus">
                                    <div class="option-title-cus">In Warranty</div>
                                    <div class="option-description-cus">Product is covered under manufacturer warranty</div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label class="warranty-option-cus">
                                    <div class="radio-container-cus">
                                    <input type="radio" name="warranty_status" value="OUT OF WARRANTY" onchange="return WarrantyStatusChange(2)" required {{ $transaction_details->warranty_status == 'OUT OF WARRANTY' ? 'checked' : ''}}>
                                    <span class="radio-custom"></span>
                                    </div>
                                    <div class="option-content-cus">
                                    <div class="option-title-cus">Out of Warranty</div>
                                    <div class="option-description-cus">Product warranty has expired</div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label class="warranty-option-cus">
                                    <div class="radio-container-cus">
                                    <input type="radio" name="warranty_status" value="SPECIAL" onchange="return WarrantyStatusChange(3)" required {{ $transaction_details->warranty_status == 'SPECIAL' ? 'checked' : ''}}>
                                    <span class="radio-custom"></span>
                                    </div>
                                    <div class="option-content-cus">
                                    <div class="option-title-cus">Special Coverage</div>
                                    <div class="option-description-cus">Extended warranty or special program</div>
                                    </div>
                                </label>
                            </div>
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
                        <div class="col-md-12" style="margin-top:7px;">
                            <label class="require label-cus"><span class="requiredField">*</span>Problem Details:</label>
                            <select data-placeholder="Choose problem details here..." class="input-cus limitedNumbSelect2" name="problem_details[]" id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100% !important;" required {{ $transaction_details->repair_status == 3 ? 'disabled' : ''}}>
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
                            <div class="col-md-12" style="margin-top:7px;">
                                <label class="require label-cus"><span class="requiredField">*</span>Other Problem Details:</label>
                                <input type="text" class="input-cus" name="problem_details_other" id="problem_details_other" value="{{$transaction_details->problem_details_other}}" placeholder="Type your other problem details here" required>
                            </div>
                        </div>
                    </div>
                    <br>
                @else
                <div class="row" id="show_other_problem"></div><br>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top:7px;">
                            <label class="require label-cus">Other Remarks:</label>
                            <textarea placeholder="Type your other remarks here" name="other_remarks" rows="2" class="input-cus" {{ $transaction_details->repair_status != 8 ? 'readonly' : '' }}>{{ $transaction_details->other_remarks }}</textarea>
                        </div>
                    </div>
                </div><br>
            </section>
            @endif

            @if($transaction_details->repair_status != 8)
                @include('transaction_details.technical_report')
                @if (CRUDBooster::myPrivilegeId() != 9)
                    @include('transaction_details.diagnostic_results')
                @endif
                @include('transaction_details.quotation')
            @endif

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
                    @elseif($transaction_details->repair_status == 1 && CRUDBooster::getModulePath() == "to_diagnose")
                        <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
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
@endpush