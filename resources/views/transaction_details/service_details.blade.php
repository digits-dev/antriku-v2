<section class="card-cust" style="border-radius: 0%;">
    <div class="card-header-cust">
        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
            <i class="bi bi-wrench-adjustable-circle-fill"></i>
        </div>
        Service Details
    </div>
    <div class="card-body-cust">
        <div class="info-grid-cust">
            <div class="info-item-cust">
                <div class="info-label-cust">{{ trans('labels.form-label.purchase_date') }}</div>
                <div class="info-value-cust">{{ date('F j, Y', strtotime($transaction_details->purchase_date)) }}</div>
            </div>

            @if(request()->segment(3) == "edit" && CRUDBooster::getModulePath() == "to_diagnose" && $transaction_details->repair_status == 10 && CRUDBooster::myPrivilegeId() != 2)
                <div class="info-item-cust">
                    <div class="info-label-cust"><span class="requiredField">*</span>{{ trans('labels.form-label.warranty_expiration_date') }}</div>
                    <div class="info-value-cust">
                        <input type="input" name="warranty_expiration_date" placeholder="MM/DD/YYYY" id="warranty_expiration_date" value="{{ date('m/d/Y', strtotime($transaction_details->warranty_expiration_date)) }}" style="border: none; outline:none; margin-bottom: 0rem" autocomplete="off" required readonly/>                        
                    </div>
                </div>
            @elseif(CRUDBooster::getModulePath() != "to_diagnose" || request()->segment(3) == "detail")
                <div class="info-item-cust">
                    <div class="info-label-cust">{{ trans('labels.form-label.warranty_expiration_date') }}</div>
                    <div class="info-value-cust">{{ date('F j, Y', strtotime($transaction_details->warranty_expiration_date)) }}</div>
                </div>
            @endif
        </div>

        {{-- <div class="product-section-cust">
            <div class="product-details-cust"> --}}
            <div class="info-grid-cust">
                <div class="info-item-cust">
                    <div class="info-label-cust">UPC Code</div>
                    <div class="info-value-cust">{{ $transaction_details->header_upc_code }}</div>
                </div>
                <div class="info-item-cust">
                    <div class="info-label-cust">Item Description</div>
                    <div class="info-value-cust">{{ $transaction_details->header_item_description }}</div>
                </div>
                <div class="info-item-cust">
                    {{-- <div class="info-label-cust">{{ trans('labels.table.serial_no') }}</div> --}}
                    <div class="info-label-cust">Unit Serial Number</div>
                    <div class="info-value-cust">{{ $transaction_details->header_serial_no }}</div>
                </div>
                <div class="info-item-cust">
                    <div class="info-label-cust">Branch</div>
                    <div class="info-value-cust">{{ $data['Branch']->branch_name }}</div>
                </div>
                <div class="info-item-cust">
                    <div class="info-label-cust">Model</div>
                    <div class="info-value-cust">{{ $transaction_details->model_name }}</div>
                </div>
                <div class="info-item-cust" style="display: {{$transaction_details->warranty_status != 'OUT OF WARRANTY' ? 'none' : ''}}">
                    <div class="info-label-cust">Unit Type</div>
                    <div class="info-value-cust">{{ $transaction_details->unit_type }}</div>
                </div>
                <div class="info-item-cust">
                    <div class="info-label-cust">VMI</div>
                    <div class="info-value-cust">{{ $transaction_details->summary_of_concern }}</div>
                </div>
            </div>
            {{-- </div>
        </div> --}}
        <div class="row">
            <div class="col-md-6">
                <div class="product-image-cust">
                    <p class="text-uppercase">🪛 <b>First Diagnosis</b></p>
                    <div class="original_marked_model">
                        @if ($transaction_details->inspected_model_photo)
                            <img src="{{ Storage::url($transaction_details->inspected_model_photo) }}" alt="model photo" id="original_editable_model">
                        @else
                            <img src="{{ URL::to('/') }}/{{ $transaction_details->model_photo }}" alt="model photo" id="original_editable_model">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-image-cust">
                    <p class="text-uppercase">🪛 <b>Second Diagnosis</b></p>
                    <div class="second_marked_model">
                        @if ($transaction_details->second_inspected_model_photo)
                            <img src="{{ Storage::url($transaction_details->second_inspected_model_photo) }}" alt="model photo" id="saved_2nd_inpeted_model_photo">
                            <div id="second_marked_model"></div>
                        @else
                            <div id="second_marked_model"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
