@if(request()->segment(3) == "edit")
<section class="card-cust" style="border-radius: 0rem">
    <div class="row">
        <div class="col-md-12">
            <div class="row"> 
                <div class="col-md-12">
                    <div class="card-header-cust">
                        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
                            <i class="bi bi-tools"></i>
                        </div>
                        Quotation of Repair
                    </div>
                </div> 
            </div>  
            <br>
            @if(in_array($transaction_details->repair_status, [10, 34, 35]))
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="toggle-row" style="margin-left: 20px">
                                    <div class="toggle-info">
                                        <span class="toggle-label">Additional Required?</span>
                                        <span class="toggle-description">Enable additional spare part required</span>
                                    </div>
                                    <label class="toggle">
                                        <input type="checkbox" id="additional-toggle"
                                        {{$transaction_details->repair_status == 35 ? 'checked disabled' : ''}}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                            @if (in_array($transaction_details->repair_status, [10, 34]))    
                                <div class="col-md-6">
                                    <div class="toggle-row">
                                        <div class="toggle-info">
                                            <span class="toggle-label">DOA?</span>
                                            <span class="toggle-description">Dead on arrival verification process</span>
                                        </div>
                                        <label class="toggle">
                                            <input type="checkbox" id="doa-toggle" name="doa_jo" value="no" onclick="this.value = this.checked ? 'yes' : 'no';">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4" id="add_parts_btn" style="display: {{ in_array($transaction_details->repair_status, [34, 35]) ? 'none' : '' }}">
                        <div class="col-md-12">
                            <button onclick="AddQuotation()" id="addQuotes" style="margin-top:5px" class="btn btn-warning pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Parts</button>
                            <input type="hidden" value="{{$transaction_details->repair_status}}" id="transaction_status" name="recent_treansaction_status">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>          

    <div class="row">
        <div class="col-md-12">
            <div class="box-body">
                <div class="table-responsive borderline" style="overflow-x:unset !important; border-top: 1px solid lightgrey;">
                    <div class="pic-container">
                        <div class="pic-row">
                            <table class="table table-bordered" id="dynamic_field">
                                <tbody>
                                    <tr class="tbl_header_color text-uppercase" style="padding: 3px !important;">
                                        <th width="10%" class="text-center" style="padding: 1px !important;">Spare Part#</th>
                                        <th width="10%" class="text-center" style="padding: 1px !important;">GSX Reference</th>
                                        <th width="10%" class="text-center" style="padding: 1px !important;">CS Code</th>
                                        <th width="10%" class="text-center" style="padding: 1px !important;">KGB Serial Number</th>
                                        <th width="20%" class="text-center" style="padding: 1px !important;">Item Description</th>
                                        <th width="9%" class="text-center" style="padding: 1px !important;">Qty</th>
                                        <th width="7%" class="text-center" style="padding: 1px !important; display:none">Item Parts ID</th>
                                        <th width="9%" class="text-center" style="padding: 1px !important;">Price</th>
                                        <th width="1%" class="text-center" style="padding: 1px !important;"></th>
                                    </tr>
                                    <tr id="quotelist">
                                        <input type="hidden" value="{{$transaction_details->repair_status}}" name="recent_treansaction_status">
                                        @if(!empty($data['quotation']))
                                            @foreach($data['quotation'] as $qt)
                                            <input type="hidden" class="hidden_doa_jo" name="doa_jo" value="no">
                                            <input type="hidden" value="{{$qt->item_spare_additional_type}}" class="item_spare_additional_type">
                                                <tr class="nr row_num" id="rowID{{$qt->id}}"
                                                    style="background: 
                                                        {{ $qt->item_spare_additional_type == 'Additional-Standard-DOA' ? '#443627' : 
                                                        ($qt->item_spare_additional_type != 'Additional-Standard' ? '#FFC785' : '') }}"
                                                    >
                                                    <input type="hidden"class="getidValue" value="{{$qt->id}}">
                                                    <td style="padding: 3px !important;">
                                                        <input class="input-cus text-center getscValue" type="text" id="service_code_{{$qt->id}}" oninput="gsx_data('{{$qt->id}}')" value="{{ $qt->service_code }}" placeholder="Enter Spare Part Number" readonly {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}} style="background: lightgrey">
                                                    </td>
                                                    <td style="padding: 3px !important;">
                                                        <input class="input-cus text-center getgsxValue" type="text" id="gsx_code_{{$qt->id}}"  value="{{ $qt->gsx_ref }}" placeholder="Enter GSX Reference" {{ !in_array($transaction_details->repair_status, [10, 29]) ? 'readonly' : ''}} style="background: {{ !in_array($transaction_details->repair_status, [10, 29]) ? 'lightgrey' : ''}}">
                                                    </td>
                                                    <td style="padding: 3px !important;">
                                                        <input class="input-cus text-center getcsValue" type="text" id="cs_code_{{$qt->id}}" value="{{ $qt->cs_code }}" placeholder="Enter CS Code" {{ !in_array($transaction_details->repair_status, [10, 29]) ? 'readonly' : ''}} style="background: {{ !in_array($transaction_details->repair_status, [10, 29]) ? 'lightgrey' : ''}}">
                                                    </td>
                                                    <td style="padding: 3px !important;">                        
                                                        <input class="input-cus text-center getserialValue" type="text" value="{{ $qt->serial_no }}" placeholder="Enter KGB Serial Number" {{ !in_array($transaction_details->repair_status, [10, 34]) ? 'readonly' : ''}} style="background: {{ !in_array($transaction_details->repair_status, [10, 34]) ? 'lightgrey' : ''}}">
                                                    </td>
                                                    <td style="padding: 3px !important;">
                                                        <input class="input-cus text-center getitemValue" type="text" id="item_desc_{{$qt->id}}" value="{{ $qt->item_description }}" placeholder="Enter Item Description" readonly {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}} style="background: lightgrey">
                                                    </td>
                                                    <td style="padding: 3px !important;">
                                                        <input class="input-cus text-center getqtyValue" type="text" id="qty_{{$qt->id}}" value="{{$qt->qty_status}}" readonly 
                                                               style="font-weight:500; background: lightgrey; color:{{ $qt->qty_status == 'Available-DOA' ? '#443627' : ($qt->qty_status == 'Available' ? '#16a34a' : '#ef4444') }}">
                                                    </td>
                                                    <td style="padding: 1px !important; display:none">
                                                        <input class="input-cus text-center getitemparstidValue" type="hidden" id="item_parts_id_{{$qt->id}}" value="{{$qt->item_parts_id}}" readonly>
                                                    </td>
                                                    <td style="padding: 3px !important;"><input class="input-cus text-center getcostValue" type="number" onblur="AutoFormatCost('{{$qt->id}}')" id="price_{{$qt->id}}" value="{{ $qt->cost }}" min="0" max="9999" step="any" placeholder="Enter Price" {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}} style="background: {{ !in_array($transaction_details->repair_status, [10]) ? 'lightgrey' : ''}}"></td> 
                                                    @if(in_array($transaction_details->repair_status, [10, 34])) 
                                                        <td style="padding: 5px !important;" class="text-center {{$qt->item_spare_additional_type == 'Additional-Standard' && $transaction_details->repair_status == 34 ? 'hidden' : ''}}">
                                                            <a onclick="RemoveRow('{{$qt->id}}')"><i class="fa fa-close fa-2x remove" style="color:red"></i></a>
                                                        </td>
                                                    @elseif(in_array($transaction_details->repair_status, [33]) && CRUDBooster::myPrivilegeId() == 9 && $qt->qty_status == 'Unavailable') 
                                                        <td style="padding: 5px !important;" class="text-center">
                                                            <button type="button" class="btn btn-success spare_receiving_btn" onclick="receive_parts({{$qt->item_parts_id}})">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-labelledby="receiveIconTitle" style="vertical-align: -0.125em; margin-right: 1px;">
                                                                    <title id="receiveIconTitle">Inventory Receiving Quantity</title>
                                                                    <!-- Truck body -->
                                                                    <path d="M1 3h15v13H1z" fill="#e8f5e9" />
                                                                    <!-- Truck cabin -->
                                                                    <path d="M16 8h4l3 3v5h-7V8z" fill="#c8e6c9" />
                                                                    <!-- Wheels -->
                                                                    <circle cx="5.5" cy="18.5" r="2.5" />
                                                                    <circle cx="18.5" cy="18.5" r="2.5" />
                                                                    <!-- Package in the back of the truck -->
                                                                    <rect x="7" y="8" width="5" height="5" rx="1" fill="#81c784" />
                                                                    <!-- Quantity badge -->
                                                                    <circle cx="19" cy="5" r="4" fill="#ff9800" stroke="#ff9800" />
                                                                    <text x="19" y="7" dominant-baseline="middle" text-anchor="middle" fill="white" style="font-size: 6px; font-weight: bold;">+</text>
                                                                </svg>
                                                                Receive
                                                            </button>
                                                        </td> 
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tr>
                                    <tr class="nr row_num" {{ !in_array($transaction_details->repair_status, [10, 34]) ? 'hidden' : ''}} style="display:none" id="spare_parts_filter">
                                        <input type="hidden"class="getidValue" value="">
                                        <td style="padding: 1px !important;position: relative;">
                                            <input class="input-cus text-center getscValue getscValue2"  type="text" value="" id="service_code" oninput="gsx_data('service_code')" placeholder="Enter Spare Part Number">
                                            <ul class="form-control ui-front sparepartlist ui-menu ui-widget ui-widget-content">
                                                <li class="li-padding">Loading...</li>
                                            </ul>
                                        </td>
                                        <td style="padding: 1px !important;"><input class="input-cus text-center getgsxValue getgsxValue2" type="text" value="" id="gsx_ref"  placeholder="Enter GSX Reference"></td>
                                        <td style="padding: 1px !important;"><input class="input-cus text-center getcsValue getcsValue2" type="text" value="" id="cs_code" placeholder="Enter CS Code"></td>
                                        <td style="padding: 1px !important;"><input class="input-cus text-center getserialValue getserialValue2" type="text" value="" id="serial_no" placeholder="Enter KGB Serial Number"></td>
                                        <td style="padding: 1px !important;"><input class="input-cus text-center getitemValue getitemValue2" type="text" value="" id="item_desc" placeholder="Enter Item Description"></td>
                                        <td style="padding: 1px !important;"><input class="input-cus text-center getqtyValue getqtyValue2" type="text" value="" id="qty" placeholder="Search Item" readonly style="background: lightgrey"></td>
                                        <td style="padding: 1px !important; display:none"><input class="input-cus text-center getitemparstidValue getitemparstidValue2" type="hidden" value="" id="item_parts_id" placeholder="Search Item" readonly style="background: lightgrey"></td>
                                        <td style="padding: 1px !important;"><input class="input-cus text-center getcostValue getcostValue2" type="number" value="" onblur="AutoFormatCost('cost')" id="cost" min="0" max="9999" step="any"  placeholder="Enter Price"></td> 
                                        <td style="padding: 5px !important;" class="text-center"> 
                                            <i class="bi bi-eraser-fill" onclick="erase_wrong_filter()" style="font-size: 24px; color: rgb(235, 63, 92)"></i> 
                                            @if ($transaction_details->repair_status == 34)
                                                <input type="hidden" name="new_spare_req" id="new_spare_req">
                                            @endif
                                        </td>
                                    </tr>
                                        <input type="hidden" name="header_id" id="header_id" value="{{ $transaction_details->header_id }}">
                                        <input type="hidden" name="number_of_rows" id="number_of_rows">
                                        <input type="hidden" name="row_id" id="rowidArray">
                                        <input type="hidden" name="service_code" id="scArray">
                                        <input type="hidden" name="gsx_ref" id="gsxArray">
                                        <input type="hidden" name="cs_code" id="csArray">
                                        <input type="hidden" name="serial_no" id="serialArray">
                                        <input type="hidden" name="item_desc" id="itemArray">
                                        <input type="hidden" name="qty" id="qtyArray">
                                        <input type="hidden" name="item_parts_id" id="itempartsidArray">
                                        <input type="hidden" name="cost" id="costArray">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('bottom')
    @include('technician.quotation_script')
@endpush

@else
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
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Spare Part#</th>
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">GSX Reference</th>
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">CS Code</th>
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Apple Part#</th>
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Item Description</th>
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Qty</th>
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important; display:none">Item Parts ID</th>
                                        <th width="10%" class="text-center table-bordered-display" style="padding: 5px !important;">Price</th>
                                    </tr>
                                    <tr>
                                        @if(request()->segment(3) == "getDetailView")
                                            @if(!empty($quotation))
                                                @foreach($quotation as $qt)
                                                    <tr>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->service_code }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->gsx_ref }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->cs_code }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->serial_no }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->item_description }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->qty_status }}</p></td>
                                                        <td style="padding: 5px !important; display:none;" class="text-center table-bordered-display"><p>{{ $qt->item_parts_id }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>₱{{ $qt->cost }}</p></td> 
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="table-bordered-display" style="padding: 5px !important;border-width: 1px !important;background-color:#EDEDED;text-align: center;" colspan="7">
                                                        <p><i class="fa fa-search"></i> No Data Available</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            @if(!empty($data['quotation']))
                                                @foreach($quotation as $qt)
                                                    <tr>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->service_code }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->gsx_ref }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->cs_code }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->serial_no }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->item_description }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>{{ $qt->qty_status }}</p></td>
                                                        <td style="padding: 5px !important; display:none" class="text-center table-bordered-display"><p>{{ $qt->item_parts_id }}</p></td>
                                                        <td style="padding: 5px !important;" class="text-center table-bordered-display"><p>₱{{ $qt->cost }}</p></td> 
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="table-bordered-display" style="padding: 5px !important;border-width: 1px !important;background-color:#EDEDED;text-align: center;" colspan="7">
                                                        <p><i class="fa fa-search"></i> No Data Available</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const additionalToggle = document.getElementById('additional-toggle');
        const doaToggle = document.getElementById('doa-toggle');
    
        function updateStatus() {
            if (additionalToggle.checked) {
                $('#add_parts_btn').show();
                $('#spare_parts_filter').show();
                $('.iw_cin_additional_spare_part').show();
                $('.iw_cin_no_additional_spare_part').hide();
                $('#doa-toggle').attr('disabled', 'disabled');
            } else if (doaToggle.checked) {
                $('.hidden_doa_jo').val('yes');
                $('.iw_cin_doa').show();
                $('#add_parts_btn').show();
                $('#spare_parts_filter').show();
                $('.iw_cin_no_additional_spare_part').hide();
                $('#additional-toggle').attr('disabled', 'disabled');
            } else {
                $('.hidden_doa_jo').val('no');
                $('.iw_cin_doa').hide();
                $('#add_parts_btn').hide();
                $('#spare_parts_filter').hide();
                $('.iw_cin_additional_spare_part').hide();
                $('.iw_cin_no_additional_spare_part').show();
                $('#doa-toggle').removeAttr('disabled');
                $('#additional-toggle').removeAttr('disabled');
            }
        }
    
        additionalToggle.addEventListener('change', updateStatus);
        doaToggle.addEventListener('change', updateStatus);
    
        updateStatus();

        let all_item_parts_type = $('.item_spare_additional_type').map(function () {
            return $(this).val().trim().toLowerCase();
        }).get();
        
        const has_additional_required = all_item_parts_type.includes("additional-required-pending");
        const has_doa_jo = all_item_parts_type.includes("additional-standard-doa");

        if (has_additional_required) {
            $('#additional-toggle').prop('checked', true).attr('disabled', true);
            updateStatus();
        } else {
            $('#additional-toggle').prop('checked', false).attr('disabled', false);
        }

        if(has_doa_jo){
            $('#doa-toggle').prop('checked', true).attr('disabled', true);
            updateStatus();
        } else {
            $('#doa-toggle').prop('checked', false).attr('disabled', false);
        }

    });

    function receive_parts(item_parts_id){
        let spare_parts_id = item_parts_id;
        let header_id = $('#header_id').val();

        $.ajax({
            url: "{{ route('receive_spare_part') }}",
            type: "POST",
            data: {
                'spare_parts_id' : spare_parts_id,
                'header_id' : header_id,
                _token: '{!! csrf_token() !!}',
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                Swal.fire({
                    icon: "info",
                    title: "Item Receiving",
                    text: "Please wait...",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                if(response.success == true){
                    Swal.fire({
                        icon: "success",
                        title: response.message,
                        html: `This is also marked as reserved Qty, since this item is ordered for this Job Order.`,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 2000,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        window.location.reload();
                });

                } else if (response.success == false) {
                    Swal.fire({
                        icon: "error",
                        title: response.message,
                        allowOutsideClick: false,
                        showConfirmButton: true,
                    });
                }
            },
            error: function (xhr, error) {
                Swal.close();
                Swal.fire({
                    title: "Can't receive this item, try again!",
                    html: "Something went wrong!",
                    icon: "error",
                    timer: 3000,
                    didOpen: () => Swal.showLoading()
                });setTimeout(() => {
                },3000)
            }
        });
    }
</script>
    