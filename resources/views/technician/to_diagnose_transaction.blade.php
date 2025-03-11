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

    .diagnose-header {
        background: #4B79A1; 
        background: -webkit-linear-gradient(to right, #283E51, #4B79A1); 
        background: linear-gradient(to right, #283E51, #4B79A1);
        padding: 6px;
        color:white;
        text-align:center;
    }

    .borderline {
        border-top-style: solid;
        border-top-color: #B8B8B8;
        border-top-width: 1px;
        padding-top: 10px;
    }
    li:hover {
        background-color: #3c8dbc;
        color:white;
    }

    .sparepartlist{
        border: 1px solid slategray !important;
        position: absolute;
        display:none; 
        min-width: 170px;
        width: auto;
        height: auto;
        white-space: nowrap;
    }

    .li-padding {
        padding: 3px 5px;
    }
</style>
@endpush

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" >
                    <div class="form-group">
                        <h4 style="text-align: center;">Diagnose Transaction</h4><br>
                        <div class="col-md-12" >
                            @include('include.comment-box')
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <form method="post" action="{{CRUDBooster::mainpath('diagnose-transaction-process/'.$transaction_details->header_id)}}" id="SubmitTransactionForm">                    
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
                        <div class="table-responsive">
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
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->email}}</div>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.contact_no') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->contact_no}}</div>
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
                    <br>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="table-responsive">
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
                                            <label class="control-label col-md-12" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.warranty_expiration_date') }}</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">
                                                <input type="input" name="warranty_expiration_date" placeholder="MM/DD/YYYY" id="warranty_expiration_date" value="{{ date('m/d/Y', strtotime($transaction_details->warranty_expiration_date)) }}" class="form-control" autocomplete="off" required {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}/>                        
                                            </div>
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
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div class="row"> 
                        <div class="col-md-12">
                            <div style="background:#595959;color:white;padding:3px;text-align: center;">
                                <h4>Technical Report</h4>  
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
                                <label class="radio-inline control-label text-success"><input type="radio" name="warranty_status" value="IN WARRANTY" onchange="return WarrantyStatusChange(1)" required {{ $transaction_details->warranty_status == 'IN WARRANTY' ? 'checked' : ''}} {{ $transaction_details->repair_status != 9 ? 'disabled' : ''}}><strong>IN WARRANTY</strong></label>
                                <br>
                            </div>
                            <div class="col-md-3" style="margin-top:7px;">
                                <label class="radio-inline control-label text-danger"><input type="radio" name="warranty_status" value="OUT OF WARRANTY" onchange="return WarrantyStatusChange(2)" required {{ $transaction_details->warranty_status == 'OUT OF WARRANTY' ? 'checked' : ''}} {{ $transaction_details->repair_status != 9 ? 'disabled' : ''}}><strong>OUT OF WARRANTY</strong></label>
                                <br>
                            </div>
                            <div class="col-md-3" style="margin-top:7px;">
                                <label class="radio-inline control-label text-warning"><input type="radio" name="warranty_status" value="SPECIAL" onchange="return WarrantyStatusChange(3)" required {{ $transaction_details->warranty_status == 'SPECIAL' ? 'checked' : ''}} {{ $transaction_details->repair_status != 9 ? 'disabled' : ''}}><strong>SPECIAL</strong></label>
                                <br>
                            </div>
                        </div>
                    </div> 
                    <br>
                    <?php $problem_details = explode(",", $transaction_details->problem_details); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Problem Details:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <select class="form-control limitedNumbSelect2" name="problem_details[]" id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100%" required>
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
                    <br>
                    @if(!empty($transaction_details->problem_details_other))
                        <div class="row" id="show_other_problem">    
                            <div class="col-md-12">
                                <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Other Problem Details:</label>
                                <div class="col-md-10" style="margin-top:7px;">
                                    <input type="text" class="form-control" name="problem_details_other" value="{{$transaction_details->problem_details_other}}" placeholder="Type your other problem details here" {{ $transaction_details->repair_status != 9 ? 'readonly' : '' }}>
                                </div>
                            </div>
                        </div>
                        <br>
                    @else
                        <div class="row" id="show_other_problem"></div><br>
                    @endif
                    <div class="row">    
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;">Other Remarks:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <textarea placeholder="Type your other remarks here" name="other_remarks" rows="2" class="form-control" {{ $transaction_details->repair_status != 9 ? 'readonly' : '' }}>{{ $transaction_details->other_remarks }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">    
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Device Issue Description:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <textarea placeholder="Type your device issue description here" name="device_issue_description" rows="2" class="form-control" required {{ $transaction_details->repair_status != 9 ? 'readonly' : '' }}>{{ $transaction_details->device_issue_description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">    
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Findings:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <textarea placeholder="Type your findings here" name="findings" rows="2" class="form-control" required {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}>{{ $transaction_details->findings }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">    
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Resolution:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <textarea placeholder="Type your resolution here" name="resolution" rows="2" class="form-control" required {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}>{{ $transaction_details->resolution }}</textarea>
                            </div>
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
                                <h4>Diagnostic Results</h4>  
                            </div> 
                        </div> 
                    </div> 
                    <br>    
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <table class="table table-bordered-display">
                                    <tbody>
                                        <?php 
                                            $test_type = explode(',', $data['diagnostic_test'][0]->test_type);
                                            $test_result = explode(',', $data['diagnostic_test'][0]->test_result);
                                            $show = false;
                                            $counter = 0; 
                                        ?>
                                        <tr class="tbl_header_color" style="padding: 1px !important;">
                                            <th width="60%" class="text-center table-bordered-display" style="padding: 5px !important;border-width: 1px !important;">Test Type:</th>
                                            <th width="40%" class="text-center table-bordered-display" style="padding: 5px !important;border-width: 1px !important;" colspan="4">Result:</th>
                                        </tr>

                                        @if($transaction_details->repair_status != 9)
                                            @foreach($data['TechTesting']  as $key=>$dt)
                                                <?php 
                                                    $ModelGroupTech = explode(",", $dt->model_group_id);
                                                ?>
                                                @if(in_array($data['transaction_details']->model_group, $ModelGroupTech))
                                                    <tr>
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 1px 1px 1px !important;"><span>{{$dt->description}}</span></td>
                                                        @if(count($test_result) <= 0)
                                                            @foreach($test_result as $tr)
                                                                <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                                    @if($tr == 1)
                                                                        <span class="text-success"><strong>Passed</strong></span>
                                                                    @elseif($tr == 2)
                                                                        <span class="text-warning"><strong>Warning</strong></span>
                                                                    @elseif($tr == 3)
                                                                        <span class="text-danger"><strong>Failed</strong></span>
                                                                    @else
                                                                        <span class="text-dark"><strong>N/A</strong></span>
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        @else
                                                            <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                                <span class="text-dark"><strong>N/A</strong></span>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <?php $counter++; ?>
                                                @else
                                                    @if($key == count($data['TechTesting']))
                                                        <?php $show = true; ?>
                                                    @endif
                                                @endif
                                            @endforeach
                                            @if($show)
                                                <tr>
                                                    <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;background-color:#EDEDED;text-align: center;" colspan="2">
                                                    <p>NO RESULT FOUND.</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            @foreach($data['TechTesting']  as $key=>$dt)
                                                <?php 
                                                    $ModelGroupTech = explode(",", $dt->model_group_id); 
                                                ?>
                                                @if(in_array($data['transaction_details']->model_group, $ModelGroupTech))
                                                    <tr>
                                                        <input type="hidden" name="test_result_id[]" value="{{$dt->id}}">
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 1px 1px 1px !important;"><span>{{$dt->description}}</span></td>
                                                    
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                            <input type="radio" name="test_result_{{$dt->id}}" value="1" {{ $test_result[$counter] == 1 ? 'checked' : ''}}> 
                                                            <span class="text-success"><strong>Passed</strong></span>
                                                        </td>
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                            <input type="radio" name="test_result_{{$dt->id}}" value="2" {{ $test_result[$counter] == 2 ? 'checked' : ''}}> 
                                                            <span class="text-warning"><strong>Warning</strong></span>
                                                        </td>
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                            <input type="radio" name="test_result_{{$dt->id}}" value="3" {{ $test_result[$counter] == 3 ? 'checked' : ''}}> 
                                                            <span class="text-danger"><strong>Failed</strong></span>
                                                        </td>
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                            <input type="radio" name="test_result_{{$dt->id}}" value="4" {{ $test_result[$counter] == 4 || empty($test_result[$counter]) ? 'checked' : ''}}> 
                                                            <span class="text-dark"><strong>N/A</strong></span>
                                                        </td>
                                                    </tr>
                                                    <?php $counter++; ?>
                                                @endif
                                            @endforeach
                                            @if($counter == 0)
                                                <tr>
                                                    <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;background-color:#EDEDED;text-align: center;" colspan="2">
                                                    <p>NO RESULT FOUND.</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">    
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Other Diagnostic Information:</label>
                            <div class="col-md-10">
                                <textarea placeholder="Type your other diagnostic information here" name="other_diagnostic" rows="2" class="form-control" required {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}>{{ $transaction_details->other_diagnostic }}</textarea>
                            </div>
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
                                <h4>Quotation of Repair</h4>  
                            </div> 
                        </div> 
                    </div> 
                    <br>    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col-md-4 control-label"  style="font-size: 1.1em;"><strong>Memo Number: </strong></label>
                                            <div class="col-md-8">
                                                <input class="form-control" style="font-weight:bolder;font-size: 1.2em;" type="text" name="memo_number" value="{{$transaction_details->memo_no}}" {{ $transaction_details->memo_no != null && $transaction_details->repair_status == 9 ? 'readonly' : ''}} {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}> 
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col-md-4 control-label" style="font-size: 1.1em;"><strong>Software Fee: </strong></label>
                                            <div class="col-md-8 input-icon">
                                                <input type="hidden" value="{{ number_format($transaction_details->software_fee, 2, '.', '') }}" id="diagnostic_payment_fee">
                                                <input class="form-control" style="font-weight:bolder;font-size: 1.2em;" type="text" id="software_cost" name="software_cost" onblur="AutoFormatPrice()" value="{{ number_format($transaction_details->software_cost, 2, '.', '') }}" {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}> 
                                                <i>₱</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-8 pull-right">
                                                <button class="btn btn-danger" style="margin-right:5px;margin-top:5px" onclick="ResetFee()" id="reset_fee">Reset</button>
                                                <button class="btn btn-primary" style="margin-top:5px" onclick="AddFee()" id="add_fee"><i class="fa fa-plus" aria-hidden="true"></i> Add Fee</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12 ">
                                <button onclick="AddQuotation()" id="addQuotes" style="margin-top:5px" class="btn btn-warning pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Parts</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          

            <div class="row">
                <div class="col-md-12">
                    <div class="box-body">
                        <div class="table-responsive borderline" style="overflow-x:unset !important;">
                            <div class="pic-container">
                                <div class="pic-row">
                                    <table class="table table-bordered" id="dynamic_field">
                                        <tbody>
                                            <tr class="tbl_header_color" style="padding: 1px !important;">
                                                <th width="10%" class="text-center" style="padding: 1px !important;">Spare Part#</th>
                                                <th width="10%" class="text-center" style="padding: 1px !important;">GSX Reference</th>
                                                <th width="10%" class="text-center" style="padding: 1px !important;">CS Code</th>
                                                <th width="10%" class="text-center" style="padding: 1px !important;">Serial#</th>
                                                <th width="10%" class="text-center" style="padding: 1px !important;">Digits Code</th>
                                                <th width="10%" class="text-center" style="padding: 1px !important;">Item Description</th>
                                                <th width="9%" class="text-center" style="padding: 1px !important;">Price</th>
                                                <th width="1%" class="text-center" style="padding: 1px !important;">      </th>
                                            </tr>
                                            <tr id="quotelist">
                                                @if(count($data['quotation'])>0)
                                                    @foreach($data['quotation'] as $qt)
                                                        <tr class="nr row_num" id="rowID{{$qt->id}}">
                                                            <input type="hidden"class="getidValue" value="{{$qt->id}}">
                                                            <td style="padding: 1px !important;"><input class="form-control text-center getscValue" type="text" id="service_code_{{$qt->id}}" oninput="gsx_data('{{$qt->id}}')" value="{{ $qt->service_code }}" placeholder="Enter Spare Part Number" readonly {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}></td>
                                                            <td style="padding: 1px !important;"><input class="form-control text-center getgsxValue" type="text" id="gsx_code_{{$qt->id}}"  value="{{ $qt->gsx_ref }}" placeholder="Enter GSX Reference" {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}></td>
                                                            <td style="padding: 1px !important;"><input class="form-control text-center getcsValue" type="text" id="cs_code_{{$qt->id}}" value="{{ $qt->cs_code }}" placeholder="Enter CS Code" {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}></td>
                                                            <td style="padding: 1px !important;"><input class="form-control text-center getserialValue" type="text" value="{{ $qt->serial_no }}" placeholder="Enter Serial Number" {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}></td>
                                                            <td style="padding: 1px !important;"><input class="form-control text-center getdcValue" type="text" id="digits_code_{{$qt->id}}" value="{{ $qt->digits_code }}" placeholder="Enter Item Code" readonly {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}></td>
                                                            <td style="padding: 1px !important;"><input class="form-control text-center getitemValue" type="text" id="item_desc_{{$qt->id}}" value="{{ $qt->item_description }}" placeholder="Enter Item Description" readonly {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}></td>
                                                            <td style="padding: 1px !important;"><input class="form-control text-center getcostValue" type="number" onblur="AutoFormatCost('{{$qt->id}}')" id="price_{{$qt->id}}" value="{{ $qt->cost }}" min="0" max="9999" step="any" placeholder="Enter Price" {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}></td> 
                                                            @if($transaction_details->repair_status == 9) <td style="padding: 5px !important;" class="text-center"><a onclick="RemoveRow('{{$qt->id}}')"><i class="fa fa-close fa-2x remove" style="color:red"></i></a></td> @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tr>
                                            <tr class="nr row_num" {{ $transaction_details->repair_status != 9 ? 'hidden' : ''}}>
                                                <input type="hidden"class="getidValue" value="">
                                                <td style="padding: 1px !important;position: relative;">
                                                    <input class="form-control text-center getscValue"  type="text" value="" id="service_code" oninput="gsx_data('service_code')" placeholder="Enter Spere Part Number">
                                                    <ul class="form-control ui-front sparepartlist ui-menu ui-widget ui-widget-content">
                                                        <li class="li-padding">Loading...</li>
                                                    </ul>
                                                   
                                                </td>
                                                <td style="padding: 1px !important;"><input class="form-control text-center getgsxValue" type="text" value="" id="gsx_ref"  placeholder="Enter GSX Reference"></td>
                                                <td style="padding: 1px !important;"><input class="form-control text-center getcsValue" type="text" value="" id="cs_code" placeholder="Enter CS Code"></td>
                                                <td style="padding: 1px !important;"><input class="form-control text-center getserialValue" type="text" value="" id="serial_no" placeholder="Enter Serial Number"></td>
                                                <td style="padding: 1px !important;"><input class="form-control text-center getdcValue" type="text" value="" id="digits_code" placeholder="Enter Item Code"></td>
                                                <td style="padding: 1px !important;"><input class="form-control text-center getitemValue" type="text" value="" id="item_desc" placeholder="Enter Item Description"></td>
                                                <td style="padding: 1px !important;"><input class="form-control text-center getcostValue" type="number" value="" onblur="AutoFormatCost('cost')" id="cost" min="0" max="9999" step="any"  placeholder="Enter Price"></td> 
                                                <td style="padding: 5px !important;" class="text-center"></td>
                                            </tr>
                                            <input type="hidden" name="header_id" id="header_id" value="{{ $transaction_details->header_id }}">
                                            <input type="hidden" name="number_of_rows" id="number_of_rows">
                                            <input type="hidden" name="row_id" id="rowidArray">
                                            <input type="hidden" name="gsx_ref" id="gsxArray">
                                            <input type="hidden" name="cs_code" id="csArray">
                                            <input type="hidden" name="service_code" id="scArray">
                                            <input type="hidden" name="serial_no" id="serialArray">
                                            <input type="hidden" name="digits_code" id="dcArray">
                                            <input type="hidden" name="item_desc" id="itemArray">
                                            <input type="hidden" name="cost" id="costArray">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $problem_details = explode(",", $transaction_details->problem_details); ?>
            <br>    
            <div class="panel-footer">
                <input type="hidden" name="mainpath" id="mainpath" value="{{CRUDBooster::mainpath()}}"/>
                @if($transaction_details->repair_status == 9)
                    <input type="submit" id="save" onclick="return changeStatus(0)" class="btn btn-primary pull-right buttonSubmit" value="SAVE" style="margin-left: 20px;"/>
                @endif
                @if($transaction_details->repair_status == 9 || $transaction_details->repair_status == 2)
                    <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default pull-left" id="back">BACK</a>
                    <input type="submit" id="reject" onclick="return changeStatus(3)" class="btn btn-danger pull-right buttonSubmit" value="CANCEL" style="margin-left: 20px;"/>
                    <input type="submit" id="repair" onclick="return changeStatus(2)" class="btn btn-success pull-right buttonSubmit" name="send_quote" value="SEND QUOTATION" style="margin-left: 20px;{{ $transaction_details->repair_status == 2 ? 'display:none' : ''}}"/>
                    <input type="submit" id="pay_diagnostic" onclick="return changeStatus(8)" class="btn btn-primary pull-right buttonSubmit" value="REWIND" style="margin-left: 20px;"/>                
                @elseif($transaction_details->repair_status == 4)
                    <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default pull-left" id="back">BACK</a>
                    <input type="submit" id="pickup" onclick="return changeStatus(7)" class="btn btn-success pull-right buttonSubmit" value="TO PICK UP" style="margin-left: 20px;"/>
                @elseif($transaction_details->repair_status == 3)
                    <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default pull-left" id="back">BACK</a>
                    <input type="submit" id="void" onclick="return changeStatus(5)" class="btn btn-danger pull-right buttonSubmit" value="CANCELLED/CLOSE"/>
                @elseif($transaction_details->repair_status == 7)
                    <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default pull-left" id="back">BACK</a>
                    <input type="submit" id="close" onclick="return changeStatus(6)" class="btn btn-success pull-right buttonSubmit" value="CLOSE" style="margin-left: 20px;"/>
                    <input type="submit" id="send_link" onclick="return changeStatus('send_link')" class="btn btn-primary pull-right buttonSubmit" value="SEND PAYMENT LINK"/>
                @endif
            </div>
            </form>
        </div>
    </div>       
@endsection

@push('bottom')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

@include('technician.to_diagnose_transaction_script')
@include('include.comment-box-script')
@endpush