
<section class="card-cust" style="border-radius: 0%;">
    <div class="card-header-cust">
        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
            <i class="bi bi-card-checklist"></i>
        </div>
        Technical Report
    </div>

    <div class="row">
        <div class="col-md-12">
            @if(in_array(CRUDBooster::myPrivilegeId(), [4,8]) && request()->segment(3) == "edit")
            <div class="card-body-cust" style="padding-bottom: 0px !important;">
                <div class="info-grid-cust">
                  <div class="info-item-cust">
        
                @if ($transaction_details->repair_status == 17)
                <div class="row">
                    <div class="col-md-12">       
                        <div class="col-md-12" style="margin-top:7px;">
                            <div class="info-label-cust">Warranty Status:</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="warranty-option-cus">
                            <div class="radio-container-cus">
                                <input type="radio" name="warranty_status" value="IN WARRANTY" onchange="return WarrantyStatusChange(1)" required {{ $transaction_details->warranty_status == 'IN WARRANTY' ? 'checked' : ''}}>
                            <span class="radio-custom"></span>
                            </div>
                            <div class="option-content-cus">
                            <div class="option-title-cus">In Warranty</div>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="warranty-option-cus">
                            <div class="radio-container-cus">
                                <input type="radio" name="warranty_status" value="OUT OF WARRANTY" onchange="return WarrantyStatusChange(2)" required {{ $transaction_details->warranty_status == 'OUT OF WARRANTY' ? 'checked' : ''}}>
                            <span class="radio-custom"></span>
                            </div>
                            <div class="option-content-cus">
                            <div class="option-title-cus">Out of Warranty</div>
                            </div>
                        </label>
                    </div>
                     
                </div> 
                @else
                <div class="info-label-cust">Warranty Status</div>
                <div class="info-value-cust">
                    @if($transaction_details->warranty_status == "OUT OF WARRANTY")
                        <div class="status-badge-cust danger" style="margin-top: 0rem">{{ $transaction_details->warranty_status }}</div>
                    @elseif($transaction_details->warranty_status == "IN WARRANTY")
                        <div class="status-badge-cust success" style="margin-top: 0rem">{{ $transaction_details->warranty_status }}</div>
                    @elseif($transaction_details->warranty_status == "SPECIAL")
                        <div class="status-badge-cust warning" style="margin-top: 0rem">{{ $transaction_details->warranty_status }}</div>
                    @endif
                </div>
                @endif
            </div>
            <div class="info-item-cust">
                <div class="info-label-cust">Case</div>
                <div class="info-value-cust">
                    <div class="status-badge-cust warning" style="margin-top: 0rem">{{ $transaction_details->case_status }}</div>
                </div>
            </div>
        </div>
            </div>
                <?php $problem_details = explode(",", $transaction_details->problem_details); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top:7px;">
                            <label class="label-cus" style="margin-top:7px;"><span class="requiredField">*</span>Problem Details:</label>
                            <select class="input-cus limitedNumbSelect2" name="problem_details[]" id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100%" required>
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
                @if(!empty($transaction_details->problem_details_other))
                    <div class="row" id="show_other_problem">    
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label class="label-cus"><span class="requiredField">*</span>Other Problem Details:</label>
                                <input type="text" class="input-cus" name="problem_details_other" value="{{$transaction_details->problem_details_other}}" placeholder="Type your other problem details here">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row" id="show_other_problem"></div>
                @endif
                <div class="row">    
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top: 5px;">
                            <label class="label-cus">Other Remarks:</label>
                            <textarea placeholder="Type your other remarks here" name="other_remarks" rows="2" class="input-cus">{{ $transaction_details->other_remarks }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">    
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top: 5px;">
                            <label class="label-cus"><span class="requiredField">*</span>Device Issue Description:</label>
                            <textarea placeholder="Type your device issue description here" name="device_issue_description" rows="2" class="input-cus" required {{ $transaction_details->repair_status != 10 ? 'readonly' : '' }}>{{ $transaction_details->device_issue_description }}</textarea>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="row">    
                        <div class="col-md-6" style="margin-top: 5px;">
                            <label class="label-cus"><span class="requiredField">*</span>Findings:</label>
                            <textarea placeholder="Type your findings here" name="findings" rows="2" class="input-cus" required >{{ $transaction_details->findings }}</textarea>
                        </div>
                        <div class="col-md-6" style="margin-top: 5px;">
                            <label class="label-cus"><span class="requiredField">*</span>Resolution:</label>
                            <textarea placeholder="Type your resolution here" name="resolution" rows="2" class="input-cus" required>{{ $transaction_details->resolution }}</textarea>
                        </div>
                    </div>
                </div>
        
                @if($defective_serial_numbers->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                        <br>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <div class="pic-container">
                                        <div class="pic-row">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="tbl_header_color" style="padding: 1px !important;">
                                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Defective KBB Part ID</th>
                                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Defective Serial Number</th>
                                                    </tr>
                                                    @foreach($defective_serial_numbers as $serial)
                                                        <tr>
                                                            <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $serial->defective_kbb_name }}</p></td>
                                                            <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $serial->defective_serial_number }}</p></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    @else

    <?php 
        $test_type = explode(',', $data['diagnostic_test'][0]->test_type);
        $test_result = explode(',', $data['diagnostic_test'][0]->test_result);
        $counter = 0; 
    ?>
    <div class="card-body-cust">
        <div class="info-grid-cust">
            <div class="info-item-cust">
        
                <div class="info-label-cust">Warranty Status</div>
                <div class="info-value-cust">
                    @if($transaction_details->warranty_status == "OUT OF WARRANTY")
                        <div class="status-badge-cust danger" style="margin-top: 0rem">{{ $transaction_details->warranty_status }}</div>
                    @elseif($transaction_details->warranty_status == "IN WARRANTY")
                        <div class="status-badge-cust success" style="margin-top: 0rem">{{ $transaction_details->warranty_status }}</div>
                    @elseif($transaction_details->warranty_status == "SPECIAL")
                        <div class="status-badge-cust warning" style="margin-top: 0rem">{{ $transaction_details->warranty_status }}</div>
                    @endif
                </div>
            </div>
            <div class="info-item-cust">
                <div class="info-label-cust">Case</div>
                <div class="info-value-cust">
                    <div class="status-badge-cust warning" style="margin-top: 0rem">{{ $transaction_details->case_status }}</div>
                </div>
            </div>
        </div>
        
        <div class="info-item-cust">
            <div class="info-label-cust">Problem Details</div>
            <div class="info-value-cust">{{$transaction_details->problem_details}}</div>
        </div>
        @if(!empty($transaction_details->problem_details_other))
            <div class="info-item-cust">
                <div class="info-label-cust">Other Problem Details</div>
                <div class="info-value-cust">{{$transaction_details->problem_details_other}}</div>
            </div>
        @endif
        <div class="info-grid-cust">
            <div class="info-item-cust">
                <div class="info-label-cust">Other Remarks</div>
                <div class="info-value-cust">{{ $transaction_details->other_remarks ?? 'N/A' }}</div>
            </div>
            {{-- <div class="info-item-cust">
                <div class="info-label-cust">Device Issue Description</div>
                <div class="info-value-cust">{{ $transaction_details->device_issue_description ?? 'N/A' }}</div>
            </div> --}}
        </div>
        <div class="info-grid-cust">
            <div class="info-item-cust">
                <div class="info-label-cust">Findings</div>
                <div class="info-value-cust">{{ $transaction_details->findings ?? 'N/A' }}</div>
            </div>
            <div class="info-item-cust">
                <div class="info-label-cust">Resolution</div>
                <div class="info-value-cust">{{ $transaction_details->resolution ?? 'N/A' }}</div>
            </div>
        </div>
        @if($defective_serial_numbers->isNotEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <div class="pic-container">
                                <div class="pic-row">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="tbl_header_color" style="padding: 1px !important;">
                                                <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Defective KBB Part ID</th>
                                                <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Defective Serial Number</th>
                                            </tr>
                                            @foreach($defective_serial_numbers as $serial)
                                                <tr>
                                                    <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $serial->defective_kbb_name }}</p></td>
                                                    <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $serial->defective_serial_number }}</p></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
</section>