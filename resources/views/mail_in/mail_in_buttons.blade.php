<div id="mailin-in-warranty" style="display: {{ $transaction_details->warranty_status === 'IN WARRANTY' ? 'block' : 'none' }};">
    <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> IN WARRANTY MAIL IN
    </button>
</div>

<div id="mailin-out-warranty" style="display: {{ $transaction_details->warranty_status === 'OUT OF WARRANTY' ? 'block' : 'none' }};">
    <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> OUT OF WARRANTY MAIL IN
    </button>
</div>
