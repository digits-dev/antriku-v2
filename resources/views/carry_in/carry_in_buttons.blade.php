<div id="carryin-in-warranty" style="display: {{ $transaction_details->warranty_status === 'IN WARRANTY' ? 'block' : 'none' }};">

    @if ($transaction_details->repair_status == 10)
        <div id="inwarranty_carryin_btns" style="display: none">
            {{-- available iventory button  --}}
            <button type="submit" id="save" onclick="return changeStatus(29)" class="btn btn-success pull-right buttonSubmit iw_cin_available_btn" style="margin-left: 20px; display:none;">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
            </button>
            
            {{-- unavailable inventory button  --}}
            <button type="submit" id="save" onclick="return changeStatus(30)" class="btn btn-danger pull-right buttonSubmit iw_cin_unavailable_btn" style="margin-left: 20px; display:none;">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed 
            </button>
        </div>
    @endif
    @if ($transaction_details->repair_status == 29)
        <div>
            <button type="submit" id="save" onclick="return changeStatus(31)" class="btn btn-primary pull-right buttonSubmit iw_cin_spare_part_release">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
            </button>
        </div>
    @endif
    @if ($transaction_details->repair_status == 31)
        <div>
            <button type="submit" id="save" onclick="return changeStatus(34)" class="btn btn-primary pull-right buttonSubmit">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed Ongoing Repair
            </button>
        </div>
    @endif
    @if ($transaction_details->repair_status == 34)
        <div>
            <button type="submit" id="save" onclick="return changeStatus(34)" class="btn btn-danger pull-right buttonSubmit iw_cin_doa" style="display: none">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed, DOA
            </button>
            <button type="submit" id="save" onclick="return changeStatus(35)" class="btn btn-danger pull-right buttonSubmit iw_cin_additional_spare_part" style="display: none">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed, Additional Spare Part
            </button>
            <input type="hidden" value="{{$transaction_details->repair_status}}" id="transaction_status">
            <button type="submit" id="save" onclick="return changeStatus(19)" class="btn btn-primary pull-right buttonSubmit iw_cin_no_additional_spare_part" >
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
            </button>
        </div>
    @endif
    @if ($transaction_details->repair_status == 35)
        <div>
            <button type="submit" id="save" onclick="return changeStatus(29)" class="btn btn-success pull-right" style="margin-left: 10px">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed, Yes
            </button>
            <button type="submit" id="save" onclick="return changeStatus(19)" class="btn btn-primary pull-right">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed, No
            </button>
            <input type="hidden" value="{{$transaction_details->repair_status}}" id="transaction_status">
        </div>
    @endif
</div>

<div id="carryin-out-warranty" style="display: {{ $transaction_details->warranty_status === 'OUT OF WARRANTY' ? 'block' : 'none' }};">
    <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> OUT OF WARRANTY CARRY IN
    </button>
</div>

