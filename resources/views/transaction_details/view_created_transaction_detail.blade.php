@extends('crudbooster::admin_template')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@include('include.css')
<style>
    .content{
       padding: 0;
    }
   
    .content-header{
       display: none;
    }
    
    .cust-ch{
        margin-top: 50px;
    }
    
    @media (max-width: 767px) {
        .cust-ch {
            margin-top: 100px;
        }
    }
</style>
@endpush

@section('content')
    <div class="panel panel-default" style="margin: 0; padding:0">
        <div class="panel-body">
            <div class="row cust-ch" style="margin-bottom: 0%">
                <div class="col-md-12" style="margin-bottom: 0%">
                    <div class="form-group" style="margin-bottom: 0rem">
                        <div class="transaction-card" style="border-bottom-left-radius: 0%; border-bottom-right-radius: 0%;">
                            <header class="page-header-cust">
                                <div class="header-left">
                                    <div style="background: rgba(255, 255, 255, 0.3); padding: 5px; border-radius: 20%">
                                        <img src="https://cdn-icons-png.flaticon.com/128/7711/7711811.png" width="40" alt="">
                                    </div>
                                    <h1>
                                        Transaction Details
                                    </h1>
                                </div>
                                <div class="reference-badge-cust">
                                    Reference:
                                    <strong style="margin-left: 4px;">{{$transaction_details->reference_no}}</strong>
                                    <span class="copy-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </span>
                                </div>
                            </header>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 0%">
                            @include('include.comment-box')
                        </div>
                    </div>
                </div>
            </div>
            @if(request()->segment(3) == "edit")
                <form method="post" action="" id="SubmitTransactionForm">                
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            @endif
            @include('transaction_details.customer_details')
            @include('transaction_details.service_details')
            @include('transaction_details.uploade_invoice')

                {{-- Technical Report --}}
            @if($transaction_details->case_status === 'MAIL-IN')
                @include('mail_in.technical_report')
            @elseif($transaction_details->case_status === 'CARRY-IN')
                @include('carry_in.technical_report')
            @else
                @include('transaction_details.technical_report')
            @endif

            {{-- Diagnostic Results (only if privilege != 9) Spare Custodian --}}
            @if (CRUDBooster::myPrivilegeId() != 9)
                @if($transaction_details->case_status === 'MAIL-IN')
                        @include('mail_in.diagnostic_results')
                @elseif($transaction_details->case_status === 'CARRY-IN')
                        @include('carry_in.diagnostic_results')
                @else
                        @include('transaction_details.diagnostic_results')
                @endif
            @endif

            {{-- Quotation --}}
            @if($transaction_details->case_status === 'MAIL-IN')
                @include('mail_in.quotation')
            @elseif($transaction_details->case_status === 'CARRY-IN')
                @include('carry_in.quotation')
            @else
                @include('transaction_details.quotation')
            @endif


            <div class="panel-footer">
              
                    <a href="{{ CRUDBooster::adminPath() }}/{{ CRUDBooster::getModulePath() }}" class="btn btn-default pull-left"><i class="fa fa-chevron-circle-left"></i> BACK</a>
                    <input type="hidden" value="{{$data['transaction_details']->header_id}}" name="header_id" id="header_id">
                   
                    <input type="hidden" name="mainpath" id="mainpath" value="{{CRUDBooster::mainpath()}}">
                    <input type="hidden" id="warranty_status" value="{{$transaction_details->warranty_status}}">
                    <input type="hidden" name="action" id="action" value="">

                    @if($transaction_details->repair_status == 10 && CRUDBooster::getModulePath() == "to_diagnose")
                        <button type="submit" id="save" onclick="return changeStatus('save')" class="btn btn-primary pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
                        <button type="submit" id="reject" onclick="return changeStatus(3)" class="btn btn-danger pull-right buttonSubmit" style="margin-left: 20px;"><i class="fa fa-ban" aria-hidden="true"></i> CANCEL</button>
                    @elseif($transaction_details->repair_status == 3 && CRUDBooster::getModulePath() == "to_close" && CRUDBooster::myPrivilegeId() != 2)
                        <button type="submit" id="void" onclick="return changeStatus(5)" class="btn btn-danger pull-right buttonSubmit"/><i class="fa fa-check-square-o" aria-hidden="true"></i> CANCELLED/CLOSE</button>
                    @endif 
            </div>
            @if(request()->segment(3) == "edit") </form> @endif 
        </div>
    </div>
@endsection

@push('bottom')

        @include('technician.to_diagnose_transaction_script')

    <script>
        $(document).ready(function() {
            $('.copy-icon').on('click', function() {
                var $icon = $(this);
                var reference = $icon.siblings('strong').text().trim();
        
                // Copy to clipboard
                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(reference).select();
                document.execCommand('copy');
                tempInput.remove();
        
                // Swap SVG to check icon
                var originalIcon = $icon.html();
                var checkIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        style="color: limegreen;">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                `;
                $icon.html(checkIcon).show();
    
                setTimeout(function() {
                    $icon.html(originalIcon);
                }, 1000);
            });
        });
    </script>        
@endpush