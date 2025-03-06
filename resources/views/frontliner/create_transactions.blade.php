@extends('crudbooster::admin_template')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    @include('include.css')
@endpush

@section('content') 
    <div class="panel panel-default">
        <form method="post" action="{{CRUDBooster::mainpath('add-transaction-process')}}" id="SubmitTransactionForm">
            <div class="panel-heading">Create Transaction</div>
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <div class="panel-body">
                <div class="form-group"> 
                    <h4 style="text-align: center;">Customer Details  
                    @if(Session::get('success'))
                        <div class="sweet-overlay" tabindex="-1" style="opacity: 1.27; display: block;"></div>
                    @endif
                    </h4><br>
                    <div class="row">                           
                        <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.first_name') }}</label>
                        <div class="col-md-4">
                            <input type="input" name="first_name" placeholder="First Name" class="form-control" autocomplete="off" required/>                  
                        </div>
                        <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.last_name') }}</label>
                        <div class="col-md-4">
                            <input type="input" name="last_name" placeholder="Last Name" class="form-control" autocomplete="off" required/>                        
                        </div>
                    </div>
                    <br>
                    <div class="row">                           
                        <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.email_address') }}</label>
                        <div class="col-md-4">
                            <input type="input" name="email" placeholder="Email Address" class="form-control" autocomplete="off" required/>                        
                        </div>
                        <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.contact_no') }}</label>
                        <div class="col-md-4">
                            <input type="input" name="contact_no" placeholder="09#########" pattern="[09][0-9]{10}" class="form-control" autocomplete="off" required/>                  
                        </div>
                    </div>
                    <br>
                    <div class="row">                           
                        <label class="control-label col-md-2" style="margin-top:7px;">Company Name:</label>
                        <div class="col-md-4">
                            <input type="input" name="company_name" placeholder="" class="form-control" autocomplete="off"/>                        
                        </div>
                        <label class="control-label col-md-2" style="margin-top:7px;">Company Contact#:</label>
                        <div class="col-md-4">
                            <input type="input" name="company_contact_no" placeholder="09#########" pattern="[09][0-9]{10}" class="form-control" autocomplete="off"/>                        
                        </div>
                    </div>
                    <br>
                    <div class="row">   
                        <label class="control-label col-md-2" style="margin-top:7px;">Address:</label>
                        <div class="col-md-4">
                            <input type="input" name="address" placeholder="" class="form-control" autocomplete="off"/>                        
                        </div>
                    </div> 
                    <hr/> 
                    <h4 style="text-align: center;">Service Details</h4><br>
                    <div class="row"> 
                        <label class="require control-label col-md-2"><span class="requiredField">*</span>Warranty Status:</label>
                        <div class="col-md-3">
                            <label class="radio-inline control-label "><input type="radio" name="warranty_status" value="IN WARRANTY"  required>IN WARRANTY</label>
                            <br>
                        </div>
                        <div class="col-md-3">
                            <label class="radio-inline control-label "><input type="radio" name="warranty_status" value="OUT OF WARRANTY" required>OUT OF WARRANTY</label>
                            <br>
                        </div>
                        <div class="col-md-3">
                            <label class="radio-inline control-label "><input type="radio" name="warranty_status" value="SPECIAL" required>SPECIAL</label>
                            <br>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="row">                           
                        <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.purchase_date') }}</label>
                        <div class="col-md-4">
                            <input type="input" name="purchase_date" placeholder="" id="purchase_date" class="form-control" autocomplete="off" required/>                        
                        </div>
                        <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>{{ trans('labels.form-label.warranty_expiration_date') }}</label>
                        <div class="col-md-4">
                            <input type="input" name="warranty_expiration_date" placeholder="" id="warranty_expiration_date" class="form-control" autocomplete="off" required/>                        
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px;"><span class="requiredField">*</span>Model:</label>
                                <div class="col-md-8">
                                    <select name="model" autocomplete="off" class="form-control" id="model" onchange="SelectedModel()" required> 
                                        <option value="" selected disabled>Choose model here...</option>
                                        @foreach($data['Model'] as $key=>$model)
                                            <option value="{{ $model->id }}">{{ $model->model_name }}</option>
                                        @endforeach      
                                    </select> 
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px;"><span class="requiredField">*</span>Summary of Concern:</label>
                                <div class="col-md-8">
                                    <textarea placeholder="Type your summary of concern here" name="summary_of_concern" rows="3" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px;">Item Photo:</label>
                                <div class="col-md-8" id="Photo" style="text-align: center;"></div> 
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr/> 
                    @foreach($data['imfs']  as $key=>$rowresult)
                        <?php $stack_serials = ''; ?>
                        <?php $stack_problem_details = ''; ?>
                        <?php $stack_problem_details_other = ''; ?>
                        <?php $stack_cost = $rowresult->cost;?>
                    @endforeach
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Please indicate UPC Code or Item Description</label>
                                <input class="form-control auto" style="width:420px;" placeholder="Search Item" id="search">
                                <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" style="display: none; top: 60px; left: 15px; width: 520px;">
                                    <li>Loading...</li>
                                </ul>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header text-center"></div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <div class="pic-container">
                                        <div class="pic-row">
                                            <table class="table table-bordered" id="pullout-items">
                                                <tbody>
                                                    <tr class="tbl_header_color dynamicRows">
                                                        <th width="30%" class="text-center"><span class="requiredField">*</span>UPC Code</th>
                                                        <th width="54%" class="text-center"><span class="requiredField">*</span>{{ trans('labels.table.item_description') }}</th>
                                                        <th width="15%" class="text-center"><span class="requiredField">*</span>{{ trans('labels.table.serial_no') }}</th>
                                                        <th width="1%" class="text-center"> </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label><span class="requiredField">*</span>Problem Details:</label>
                            <select class="form-control limitedNumbSelect2" name="problem_details[]" data-placeholder="Choose problem details here..." id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100%" required>
                                @foreach($data['ProblemDetails'] as $key=>$pd)
                                    <option value="{{$pd->problem_details}}">{{$pd->problem_details}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12" id="show_other_problem"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Other Remarks:</label>
                            <textarea placeholder="Type your other remarks here" name="other_remarks" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="panel-footer">
                    <input type="hidden" name="SubmitStatus" id="SubmitStatus"> 
                    <button type="submit" class="btn btn-primary pull-right buttonSubmit" id="ToPayment" style="margin-left: 20px;"/><i class="fa fa-plus" aria-hidden="true"></i> CREATE</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('bottom')
<script type='text/javascript'>
@if (!empty($data['success']))
    swal("{{ $data['success'] }}");
@endif
</script>

       <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    @include('frontliner.create_transactions_script')
@endpush