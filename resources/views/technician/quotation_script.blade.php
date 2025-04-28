
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

        if(checkIfDuplicateExists(getscValue)){
            swal('Error!','The Spare Part you entered is already in the list.','error');
            return false;
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
                        _token: '{!! csrf_token() !!}'
                    },
                    success: function(result)
                    {
                        var showData = '';
                        showData += '<tr class="nr row_num" id="rowID'+ result.quotation.id +'" style="background: ' + (result.item_spare_additional_type != 'Additional-Standard' ? '#FFC785' : '') + ';"><input type="hidden" class="getidValue" name="header_id" value="'+ result.quotation.id +'">';
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
                        let caseStatus = $('[name="case_status"]').val()?.trim();
                        let warrantyStatus = $('[name="warranty_status"]').val()?.trim();

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
                            $('.iw_cin_unavailable_btn').hide();
                            $('.iw_cin_available_btn').show();
                            $('#inwarranty_carryin_btns').show();
                        } else {
                            $('.iw_cin_unavailable_btn').hide();
                            $('.iw_cin_available_btn').hide();
                            $('#inwarranty_carryin_btns').hide();
                        }
                        // end of buttons display logic

                        $('#additional-toggle').attr('disabled', true);

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
                let caseStatus = $('[name="case_status"]').val()?.trim();
                let warrantyStatus = $('[name="warranty_status"]').val()?.trim();

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
                    $('.iw_cin_unavailable_btn').hide();
                    $('.iw_cin_available_btn').show();
                    $('#inwarranty_carryin_btns').show();
                } else {
                    $('.iw_cin_unavailable_btn').hide();
                    $('.iw_cin_available_btn').hide();
                    $('#inwarranty_carryin_btns').hide();
                }
                // end of buttons display logic

                
                $('#additional-toggle').attr('disabled', false);

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
                        if(transaction_status == 34){
                            $("#new_spare_req").val('Additional-Required-Pending');
                        }

                        // display buttons logic 
                        let caseStatus = $('[name="case_status"]').val()?.trim();
                        let warrantyStatus = $('[name="warranty_status"]').val()?.trim();

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
                            $('.iw_cin_unavailable_btn').hide();
                            $('.iw_cin_available_btn').show();
                            $('#inwarranty_carryin_btns').show();
                        } else {
                            $('.iw_cin_unavailable_btn').hide();
                            $('.iw_cin_available_btn').hide();
                            $('#inwarranty_carryin_btns').hide();
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
        let caseStatus = $('[name="case_status"]').val()?.trim();
        let warrantyStatus = $('[name="warranty_status"]').val()?.trim();

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
            $('.iw_cin_unavailable_btn').hide();
            $('.iw_cin_available_btn').show();
            $('#inwarranty_carryin_btns').show();
        } else {
            $('.iw_cin_unavailable_btn').hide();
            $('.iw_cin_available_btn').hide();
            $('#inwarranty_carryin_btns').hide();
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