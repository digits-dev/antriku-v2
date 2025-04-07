
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
        console.log(cost_id);
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
        document.getElementById("addQuotes").disabled = true;
        setTimeout(function() {
            document.getElementById("addQuotes").disabled = false;
        }, 1000);

        document.getElementById("gsx_ref").disabled = false;
        document.getElementById("cs_code").disabled = false;
        document.getElementById("service_code").disabled = false;
        // document.getElementById("digits_code").disabled = false;
        document.getElementById("item_desc").disabled = false;
        document.getElementById("item_qty").disabled = false;
        document.getElementById("item_id").disabled = false;
        document.getElementById("cost").disabled = false;

        var header_id = document.getElementById("header_id").value;
        var gsx_ref = document.getElementById("gsx_ref").value;
        var cs_code = document.getElementById("cs_code").value;
        // var apple_parts = document.getElementById("apple_parts").value;
        var service_code = document.getElementById("service_code").value;
        var serial_no = document.getElementById("serial_no").value;
        // var digits_code = document.getElementById("digits_code").value;
        var item_desc = document.getElementById("item_desc").value;
        var item_qty = document.getElementById("item_qty").value;
        var item_id = document.getElementById("item_id").value;
        var cost = document.getElementById("cost").value;
        let stop = false;

        var getscValue = $('.getscValue').map((_,el) => el.value).get()
        $("#scArray").val(getscValue);

        if(checkIfDuplicateExists(getscValue)){
            swal('Error!','The Spare Part you entered is already in the list.','error');
            return false;
        }

        if(isEmptyOrSpaces(gsx_ref) == false || isEmptyOrSpaces(cs_code) == false || isEmptyOrSpaces(service_code) == false || isEmptyOrSpaces(serial_no) == false || isEmptyOrSpaces(item_desc) == false || isEmptyOrSpaces(item_qty) == false || isEmptyOrSpaces(cost) == false)
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
            }
            else if(isEmptyOrSpaces(item_qty) == true)
            {
                swal('Info!','Qty is required.');
            }
            else if(isEmptyOrSpaces(cost) == true){
                swal('Info!','Price is required.');
            }else{
                $.ajax
                ({ 
                    url: "{{ route('add-quotation') }}",
                    type: "POST",
                    data: {'id' : header_id, 'gsx_ref' : gsx_ref, 'cs_code' : cs_code, 'service_code' : service_code, 'serial_no' : serial_no, 'item_desc' : item_desc, 'item_qty' : item_qty, 'item_id' : item_id, 'cost' : cost, _token: '{!! csrf_token() !!}'},
                    success: function(result)
                    {
                        var showData = '';
                        showData += '<tr class="nr row_num" id="rowID'+ result.quotation.id +'"><input type="hidden" class="getidValue" name="header_id" value="'+ result.quotation.id +'">';
                        showData += '<input type="hidden" name="header_id" value="">'; 
                        showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getitemValue" type="text" id="item_desc_'+ result.quotation.id +'" value="'+ result.quotation.item_description +'" placeholder="Enter Item Description" readonly /></td>';
                        showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getscValue" type="text" id="service_code_'+ result.quotation.id +'" value="'+ result.quotation.service_code +'" placeholder="Enter Service Code" readonly /></td>';
                        showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getgsxValue" type="text" id="gsx_code_'+ result.quotation.id +'" oninput="gsx_data('+ result.quotation.id +')" value="'+ result.quotation.gsx_ref +'" placeholder="Enter GSX Reference"/></td>';
                        showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getcsValue" type="text" id="cs_code_'+ result.quotation.id +'" value="'+ result.quotation.cs_code +'" placeholder="Enter CS Code"/></td>';
                        // showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getapValue" type="text" id="apple_parts_'+ result.quotation.id +'" value="'+ result.quotation.apple_parts +'" placeholder="Enter Apple Parts Number"/></td>';
                        showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getserialValue" type="text" value="'+ result.quotation.serial_no +'" placeholder="Enter Apple Parts Number"/></td>';
                        // showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getdcValue" type="text" id="digits_code_'+ result.quotation.id +'" value="'+ result.quotation.digits_code +'" placeholder="Enter Item Code" readonly /></td>';
                        showData += '<td style="padding: 1px !important; color: limegreen !important;"><input class="input-cus text-center getqtyValue" type="text" id="item_qty_'+ result.quotation.id +'" value="'+ result.quotation.qty +'" placeholder="Qty" readonly /></td>';
                        showData += '<td style="padding: 1px !important; color: limegreen !important; display:none"><input class="input-cus text-center getidValue" type="text" id="item_id_'+ result.quotation.item_id +'" value="'+ item_id +'" readonly /></td>';
                        showData += '<td style="padding: 1px !important;"><input class="input-cus text-center getcostValue" type="number" onblur="AutoFormatCost('+ result.quotation.id +')" id="price_'+ result.quotation.id +'" value="'+ result.quotation.cost +'" min="0" max="9999" step="any" placeholder="Enter Price"></td>';
                        showData += '<td style="padding: 5px !important;" class="text-center"><a onclick="RemoveRow('+ result.quotation.id +')"><i class="fa fa-close fa-2x remove" style="color:red"></i></a></td>';
                        showData += '</tr>';

                        $("#gsx_ref").val('');        
                        $("#cs_code").val('');  
                        $("#service_code").val('');
                        // $("#apple_parts").val('');
                        $("#serial_no").val('');
                        // $("#digits_code").val('');
                        $("#item_desc").val('');
                        $("#item_qty").val('');
                        $("#item_id").val('');
                        $("#cost").val('');
                        $('table .nr:last').before(showData);
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
                        // $("#digits_code").val(result[0].digits_code);
                        $("#item_desc").val(result[0].item_description);
                        $("#item_qty").val(result[0].qty); 
                        $("#item_id").val(result[0].id); 
                        $("#item_qty").css('color', result[0].qty == 0 ? 'red' : 'limegreen');
                        $("#cost").val(result[0].cost);
                        
                            // if(result[0].qty == 0){
                            //     $('.btn_ongoing_repair_1').hide();
                            // } else {
                            //     $('.btn_ongoing_repair_1').show();
                            // }

                        document.getElementById("service_code").disabled = true;
                        // document.getElementById("digits_code").disabled = true;
                        document.getElementById("item_desc").disabled = true;
                        document.getElementById("item_qty").disabled = true;
                        document.getElementById("item_id").disabled = true;
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
                        // $("#digits_code_"+row_id).val(result[0].digits_code);
                        $("#item_desc_"+row_id).val(result[0].item_description);
                        $("#item_qty_"+row_id).val(result[0].qty);
                        $("#item_id_"+row_id).val(result[0].id);
                        $("#price_"+row_id).val(result[0].cost);

                        document.getElementById("service_code_"+row_id).disabled = true;
                        // document.getElementById("digits_code_"+row_id).disabled = true;
                        document.getElementById("item_desc_"+row_id).disabled = true;
                        document.getElementById("item_qty_"+row_id).disabled = true;
                        document.getElementById("item_id_"+row_id).disabled = true;
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
    
    
// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
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
    
     // adding original cost of software fee
    // function AddDiagnosticFee()
    // {
    //     var diagnostic_original_cost = document.getElementById("diagnostic_original_cost").value;
    //     $("#add_diagnostic_fee").attr("disabled", "disable");
    //     $("#diagnostic_cost").val(diagnostic_original_cost);
        
    //     return false;
    // }

    // reset value of software fee
    // function ResetDiagnosticFee()
    // {
    //     $("#add_diagnostic_fee").attr("disabled", false);
    //     var diagnostic_cost = document.getElementById("diagnostic_cost").value;
    //     $("#software_cost").val('0.00');
    //     return false;
    // }
</script>