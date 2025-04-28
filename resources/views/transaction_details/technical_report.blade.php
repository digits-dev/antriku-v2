
<section class="card-cust" style="border-radius: 0%;">
    <div class="card-header-cust">
        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
            <i class="bi bi-card-checklist"></i>
        </div>
        Technical Report
    </div>

    <div class="row">
        <div class="col-md-12">
            @if($transaction_details->repair_status == 10 && CRUDBooster::getModulePath() == "to_diagnose" && request()->segment(3) == "edit")
                <div class="row">
                    <div class="col-md-12">
                        {{-- <div class="col-md-12" style="margin-top: 12px;margin-bottom: 12px;">
                            <div class="alert-cust alert-info-cust alert-with-icon-cust">
                                <div class="alert-icon-cust">i</div>
                                    <span class="alert-title-cust">Info!</span> 
                                    If you are changing the Warranty Status make sure to click the rewind button.
                            </div>
                        </div> --}}
                        <div class="col-md-12" style="margin-top:7px;">
                            <label class="label-cus"><span class="requiredField">*</span>Warranty Status:</label>
                        </div>
                        <div class="col-md-4">
                            <label class="warranty-option-cus">
                                <div class="radio-container-cus">
                                <input type="radio" name="warranty_status" value="IN WARRANTY" value="IN WARRANTY" onchange="return WarrantyStatusChange(1)" required {{ $transaction_details->warranty_status == 'IN WARRANTY' ? 'checked' : ''}} {{ $transaction_details->repair_status != 10 ? 'disabled' : ''}}>
                                <span class="radio-custom"></span>
                                </div>
                                <div class="option-content-cus">
                                <div class="option-title-cus">
                                    In Warranty
                                    <span class="pull-right text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                            <path d="m9 12 2 2 4-4"></path>
                                          </svg>
                                    </span>
                                </div>
                                <div class="option-description-cus">Product under manufacturer warranty</div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="warranty-option-cus">
                                <div class="radio-container-cus">
                                <input type="radio" name="warranty_status" value="OUT OF WARRANTY" onchange="return WarrantyStatusChange(2)" required {{ $transaction_details->warranty_status == 'OUT OF WARRANTY' ? 'checked' : ''}} {{ $transaction_details->repair_status != 10 ? 'disabled' : ''}}>
                                <span class="radio-custom"></span>
                                </div>
                                <div class="option-content-cus">
                                <div class="option-title-cus">
                                    Out of Warranty
                                    <span class="pull-right text-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19.69 14a6.9 6.9 0 0 0 .31-2V5l-8-3-3.16 1.18"></path>
                                            <path d="M4.73 4.73 4 5v7c0 6 8 10 8 10a20.29 20.29 0 0 0 5.62-4.38"></path>
                                            <line x1="2" y1="2" x2="22" y2="22"></line>
                                          </svg>
                                    </span>
                                </div>
                                <div class="option-description-cus">Product warranty has expired</div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="warranty-option-cus">
                                <div class="radio-container-cus">
                                <input type="radio" name="warranty_status" value="SPECIAL" onchange="return WarrantyStatusChange(3)" required {{ $transaction_details->warranty_status == 'SPECIAL' ? 'checked' : ''}} {{ $transaction_details->repair_status != 10 ? 'disabled' : ''}}>
                                <span class="radio-custom"></span>
                                </div>
                                <div class="option-content-cus">
                                <div class="option-title-cus">
                                    Special Coverage
                                    <span class="pull-right text-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                            <polygon points="12 8 12.8 10.5 15.5 10.6 13.4 12.3 14 14.9 12 13.4 10 14.9 10.6 12.3 8.5 10.6 11.2 10.5 12 8"></polygon>
                                          </svg>
                                    </span>
                                </div>
                                <div class="option-description-cus">Extended warranty or special program</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top:7px;">
                            <label class="label-cus"><span class="requiredField">*</span>Case Type:</label>
                        </div>
                        <div class="col-md-6" style="margin-top:7px;">
                            <label class="warranty-option-cus">
                                <div class="radio-container-cus">
                                    <input type="radio" name="case_status" value="CARRY-IN" required {{ $transaction_details->case_status == 'CARRY-IN' ? 'checked' : ''}} {{ $transaction_details->repair_status != 10 ? 'disabled' : ''}}>
                                    <span class="radio-custom"></span>
                                </div>
                                <div class="option-content-cus">
                                    <div class="option-title-cus">
                                        CARRY-IN
                                        <span class="pull-right" style="color:#00c0ef">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M16.5 9.4l-9-5.19M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                                <line x1="12" y1="22" x2="12" y2="12"></line>
                                              </svg>
                                        </span>
                                    </div>
                                    <div class="option-description-cus">Bring product to Service Center</div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6" style="margin-top:7px;">
                            <label class="warranty-option-cus">
                                <div class="radio-container-cus">
                                    <input type="radio" name="case_status" value="MAIL-IN" required {{ $transaction_details->case_status == 'MAIL-IN' ? 'checked' : ''}} {{ $transaction_details->repair_status != 10 ? 'disabled' : ''}}>
                                    <span class="radio-custom"></span>
                                </div>
                                <div class="option-content-cus">
                                    <div class="option-title-cus">
                                        MAIL-IN
                                        <span class="pull-right" style="color: #00c0ef">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                              </svg>
                                        </span>
                                    </div>
                                    <div class="option-description-cus">Ship your product to Apple Service Center</div>
                                </div>
                            </label>
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
                    <div class="row" id="show_other_problem" style="margin-top: 5px">    
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label class="label-cus"><span class="requiredField">*</span>Other Problem Details:</label>
                                <input type="text" class="input-cus" name="problem_details_other" value="{{$transaction_details->problem_details_other}}" placeholder="Type your other problem details here" {{ $transaction_details->repair_status != 10 ? 'readonly' : '' }}>
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
                            <textarea placeholder="Type your other remarks here" name="other_remarks" rows="2" class="input-cus" {{ $transaction_details->repair_status != 10 ? 'readonly' : '' }}>{{ $transaction_details->other_remarks }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6" style="margin-top: 5px;">
                            <label class="label-cus">Device Serial Number:</label>
                            <input placeholder="Type your Device Serial Number here" name="device_serial_number" class="input-cus" {{ $transaction_details->repair_status != 10 ? 'readonly' : '' }} value="{{ $transaction_details->device_serial_number }}"/>
                        </div>
                        <div class="col-md-6" style="margin-top: 5px;">
                            <label class="label-cus"><span class="requiredField">*</span>Defective Serial Number (KBB):</label>
                            <input placeholder="Type your Defective Serial Number here" name="defective_serial_number" class="input-cus" required  {{ $transaction_details->repair_status != 10 ? 'readonly' : '' }} value="{{ $transaction_details->defective_serial_number }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">    
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top: 10px;">
                            <label class="label-cus"><span class="requiredField">*</span>Device Issue Description:</label>
                            <textarea placeholder="Type your device issue description here" name="device_issue_description" rows="2" class="input-cus" required {{ $transaction_details->repair_status != 10 ? 'readonly' : '' }}>{{ $transaction_details->device_issue_description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top: 5px;">
                            <label class="label-cus"><span class="requiredField">*</span>Findings:</label>
                            <textarea placeholder="Type your findings here" name="findings" rows="2" class="input-cus" required {{ $transaction_details->repair_status != 10 ? 'readonly' : ''}}>{{ $transaction_details->findings }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top: 5px;">
                            <label class="label-cus"><span class="requiredField">*</span>Resolution:</label>
                            <textarea placeholder="Type your resolution here" name="resolution" rows="2" class="input-cus" required {{ $transaction_details->repair_status != 10 ? 'readonly' : ''}}>{{ $transaction_details->resolution }}</textarea>
                        </div>
                    </div>
                </div>
                @if ($transaction_details->warranty_status == "OUT OF WARRANTY")
                    <div class="row">    
                        <div class="col-md-12">
                            <div class="col-md-12" style="margin-top: 5px;">
                                <label class="label-cus"><span class="requiredField">*</span>Parts Replacement Cost:</label>
                                <textarea placeholder="Type your Parts Replacement Cost here" name="replacement_cost" rows="2" class="input-cus" required {{ $transaction_details->repair_status != 10 ? 'readonly' : ''}}>{{ $transaction_details->parts_replacement_cost }}</textarea>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <br>
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
            <div class="info-item-cust">
                <div class="info-label-cust">Device Issue Description</div>
                <div class="info-value-cust">{{ $transaction_details->device_issue_description ?? 'N/A' }}</div>
            </div>
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
        
        @if ($transaction_details->warranty_status == "OUT OF WARRANTY")
            <div class="info-item-cust">
                <div class="info-label-cust">Parts Replacement Cost</div>
                <div class="info-value-cust">{{ $transaction_details->parts_replacement_cost ?? 'N/A' }}</div>
            </div>
        @endif
    </div>
    @endif
</section>