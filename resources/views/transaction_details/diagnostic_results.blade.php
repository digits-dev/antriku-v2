<div class="row">
    <div class="col-md-12">
        <div class="row"> 
            <div class="col-md-12">
                <div style="background:#595959;color:white;padding:3px;text-align: center;">
                    <h4>Diagnostic Results</h4>  
                </div> 
            </div> 
        </div> 
        @if($transaction_details->repair_status == 9 && CRUDBooster::getModulePath() == "to_diagnose" && request()->segment(3) == "edit")
            <div class="row" style="margin-top:7px;"> 
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
                                    @foreach($data['TechTesting'] ?? [] as $key=>$dt)
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
                                    @foreach($data['TechTesting'] ?? []  as $key=>$dt)
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
                                    <tr class="tbl_header_color" style="padding: 1px !important;">
                                        <th width="60%" class="text-center table-bordered-display" style="padding: 5px !important;border-width: 1px !important;">Test Type:</th>
                                        <th width="40%" class="text-center table-bordered-display" style="padding: 5px !important;border-width: 1px !important;" colspan="4">Result:</th>
                                    </tr>
                                    @if(CRUDBooster::getModulePath() == "transaction_history" && request()->segment(3) == "getDetailView")
                                        @foreach($TechTesting ?? [] as $key=>$dt)
                                            <?php $ModelGroupTech = explode(",", $dt->model_group_id); ?>
                                            @if(in_array($transaction_details->model_group, $ModelGroupTech))
                                                <tr>
                                                    <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 1px 1px 1px !important;"><span>{{$dt->description}}</span></td>
                                                    @if(count($test_result) != 0)
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                        
                                                            @if($test_result[$counter] == 1)
                                                                <span class="text-success"><strong>Passed</strong></span>
                                                            @elseif($test_result[$counter] == 2)
                                                                <span class="text-warning"><strong>Warning</strong></span>
                                                            @elseif($test_result[$counter] == 3)
                                                                <span class="text-danger"><strong>Failed</strong></span>
                                                            @else
                                                                <span class="text-dark"><strong>N/A  </strong></span>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                            <span class="text-dark"><strong>N/A</strong></span>
                                                        </td>
                                                    @endif
                                                </tr>
                                                <?php $counter++; ?>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($data['TechTesting'] ?? [] as $key=>$dt)
                                            <?php $ModelGroupTech = explode(",", $dt->model_group_id); ?>
                                            @if(in_array($data['transaction_details']->model_group, $ModelGroupTech))
                                                <tr>
                                                    <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 1px 1px 1px !important;"><span>{{$dt->description}}</span></td>
                                                    @if(count($test_result) != 0)
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                        
                                                            @if($test_result[$counter] == 1)
                                                                <span class="text-success"><strong>Passed</strong></span>
                                                            @elseif($test_result[$counter] == 2)
                                                                <span class="text-warning"><strong>Warning</strong></span>
                                                            @elseif($test_result[$counter] == 3)
                                                                <span class="text-danger"><strong>Failed</strong></span>
                                                            @else
                                                                <span class="text-dark"><strong>N/A  </strong></span>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;">
                                                            <span class="text-dark"><strong>N/A</strong></span>
                                                        </td>
                                                    @endif
                                                </tr>
                                                <?php $counter++; ?>
                                            @endif
                                        @endforeach
                                    @endif
                                        @if($counter == 0)
                                            <tr>
                                                <td class="table-bordered-display" style="padding: 5px !important;border-width: 0 0 1px 0 !important;background-color:#EDEDED;text-align: center;" colspan="2">
                                                <p>NO RESULT FOUND.</p>
                                                </td>
                                            </tr>
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">    
                <div class="col-md-12">
                    <label class="control-label col-md-3" style="margin-top:7px;">Other Diagnostic Information:</label>
                    <div class="col-md-9" style="margin-top:7px;">{{ $transaction_details->other_diagnostic ?? 'N/A' }}</div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- <section class="card-cust" style="border-radius: 0rem">
    <div class="card-header-cust">Diagnostic Results</div>
    <div class="card-body-cust">
        <table class="diagnostic-table-cust">
            <thead>
                <tr>
                    <th>Test Type</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Battery Usage</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Call Performance</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Cosmetic Check</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Display and Graphics / VST</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Display Backlight and Color</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Display Image Quality</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Display Pixel Anomalies</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Home Button</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Adapter</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Apple USB INPUT devices</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Battery</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Bluetooth</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Display</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Ethernet</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Fan Motor</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Graphics/GPU</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Mac Resource Inspections (MRI) Hard Drive</td>
                    <td>N/A</td>
                </tr>
            </tbody>
        </table>
        
        <div class="info-item-cust">
            <div class="info-label-cust">Other Diagnostic Information</div>
            <div class="info-value-cust">SMP</div>
        </div>
    </div>
</section> --}}