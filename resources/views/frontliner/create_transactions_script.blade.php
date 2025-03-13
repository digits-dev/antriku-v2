
<script type="text/javascript">
    var base_url = window.location.origin;
    $(document).ready(function(){
        $(".limitedNumbChosen").chosen({
        })
        .bind("chosen:maxselected", function (){
        })
        $(".limitedNumbSelect2").select2({
        })
    });

    function preventBack() {
        window.history.forward();
    }

    // FUNCTION FOR VALIDATING NULL OR EMPTY VALUE
    function isEmptyOrSpaces(str){
        return str === null || str == '' || str.length === 0;
    }

    $( "#purchase_date" ).datepicker( { format: 'yyyy/mm/dd', endDate: new Date()} );
    $( "#warranty_expiration_date" ).datepicker( {format: 'yyyy/mm/dd'} );

    $(document).ready(function() {
        $("form").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                return false;
            }
        });
    });
    
    function AvoidSpace(event) {
        var k = event ? event.which : window.event.keyCode;
        if (k == 32) return false;
    }

    $('form').submit(function(){
        $(this).find(':submit').attr('disabled','disabled');
    });
  
    $(document).ready(function() {
        $("form").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
    
    function in_array(search, array) {
        for (i = 0; i < array.length; i++) {
            if (array[i] == search) {
            return true;
            }
        }
        return false;
    }

    var id_qty = 0;
    var stack = [];
    var token = $("#token").val();
    var myStr = '';
    // var xx_len = 0;
    var restriction = 0;
    var blank = 0;
    var execute = 0;
    var button_asc = 0;
    var temp = '';
    var problem_loop = 0;
    var stack_serials = <?php echo json_encode($stack_serials); ?>;
    var stack_problem_details = <?php echo json_encode($stack_problem_details); ?>;
    var stack_problem_details_other = <?php echo json_encode($stack_problem_details_other); ?>;
    var stack_cost = <?php echo json_encode($stack_cost); ?>;

    $(document).ready(function(){
        $(function(){
            $("#search").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('search-item') }}", 
                        type: "POST",
                        dataType: "json",
                        data: {
                            "_token": token,
                            "search": request.term
                        },
                        success: function (data) {
                            var rowCount = $('#pullout-items tr').length;
                            if(rowCount == 1){
                                myStr = data.sample;   
                                if (data.status_no == 1) {
                                    $("#val_item").html();
                                    var data = data.items;
                                    $('#ui-id-2').css('display', 'none');
                                    response($.map(data, function (item) {
                                        return {
                                            id: item.id,
                                            digits_code: item.digits_code,
                                            stock_upc: item.upc_code,
                                            value: item.item_description,
                                        }
                                    }));
                                } else {
                                    $('.ui-menu-item').remove();
                                    $('.addedLi').remove();
                                    $("#ui-id-2").append($("<li class='addedLi'>").text(data.message));
                                    var searchVal = $("#search").val();
                                    if (searchVal.length > 0) {
                                        $("#ui-id-2").css('display', 'block');
                                    } else {
                                        $("#ui-id-2").css('display', 'none');
                                    }
                                }
                            }else{
                                $("#search").val("");
                                alert("Only 1 item allowed!");
                            }
                        },
                        error: function(data){
                            console.log(JSON.stringify(data));
                        }
                    })
                },
                select: function (event, ui) {
                    var e = ui.item;
                    if (e.id) {
                        if (!in_array(e.stock_upc, stack)) {
                            button_asc++;
                            problem_loop++;
                            stack.push(e.stock_upc);                    
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                '<td><input class="input-cus text-center" type="text" name="digits_code" readonly value="' + e.digits_code + '"></td>' +
                                '<td><input class="input-cus text-center" type="text" name="upc_code" readonly value="' + e.stock_upc + '"></td>' +
                                '<td><input class="input-cus" type="text" name="item_description" readonly value="' + e.value + '"></td>' +
                                '<td><input class="input-cus text-center" type="text" name="serial_no" id="serial_no"></td>' +
                                '<td style="padding: 5px !important; padding-top: 15px !important" class="text-center"><a onclick="RemoveRow('+ e.id +')"><i class="fa fa-close fa-2x remove" style="color:red"></i></a></td>' +
                                '</tr>';
                            $(new_row).insertAfter($('table tr.dynamicRows:last'));
                            $('.js-example-basic-multiple').select2();
                            $(".js-example-basic-multiple").select2({
                            theme: "classic"
                            });
                        } else {
                            if(!related_items.includes(e.stock_upc)){
                                $('#' + e.stock_upc).val(function (i, oldval) {
                                    return ++oldval;
                                });
                                var temp_qty = $('#'+ e.stock_upc).attr("data-id");
                                var q = $('#' +e.stock_upc).val();
                                var r = $("#rate_id_" + e.id).val();
                                $('#amount_' + e.id).val(function (i, amount) {
                                    if (q != 0) {
                                        var itemPrice = (q * r);
                                        return itemPrice;
                                    } else {
                                        return 0;
                                    }
                                });
                                $('#'+temp_qty).val(q);

                            }else{
                                alert("You can not add this item!");
                            }
                        }
                        $(this).val('');
                        $('#val_item').html('');
                        return false;
                    }
                },
                minLength: 1,
                autoFocus: true
            });
        });
    });

    // Delete item row
    $(document).ready(function (e) {
        $('#pullout-items').on('click', '.delete_item', function () {
            problem_loop = problem_loop - 1;
            var  v = $(this).attr("id").substr(0, 8);
            stack = jQuery.grep(stack, function (value) {
            return value != v;
            });

            $(this).closest("tr").remove();
            execute = 0;

            for (iz = 0; iz <=count_of_id; iz++) { 
                var child = $('#second'+div_container+iz);
                child.remove();
            }
            div_container1 = [];
        });
    });

    // REMOVING ROW IN ITEM DESCRIPTION
    function RemoveRow(row_id)
    {
        $('#rowid'+row_id).remove();
    }

    $(document).on('keyup', '.no_units', function (ev) {
        $('#'+ $(this).attr("data-id")).val(this.value);
    });

    $("#").on('keyup', function () {
        var searchVal = $("#search").val();
        if (searchVal.length > 0) {
            $("#ui-id-2").css('display', 'block');
        } else {
            $("#ui-id-2").css('display', 'none');
        }
    });

    // MODEL DROPDOWN
    function SelectedModel()
    {
        var model = document.getElementById("model").value; 
        $.ajax
        ({ 
            url: "{{ route('selected-model') }}",
            type: "POST",
            data: {
                'model': model,
                _token: '{!! csrf_token() !!}'
                },
            success: function(result)
            {
                var img = "{{ URL::to('/') }}/" + result[0].model_photo;
                var showData = "<img src=" + img + " style='border: 1px solid slategray; width: 100%;'/>";
                
                jQuery("#Photo").html(showData); 
                $('.item-img-hov').hide();
                $('#Photo').show();             
            }
        });
    }

    // PROBLEM DETAIL DROPDOWN
    function OtherProblemDetail()
    {
        count_problem_details_other_array = [];                         
        var ProblemDetailArray = $('#problem_details').val();
        count_problem_details_other_array.push(ProblemDetailArray);
        count_problem_details_other_array.forEach(function(opd) {
            for (var i = 0; i < opd.length; ++i) {
                if(opd[i] === 'OTHERS')
                {
                    addinputField = `
                        <label><span class="requiredField">*</span>Other Problem Details</label>
                        <input type="input" class="form-control" name="problem_details_other" id="problem_details_other" placeholder="Other Problem Details" required><br>`
                    $("#show_other_problem").html(addinputField);
                    break;
                }else{
                    addinputField = ` `
                    $("#show_other_problem").html(addinputField);
                }
            }
        });
    }

    // PRINT FORM
    function printDivision(divName) {
        alert('Please print 2 copies!');
        var generator = window.open(",'printableArea,");
        var layertext = document.getElementById(divName);
        generator.document.write(layertext.innerHTML.replace("Print Me"));
        generator.document.close();
        generator.print();
        generator.close();
    }  
    
    function isEmpty(value){
      return (value == null || value.length === 0);
    }
    
    $(".buttonSubmit").on('click',function()
    {
        var rowCount = $('#pullout-items tr').length;  
        var formdata = false;
        
        $('form#SubmitTransactionForm').find("input[type='input'], select, input[type='radio']:checked, textarea").each(function(){
            if($(this).prop('required')){
                var formval = $(this).val();
                if(isEmptyOrSpaces(formval)){
                    formdata = true;
                }
            } 
        });

        if(rowCount > 1){ 
            var serial_no = document.getElementById("serial_no").value;
        }else{
            var serial_no = '';
        }
        
        if(formdata){ 
            swal('Error!','Please fill up required field!','error');
        }else if(rowCount <= 1){
            swal('Error!','Please put an item!','error');
        }else if(isEmptyOrSpaces(serial_no)){ 
            swal('Warning!','Serial Number is required!','warning');
        }else{
            $(".buttonSubmit").attr("disabled", "disable");
            $.ajax({ 
                url: "{{ route('add-transaction') }}",
                type: "POST",
                data: {
					'data': $("#SubmitTransactionForm").serialize(),
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                {
                    swal({ 
                        title: result[0].ref_no, 
                        text: "This is your Reference Number.", 
                        type: "info", 
                        confirmButtonColor: "#5CB85C", 
                        confirmButtonText: `Proceed To ${result[0].warranty_status === "OUT OF WARRANTY" ? "Payment" : "Print"}`, 
                        closeOnConfirm: false
                    }, function(){
                        if(result[0].warranty_status === "OUT OF WARRANTY"){
                            window.location.href = base_url+"/admin/pay_diagnostic/edit/"+result[0].header_id;
                        } else {
                            window.location.href = base_url+"/admin/returns_header/PrintReceivingForm/"+result[0].header_id;
                        }
                    });
                }                    
            });
        }
    });
    
    $(document).on('click', '#ToPayment', function(e){
        e.preventDefault();
    });
</script>