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
            @if(in_array($transaction_details->repair_status, [10]))
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 ">
                            <button onclick="AddQuotation()" id="addQuotes" style="margin-top:5px" class="btn btn-warning pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Parts</button>
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
                                    <tr class="tbl_header_color text-uppercase" style="padding: 1px !important;">
                                        <th width="10%" class="text-center" style="padding: 1px !important;">Spare Part#</th>
                                        <th width="10%" class="text-center" style="padding: 1px !important;">GSX Reference</th>
                                        <th width="10%" class="text-center" style="padding: 1px !important;">CS Code</th>
                                        <th width="10%" class="text-center" style="padding: 1px !important;">KGB Serial Number</th>
                                        <th width="20%" class="text-center" style="padding: 1px !important;">Item Description</th>
                                        <th width="7%" class="text-center" style="padding: 1px !important;">Qty</th>
                                        <th width="7%" class="text-center" style="padding: 1px !important; display:none">Item Parts ID</th>
                                        <th width="9%" class="text-center" style="padding: 1px !important;">Price</th>
                                        <th width="1%" class="text-center" style="padding: 1px !important;"></th>
                                    </tr>
                                    <tr id="quotelist">
                                        @if(!empty($data['quotation']))
                                            @foreach($data['quotation'] as $qt)
                                                <tr class="nr row_num" id="rowID{{$qt->id}}">
                                                    <input type="hidden"class="getidValue" value="{{$qt->id}}">
                                                    <td style="padding: 1px !important;"><input class="input-cus text-center getscValue" type="text" id="service_code_{{$qt->id}}" oninput="gsx_data('{{$qt->id}}')" value="{{ $qt->service_code }}" placeholder="Enter Spare Part Number" readonly {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}} style="background: lightgrey"></td>
                                                    <td style="padding: 1px !important;">
                                                        @if(CRUDBooster::getModulePath() == "to_pay_parts" && CRUDBooster::myPrivilegeId() == 1)
                                                            <input class="input-cus text-center getgsxValue" type="text" id="gsx_code_{{$qt->id}}"  value="{{ $qt->gsx_ref }}" placeholder="Enter GSX Reference">
                                                        @elseif(CRUDBooster::getModulePath() == "to_pay_parts" && CRUDBooster::myPrivilegeId() == 4)
                                                            <input class="input-cus text-center getgsxValue" type="text" id="gsx_code_{{$qt->id}}"  value="{{ $qt->gsx_ref }}" placeholder="Enter GSX Reference">
                                                        @else
                                                            <input class="input-cus text-center getgsxValue" type="text" id="gsx_code_{{$qt->id}}"  value="{{ $qt->gsx_ref }}" placeholder="Enter GSX Reference" {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}}>
                                                        @endif
                                                    </td>
                                                    <td style="padding: 1px !important;"><input class="input-cus text-center getcsValue" type="text" id="cs_code_{{$qt->id}}" value="{{ $qt->cs_code }}" placeholder="Enter CS Code" {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}}></td>
                                                    <td style="padding: 1px !important;">
                                                        @if(CRUDBooster::getModulePath() == "to_close" && CRUDBooster::myPrivilegeId() == 1)
                                                            <input class="input-cus text-center getserialValue" type="text" value="{{ $qt->serial_no }}" placeholder="Enter KGB Serial Number">
                                                        @elseif(CRUDBooster::getModulePath() == "to_close" && CRUDBooster::myPrivilegeId() == 2)
                                                            <input class="input-cus text-center getserialValue" type="text" value="{{ $qt->serial_no }}" placeholder="Enter KGB Serial Number">
                                                        @else
                                                             @if(CRUDBooster::getModulePath() == "repair_in_process" && CRUDBooster::myPrivilegeId() == 1)
                                                                <input class="input-cus text-center getserialValue" type="text" value="{{ $qt->serial_no }}" placeholder="Enter KGB Serial Number">
                                                            @elseif(CRUDBooster::getModulePath() == "repair_in_process" && CRUDBooster::myPrivilegeId() == 2)
                                                                <input class="input-cus text-center getserialValue" type="text" value="{{ $qt->serial_no }}" placeholder="Enter KGB Serial Number">
                                                            @else
                                                                <input class="input-cus text-center getserialValue" type="text" value="{{ $qt->serial_no }}" placeholder="Enter KGB Serial Number" {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}}>
                                                            @endif
                                                        @endif
                                                        
                                                    </td>
                                                    <td style="padding: 1px !important;"><input class="input-cus text-center getitemValue" type="text" id="item_desc_{{$qt->id}}" value="{{ $qt->item_description }}" placeholder="Enter Item Description" readonly {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}} style="background: lightgrey"></td>
                                                    <td style="padding: 1px !important;"><input class="input-cus text-center getqtyValue" type="text" id="qty_{{$qt->id}}" value="{{$qt->qty_status}}" readonly {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}} style="background: lightgrey; color: {{$qt->qty_status == 'Available' ? '#16a34a' : '#ef4444'}}"></td>
                                                    <td style="padding: 1px !important; display:none"><input class="input-cus text-center getitemparstidValue" type="hidden" id="item_parts_id_{{$qt->id}}" value="{{$qt->item_parts_id}}" readonly></td>
                                                    <td style="padding: 1px !important;"><input class="input-cus text-center getcostValue" type="number" onblur="AutoFormatCost('{{$qt->id}}')" id="price_{{$qt->id}}" value="{{ $qt->cost }}" min="0" step="any" placeholder="Enter Price" {{ !in_array($transaction_details->repair_status, [10]) ? 'readonly' : ''}}></td> 
                                                    @if(in_array($transaction_details->repair_status, [10])) <td style="padding: 5px !important;" class="text-center"><a onclick="RemoveRow('{{$qt->id}}')"><i class="fa fa-close fa-2x remove" style="color:red"></i></a></td> @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tr>
                                    <tr class="nr row_num" {{ !in_array($transaction_details->repair_status, [10]) ? 'hidden' : ''}}>
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
                                        <td style="padding: 1px !important;"><input class="input-cus text-center getcostValue getcostValue2" type="number" value="" onblur="AutoFormatCost('cost')" id="cost" min="0" step="any"  placeholder="Enter Price"></td> 
                                        <td style="padding: 5px !important;" class="text-center"> <i class="bi bi-eraser-fill" onclick="erase_wrong_filter()" style="font-size: 24px; color: rgb(235, 63, 92)"></i> </td>
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
