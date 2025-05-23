<section class="card-cust" style="border-radius: 0%;">
    <div class="card-header-cust">
        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
            <i class="bi bi-person-vcard-fill"></i>
        </div>
        Customer Details
    </div>
    <div class="card-body-cust">
        <div class="info-grid-cust">
            <div class="info-item-cust">
                <div class="info-label-cust">{{ trans('labels.form-label.first_name') }}</div>
                <div class="info-value-cust">{{$transaction_details->first_name}}</div>
            </div>
            <div class="info-item-cust">
                <div class="info-label-cust">{{ trans('labels.form-label.last_name') }}</div>
                <div class="info-value-cust">{{$transaction_details->last_name}}</div>
            </div>
            @if(request()->segment(3) == "detail" || CRUDBooster::getModulePath() != "pay_diagnostic")
                <div class="info-item-cust">
                    <div class="info-label-cust">{{ trans('labels.form-label.email_address') }}</div>
                    <div class="info-value-cust">{{$transaction_details->email}}</div>
                </div>
                <div class="info-item-cust">
                    <div class="info-label-cust">{{ trans('labels.form-label.contact_no') }}</div>
                    <div class="info-value-cust">{{$transaction_details->contact_no}}</div>
                </div>
            @elseif(request()->segment(3) == "edit" && CRUDBooster::getModulePath() == "pay_diagnostic")
                <div class="info-item-cust">
                    <div class="info-label-cust">{{ trans('labels.form-label.email_address') }}</div>
                    <div class="info-value-cust">
                        <input type="email" name="email" id="email" value="{{$transaction_details->email}}" placeholder="Email Address" style="border:none; outline: none;" autocomplete="off" required/>
                    </div>
                </div>
                <div class="info-item-cust">
                    <div class="info-label-cust">{{ trans('labels.form-label.contact_no') }}</div>
                    <div class="info-value-cust">
                        <input type="input" name="contact_no" id="contact_no" value="{{$transaction_details->contact_no}}" placeholder="09#########" pattern="[09][0-9]{10}" style="border:none; outline: none;"  autocomplete="off" required/>
                    </div>
                </div>
            @endif
            <div class="info-item-cust">
                <div class="info-label-cust">Company Name</div>
                <div class="info-value-cust">{{$transaction_details->company_name ?? 'N/A'}}</div>
            </div>
            <div class="info-item-cust">
                <div class="info-label-cust">Company Contact</div>
                <div class="info-value-cust">{{$transaction_details->company_contact_no ?? 'N/A'}}</div>
            </div>
        </div>
        <div class="info-item-cust">
            <div class="info-label-cust">Address</div>
            <div class="info-value-cust">{{$transaction_details->address ?? 'N/A'}}</div>
        </div>
    </div>
</section>