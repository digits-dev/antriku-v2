<div id="mailin-in-warranty" style="display: {{ $transaction_details->warranty_status === 'IN WARRANTY' ? 'block' : 'none' }};">
    @if (CRUDBooster::myPrivilegeId() == 3)
        @if ($transaction_details->repair_status == 12)
        <button type="submit" id="save" onclick="return changeStatus(14)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        <button type="submit" id="reject" onclick="return changeStatus(13)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>
        @endif
    @elseif (CRUDBooster::myPrivilegeId() == 9)
        @if ($transaction_details->repair_status == 15)
        <button type="submit" id="save" onclick="return changeStatus(16)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @endif
    @else
        @if ($transaction_details->repair_status == 14)
        <button type="submit" id="save" onclick="return changeStatus(15)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @endif
    @endif
    
</div>

<div id="mailin-out-warranty" style="display: {{ $transaction_details->warranty_status === 'OUT OF WARRANTY' ? 'block' : 'none' }};">
    <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> OUT OF WARRANTY MAIL IN
    </button>
</div>
