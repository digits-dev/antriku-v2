
<script type="text/javascript">

// function for validating null or empty value
function isEmptyOrSpaces(str){
    return str === null || str.match(/^ *$/) !== null;
}

// validation for submitting form
function changeStatus(status_id)
{
    $(".buttonSubmit").attr("disabled", "disable");
    var warranty_status = document.getElementById("warranty_status").value;
    var mainpath = document.getElementById("mainpath").value;
    var header_id = document.getElementById("header_id").value;
    $.ajax
    ({ 
        url: "{{ route('change-status') }}",
        type: "POST",
        data: {
            'header_id': header_id,
            'status_id': status_id,
            'warranty_status': warranty_status,
            _token: '{!! csrf_token() !!}'
            },
        success: function(result)
        {
            if(status_id == 2){
                swal('Info!','STATUS: TO PAY PARTS');
            }else if(status_id == 3){
                swal('Info!','STATUS: CANCELLED');
            }else if(status_id == 4){
                swal('Info!','STATUS: REPAIR IN PROCESS');
            }else if(status_id == 5){
                swal('Info!','STATUS: CANCELLED/CLOSE');
            }else if(status_id == 6){
                swal('Success!','STATUS: COMPLETE', 'success');
            }else if(status_id == 7){
                swal('Info!','STATUS: TO PICK UP');
            }else if(status_id == 'send_link'){
                swal('Info!','PAYMENT LINK SENT!');
            }
            setTimeout(function() {
                window.location.href = mainpath;
            }, 4000);                           
        }                    
    });
    return false;
}

</script>