<div class="row">
    <div class="col-md-12">
        <div class="row"> 
            <div class="col-md-12">
                <div style="background:#595959;color:white;padding:3px;text-align: center;">
                    <h4>Customer Details</h4>  
                </div> 
            </div>  
        </div>  
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
                            @if(request()->segment(3) == "detail" || CRUDBooster::getModulePath() != "pay_diagnostic")
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
                            @elseif(request()->segment(3) == "edit" && CRUDBooster::getModulePath() == "pay_diagnostic")
                                <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                    <label class="control-label col-md-12" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.email_address') }}</label>
                                </td>
                                <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                    <div class="col-md-12" style="margin-top:7px;">
                                        <input type="email" name="email" id="email" value="{{$transaction_details->email}}" placeholder="Email Address" class="form-control" autocomplete="off" required/>   
                                    </div>
                                </td>
                                <td class="table-bordered-display" style="padding:5px !important; width:20%;">
                                    <label class="control-label col-md-12" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.contact_no') }}</label>
                                </td>
                                <td class="table-bordered-display" style="padding:5px !important; width:30%;">
                                    <div class="col-md-12" style="margin-top:7px;">
                                        <input type="input" name="contact_no" id="contact_no" value="{{$transaction_details->contact_no}}" placeholder="09#########" pattern="[09][0-9]{10}" class="form-control" autocomplete="off" required/>                  
                                    </div>
                                </td>
                            @endif
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