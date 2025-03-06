

<div class="row">
    <div class="col-md-12">
        <div class="row"> 
            <div class="col-md-12">
                <div style="background:#595959;color:white;padding:3px;text-align: center;">
                    <h4>Technical Report</h4>  
                </div>
            </div> 
        </div> 
        @if($transaction_details->repair_status == 1 && CRUDBooster::getModulePath() == "to_diagnose" && request()->segment(3) == "edit")
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="margin-top:7px;">
                        <div class="col-md-12">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <div class="alert alert-info" style="font-size:1.2vw;"><strong>Info! </strong>If you are changing the Warranty Status make sure to click the rewind button.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-top:7px;">
                        <label><span class="requiredField">*</span>Warranty Status:</label>
                    </div>
                    <div class="col-md-3" style="margin-top:7px;">
                        <label class="radio-inline control-label text-success"><input type="radio" name="warranty_status" value="IN WARRANTY" onchange="return WarrantyStatusChange(1)" required {{ $transaction_details->warranty_status == 'IN WARRANTY' ? 'checked' : ''}} {{ $transaction_details->repair_status != 1 ? 'disabled' : ''}}><strong>IN WARRANTY</strong></label>
                        <br>
                    </div>
                    <div class="col-md-3" style="margin-top:7px;">
                        <label class="radio-inline control-label text-danger"><input type="radio" name="warranty_status" value="OUT OF WARRANTY" onchange="return WarrantyStatusChange(2)" required {{ $transaction_details->warranty_status == 'OUT OF WARRANTY' ? 'checked' : ''}} {{ $transaction_details->repair_status != 1 ? 'disabled' : ''}}><strong>OUT OF WARRANTY</strong></label>
                        <br>
                    </div>
                    <div class="col-md-3" style="margin-top:7px;">
                        <label class="radio-inline control-label text-warning"><input type="radio" name="warranty_status" value="SPECIAL" onchange="return WarrantyStatusChange(3)" required {{ $transaction_details->warranty_status == 'SPECIAL' ? 'checked' : ''}} {{ $transaction_details->repair_status != 1 ? 'disabled' : ''}}><strong>SPECIAL</strong></label>
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
                            <input type="text" class="form-control" name="problem_details_other" value="{{$transaction_details->problem_details_other}}" placeholder="Type your other problem details here" {{ $transaction_details->repair_status != 1 ? 'readonly' : '' }}>
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
                        <textarea placeholder="Type your other remarks here" name="other_remarks" rows="2" class="form-control" {{ $transaction_details->repair_status != 1 ? 'readonly' : '' }}>{{ $transaction_details->other_remarks }}</textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">    
                <div class="col-md-12">
                    <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Device Issue Description:</label>
                    <div class="col-md-10" style="margin-top:7px;">
                        <textarea placeholder="Type your device issue description here" name="device_issue_description" rows="2" class="form-control" required {{ $transaction_details->repair_status != 1 ? 'readonly' : '' }}>{{ $transaction_details->device_issue_description }}</textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">    
                <div class="col-md-12">
                    <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Findings:</label>
                    <div class="col-md-10" style="margin-top:7px;">
                        <textarea placeholder="Type your findings here" name="findings" rows="2" class="form-control" required {{ $transaction_details->repair_status != 1 ? 'readonly' : ''}}>{{ $transaction_details->findings }}</textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">    
                <div class="col-md-12">
                    <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Resolution:</label>
                    <div class="col-md-10" style="margin-top:7px;">
                        <textarea placeholder="Type your resolution here" name="resolution" rows="2" class="form-control" required {{ $transaction_details->repair_status != 1 ? 'readonly' : ''}}>{{ $transaction_details->resolution }}</textarea>
                    </div>
                </div>
            </div>
        @else
            <div class="row" style="margin-top: 10px;">
                <?php 
                    $test_type = explode(',', $data['diagnostic_test'][0]->test_type);
                    $test_result = explode(',', $data['diagnostic_test'][0]->test_result);
                    $counter = 0; 
                ?>
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
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Problem Details:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{$transaction_details->problem_details}}</div>
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
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Device Issue Description:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->device_issue_description ?? 'N/A' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Findings:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->findings ?? 'N/A' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <label class="control-label col-md-12" style="margin-top:7px;">Resolution:</label>
                                        </td>
                                        <td class="table-bordered-display" style="padding: 5px !important;">
                                            <div class="col-md-12" style="margin-top:7px;">{{ $transaction_details->resolution ?? 'N/A' }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>