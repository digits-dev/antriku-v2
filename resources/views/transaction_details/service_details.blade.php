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
                            @if(request()->segment(3) == "edit" && CRUDBooster::getModulePath() == "to_diagnose" && $transaction_details->repair_status == 1 && CRUDBooster::myPrivilegeId() != 2)
                                <td class="table-bordered-display" style="padding: 5px !important;">
                                    <label class="control-label col-md-12" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.warranty_expiration_date') }}</label>
                                </td>
                                <td class="table-bordered-display" style="padding: 5px !important;">
                                    <div class="col-md-12" style="margin-top:7px;">
                                        <input type="input" name="warranty_expiration_date" placeholder="MM/DD/YYYY" id="warranty_expiration_date" value="{{ date('m/d/Y', strtotime($transaction_details->warranty_expiration_date)) }}" class="form-control" autocomplete="off" required readonly/>                        
                                    </div>
                                </td>
                            @elseif(CRUDBooster::getModulePath() != "to_diagnose" || request()->segment(3) == "detail")
                                <td class="table-bordered-display" style="padding: 5px !important;">
                                    <label class="control-label col-md-12" style="margin-top:7px;">{{ trans('labels.form-label.warranty_expiration_date') }}</label>
                                </td>
                                <td class="table-bordered-display" style="padding: 5px !important;">
                                    <div class="col-md-12" style="margin-top:7px;">{{ date('F j, Y', strtotime($transaction_details->warranty_expiration_date)) }}</div>
                                </td>
                            @endif
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
                                <div class="col-md-12" style="margin-top:7px;">{{ $data['Branch']->branch_name }}</div>
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