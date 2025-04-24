
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
    
    $('textarea').keypress(function(event) {
        console.log($(this).attr('name'));
        if (event.which == 13 && $(this).attr('name') !== "comment") {
            event.preventDefault();
            var s = $(this).val();
            $(this).val(s+"\n");
        }
    });
    
    // select plugins
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

    window.onunload = function() {
        null;
    };

    setTimeout("preventBack()", 0);
    
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
        
    function in_array(search, array) {
        for (i = 0; i < array.length; i++) {
            if (array[i] == search) {
            return true;
            }
        }
        return false;
    }

    function checkIfDuplicateExists(arr) {
        return new Set(arr).size !== arr.length
    }

     // warranty expiration date picker
    $( "#warranty_expiration_date" ).datepicker( {format: 'yyyy/mm/dd'} );     

     // date ordered date picker
    $( ".dateordered" ).datepicker( {format: 'yyyy-mm-dd'} );                  

    // function for validating null or empty value
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }

    // display of other problem detail input field
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
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Other Problem Details:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <input type="text" class="form-control" name="problem_details_other" id="problem_details_other" value="" placeholder="Type your other problem details here">
                            </div>
                        </div>`;

                    $("#show_other_problem").html(addinputField);
                    break;
                }else{
                    addinputField = ` `;
                    $("#show_other_problem").html(addinputField);
                }
            }
        });
    }

    // validation for submitting form
    function changeStatus(status_id)
    {
  
        var mainpath = document.getElementById("mainpath").value;  
        var header_id = document.getElementById("header_id").value;
        var warranty_status = document.getElementById("warranty_status").value;
        var gsx_ref = document.getElementById("gsx_ref").value;
        var cs_code = document.getElementById("cs_code").value;
        var service_code = document.getElementById("service_code").value;
        var serial_no = document.getElementById("serial_no").value;
        var item_desc = document.getElementById("item_desc").value;
        var cost = document.getElementById("cost").value;
        let stop = false;
        let proceed = false;

        //****************QUOTATION************************************/
        var row_num = $('.row_num').length;
        $("#number_of_rows").val(row_num);

        var getidValue = $('.getidValue').map((_,el) => el.value).get()
        $("#rowidArray").val(getidValue);

        var getgsxValue = $('.getgsxValue').map((_,el) => el.value).get()
        $("#gsxArray").val(getgsxValue);
 
        var getcsValue = $('.getcsValue').map((_,el) => el.value).get()
        $("#csArray").val(getcsValue);

        var getscValue = $('.getscValue').map((_,el) => el.value).get()
        $("#scArray").val(getscValue);
        
        var getapValue = $('.getapValue').map((_,el) => el.value).get()
        $("#apArray").val(getapValue);

        var getserialValue = $('.getserialValue').map((_,el) => el.value).get()
        $("#serialArray").val(getserialValue);

        var getitemValue = $('.getitemValue').map((_,el) => el.value).get()
        $("#itemArray").val(getitemValue);

        var getcostValue = $('.getcostValue').map((_,el) => el.value).get()
        $("#costArray").val(getcostValue);
        //*****************************************************************/
        
        // For Cost Computation
        var all_cost = document.getElementById("costArray").value;
        var all_item_desc = document.getElementById("itemArray").value;
        // var software_cost = document.getElementById("software_cost").value ?? 0;

        //************************Validation for Array************************
        if(checkIfDuplicateExists(getscValue)){
            setTimeout(function () {
                swal('Error!','The Spare Part you entered is already in the list.','error');
            }, 1000);
            return false;
        }

        for(var i=0; i < getitemValue.length-1; ++i) {
            if(isEmptyOrSpaces(getitemValue[i]) == true){
                setTimeout(function () {
                    swal('Info!','Item Description is required.');
                }, 1000);
                return false;
            }
        }

        for(var i=0; i < getcostValue.length-1; ++i) {
            if(isEmptyOrSpaces(getcostValue[i]) == true){
                setTimeout(function () {
                    swal('Info!','Price is required.');
                }, 1000);
                return false;
            }
        }

        for(var i=0; i < getscValue.length-1; ++i) {
            if(isEmptyOrSpaces(getscValue[i]) == false){
                $.ajax({
                    "async" : false,
                    url: "{{ route('check-gsx') }}",
                    type: "POST",
                    data: {
                        'gsx': getscValue[i],
                        _token: '{!! csrf_token() !!}'
                        },
                }).success(function(result){
                    
                    if(result.length == 0){
                        $(".getscValue:eq("+[i]+")").css( "border", "2px solid red" );
                        stop = true; 
                    }else{
                        $(".getscValue:eq("+[i]+")").css( "border", "1px solid slategray" );
                    }
                });
            }else if(isEmptyOrSpaces(getscValue[i]) == true){
                setTimeout(function () {
                    swal('Info!','Spare Part is required.');
                }, 1000);
                return false;
            }
      
            if(stop && getscValue.length-1 == i+1) {
                setTimeout(function () {
                    swal('Info!','Your Spare Part is not existing.');
                }, 1000);
                return false;
            }
        }
        //****************************************************************************** */

        if(isEmptyOrSpaces(gsx_ref) == false || isEmptyOrSpaces(cs_code) == false || isEmptyOrSpaces(service_code) == false || isEmptyOrSpaces(serial_no) == false || isEmptyOrSpaces(item_desc) == false || isEmptyOrSpaces(cost) == false)
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
                proceed = false;
                setTimeout(function () {
                    swal('Info!','Spare Part is required.');
                }, 1000);
                return false;
            }else if(stop){
                proceed = false;
                setTimeout(function () {
                    swal('Info!','Your Spare Part is not existing.');
                }, 1000);
                return false;
            }else if(isEmptyOrSpaces(item_desc) == true){
                proceed = false;
                setTimeout(function () {
                    swal('Info!','Item Description is required.');
                }, 1000);
                return false;
            }else if(isEmptyOrSpaces(cost) == true){
                proceed = false;
                setTimeout(function () {
                    swal('Info!','Price is required.');
                }, 1000);
                return false;
            }else{
                proceed = true;
            }
        }else{
            proceed = true;
        }
        if(proceed){
            if(status_id == 'send' || status_id == 'save'){
                $(".buttonSubmit").removeAttr("disabled");
            }else{
                $(".buttonSubmit").attr("disabled", "disable");
            }

            $.ajax
            ({ 
                url: "{{ route('change-status') }}",
                type: "POST",
                data: {
                    'all_data': $("#SubmitTransactionForm").serialize(),
                    'header_id': header_id,
                    'status_id': status_id,
                    'warranty_status': warranty_status,
                    'all_cost': all_cost,
                    'all_item_desc' : all_item_desc,
                    // 'software_cost': software_cost,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                {   
                    if(status_id == 2){
                        swal({ title: "Info!", text: "STATUS: TO PAY PARTS", type: "info", confirmButtonClass: "btn-primary", confirmButtonText: "OK",
                        }, function(){
                            window.location.href = window.location.origin+"/admin/to_pay_parts/edit/"+header_id;
                        });
                    }else if(status_id == 3){
                        swal({ title: "Info!", text: "STATUS: CANCELLED", type: "info", confirmButtonClass: "btn-primary", confirmButtonText: "OK",
                        }, function(){
                            window.location.href = window.location.origin+"/admin/to_close/edit/"+header_id;
                        });
                    }else if(status_id == 4){
                        swal({ title: "Info!", text: "STATUS: REPAIR IN PROCESS", type: "info", confirmButtonClass: "btn-primary", confirmButtonText: "OK",
                        }, function(){
                            window.location.href = window.location.origin+"/admin/repair_in_process/edit/"+header_id;
                        });
                    }else if(status_id == 5){
                        swal({ title: "Info!", text: "STATUS: CANCELLED/CLOSE", type: "info", confirmButtonClass: "btn-primary", confirmButtonText: "OK",
                        }, function(){
                            window.location.href = window.location.origin+"/admin/to_close";
                        });
                    }else if(status_id == 6){
                        swal({ title: "Success!", text: "STATUS: COMPLETE", type: "success", confirmButtonClass: "btn-primary", confirmButtonText: "OK",
                        }, function(){
                            window.location.href = window.location.origin+"/admin/to_close";
                        });
                    }else if(status_id == 7){
                        swal({ title: "Info!", text: "STATUS: TO PICK UP", type: "info", confirmButtonClass: "btn-primary", confirmButtonText: "OK",
                        }, function(){
                            window.location.href = window.location.origin+"/admin/repair_in_process";
                        });
                    }else if(status_id == 8){
                        swal({ title: "Info!", text: "STATUS: TO PAY DIAGNOSTIC", type: "info", confirmButtonClass: "btn-primary", confirmButtonText: "OK",
                        }, function(){
                            window.location.href = window.location.origin+"/admin/to_diagnose";
                        });
                    }else if(status_id == 'send'){
                        $(".buttonSubmit").removeAttr("disabled");
                        if(warranty_status == 'OUT OF WARRANTY'){
                            swal('Info!','PAYMENT LINK SENT!');
                        }else{
                            swal('Info!','Sending Payment Link is only applicable for Out Of Warranty Status.');
                        }
                    }else if(status_id == 'save'){
                        $(".buttonSubmit").removeAttr("disabled");
                        swal({ title: "Success!", text: "Transaction Details are saved.", type: "success"
                        }, function(){
                           location.reload();
                        });
                    }
                }                    
            });
            return false;
        }
    }

    // confirmation for send quotation button
    $(document).on('click', '#repair', function(e){
        swal({
            title: "Are you sure?",
            text: "Click the save button to check the transaction details before sending a quotation", type: "warning",
            showCancelButton: true, confirmButtonColor: "#5CB85C", confirmButtonText: "Send Quotation", 
            cancelButtonText: "Cancel", closeOnConfirm: false, showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                return changeStatus(2);
            } else {
                e.preventDefault();
            }
        });
        e.preventDefault();
    });

    // confirmation for close button
    $(document).on('click', '#close', function(e){
        swal({ 
            title:"Do you want to proceed?", text:"Ensure that the customer has received their item before clicking YES.", type:"warning", 
            confirmButtonText:"Yes", confirmButtonColor:"#5CB85C", showCancelButton:true, cancelButtonText:"No", closeOnConfirm: false, showLoaderOnConfirm: true
        }, function(){
            return changeStatus(6);
        });
        
        e.preventDefault();
    });

    // prevent multiple submit of form
    $('form').submit(function(){
        $(this).find(':submit').attr('disabled','disabled');
    });

    // warranty status name
    function WarrantyStatusChange(warranty)
	{
		if(warranty == 1){
			$("#warranty_status").val("IN WARRANTY");
		}else if(warranty == 2){
			$("#warranty_status").val("OUT OF WARRANTY");
		}else if(warranty == 3){
			$("#warranty_status").val("SPECIAL");
		}
	}

</script>