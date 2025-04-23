
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
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

    // Function for validating email format
    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    
    // Function for validating null or empty value
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }

    // Date Picker
    setTimeout("preventBack()", 0);
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
        
    function in_array(search, array) {
        for (i = 0; i < array.length; i++) {
            if (array[i] == search) {
            return true;
            }
        }
        return false;
    }

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

    function changeStatus(status_id)
    { 
        var header_id = document.getElementById("header_id").value;
        var email = document.getElementById("email").value; 
        var contact_no = document.getElementById("contact_no").value; 
        var regex_contact_number = /^(09)[0-9]{9}$/;
        var invoice = $("#invoice")[0].files[0];
        let other_pd = false;


        if(isEmptyOrSpaces(email))
        {
            swal('Error!','Email Address is empty!','error');
        }else if(!validateEmail(email))
        {
            swal('Error!','Invalid format of Email Address.','error');  
        }else if(isEmptyOrSpaces(contact_no))
        {
            swal('Error!','Contact Number is empty!','error');
        }else if(!regex_contact_number.test(contact_no))
        {
        }else{
            $(".buttonSubmit").attr("disabled", "disable");

            var formData = new FormData();
            formData.append('header_id', header_id);
            formData.append('status_id', status_id);
            formData.append('email', email);
            formData.append('invoice', invoice); // File goes here
            formData.append('_token', '{!! csrf_token() !!}');

            $.ajax
            ({ 
                url: "{{ route('diagnostic-status') }}",
                type: "POST",
                data: formData,
                contentType: false, // Important for file upload
                processData: false, // Important for file upload
                success: function(result)
                {
                 if(status_id == 11){
                        swal({
                        title: "Success!",
                        text: "DIAGNOSTIC FEE IS NOW PAID!",
                        type: "success",
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "OK",
                        },
                        function(){
                            $("#SubmitTransactionForm").submit();
                        });
                    }
                }                    
            });
        }
    }

    $(document).on('click', '#send', function(e){
        e.preventDefault();
    });

    $(document).on('click', '#paid', function(e){
        e.preventDefault();
    });

    function OtherProblemDetail()
    {
        var ProblemDetailArray = $('#problem_details').val();
       
        if(ProblemDetailArray !== null)
        {
            if(in_array("OTHERS", ProblemDetailArray))
            {
                $("#problem_details_other").val('');
                addinputField = `
                    <div class="col-md-12">
                        <label class="require control-label col-md-2"><span class="requiredField">*</span>Other Problem Details: </label>
                        <div class="col-md-10" style="margin-top:7px;">
                            <input type="text" class="form-control" name="problem_details_other" id="problem_details_other" value="{{$transaction_details->problem_details_other}}" placeholder="Type your other problem details here" required> 
                        </div>
                    </div> `
            }else{
                addinputField = ` `;
            }
            
        }else{
            addinputField = ` `;
        }
        
        $("#show_other_problem").html(addinputField);
    }
	
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