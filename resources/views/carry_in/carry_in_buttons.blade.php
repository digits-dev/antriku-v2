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
</div>

<div id="carryin-out-warranty" style="display: {{ $transaction_details->warranty_status === 'OUT OF WARRANTY' ? 'block' : 'none' }};">
    <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> OUT OF WARRANTY CARRY IN
    </button>
</div>
