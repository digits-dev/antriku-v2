@extends('crudbooster::admin_template')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
@include('include.css')
<style>
    .center-img {
        height: 80%;
        max-width: 100%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .table-bordered-display { border: 1px solid #B8B8B8 !important; }
    .select2-container--default .select2-selection--multiple {
        border-radius: 0px !important;
    }
</style>
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
            </div>
            <br>
            <form method="post" action="{{CRUDBooster::mainpath('edit-transaction-process/'.$transaction_details->header_id)}}" id="SubmitTransactionForm">                    
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <div class="row">
                <div class="col-md-12">
                    <div class="row"> 
                        <div class="col-md-12">
                            <div style="background:#595959;color:white;padding:3px;text-align: center;">
                                <h4>Customer Details</h4>  
                            </div> 
                        </div>  
                    </div>  
                    <br>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="table-responsive borderline">
                            <table class="table table-bordered-display">
                                <tbody>
                                    <tr>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.first_name') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->first_name}}</div>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.last_name') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->last_name}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.email_address') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">
                                                <input type="input" name="email" value="{{$transaction_details->email}}" placeholder="Email Address" class="form-control" autocomplete="off" required/>   
                                            </div>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.contact_no') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">
                                                <input type="input" name="contact_no" value="{{$transaction_details->contact_no}}" placeholder="09#########" pattern="[09][0-9]{10}" class="form-control" autocomplete="off" required/>                  
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Company Name:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->company_name ?? 'N/A'}}</div>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Company Contact#:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->company_contact_no ?? 'N/A'}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Address:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->address ?? 'N/A'}}</div>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Reference#:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;"><strong>{{$transaction_details->reference_no}}</strong></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div class="row"> 
                        <div class="col-md-12">
                            <div style="background:#595959;color:white;padding:3px;text-align: center;">
                                <h4>Service Details</h4>  
                            </div> 
                        </div> 
                    </div>  
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="table-responsive borderline">
                            <table class="table table-bordered-display">
                                <tbody>
                                    <tr>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.purchase_date') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ date('F j, Y', strtotime($transaction_details->purchase_date)) }}</div>
                                        </td>
                                        <td class="table-bordered-display text-center" style="padding:5px !important;width:50%;background-color:#EDEDED;" rowspan="7">
                                            <div class="col-md-12" style="height:340px;background-color:#EDEDED;min-width: 340px;width: 100%;"> 
                                                <img src="{{ URL::to('/') }}/{{ $transaction_details->model_photo }}" class="center-img"/>
                                            </div> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.warranty_expiration_date') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ date('F j, Y', strtotime($transaction_details->warranty_expiration_date)) }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">UPC Code:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->header_upc_code }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.table.item_description') }}: </label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->header_item_description }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.table.serial_no') }}:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->header_serial_no }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Branch:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $data['branch']->branch_name }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Model: </label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->model_name }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Summary of Concern:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;" colspan="2">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->summary_of_concern }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">    
                <div class="col-md-12">
                    <label class="require control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Memo Number:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="memo_number" id="memo_number" value="{{$transaction_details->memo_no}}" placeholder="Memo Number" required>
                    </div>
                </div>
            </div>
            <br>
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
            @if($transaction_details->repair_status == 8 && CRUDBooster::getModulePath() == "pay_diagnostic")
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
            @else
                <div class="row">
                    <div class="col-md-2">
                        <label class="control-label col-md-12">Problem Details:</label>
                        <div class="col-md-10" style="margin-top:7px;">{{ $transaction_details->problem_details }}</div>
                    </div>
                </div>
            @endif
            <br> 
            @if($transaction_details->repair_status == 8 && CRUDBooster::getModulePath() == "pay_diagnostic")
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
            @else
                @if(!empty($transaction_details->problem_details_other))
                    <div class="row" id="show_other_problem">    
                        <div class="col-md-12">
                            <label class="control-label col-md-2">Other Problem Details:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                {{$transaction_details->problem_details_other}}
                            </div>
                        </div>
                    </div>
                    <br>
                @else
                    <div class="row" id="show_other_problem"></div><br>
                @endif
            @endif
            <div class="row">
                <div class="col-md-12">
                    <label class="require control-label col-md-2">Other Remarks:</label>
                    <div class="col-md-10" style="margin-top:7px;">
                        <textarea placeholder="Type your other remarks here" name="other_remarks" rows="2" class="form-control" {{ $transaction_details->repair_status != 8 ? 'readonly' : '' }}>{{ $transaction_details->other_remarks }}</textarea>
                    </div>
                </div>
            </div>
            <br> 
            <div class="panel-footer">
                <input type="hidden" value="{{$data['transaction_details']->header_id}}" name="header_id" id="header_id">
                @if($transaction_details->repair_status == 8 && CRUDBooster::getModulePath() == "pay_diagnostic")
                    <input type="submit" id="paid" onclick="return changeStatus(1)" class="btn btn-success pull-right buttonSubmit" value="PAID" style="margin-left: 20px;"/>
                    <input type="submit" id="send_link" onclick="return changeStatus(0)" class="btn btn-primary pull-right buttonSubmit" value="SEND PAYMENT LINK"/>
                    <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default pull-left" id="back">BACK</a>
                @else
                    <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-primary pull-right">BACK</a>
                @endif       
            </div>
            </form>
        </div>
    </div>
@endsection
@push('bottom')
@include('frontliner.to_pay_diagnostic_transactions_script')
@include('include.comment-box-script')
@endpush