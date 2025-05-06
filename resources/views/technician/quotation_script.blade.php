<script type="text/javascript">

    // preventing form submit for add fee button
    $(document).on('click', '#add_fee', function(e){
        e.preventDefault();
    });

    // preventing form submit for remove fee button
    $(document).on('click', '#reset_fee', function(e){
        e.preventDefault();
    });

    // preventing form submit for add quotation button
    $(document).on('click', '#addQuotes', function(e){
        e.preventDefault();
    });

    // auto format of cost
    function AutoFormatCost(cost_id)
    {
        // console.log(cost_id);
        if(cost_id == 'cost'){
            var cost = document.getElementById("cost").value;
            var formatter = parseFloat(cost).toFixed(2);
            $("#cost").val(formatter);
        }else{
            var cost = document.getElementById('price_'+cost_id).value;
            var formatter = parseFloat(cost).toFixed(2);
            $('#price_'+cost_id).val(formatter);
        }
    }

    // auto format of software fee
    function AutoFormatPrice()
    {
        var software_cost = document.getElementById("software_cost").value;
        var formatter = parseFloat(software_cost).toFixed(2);
        $("#software_cost").val(formatter);
    }

    // adding original cost of software fee
    function AddFee()
    {
        var diagnostic_payment_fee = document.getElementById("diagnostic_payment_fee").value;
        $("#add_fee").attr("disabled", "disable");
        $("#software_cost").val(diagnostic_payment_fee);
    }

    // reset value of software fee
    function ResetFee()
    {
        $("#add_fee").attr("disabled", false);
        var diagnostic_payment_fee = document.getElementById("diagnostic_payment_fee").value;
        $("#software_cost").val('0.00');
    }

    // adding rows in quotation table
    function AddQuotation()
    {
        let transaction_status = $('#transaction_status').val();
        document.getElementById("addQuotes").disabled = true;
        setTimeout(function() {
            document.getElementById("addQuotes").disabled = false;
        }, 1000);

        let doa_jo = $('#doa-toggle').val();

        document.getElementById("gsx_ref").disabled = false;
        document.getElementById("cs_code").disabled = false;
        document.getElementById("service_code").disabled = false;
        document.getElementById("item_desc").disabled = false;
        document.getElementById("qty").disabled = false;
        document.getElementById("cost").disabled = false;

        var header_id = document.getElementById("header_id").value;
        var gsx_ref = document.getElementById("gsx_ref").value;
        var cs_code = document.getElementById("cs_code").value;
        var service_code = document.getElementById("service_code").value;
        var serial_no = document.getElementById("serial_no").value;
        var item_desc = document.getElementById("item_desc").value;
        var qty = document.getElementById("qty").value;
        var item_parts_id = document.getElementById("item_parts_id").value;
        var cost = document.getElementById("cost").value;
        let stop = false;

        var getscValue = $('.getscValue').map((_,el) => el.value).get()
        $("#scArray").val(getscValue);

        let all_item_parts_type = $('.item_spare_additional_type').map(function () {
            return $(this).val().trim().toLowerCase();
        }).get();

        const has_additional_doa = all_item_parts_type.includes("additional-standard-doa-yes");

        if(!has_additional_doa){
            if(checkIfDuplicateExists(getscValue)){
                swal('Error!','The Spare Part you entered is already in the list.','error');
                return false;
            }
        }

        if(isEmptyOrSpaces(gsx_ref) == false || isEmptyOrSpaces(cs_code) == false || isEmptyOrSpaces(service_code) == false || isEmptyOrSpaces(serial_no) == false || isEmptyOrSpaces(item_desc) == false || isEmptyOrSpaces(qty) == false || isEmptyOrSpaces(item_parts_id) || isEmptyOrSpaces(cost) == false)
        {
            if(isEmptyOrSpaces(service_code) == false){
                $.ajax({
                    "async" : false,
                    url: "{{ route('check-gsx') }}",
                    type: "POST",
                    data: {
                        'gsx': service_code,
                        _token: '{!! csrf_token() !!}'
                        },
                }).success(function(result){
                    if(result.length == 0){
                        $("#service_code").css( "border", "2px solid red" );
                        stop = true;
                    }else{
                        $("#service_code").css( "border", "1px solid slategray" );
                    }
                });
            }else{
                $("#service_code").css( "border", "1px solid slategray" );
            }
            if(isEmptyOrSpaces(service_code) == true)
            {
                swal('Info!','Spare Part is required.');
            }else if(stop)
            {
                swal('Info!','Your Spare Part is not existing.');
            }else if(isEmptyOrSpaces(item_desc) == true)
            {
                swal('Info!','Item Description is required.');
            }else if(isEmptyOrSpaces(qty) == true)
            {
                swal('Info!','Qty is required.');
            }else if(isEmptyOrSpaces(item_parts_id) == true)
            {
                swal('Info!','Missing item_parts_id.');
            }else if(isEmptyOrSpaces(cost) == true){
                swal('Info!','Price is required.');
            }else{
                $.ajax
                ({ 
                    url: "{{ route('add-quotation') }}",
                    type: "POST",
                    data: {
                        'id' : header_id, 
                        'gsx_ref' : gsx_ref, 
                        'cs_code' : cs_code, 
                        'service_code' : service_code, 
                        'serial_no' : serial_no, 
                        'item_desc' : item_desc, 
                        'qty' : qty,
                        'item_parts_id' : item_parts_id,
                        'cost' : cost, 
                        'transaction_status' : transaction_status,
                        'doa_jo' : doa_jo,
                        _token: '{!! csrf_token() !!}'
                    },
                    success: function(result)
                    {
                        let transaction_status = $('#transaction_status').val();
                        var showData = '';
                        let bgColor = '';

                        if (result.quotation.item_spare_additional_type === 'Additional-Standard-DOA') {
                            bgColor = '#443627';
                            
                        } else if (
                            result.quotation.item_spare_additional_type !== 'Additional-Standard' &&
                            result.quotation.item_spare_additional_type !== 'Additional-Standard-DOA' &&
                            [34, 42].includes(Number(transaction_status))
                        ) {
                            bgColor = '#FFC785';
                        }

                        showData += '<tr class="nr row_num" id="rowID'+ result.quotation.id +'" style="background:' + bgColor + ';"><input type="hidden" class="getidValue" name="header_id" value="'+ result.quotation.id +'">';
                        showData += '<input type="hidden" name="header_id" value="">'; 
                        showData += '<td style="padding: 3px !important;"><input class="input-cus text-center getscValue" type="text" id="service_code_'+ result.quotation.id +'" value="'+ result.quotation.service_code +'" placeholder="Enter Service Code" readonly style="background: lightgrey" /></td>';
                        showData += '<td style="padding: 3px !important;"><input class="input-cus text-center getgsxValue" type="text" id="gsx_code_'+ result.quotation.id +'" oninput="gsx_data('+ result.quotation.id +')" value="'+ result.quotation.gsx_ref +'" placeholder="Enter GSX Reference"/></td>';
                        showData += '<td style="padding: 3px !important;"><input class="input-cus text-center getcsValue" type="text" id="cs_code_'+ result.quotation.id +'" value="'+ result.quotation.cs_code +'" placeholder="Enter CS Code"/></td>';
                        showData += '<td style="padding: 3px !important;"><input class="input-cus text-center getserialValue" type="text" value="'+ result.quotation.serial_no +'" placeholder="Enter Apple Parts Number"/></td>';
                        showData += '<td style="padding: 3px !important;"><input class="input-cus text-center getitemValue" type="text" id="item_desc_'+ result.quotation.id +'" value="'+ result.quotation.item_description +'" placeholder="Enter Item Description" readonly style="background: lightgrey" /></td>';
                        showData += '<td style="padding: 3px !important;"><input class="input-cus text-center getqtyValue" type="text" id="qty'+ result.quotation.id +'" value="'+ result.quotation.qty_status +'" placeholder="Search Item" readonly style="background: lightgrey; color: '+ (result.quotation.qty_status == "Available" ? "#16a34a" : "#ef4444") +'" /></td>';
                        showData += '<td style="padding: 3px !important; display:none"><input class="input-cus text-center getitemparstidValue" type="hidden" id="item_parts_id'+ result.quotation.id +'" value="'+ result.quotation.item_parts_id +'" placeholder="Search Item" readonly style="background: lightgrey;" /></td>';
                        showData += '<td style="padding: 3px !important;"><input class="input-cus text-center getcostValue" type="number" onblur="AutoFormatCost('+ result.quotation.id +')" id="price_'+ result.quotation.id +'" value="'+ result.quotation.cost +'" min="0" max="9999" step="any" placeholder="Enter Price"></td>';
                        showData += '<td style="padding: 5px !important;" class="text-center"><a onclick="RemoveRow('+ result.quotation.id +')"><i class="fa fa-close fa-2x remove" style="color:red"></i></a></td>';
                        showData += '</tr>';

                        $("#gsx_ref").val('');        
                        $("#cs_code").val('');  
                        $("#service_code").val('');
                        $("#serial_no").val('');
                        $("#item_desc").val('');
                        $("#qty").val('');
                        $("#item_parts_id").val('');
                        $("#cost").val('');
                        $('table .nr:last').before(showData); 

                        // display buttons logic 
                        let caseStatus = $('#case_status').val();
                        let warrantyStatus = $('#warranty_status').val();

                        let all_item_qty = $('.getqtyValue').map(function () {
                            return $(this).val().trim().toLowerCase();
                        }).get();

                        const allUnavailable = all_item_qty.includes("unavailable");
                        const filteredQty = all_item_qty.filter(qty => qty !== "");
                        const allAvailable = filteredQty.length > 0 && filteredQty.every(qty => qty === "available");

                        if (allUnavailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
                            $('#inwarranty_carryin_btns').show();
                            $('.iw_cin_unavailable_btn').show();
                            $('.iw_cin_available_btn').hide();
                        } else if (allAvailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
                            $('#inwarranty_carryin_btns').show();
                            $('.iw_cin_available_btn').show();
                            $('.iw_cin_unavailable_btn').hide();
                        // } else if (allUnavailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
                        //     $('#outofwarranty_carryin_btns').show();
                        //     $('.oow_cin_unavailable_btn').show();
                        //     $('.oow_cin_available_btn').hide();
                        // } else if (allAvailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
                        //     $('#outofwarranty_carryin_btns').show();
                        //     $('.oow_cin_available_btn').show();
                        //     $('.oow_cin_unavailable_btn').hide();
                        } else {
                            $('#inwarranty_carryin_btns').hide();
                            $('.iw_cin_unavailable_btn').hide();
                            $('.iw_cin_available_btn').hide();

                            // $('#outofwarranty_carryin_btns').hide();
                            // $('.oow_cin_available_btn').hide();
                            // $('.oow_cin_unavailable_btn').hide();
                        }
                        // end of buttons display logic

                        $('#additional-toggle').attr('disabled', true);
                        $('#doa-toggle').attr('disabled', true);

                    }
                });
            }
        }else{ swal('Info!','Enter at least 1 on these fields.'); }      
    }

    // remove row in quotation table
    function RemoveRow(row_id)
    {
        $.ajax
        ({ 
            url: "{{ route('delete-quotation') }}",
            type: "POST",
            data: {
                'id' : row_id,
                _token: '{!! csrf_token() !!}'
                },
            success: function(result)
            {
                $('#rowID'+row_id).remove();
                
                // display buttons logic 
                let caseStatus = $('#case_status').val();
                let warrantyStatus = $('#warranty_status').val();

                let all_item_qty = $('.getqtyValue').map(function () {
                    return $(this).val().trim().toLowerCase();
                }).get();

                const allUnavailable = all_item_qty.includes("unavailable");
                const filteredQty = all_item_qty.filter(qty => qty !== "");
                const allAvailable = filteredQty.length > 0 && filteredQty.every(qty => qty === "available");

                if (allUnavailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
                    $('#inwarranty_carryin_btns').show();
                    $('.iw_cin_unavailable_btn').show();
                    $('.iw_cin_available_btn').hide();
                } else if (allAvailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
                    $('#inwarranty_carryin_btns').show();
                    $('.iw_cin_available_btn').show();
                    $('.iw_cin_unavailable_btn').hide();
                // } else if (allUnavailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
                //     $('#outofwarranty_carryin_btns').show();
                //     $('.oow_cin_unavailable_btn').show();
                //     $('.oow_cin_available_btn').hide();
                // } else if (allAvailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
                //     $('#outofwarranty_carryin_btns').show();
                //     $('.oow_cin_available_btn').show();
                //     $('.oow_cin_unavailable_btn').hide();
                } else {
                    $('#inwarranty_carryin_btns').hide();
                    $('.iw_cin_unavailable_btn').hide();
                    $('.iw_cin_available_btn').hide();

                    // $('#outofwarranty_carryin_btns').hide();
                    // $('.oow_cin_available_btn').hide();
                    // $('.oow_cin_unavailable_btn').hide();
                }
                // end of buttons display logic

                
                $('#additional-toggle').attr('disabled', false);
                $('#doa-toggle').attr('disabled', false);

            }
        });
    }

    // set value for item description and price by oninput of gsx code
    function gsx_data(row_id){
        if(row_id == 'service_code'){
            var service_code = document.getElementById(row_id).value;
            $.ajax
            ({ 
                url: "{{ route('check-gsx') }}",
                type: "POST",
                data: {
                    'gsx': service_code,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                { 
                    if(result.length > 0){
                        $("#item_desc").val(result[0].item_description);
                        $("#qty").val(result[0].qty).css('color', (result[0].qty > 0 ? '#16a34a' : '#ef4444'));
                        $("#item_parts_id").val(result[0].id);
                        $("#cost").val(result[0].cost);
                        
                        let transaction_status = $('#transaction_status').val();
                        if([34, 43].includes(Number(transaction_status))){
                            $("#new_spare_req").val('Additional-Required-Pending');
                        }

                        // display buttons logic 
                        let caseStatus = $('#case_status').val();
                        let warrantyStatus = $('#warranty_status').val();

                        let all_item_qty = $('.getqtyValue').map(function () {
                            return $(this).val().trim().toLowerCase();
                        }).get();

                        const allUnavailable = all_item_qty.includes("unavailable");
                        const filteredQty = all_item_qty.filter(qty => qty !== "");
                        const allAvailable = filteredQty.length > 0 && filteredQty.every(qty => qty === "available");

                        if (allUnavailable || result[0].qty < 1 && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
                            $('#inwarranty_carryin_btns').show();
                            $('.iw_cin_unavailable_btn').show();
                            $('.iw_cin_available_btn').hide();
                        } else if (allAvailable || result[0].qty > 0 && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
                            $('#inwarranty_carryin_btns').show();
                            $('.iw_cin_available_btn').show();
                            $('.iw_cin_unavailable_btn').hide();
                        // } else if (allUnavailable || result[0].qty < 1 && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
                        //     $('#outofwarranty_carryin_btns').show();
                        //     $('.oow_cin_unavailable_btn').show();
                        //     $('.oow_cin_available_btn').hide();
                        // } else if (allAvailable || result[0].qty > 0 && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
                        //     $('#outofwarranty_carryin_btns').show();
                        //     $('.oow_cin_available_btn').show();
                        //     $('.oow_cin_unavailable_btn').hide();
                        } else {
                            $('#inwarranty_carryin_btns').hide();
                            $('.iw_cin_unavailable_btn').hide();
                            $('.iw_cin_available_btn').hide();

                            // $('#outofwarranty_carryin_btns').hide();
                            // $('.oow_cin_available_btn').hide();
                            // $('.oow_cin_unavailable_btn').hide();
                        }
                        // end of buttons display logic

                        document.getElementById("service_code").disabled = true;
                        document.getElementById("item_desc").disabled = true;
                        document.getElementById("qty").disabled = true;
                        document.getElementById("item_parts_id").disabled = true;
                    }
                }
            });
        }else{
            var service_code = document.getElementById("service_code_"+row_id).value;
            $.ajax
            ({ 
                url: "{{ route('check-gsx') }}",
                type: "POST",
                data: {
                    'gsx': service_code,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                { 
                    if(result.length > 0){
                        $("#item_desc_"+row_id).val(result[0].item_description);
                        $("#qty_"+row_id).val(result[0].qty).css('color', 'green');
                        $("#item_parts_id").val(result[0].id);
                        $("#price_"+row_id).val(result[0].cost);

                        let transaction_status = $('#transaction_status').val();
                        if(transaction_status == 34){
                            $("#new_spare_req").val('Additional-Required-Pending');
                        }

                        document.getElementById("service_code_"+row_id).disabled = true;
                        document.getElementById("item_desc_"+row_id).disabled = true;
                        document.getElementById("qty"+row_id).disabled = true;
                        document.getElementById("item_parts_id"+row_id).disabled = true;
                    }
                }
            });
        }
    }

    $(document).ready(function(){
        $(function(){
            $("#service_code").autocomplete({
                source: function (request, response) {
                   
                    $('.sparepartlist li').remove(); 
                    $('.sparepartlist').html('<li class="li-padding">Loading...</li>'); 

                    if(isEmptyOrSpaces(request.term) == false){
                        $(".sparepartlist").css('display', 'block');
                    }else{
                        $(".sparepartlist").css('display', 'none');
                    }
                   
                    $.ajax
                    ({ 
                        url: "{{ route('search-sparepart') }}",
                        type: "POST",
                        data: {
                            'spare_part': request.term,
                            _token: '{!! csrf_token() !!}'
                            },
                        success: function(result)
                        { 
                            var showdata = [];
                            if (result.length > 0){
                                
                                for (var i = 0; i < result.length; ++i) {
                                    showdata[i] = '<li class="li-padding" value="'+result[i].spare_parts+'">'+result[i].spare_parts+'</li>';
                                }

                            }else{
                                showdata = '<li class="li-padding">No Result Found.</li>';
                            }

                            $(".table-responsive, .sparepartlist").css( "position", "static !important" );
                            if($(window).innerWidth() < 768){
                                $(".table-responsive").css( "overflow", "visible" ); 
                            }
                            
                            $('.sparepartlist li').remove(); 
                            $(".sparepartlist").html(showdata);
                        }
                    });      
                }
            });
        });
    });

    $(function(){
        $(document).on("click", "ul.sparepartlist li", function(e) 
        { 
            var spare_part_val = $(this).attr("value"); 
            $("#service_code").val(spare_part_val);
            $(".sparepartlist").css('display', 'none');
            $('.sparepartlist li').remove(); 
            $('.sparepartlist').html('<li class="li-padding">Loading...</li>'); 
            return gsx_data('service_code');
        });
    });

    $(document).mouseup(function(event) 
    {
        var list = $(".sparepartlist");
        if (!list.is(event.target) && list.has(event.target).length === 0) { list.hide(); }
    });
    
    // preventing form submit for add fee button
    $(document).on('click', '#add_diagnostic_fee', function(e){
        var diagnostic_original_cost = document.getElementById("diagnostic_original_cost").value;
        $("#add_diagnostic_fee").attr("disabled", "disable");
        $("#diagnostic_cost").val(diagnostic_original_cost);
        e.preventDefault();
    });

    // preventing form submit for remove fee button
    $(document).on('click', '#reset_diagnostic_fee', function(e){
        // var diagnostic_cost = document.getElementById("diagnostic_cost").value;
        $("#add_diagnostic_fee").attr("disabled", false);
        $("#diagnostic_cost").val('0.00');
        e.preventDefault();
    });
    
    // auto format of software fee
    function AutoFormatDiagnosticPrice()
    {
        var diagnostic_cost = document.getElementById("diagnostic_cost").value;
        var formatter = parseFloat(diagnostic_cost).toFixed(2);
        $("#diagnostic_cost").val(formatter);
        
    }

    $(document).ready(function () {
        let transaction_status = $('#transaction_status').val();
        let caseStatus = $('#case_status').val();
        let warrantyStatus = $('#warranty_status').val();

        let all_item_qty = $('.getqtyValue').map(function () {
            return $(this).val().trim().toLowerCase();
        }).get();

        const allUnavailable = all_item_qty.includes("unavailable");
        const filteredQty = all_item_qty.filter(qty => qty !== "");
        const allAvailable = filteredQty.length > 0 && filteredQty.every(qty => qty === "available");

        if (allUnavailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
            $('#inwarranty_carryin_btns').show();
            $('.iw_cin_unavailable_btn').show();
            $('.iw_cin_available_btn').hide();
        } else if (allAvailable && caseStatus === 'CARRY-IN' && warrantyStatus === 'IN WARRANTY') {
            $('#inwarranty_carryin_btns').show();
            $('.iw_cin_available_btn').show();
            $('.iw_cin_unavailable_btn').hide();
        } else if (allUnavailable && transaction_status == 48 && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
            $('#outofwarranty_carryin_btns').show();
            $('.oow_cin_unavailable_btn').show();
            $('.oow_cin_available_btn').hide();
        } else if (allAvailable && transaction_status == 48 && caseStatus === 'CARRY-IN' && warrantyStatus === 'OUT OF WARRANTY') {
            $('#outofwarranty_carryin_btns').show();
            $('.oow_cin_available_btn').show();
            $('.oow_cin_unavailable_btn').hide();
        } else {
            $('#inwarranty_carryin_btns').hide();
            $('.iw_cin_unavailable_btn').hide();
            $('.iw_cin_available_btn').hide();

            $('#outofwarranty_carryin_btns').hide();
            $('.oow_cin_available_btn').hide();
            $('.oow_cin_unavailable_btn').hide();
        }
    });

    $(document).ready(function() {
        let all_item_qty = $('.getqtyValue').map(function () {
            return $(this).val().trim().toLowerCase();
        }).get();

        const allUnavailable = all_item_qty.includes("unavailable");
        if(allUnavailable){
            $('.for_spare_part_release_unav').hide();
            $('.for_spare_part_release_unav_oow').hide();
            $('.proceed_yes_av').hide();
            $('.proceed_yes_unav').show();
        } else {
            $('.for_spare_part_release_unav').show();
            $('.for_spare_part_release_unav_oow').show();
            $('.proceed_yes_unav').hide();
            $('.proceed_yes_av').show();
        }
    });

    function erase_wrong_filter(){
        $('.getscValue2').val('').attr('disabled', false);
        $('.getgsxValue2').val('');
        $('.getcsValue2').val('');
        $('.getserialValue2').val('');
        $('.getitemValue2').val('').attr('disabled', false);
        $('.getqtyValue2').val('');
        $('.getitemparstidValue2').val('');
        $('.getcostValue2').val('');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const additionalToggle = document.getElementById('additional-toggle');
        const doaToggle = document.getElementById('doa-toggle');
    
        function updateStatus() {
            if (additionalToggle.checked) {
                $('#add_parts_btn').show();
                $('#spare_parts_filter').show();
                $('.iw_cin_additional_spare_part').show();
                $('.oow_cin_additional_spare_part').show();
                $('.iw_cin_no_additional_spare_part').hide();
                $('.oow_cin_no_additional_spare_part').hide();
                $('#doa-toggle').attr('disabled', 'disabled');
            } else if (doaToggle.checked) {
                $('.hidden_doa_jo').val('yes');
                $('#doa_item_filters').show();
                $('#add_doa_item_part').show();
                $('.iw_cin_no_additional_spare_part').hide();
                $('.oow_cin_additional_spare_part').hide();
                $('.oow_cin_no_additional_spare_part').hide();
                $('#additional-toggle').attr('disabled', 'disabled');
            } else {
                $('.hidden_doa_jo').val('no');
                $('#doa_item_filters').hide();
                $('#add_parts_btn').hide();
                $('#add_doa_item_part').hide();
                $('#spare_parts_filter').hide();
                $('.iw_cin_additional_spare_part').hide();
                $('.oow_cin_no_additional_spare_part').show();
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

    function receive_parts(item_parts_id) {
        Swal.fire({
            title: 'Confirm Receive',
            text: 'Are you sure you want to receive this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, receive it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let spare_parts_id = item_parts_id;
                let header_id = $('#header_id').val();

                $.ajax({
                    url: "{{ route('receive_spare_part') }}",
                    type: "POST",
                    data: {
                        'spare_parts_id': spare_parts_id,
                        'header_id': header_id,
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
                        if (response.success == true) {

                            $(document).ready(function() {
                                let all_item_qty = $('.getqtyValue').map(function () {
                                    return $(this).val().trim().toLowerCase();
                                }).get();

                                const allAvailable = all_item_qty.includes("available");
                            });

                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                html: `This is also marked as reserved Qty, since this item is ordered for this Job Order. <br>`,
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
                        });
                    }
                });
            }
        });
    }

    function filter_doa_item(){
        let spare_parts_code = $('#spare_parts_code').val();
        
        if(spare_parts_code !== 'default'){
            $.ajax({
                url: "{{ route('filter_doa_spare_part') }}",
                type: "POST",
                data: {
                    'spare_parts_id' : spare_parts_code,
                    _token: '{!! csrf_token() !!}',
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    Swal.fire({
                        icon: "info",
                        title: "Filtering Item Parts",
                        text: "Please wait...",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (response) {
                    if(response.success == true){
                        Swal.close();
                        $('#spare_part_code').val(response.response_data.spare_parts);
                        $('#doa_item_desc').val(response.response_data.item_description);
                        $('#doa_item_qty').val(response.response_data.qty);
                        $('#doa_item_id').val(response.response_data.id);
                        $('#erase_wrong_filter_doa').show();

                    } else if (response.success == false) {
                        Swal.fire({
                            icon: "error",
                            title: response.message,
                            allowOutsideClick: false,
                            showConfirmButton: true,
                        });
                        $('#erase_wrong_filter_doa').hide();
                    }
                },
                error: function (xhr, error) {
                    $('#erase_wrong_filter_doa').hide();
                    Swal.close();
                    Swal.fire({
                        title: "Can't filter this item, try again!",
                        html: "Something went wrong!",
                        icon: "error",
                        timer: 3000,
                        didOpen: () => Swal.showLoading()
                    });setTimeout(() => {
                    },3000)
                }
            });
        } else {
            $('#spare_part_code').val('');
            $('#doa_item_desc').val('');
            $('#doa_item_qty').val('');
            $('#doa_item_id').val('');
            $('#erase_wrong_filter_doa').hide();
        }
    }

    $('#add_doa_parts').on('click', function () {
        if (
            isEmptyValidator('#spare_parts_code', 'Spare Part Code') ||
            isEmptyValidator('#doa_item_desc', 'Item Description') ||
            isEmptyValidator('#doa_item_qty', 'Quantity') ||
            isEmptyValidator('#doa_item_price', 'Price')
        ) {
            return;
        }

        let header_id = $('#header_id').val();
        let spare_part_code = $('#spare_part_code').val();
        let doa_item_desc = $('#doa_item_desc').val();
        let doa_item_qty = $('#doa_item_qty').val();
        let doa_item_id = $('#doa_item_id').val();
        let doa_item_price = $('#doa_item_price').val();

        $.ajax({
            url: "{{ route('save_add_doa_parts') }}",
            type: "POST",
            data: {
                'header_id' : header_id,
                'spare_part_code' : spare_part_code,
                'doa_item_desc' : doa_item_desc,
                'doa_item_qty' : doa_item_qty,
                'doa_item_id' : doa_item_id,
                'doa_item_price' : doa_item_price,
                _token: '{!! csrf_token() !!}',
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                Swal.fire({
                    icon: "info",
                    title: "Saving DOA Item Parts",
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
                        text: "Please wait...",
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        timer: 1000,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        sessionStorage.setItem("scrollToBottomAfterReload", "true");
                        window.location.reload();
                });

                } else if (response.success == false) {
                    Swal.fire({
                        icon: "error",
                        title: response.message,
                        allowOutsideClick: false,
                        showConfirmButton: true,
                    });
                    $('#erase_wrong_filter_doa').hide();
                }
            },
            error: function (xhr, error) {
                $('#erase_wrong_filter_doa').hide();
                Swal.close();
                Swal.fire({
                    title: "Can't save this item, try again!",
                    html: "Something went wrong!",
                    icon: "error",
                    timer: 3000,
                    didOpen: () => Swal.showLoading()
                });setTimeout(() => {
                },3000)
            }
        });
    });

    function isEmptyValidator(selector, fieldName) {
        const value = $(selector).val().trim();

        if (value === '' || value === 'default') {
            Swal.fire({
                icon: 'warning',
                title: `${fieldName} is required.`,
                text: `Please fill out all the required fields for DOA.`,
                confirmButtonText: 'Okay, Got it',
            });
            $(selector).focus(); 
            $(selector).css('border', '1px solid red');
            return true;
        } else {
            $(selector).css('border', '');
            return false;
        }
    }
</script>

<script>
    // FOR AUTO scrollTo BOTTOM
    document.addEventListener("DOMContentLoaded", function () {
        if (sessionStorage.getItem("scrollToBottomAfterReload") === "true") {
            window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });
            sessionStorage.removeItem("scrollToBottomAfterReload");
        }
    });

    // AUTO FORMAL DOA COST PRICE 
    $('#doa_item_price').on('blur', function () {
        let value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2));
        }
    });

    // for DOA filter eraser 
    function erase_wrong_filter_doa(){
        $('#spare_parts_code').val('default').trigger('change');
    }

    $(document).ready(function(){
        let transaction_status = $('#transaction_status').val();
        let all_item_parts_type = $('.item_spare_additional_type').map(function () {
            return $(this).val().trim().toLowerCase();
        }).get();

        let item_qty_status = $('.getqtyValue').map(function () {
            return $(this).val().trim().toLowerCase();
        }).get();
        
        const is_unavailable = item_qty_status.includes("unavailable");
        const is_available = item_qty_status.includes("available");
        const has_doa_jo = all_item_parts_type.includes("additional-standard-doa");

        if(has_doa_jo && is_unavailable && [34, 42].includes(Number(transaction_status))){
            $('.iw_cin_doa_unav').show();
            $('.oow_cin_doa_unav').show();
        } else if (has_doa_jo && is_available && [34, 42].includes(Number(transaction_status))){
            $('.iw_cin_doa_av').show();
            $('.oow_cin_doa_av').show();
        } else {
            $('.iw_cin_doa_unav').hide();
            $('.iw_cin_doa_av').hide();

            $('.oow_cin_doa_unav').hide();
            $('.oow_cin_doa_av').hide();

        }
    });
</script>