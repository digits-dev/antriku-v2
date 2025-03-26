<section class="card-cust" style="border-radius: 0rem">
    <div class="card-header-cust">
        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
            <i class="bi bi-card-checklist"></i>
        </div>
        Diagnostic Results
    </div>
    @if($transaction_details->repair_status == 9 && CRUDBooster::getModulePath() == "to_diagnose" && request()->segment(3) == "edit")
        <div class="card-body-cust">
            <table class="diagnostic-table-cust">
                <?php 
                    $test_type = explode(',', $data['diagnostic_test'][0]->test_type);
                    $test_result = explode(',', $data['diagnostic_test'][0]->test_result);
                    $show = false;
                    $counter = 0; 
                ?>
                <thead>
                    <tr>
                        <th>Test Type</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaction_details->repair_status != 9)
                        @foreach($data['TechTesting'] ?? [] as $key=>$dt)
                            <?php 
                                $ModelGroupTech = explode(",", $dt->model_group_id);
                            ?>
                            @if(in_array($data['transaction_details']->model_group, $ModelGroupTech))
                                <tr>
                                    <td>{{$dt->description}}</td>
                                    @if(count($test_result) <= 0)
                                        @foreach($test_result as $tr)
                                            <td>
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
                                        <td>
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
                                <td colspan="2">
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
                                    <td><span>{{$dt->description}}</span></td>
                                
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="radio" name="test_result_{{$dt->id}}" value="1" {{ $test_result[$counter] == 1 ? 'checked' : ''}}> 
                                                <span class="text-success"><strong>Passed</strong></span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" name="test_result_{{$dt->id}}" value="2" {{ $test_result[$counter] == 2 ? 'checked' : ''}}> 
                                                <span class="text-warning"><strong>Warning</strong></span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" name="test_result_{{$dt->id}}" value="3" {{ $test_result[$counter] == 3 ? 'checked' : ''}}> 
                                                <span class="text-danger"><strong>Failed</strong></span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="radio" name="test_result_{{$dt->id}}" value="4" {{ $test_result[$counter] == 4 || empty($test_result[$counter]) ? 'checked' : ''}}> 
                                                <span class="text-dark"><strong>N/A</strong></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $counter++; ?>
                            @endif
                        @endforeach
                        @if($counter == 0)
                            <tr>
                                <td colspan="2">
                                    <p>NO RESULT FOUND.</p>
                                </td>
                            </tr>
                        @endif
                    @endif
                </tbody>
            </table>
            
            <div class="info-item-cust">
                <div class="info-label-cust">Other Diagnostic Information</div>
                {{-- <div class="info-value-cust">SMP</div> --}}
                <div>
                    <textarea placeholder="Type your other diagnostic information here" name="other_diagnostic" rows="2" class="input-cus" required {{ $transaction_details->repair_status != 9 ? 'readonly' : ''}}>{{ $transaction_details->other_diagnostic }}</textarea>
                </div>
            </div>
        </div>
    @else
        <div class="card-body-cust">
            <table class="diagnostic-table-cust">
                <?php 
                    $test_type = explode(',', $data['diagnostic_test'][0]->test_type);
                    $test_result = explode(',', $data['diagnostic_test'][0]->test_result);
                    $counter = 0; 
                ?>
                <thead>
                    <tr>
                        <th>Test Type</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    @if(CRUDBooster::getModulePath() == "transaction_history" && request()->segment(3) == "getDetailView")
                        @foreach($TechTesting ?? [] as $key=>$dt)
                            <?php $ModelGroupTech = explode(",", $dt->model_group_id); ?>
                            @if(in_array($transaction_details->model_group, $ModelGroupTech))
                                <tr>
                                    <td>{{$dt->description}}</td>
                                    @if(count($test_result) != 0)
                                        <td>
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
                                        <td>
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
                                    <td>{{$dt->description}}</td>
                                    @if(count($test_result) != 0)
                                        <td>
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
                                        <td>
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
                                <td colspan="2">
                                    <p>NO RESULT FOUND.</p>
                                </td>
                            </tr>
                        @endif
                </tbody>
            </table>
            
            <div class="info-item-cust">
                <div class="info-label-cust">Other Diagnostic Information</div>
                <div class="info-value-cust">{{ $transaction_details->other_diagnostic ?? 'N/A' }}</div>
            </div>
        </div>
    @endif
</section>