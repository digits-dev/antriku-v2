<div id="mailin-in-warranty" style="display: {{ $transaction_details->warranty_status === 'IN WARRANTY' ? 'block' : 'none' }};">
    {{-- FRONTLINER BUTTONS --}}
    @if (CRUDBooster::myPrivilegeId() == 3)
        @if ($transaction_details->repair_status == 12)
        <button type="submit" id="save" onclick="return changeStatus(14)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        <button type="submit" id="reject" onclick="return changeStatus(13)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>
        <button type="button" id="call_out" onclick="callOut(12)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-phone"></i> CALL OUT ({{ $CallOutCount }})
        </button>
        @elseif ($transaction_details->repair_status == 47)
        <button type="button" id="call_out" onclick="callOut(47)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-phone"></i> CALL OUT ({{ $CallOutCount }})
        </button>
        @endif
     
  {{-- SPARE CUSTODIAN BUTTONS --}}
    @elseif (CRUDBooster::myPrivilegeId() == 9)
        @if ($transaction_details->repair_status == 15)
        <button type="submit" id="save" onclick="return validateBeforeChangeStatus(16)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @elseif ($transaction_details->repair_status == 16)
        <button type="submit" id="save" onclick="return validateBeforeChangeStatus(17)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @elseif ($transaction_details->repair_status == 18)
        <button type="submit" id="save" onclick="return changeStatus(17)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @elseif ($transaction_details->repair_status == 47)
        <button type="submit" id="save" onclick="return changeStatus(18)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @endif
    {{-- LEAD TECH AND TECHNICIAN --}}
    @else
        @if ($transaction_details->repair_status == 10)
        <button type="submit" id="save" onclick="return validateBeforeChangeStatus(12)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @elseif ($transaction_details->repair_status == 14)
        <button type="submit" id="save" onclick="return changeStatus(15)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @elseif ($transaction_details->repair_status == 17)
        <button type="submit" id="save" onclick="return changeStatus(47)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @elseif ($transaction_details->repair_status == 18)
        <button type="submit" id="save" onclick="return changeStatus(19)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        @endif
    @endif
    
</div>

<div id="mailin-out-warranty" style="display: {{ $transaction_details->warranty_status === 'OUT OF WARRANTY' ? 'block' : 'none' }};">

    {{-- FRONTLINER BUTTONS --}}
    @if (CRUDBooster::myPrivilegeId() == 3)
        @if ($transaction_details->repair_status == 21)
        <button type="submit" id="save" onclick="return validateBeforeChangeStatus(23)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
        <button type="submit" id="reject" onclick="return changeStatus(22)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>
        <button type="button" id="call_out" onclick="callOut(21)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-phone"></i> CALL OUT ({{ $CallOutCount }})
        </button>
        @elseif ($transaction_details->repair_status == 26)
        <button type="button" id="call_out" onclick="callOut(26)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-phone"></i> CALL OUT ({{ $CallOutCount }})
        </button>
        @endif
     
    {{-- SPARE CUSTODIAN BUTTONS --}}
    @elseif (CRUDBooster::myPrivilegeId() == 9)
    @if ($transaction_details->repair_status == 26)
        <button type="submit" id="save" onclick="return changeStatus(27)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
    @elseif ($transaction_details->repair_status == 24)
        <button type="submit" id="save" onclick="return validateBeforeChangeStatus(25)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
    @elseif ($transaction_details->repair_status == 25)
        <button type="submit" id="save" onclick="return validateBeforeChangeStatus(26)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
        </button>
    @endif
 
    {{-- LEAD TECH AND TECHNICIAN --}}
    @else
        @if ($transaction_details->repair_status == 10)
            <button type="submit" id="save" onclick="return validateBeforeChangeStatus(21)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
            </button>
        @elseif ($transaction_details->repair_status == 17)
            <button type="submit" id="save" onclick="return changeStatus(21)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
            </button>
        @elseif($transaction_details->repair_status == 23)
            @if (is_null($transaction_details->airwaybill_upload))
                <button type="submit" id="save" onclick="return changeStatus(24)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
                </button>
            @else
                <button type="submit" id="save" onclick="return changeStatus(26)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
                </button>
            @endif
        @elseif ($transaction_details->repair_status == 27)
            <button type="submit" id="save" onclick="return changeStatus(28)" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Proceed
            </button>
            @endif
    @endif
    
</div>
