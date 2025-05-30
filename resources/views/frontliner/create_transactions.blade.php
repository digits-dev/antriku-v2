@extends('crudbooster::admin_template')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('include.css')
@endpush

@section('content') 
    <div class="container-cus" style="margin-top: 70px">
        <div class="form-card-cus">
            <div class="header-cus-2">
                <div class="title-section-cus">
                    <h1 class="h1-cus">Create Transactions</h1>
                    <p class="p-cus">Complete the form below to submit your transaction request</p>
                </div>
            </div>

            <div class="progress-section-cus">
                <div class="progress-text-cus">
                    <span>Form Progress</span>
                    <span id="progress-percentage">0% Complete</span>
                </div>
                <div class="progress-bar-cus">
                    <div class="progress-fill-cus" style="width: 0%"></div>
                </div>
            </div>

            <div class="steps-indicator-cus">
                <div style="cursor: pointer" class="step-cus active">
                    <div class="step-number-cus">1</div>
                    <div class="step-label-cus">Customer Details</div>
                </div>
                <div class="step-line-cus"></div>
                <div style="cursor: pointer" class="step-cus">
                    <div class="step-number-cus">2</div>
                    <div class="step-label-cus">Service Details</div>
                </div>
            </div>

            <form method="post" action="{{CRUDBooster::mainpath('add-transaction-process')}}" id="SubmitTransactionForm">
                <div class="form-step" id="step-1">
                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span> {{ trans('labels.form-label.first_name') }}</label>
                                <input type="input" name="first_name" placeholder="Enter First Name" class="input-cus" autocomplete="off" required/>   
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span>{{ trans('labels.form-label.last_name') }}</label>
                                <input type="input" name="last_name" placeholder="Enter Last Name" class="input-cus" autocomplete="off" required/>
                            </div>

                            <div class="customer-type-container">
                                <label class="label-cus"><span class="required">*</span>Customer Type:</label>
                                
                                <div class="customer-type-options">
                                    <!-- Personally Owned -->
                                    <div class="option-column personally-owned selected">
                                        <div class="radio-container">
                                            <label class="custom-radio">
                                                <input type="radio" name="customer_type" value="Personally Owned" checked>
                                                <span class="radio-checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="icon-container">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                        <div class="option-title">Personally Owned</div>
                                    </div>
                                    
                                    <!-- Enterprise -->
                                    <div class="option-column enterprise">
                                        <div class="radio-container">
                                            <label class="custom-radio">
                                                <input type="radio" name="customer_type" value="Enterprise">
                                                <span class="radio-checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="icon-container">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                                            </svg>
                                        </div>
                                        <div class="option-title">Enterprise</div>
                                    </div>
                                    
                                    <!-- Retail -->
                                    <div class="option-column retail">
                                        <div class="radio-container">
                                            <label class="custom-radio">
                                                <input type="radio" name="customer_type" value="Retail">
                                                <span class="radio-checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="icon-container">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
                                            </svg>
                                        </div>
                                        <div class="option-title">Retail</div>
                                    </div>
                                    
                                    <!-- E-Commerce -->
                                    <div class="option-column e-commerce">
                                        <div class="radio-container">
                                            <label class="custom-radio">
                                                <input type="radio" name="customer_type" value="E-Commerce">
                                                <span class="radio-checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="icon-container">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                            </svg>
                                        </div>
                                        <div class="option-title">E-Commerce</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span>{{ trans('labels.form-label.email_address') }}
                                    <small id="email_status" class="text-uppercase"></small>
                                </label>
                                <div class="input-container-cus">
                                    <input type="email" name="email" id="email" placeholder="Enter Email Address e.g.(example@email.com)" class="input-cus" autocomplete="off" required/>
                                    <i class="fa fa-check input-icon-cus success-icon-cus" style="display: none;"></i>
                                    <i class="fa fa-warning input-icon-cus error-icon-cus" style="display: none;"></i>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span>{{ trans('labels.form-label.contact_no') }}</label>
                                <input 
                                    style="display: none;"
                                    type="input" 
                                    name="contact_no" 
                                    {{-- placeholder="Enter Contact# e.g.(09xxxxxxxxx)"  --}}
                                    {{-- pattern="[09][0-9]{10}"  --}}
                                    {{-- maxlength="11"  --}}
                                    {{-- oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)" --}}
                                    class="input-cus contact_no" 
                                    autocomplete="off" 
                                    required
                                />
                                
                                <div class="phone-input-container">
                                    <div class="input-wrapper-cust">
                                      <div class="country-selector">
                                        <div class="flag">
                                          <img src="https://flagcdn.com/w20/ph.png" alt="..." width="20">
                                        </div>
                                        <span class="country-code">+63</span>
                                        <span class="chevron-down"></span>
                                      </div>
                                      <input type="tel" id="phone" name="phone" placeholder="">
                                    </div>
                                    <div class="dropdown-menu-cust">
                                        <input type="text" id="country-search" class="input-cus" placeholder="Search country..." autocomplete="off">
                                        <!-- Country options will be populated here -->
                                    </div>
                                </div>
                                  
                            </div>
                            <div class="form-group-cus" style="display: none" id="comp_name">
                                <label class="label-cus">Company Name:</label>
                                <input type="input" name="company_name" placeholder="Enter Company Name" class="input-cus" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-column-cus">
                            <div class="form-group-cus" style="display: none" id="comp_contact">
                                <label class="label-cus">Company Contact#:</label>
                                <input 
                                    type="input" 
                                    name="company_contact_no" 
                                    placeholder="Enter Company Contact# e.g.(09xxxxxxxxx)" 
                                    pattern="[09][0-9]{10}" 
                                    maxlength="11" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)"
                                    class="input-cus" 
                                    autocomplete="off"
                                />
                            </div>
                            <div class="form-group-cus">
                                <label for="country" class="label-cus">Country</label>
                                <select name="country" autocomplete="off" class="js-example-basic-single input-cus" id="country" disabled> 
                                    {{-- <option value="" selected disabled>Select country here...</option> --}}
                                        @foreach($country as $per_count)
                                            <option value="{{$per_count->countryDesc}}" data-id="{{$per_count->id}}" selected>{{$per_count->countryDesc}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label for="province" class="label-cus">Province
                                    <i class="fa fa-spinner fa-pulse fa-fw text-info" id="loading_filter_prov" style="display: none;"></i>
                                    <span class="sr-only">Loading...</span>
                                </label>
                                <select name="province" autocomplete="off" class="js-example-basic-single input-cus" id="province"> 
                                    <option value="" selected disabled>Select province here...</option>
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label for="city" class="label-cus"><span class="required">*</span>City 
                                    <i class="fa fa-spinner fa-pulse fa-fw text-info" id="loading_filter_city" style="display: none;"></i>
                                    <span class="sr-only">Loading...</span>
                                </label>
                                <select name="city" autocomplete="off" class="js-example-basic-single input-cus" id="city" required> 
                                    <option value="" selected disabled>Select city here...</option>
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label for="barangay" class="label-cus">Barangay
                                    <i class="fa fa-spinner fa-pulse fa-fw text-info" id="loading_filter_brgy" style="display: none;"></i>
                                    <span class="sr-only">Loading...</span>
                                </label>
                                <select name="barangay" autocomplete="off" class="js-example-basic-single input-cus" id="barangay"> 
                                    <option value="" selected disabled>Select barangay here...</option>
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span> Address Line</label>
                                <textarea name="address_line" id="address_line" placeholder="No./Line/Street/Blk/Lot/etc..." rows="5" class="textarea-cus" autocomplete="off" required></textarea>
                            </div>
                            <div class="form-group-cus" style="display:none">
                                <label class="label-cus">Address:</label>
                                <textarea name="address" id="address" placeholder="" rows="4" class="textarea-cus" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions-cus" style="margin-top: 0px">
                        <button type="button" id="next-button" class="btn-primary-cus">
                            Continue to Service Details
                            <span class="arrow-icon">→</span>
                        </button>
                    </div>
                </div>

                <div class="form-step" id="step-2" style="display: none;">
                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="require label-cus"><span class="requiredField">*</span>Warranty Status:</label> 
                                <div class="warranty-options-cus">
                                    <label class="warranty-option-cus">
                                        <div class="radio-container-cus">
                                        <input type="radio" name="warranty_status" value="IN WARRANTY" checked>
                                        <span class="radio-custom"></span>
                                        </div>
                                        <div class="option-content-cus">
                                        <div class="option-title-cus">In Warranty</div>
                                        <div class="option-description-cus">Product is covered under manufacturer warranty</div>
                                        </div>
                                    </label>
                                    
                                    <label class="warranty-option-cus">
                                        <div class="radio-container-cus">
                                        <input type="radio" name="warranty_status" value="OUT OF WARRANTY">
                                        <span class="radio-custom"></span>
                                        </div>
                                        <div class="option-content-cus">
                                        <div class="option-title-cus">Out of Warranty</div>
                                        <div class="option-description-cus">Product warranty has expired</div>
                                        </div>
                                    </label>
                                    
                                    <label class="warranty-option-cus hidden">
                                        <div class="radio-container-cus">
                                        <input type="radio" name="warranty_status" value="SPECIAL">
                                        <span class="radio-custom"></span>
                                        </div>
                                        <div class="option-content-cus">
                                        <div class="option-title-cus">Special Coverage</div>
                                        <div class="option-description-cus">Extended warranty or special program</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>Store of Purchase</label>
                                <select name="store_purchase" autocomplete="off" class="js-example-basic-single input-cus" id="store_purcahse" required>
                                    <option value="" selected disabled>Select Store here..</option>
                                    <option value="others">OTHERS</option>
                                    @foreach ($stores as $per_store)
                                        <option value="{{$per_store->store_name}}">
                                            {{$per_store->store_name}}
                                        </option>
                                    @endforeach 
                                </select>
                                <input type="text" class="input-cus" name="other_store_purchase" id="other_store_purchase" placeholder="Enter other store purchase here..." style="display: none; margin-top: 10px;">
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>{{ trans('labels.form-label.purchase_date') }}</label>
                                <input type="text" name="purchase_date" placeholder="" id="purchase_date" class="input-cus" autocomplete="off" required/>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>{{ trans('labels.form-label.warranty_expiration_date') }}</label>
                                <input type="input" name="warranty_expiration_date" placeholder="" id="warranty_expiration_date" class="input-cus" autocomplete="off" required/>                        
                            </div>
                            <div class="form-group-cus">
                                <label for="other_inclusion" class="label-cus">Accessories Included Remarks:</label>
                                <textarea class="input-cus" name="accessories_included_remarks" id="other_inclusion" rows="3" placeholder="Type accessories included remarks here..."></textarea>
                            </div>
                        </div>
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <input type="hidden" name="marked_image_base64" id="marked_image_base64">
                                <div class="row">
                                    <div class="col-md-8" id="model_class">
                                        <label for="model" class="label-cus">Model</label>
                                        <select name="model" autocomplete="off" class="js-example-basic-single input-cus" id="model" onchange="SelectedModel()" required> 
                                            <option value="" selected disabled>Choose Model here...</option>
                                            @foreach($data['Model'] as $key=>$model)
                                                <option value="{{ $model->id }}">{{ $model->model_name }}</option>
                                            @endforeach      
                                        </select> 
                                    </div>
                                    <div class="col-md-4" id="unitt_type_class">
                                        <label for="model" class="label-cus">Unit Type</label>
                                        <select name="unit_type" autocomplete="off" class="js-example-basic-single input-cus"> 
                                            <option value="" selected disabled>Choose Unit type here...</option>
                                            <option value="Accessories">Accessories</option>      
                                            <option value="iMac">iMac</option>      
                                            <option value="iPhone">iPhone</option>      
                                            <option value="macbook">MacBook</option>      
                                            <option value="mac mini">Mac Mini</option>      
                                            <option value="airpods">AirPods</option>      
                                            <option value="keyboard">Keyboard</option>      
                                            <option value="mouse">Mouse</option>      
                                            <option value="iPad">iPad</option>      
                                            <option value="Apple watch">Apple Watch</option>      
                                            <option value="trackpad">TrackPad</option>      
                                            <option value="apple tv">Apple TV</option>      
                                            <option value="studio display">Studio Display</option>      
                                            <option value="MAC Pro">MAC Pro</option>      
                                            <option value="Mac Studio">Mac Studio</option>      
                                            <option value="beats headphones">Beats Headphones</option>      
                                            <option value="beats earphone">Beats Earphones</option>      
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <div class="item-photo-cus">
                                    <img src="https://cdn-icons-png.flaticon.com/128/17522/17522345.png" class="item-img-hov" alt="">
                                    <div class="col-md-8" id="Photo" style="text-align: center; display:none;"></div>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="Purchase / Invoice Number" class="label-cus">Purchase / Invoice Number: <small class="text-danger">(If applicable)</small></label>
                                        <input type="text" name="purchase_invoice_number" id="purchase_invoice_number" class="input-cus" placeholder="Type Purchase / Invoice Number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>VMI Remarks:</label>
                                <textarea placeholder="Type your VMI remarks here..." name="summary_of_concern" rows="3" class="textarea-cus" style="padding-bottom: 15px" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="label-cus">Please indicate UPC Code or Item Description</label>
                                <input class="input-cus auto" placeholder="Search Item" id="search">
                                <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" style="display: none; top: 60px; left: 15px; width: 520px;">
                                    <li>Loading...</li>
                                </ul>
                            </div>

                            <div class="form-group-cus">
                                <div class="table-responsive" style="border: none">
                                    <div class="pic-container" style="border: none">
                                        <div class="pic-row" style="border: none">
                                            <table class="table table-bordered" id="pullout-items" style="border-radius: 10px; background-color:#ddd">
                                                <tbody>
                                                    <tr class="tbl_header_color dynamicRows">
                                                        <th width="20%" class="text-center">
                                                            <label class="label-cus">
                                                                <span class="requiredField">*</span>Digits Code
                                                            </label>
                                                        </th>
                                                        <th width="20%" class="text-center">
                                                            <label class="label-cus">
                                                                <span class="requiredField">*</span>UPC Code
                                                            </label>
                                                        </th>
                                                        <th width="44%" class="text-center">
                                                            <label for="" class="label-cus">
                                                                <span class="requiredField">*</span>{{ trans('labels.table.item_description') }}
                                                            </label>
                                                        </th>
                                                        <th width="15%" class="text-center">
                                                            <label class="label-cus">
                                                                {{-- <span class="requiredField">*</span>{{ trans('labels.table.serial_no') }} --}}
                                                                <span class="requiredField">*</span>Unit Serial Number
                                                            </label>
                                                        </th>
                                                        <th width="1%" class="text-center">-</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>Problem Details:</label>
                                <select class="limitedNumbSelect2 input-cus" name="problem_details[]" data-placeholder="Choose problem details here..." id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100%;" required>
                                    @foreach($data['ProblemDetails'] as $key=>$pd)
                                    <option value="{{$pd->problem_details}}">{{$pd->problem_details}}</option>
                                    @endforeach
                                </select>
                                <div class="col-md-12" id="show_other_problem"></div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus">Other Remarks:</label>
                                <textarea placeholder="Type your other remarks here" name="other_remarks" rows="3" class="textarea-cus"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-container-custom">
                        <div class="field-group">
                            <!-- Files Backed Up -->
                            <div class="toggle-field">
                                <label class="field-label"><span class="required-custom">*</span>Files Backed Up:</label>
                                <div class="toggle-options">
                                    <div class="toggle-option yes-option">
                                        <input type="radio" id="files-backed-yes" name="files-backed" value="Yes" class="toggle-input" required>
                                        <label for="files-backed-yes" class="toggle-card">
                                            <div class="toggle-icon">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                                </svg>
                                            </div>
                                            <span class="toggle-text">Yes</span>
                                        </label>
                                    </div>
                                    <div class="toggle-option no-option">
                                        <input type="radio" id="files-backed-no" name="files-backed" value="No" class="toggle-input" checked>
                                        <label for="files-backed-no" class="toggle-card">
                                            <div class="toggle-icon">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                                </svg>
                                            </div>
                                            <span class="toggle-text">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                
                            <!-- iCloud Signed Out -->
                            <div class="toggle-field">
                                <label class="field-label"><span class="required-custom">*</span>iCloud Signed Out:</label>
                                <div class="toggle-options">
                                    <div class="toggle-option yes-option">
                                        <input type="radio" id="icloud-signed-yes" name="icloud-signed" value="Yes" class="toggle-input" required>
                                        <label for="icloud-signed-yes" class="toggle-card">
                                            <div class="toggle-icon">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                                </svg>
                                            </div>
                                            <span class="toggle-text">Yes</span>
                                        </label>
                                    </div>
                                    <div class="toggle-option no-option">
                                        <input type="radio" id="icloud-signed-no" name="icloud-signed" value="No" class="toggle-input" checked>
                                        <label for="icloud-signed-no" class="toggle-card">
                                            <div class="toggle-icon">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                                </svg>
                                            </div>
                                            <span class="toggle-text">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions-cus" style="margin-top: 0px">
                        <button type="button" id="prev-button" class="btn-secondary-cus">
                            <span class="arrow-icon">←</span>
                            Back to Customer Details
                        </button>
                        <input type="hidden" name="SubmitStatus" id="SubmitStatus"> 
                        <button type="submit" class="btn-primary-cus buttonSubmit createJOBtn" id="ToPayment"><i class="fa fa-plus" aria-hidden="true"></i> Create Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('bottom')
{{-- phone number format each country  --}}
<script src="https://unpkg.com/libphonenumber-js@1.10.18/bundle/libphonenumber-max.js"></script>
<script>
    // Add interactivity
    document.querySelectorAll('.custom-radio input').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected class from all columns
            document.querySelectorAll('.option-column').forEach(col => {
                col.classList.remove('selected');
            });
            
            // Add selected class to the parent column of the checked radio
            if (this.checked) {
                this.closest('.option-column').classList.add('selected');
            }
        });
    });

    $(document).ready(function() {
        $('input[name="customer_type"]').on('change', function() {
            if ($(this).val() === 'Enterprise') {
                $('#comp_name').show();                
                $('#comp_contact').show();
            } else {
                $('#comp_name').hide();                
                $('#comp_contact').hide();
            }
        });
    });
</script>
<script>
  const $input = $('#email');
  $input.on('keydown', function(e) {
    if (e.key === ' ' || e.keyCode === 32) {
      e.preventDefault();
    }
  });

  $input.on('input', function() {
    this.value = this.value.replace(/\s/g, '');
  });
</script>
<script>
  $(document).ready(function () {
    const $countrySelector = $('.country-selector');
    const $dropdownMenu = $('.dropdown-menu-cust');
    const $selectedFlag = $('.flag img');
    const $selectedCountryCode = $('.country-selector .country-code');
    const $phoneInput = $('#phone');
    const $searchInput = $('#country-search');

    let selectedISO = 'PH';
    let dialCode = '+63'; 

    // Predefined maximum digits
    const countryFormats = {
      PH: { maxDigits: 10 }, 
    };

    // Set default
    $selectedFlag.attr('src', 'https://flagcdn.com/w20/ph.png');
    $selectedCountryCode.text(dialCode);
    setInputWithDialCode(dialCode);
    setMaxInputLength(selectedISO);

    const allCountries = libphonenumber.getCountries().map(iso => {
      return {
        iso,
        name: new Intl.DisplayNames(['en'], { type: 'region' }).of(iso),
        dialCode: '+' + libphonenumber.getCountryCallingCode(iso),
        flag: `https://flagcdn.com/w20/${iso.toLowerCase()}.png`
      };
    });

    function renderDropdown(countries) {
      const $items = countries.map(c => `
        <div class="dropdown-item-cust" data-iso="${c.iso}" data-dial-code="${c.dialCode}">
          <img src="${c.flag}" width="20">
          <span>${c.name}</span>
          <span class="country-code">${c.dialCode}</span>
        </div>
      `).join('');
      $dropdownMenu.find('.dropdown-item-cust').remove();
      $dropdownMenu.append($items);
    }

    function setInputWithDialCode(code) {
      $phoneInput.val(code + ' ');
      setTimeout(() => {
        // Move cursor to end
        const input = $phoneInput.get(0);
        input.setSelectionRange($phoneInput.val().length, $phoneInput.val().length);
      }, 0);
    }

    function setMaxInputLength(iso) {
      const format = countryFormats[iso];
      if (format) {
        $phoneInput.attr('maxlength', dialCode.length + 1 + format.maxDigits); // +1 for space
      } else {
        $phoneInput.removeAttr('maxlength');
      }
    }

    renderDropdown(allCountries);

    $searchInput.on('input', function () {
      const query = $(this).val().toLowerCase();
      const filtered = allCountries.filter(c =>
        c.name.toLowerCase().includes(query) ||
        c.dialCode.includes(query)
      );
      renderDropdown(filtered);
    });

    $countrySelector.on('click', function (e) {
      e.stopPropagation();
      $dropdownMenu.toggleClass('show');
      $searchInput.focus();
    });

    $dropdownMenu.on('click', '.dropdown-item-cust', function (e) {
      e.stopPropagation();
      const $item = $(this);
      const flagSrc = $item.find('img').attr('src');
      dialCode = $item.data('dial-code');
      selectedISO = $item.data('iso');

      $selectedFlag.attr('src', flagSrc);
      $selectedCountryCode.text(dialCode);
      $dropdownMenu.removeClass('show');
      setInputWithDialCode(dialCode);
      setMaxInputLength(selectedISO);
    });

    $(document).on('click', function (e) {
      if (!$(e.target).closest('.phone-input-container').length) {
        $dropdownMenu.removeClass('show');
      }
    });

    // Prevent deleting or editing the dial code
    $phoneInput.on('keydown', function (e) {
      const pos = this.selectionStart;
      const codeLength = dialCode.length + 1; // +1 for space after dial code

      // Prevent backspace/delete in dial code
      if ((e.key === 'Backspace' && pos <= codeLength) ||
          (e.key === 'ArrowLeft' && pos <= codeLength)) {
        e.preventDefault();
        return false;
      }

      // Prevent typing before dial code
      if (pos < codeLength) {
        this.setSelectionRange(codeLength, codeLength);
      }
    });

    // Allow only numbers after country code
    $phoneInput.on('keypress', function (e) {
      const char = String.fromCharCode(e.which);
      const pos = this.selectionStart;
      const codeLength = dialCode.length + 1;
      if (!/[0-9]/.test(char) || pos < codeLength) {
        e.preventDefault();
      }
    });

    $phoneInput.on('input', function() {
        $('.contact_no').val($phoneInput.val());
    });

  });
</script>

<script type='text/javascript'>
    @if (!empty($data['success']))
        swal("{{ $data['success'] }}");
    @endif

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    // get provinces
    $(document).ready(function() {
        $('#country').change(function() {
            let countryID = $(this).find(':selected').data('id');

            if (countryID) {
                $('#loading_filter_prov').show();
                $.ajax({
                    url: "{{ route('get_provinces') }}", 
                    type: "POST",
                    success: function(data) {
                        $('#province').prop('disabled', false);
                        $('#province').html('<option value="" selected disabled>Select province here...</option>');
                        $.each(data, function(key, value) {
                            $('#province').append('<option value="' + value.name + '" data-id="' + value.code + '">' + value.name + '</option>');
                        });
                        $('#province').append('<option value="Metro Manila" data-id="00">Metro Manila</option>');
                        $('#loading_filter_prov').hide();
                    }
                });
            } else {
                $('#loading_filter_prov').hide();
                $('#province').prop('disabled', true);
                $('#province').html('<option value="" selected disabled>Select province here...</option>');
            }
        });
        $('#country').trigger('change');
    });

    // get cities 
    $(document).ready(function() {
        $('#province').change(function() {
            let provCode = $(this).find(':selected').data('id');
            $('#city').val(null).trigger('change');

            if (provCode) {
                $('#loading_filter_city').show();
                $.ajax({
                    url: "{{ route('get_cities') }}", 
                    type: "POST",
                    data: { prov_code: provCode },
                    success: function(data) {
                        $('#city').prop('disabled', false);
                        $('#city').html('<option value="" selected disabled>Select city here...</option>');
                        $.each(data, function(key, value) {
                            $('#city').append('<option value="' + value.name + '" data-id="' + value.code + '">' + value.name + '</option>');
                        });
                        $('#loading_filter_city').hide();
                    }
                });
            } else {
                $('#loading_filter_city').hide();
                $('#city').prop('disabled', true);
                $('#city').html('<option value="" selected disabled>Select city here...</option>');
            }
        });
    });

    // get brgy 
    $(document).ready(function() {
        $('#city').change(function() {
            let citymunCode = $(this).find(':selected').data('id');
            $('#barangay').val(null).trigger('change');

            if (citymunCode) {
                $('#loading_filter_brgy').show();
                $.ajax({
                    url: "{{ route('get_brgy') }}", 
                    type: "POST",
                    data: { city_mun_code: citymunCode},
                    success: function(data) {
                        $('#barangay').prop('disabled', false);
                        $('#barangay').html('<option value="" selected disabled>Select barangay here...</option>');
                        $.each(data, function(key, value) {
                            $('#barangay').append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                        $('#loading_filter_brgy').hide();
                    }
                });
            } else {
                $('#loading_filter_brgy').hide();
                $('#barangay').prop('disabled', true);
                $('#barangay').html('<option value="" selected disabled>Select barangay here...</option>');
            }
        });
    });

    $(document).ready(function() {
        function updateAddress() {
            let country = $('#country').val() || '';
            let province = $('#province').val() || '';
            let city = $('#city').val() || '';
            let barangay = $('#barangay').val() || '';
            let address_line = $('#address_line').val() || '';
            let fullAddress = `${address_line}, ${barangay}, ${city}, ${province}, ${country}`;

            $('#address').val(fullAddress.trim());
        }

        $('#country, #province, #city, #barangay, #address_line').on('input change', updateAddress);
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('.content-header').hide();

        // Multi-step form functionality
        const nextButton = document.getElementById("next-button")
        const prevButton = document.getElementById("prev-button")
        const step1 = document.getElementById("step-1")
        const step2 = document.getElementById("step-2")
        const steps = document.querySelectorAll(".step-cus")
        const progressFill = document.querySelector(".progress-fill-cus")
        const progressPercentage = document.getElementById("progress-percentage")

    nextButton.addEventListener("click", () => {
        // Basic validation for required fields
        let city = $('#city').val();
        const requiredFields = step1.querySelectorAll("[required]");
        let isValid = true;

        // Get the city input element to add the class directly to it
        const cityElement = $('#city')[0];

        requiredFields.forEach((field) => {
            // Check if the field is empty or if the city is empty
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add("invalid");
            } else {
                field.classList.remove("invalid");
            }
        });

        if (!isValid) {
            Swal.fire({
                title: "Required!",
                text: "Please fill in all required fields.",
                icon: "warning",
            });
            return;
        }

        // let email = $('#email').val();

        // if (email) {
        //     $.ajax({
        //         url: "{{ route('verify_email') }}", 
        //         type: "POST",
        //         data: { email: email },
        //         success: function(data) {
        //             if(data.valid_email){
        //                 // Move to step 2
        //                 step1.style.display = "none"
        //                 step2.style.display = "block"

        //                 // Update steps indicator
        //                 steps[0].classList.remove("active")
        //                 steps[1].classList.add("active")

        //                 // Update progress
        //                 progressFill.style.width = "50%"
        //                 progressPercentage.textContent = "50% Complete"
                        
        //                 $('#email').addClass('success-input');
        //                 $('#email').removeClass('error-input');
        //                 $('#email_status').text(data.valid_email).css('color','#00c853');
        //                 $('.success-icon-cus').show();
        //                 $('.error-icon-cus').hide();
        //             } else if (data.invalid_email){
        //                 console.log(data.invalid_email);
        //                 $('#email').addClass('error-input');
        //                 $('#email').removeClass('success-input');
        //                 $('#email_status').text(data.invalid_email).css('color','#ff4d4f');
        //                 $('.error-icon-cus').show();
        //                 $('.success-icon-cus').hide();
        //                 return;
        //             }
        //         }
        //     });
        // }
        step1.style.display = "none"
        step2.style.display = "block"

        // Update steps indicator
        steps[0].classList.remove("active")
        steps[1].classList.add("active")
    })

    prevButton.addEventListener("click", () => {
        // Move back to step 1
        step2.style.display = "none"
        step1.style.display = "block"

        // Update steps indicator
        steps[1].classList.remove("active")
        steps[0].classList.add("active")
    })

    // Add input validation styling
    const inputs = document.querySelectorAll("input, textarea")

        inputs.forEach((input) => {
            input.addEventListener("blur", function () {
            if (this.hasAttribute("required") && !this.value.trim()) {
                this.classList.add("invalid")
            } else {
                this.classList.remove("invalid")
            }
            })
        })
    })

    document.addEventListener("DOMContentLoaded", () => {
        let progressFill = document.querySelector(".progress-fill-cus");
        let progressPercentage = document.getElementById("progress-percentage");

        // field names 
        const fields = [
            "first_name", "last_name", "email", "company_name", "company_contact_no", 
            "country", "province", "city", "barangay", "address_line"
        ];

        function updateProgress() {
            let filledCount = 0;

            // Count filled fields
            fields.forEach(field => {
                let input = $(`[name="${field}"]`);
                if (input.is("select")) {
                    // Check if a value is selected in a <select> field
                    if (input.val() && input.val() !== "") {
                        filledCount++;
                    }
                } else {
                    // Check for text input fields
                    if (input.val().trim().length > 0) {
                        filledCount++;
                    }
                }
            });

            // Calculate progress dynamically
            let progress = (filledCount / fields.length) * 50;

            // Update progress bar
            progressFill.style.width = `${progress}%`;
            progressPercentage.textContent = `${progress.toFixed(1)}% Complete`;
        }

        // Attach event listeners for text inputs
        fields.forEach(field => {
            let input = $(`[name="${field}"]`);

            if (input.is("select")) {
                // For standard <select> elements
                input.on("change", updateProgress);
                
                // If using Select2, listen for the Select2-specific event
                input.on("select2:select", updateProgress);
            } else {
                // For text inputs
                input.on("input", updateProgress);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.createJOBtn').hide();

        $('.toggle-input').on('change', function() {
            const icloudSigned = $('input[name="icloud-signed"]:checked').val();
            const filesBacked = $('input[name="files-backed"]:checked').val();

            if (icloudSigned === 'Yes' && filesBacked === 'Yes') {
                $('.createJOBtn').show();
            } else {
                $('.createJOBtn').hide();
            }
        });
    });

    $('#store_purcahse').on('change', function(){
        if($(this).val() == 'others'){
            $('#other_store_purchase').show();
        } else{
            $('#other_store_purchase').hide();
        }
    });
</script>

{{-- <script>
    $('#purchase_date').datepicker({
        endDate: "0d",
        format: 'mm/dd/yyyy',
        autoclose: true
    });
</script> --}}


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
@include('frontliner.create_transactions_script')
@endpush