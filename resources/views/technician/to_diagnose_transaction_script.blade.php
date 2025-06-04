<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"rel="stylesheet">
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
            $(this).val(s + "\n");
        }
    });

    // select plugins
    $(document).ready(function() {
        $(".limitedNumbChosen").chosen({})
            .bind("chosen:maxselected", function() {})
        $(".limitedNumbSelect2").select2({})
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
    $("#warranty_expiration_date").datepicker({
        format: 'yyyy/mm/dd'
    });

    // date ordered date picker
    $(".dateordered").datepicker({
        format: 'yyyy-mm-dd'
    });

    // function for validating null or empty value
    function isEmptyOrSpaces(str) {
        return str === null || str.match(/^ *$/) !== null;
    }

    // display of other problem detail input field
    function OtherProblemDetail() {
        count_problem_details_other_array = [];
        var ProblemDetailArray = $('#problem_details').val();
        count_problem_details_other_array.push(ProblemDetailArray);
        count_problem_details_other_array.forEach(function(opd) {
            for (var i = 0; i < opd.length; ++i) {
                if (opd[i] === 'OTHERS') {
                    addinputField = `
                        <div class="col-md-12">
                            <label class="control-label col-md-2" style="margin-top:7px;"><span class="requiredField">*</span>Other Problem Details:</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <input type="text" class="form-control" name="problem_details_other" id="problem_details_other" value="" placeholder="Type your other problem details here">
                            </div>
                        </div>`;

                    $("#show_other_problem").html(addinputField);
                    break;
                } else {
                    addinputField = ` `;
                    $("#show_other_problem").html(addinputField);
                }
            }
        });
    }

    // validation for submitting form
    function changeStatus(status_id) {
        $('#top-loader').show();
        var mainpath = document.getElementById("mainpath").value;
        var header_id = document.getElementById("header_id").value;
        var current_status = document.getElementById("current_status").value;
        var warranty_status = document.getElementById("warranty_status").value;
        var case_status = document.getElementById("case_status").value;
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

        var getidValue = $('.getidValue').map((_, el) => el.value).get()
        $("#rowidArray").val(getidValue);

        var getgsxValue = $('.getgsxValue').map((_, el) => el.value).get()
        $("#gsxArray").val(getgsxValue);

        var getcsValue = $('.getcsValue').map((_, el) => el.value).get()
        $("#csArray").val(getcsValue);

        var getscValue = $('.getscValue').map((_, el) => el.value).get()
        $("#scArray").val(getscValue);

        var getapValue = $('.getapValue').map((_, el) => el.value).get()
        $("#apArray").val(getapValue);

        var getserialValue = $('.getserialValue').map((_, el) => el.value).get()
        $("#serialArray").val(getserialValue);

        var getitemValue = $('.getitemValue').map((_, el) => el.value).get()
        $("#itemArray").val(getitemValue);

        var getcostValue = $('.getcostValue').map((_, el) => el.value).get()
        $("#costArray").val(getcostValue);
        //*****************************************************************/

        // For Cost Computation
        var all_cost = document.getElementById("costArray").value;
        var all_item_desc = document.getElementById("itemArray").value;

        //************************Validation for Array************************
        let all_item_parts_type = $('.item_spare_additional_type').map(function() {
            return $(this).val().trim().toLowerCase();
        }).get();
        const has_doa_jo = all_item_parts_type.includes("additional-standard-doa");
        const has_doa_jo_yes = all_item_parts_type.includes("additional-standard-doa-yes");

        if (has_doa_jo == false && has_doa_jo_yes == false) {
            if (checkIfDuplicateExists(getscValue)) {
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Error!', 'The Spare Part you entered is already in the list.', 'error');
                }, 1000);
                return false;
            }
        }

        for (var i = 0; i < getitemValue.length - 1; ++i) {
            if (isEmptyOrSpaces(getitemValue[i]) == true) {
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!', 'Item Description is required.');
                }, 1000);
                return false;
            }
        }

        for (var i = 0; i < getcostValue.length - 1; ++i) {
            if (isEmptyOrSpaces(getcostValue[i]) == true) {
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!', 'Price is required.');
                }, 1000);
                return false;
            }
        }

        if (status_id == 35) {
            let all_item_parts_type = $('.item_spare_additional_type').map(function() {
                return $(this).val().trim().toLowerCase();
            }).get();

            let new_spare_req = $('#new_spare_req').val().trim().toLowerCase();

            const has_additional_required = all_item_parts_type.includes("additional-required-pending");
            const has_new_spare_req = new_spare_req.includes("additional-required-pending");

            if (has_additional_required && has_new_spare_req) {
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!',
                        'You enabled "Additional Required", please add new required spare parts to proceed. If not, please switch it off.'
                        );
                }, 1000);
                return false;
            }
        }

        // let transaction_status = $('#transaction_status').val();
        // if (status_id == 19 && transaction_status != 35) {
        //     for (var i = 0; i < getserialValue.length - 1; ++i) {
        //         if (isEmptyOrSpaces(getserialValue[i]) == true) {
        //             $('.getserialValue').css('border', '1px solid red');
        //             setTimeout(function() {
        //                 $('#top-loader').hide();
        //                 swal('Info!', 'KGB Serial Number is required.');
        //             }, 1000);
        //             return false;
        //         }
        //         $('.getserialValue').css('border', '');
        //     }
        // }

        for (var i = 0; i < getscValue.length - 1; ++i) {
            if (isEmptyOrSpaces(getscValue[i]) == false) {
                let header_id = $('#header_id').val();
                $('#top-loader').show();
                $.ajax({
                    "async": false,
                    url: "{{ route('check-gsx') }}",
                    type: "POST",
                    data: {
                        'header_id': header_id,
                        'gsx': getscValue[i],
                        _token: '{!! csrf_token() !!}'
                    },
                }).success(function(result) {

                    if (result.length == 0) {
                        $(".getscValue:eq(" + [i] + ")").css("border", "2px solid red");
                        $('#top-loader').hide();
                        stop = true;
                    } else {
                        $(".getscValue:eq(" + [i] + ")").css("border", "1px solid slategray");
                    }
                });
            } else if (isEmptyOrSpaces(getscValue[i]) == true) {
                setTimeout(function() {
                    $('#top-loader').hide(); 
                    swal('Info!', 'Spare Part is required.');
                }, 1000);
                return false;
            }

            if (stop && getscValue.length - 1 == i + 1) {
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!', 'Your Spare Part is not existing.');
                }, 1000);
                return false;
            }
        }
        //****************************************************************************** */

        if (isEmptyOrSpaces(gsx_ref) == false || isEmptyOrSpaces(cs_code) == false || isEmptyOrSpaces(service_code) ==
            false || isEmptyOrSpaces(serial_no) == false || isEmptyOrSpaces(item_desc) == false || isEmptyOrSpaces(
            cost) == false) {
            if (isEmptyOrSpaces(service_code) == false) {
                let header_id = $('#header_id').val();

                $.ajax({
                    "async": false,
                    url: "{{ route('check-gsx') }}",
                    type: "POST",
                    data: {
                        'header_id': header_id,
                        'gsx': service_code,
                        _token: '{!! csrf_token() !!}'
                    },
                }).success(function(result) {
                    if (result.length == 0) {
                        $("#service_code").css("border", "2px solid red");
                        $('#top-loader').hide();
                        stop = true;
                    } else {
                        $("#service_code").css("border", "1px solid slategray");
                    }
                });
            } else {
                $("#service_code").css("border", "1px solid slategray");
            }

            if (isEmptyOrSpaces(service_code) == true) {
                proceed = false;
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!', 'Spare Part is required.');
                }, 1000);
                return false;
            } else if (stop) {
                proceed = false;
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!', 'Your Spare Part is not existing.');
                }, 1000);
                return false;
            } else if (isEmptyOrSpaces(item_desc) == true) {
                proceed = false;
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!', 'Item Description is required.');
                }, 1000);
                return false;
            } else if (isEmptyOrSpaces(cost) == true) {
                proceed = false;
                setTimeout(function() {
                    $('#top-loader').hide();
                    swal('Info!', 'Price is required.');
                }, 1000);
                return false;
            } else {
                proceed = true;
            }
        } else {
            proceed = true;
        }
        if (proceed) {

            $('#top-loader').hide();
            if (status_id == 'save') {
                $(".buttonSubmit").removeAttr("disabled");
            }

            var formData = new FormData();
            formData.append("all_data", $("#SubmitTransactionForm").serialize());
            formData.append("header_id", header_id);
            formData.append("current_status", current_status);
            formData.append("status_id", status_id);
            formData.append("warranty_status", warranty_status);
            formData.append("all_cost", all_cost);
            formData.append("all_item_desc", all_item_desc);
            formData.append("_token", '{!! csrf_token() !!}');

            if ([17, 26].includes(status_id)) {
                const warranty_changed = @json($data['transaction_details']->warranty_changed_at);
                if (warranty_changed == null) {
                    formData.append("waybill", selectedFiles[0]);
                }
            }

            let transaction_status = $('#transaction_status').val();
            if ([22,23, 39, 40].includes(status_id) && ![45, 43, 42].includes(Number(transaction_status))) {
                formData.append("rpf_invoice", $("#rpf_invoice")[0].files[0]);
            }



            Swal.fire({
                icon: case_status == 'MAIL-IN' && status_id == 20 ? 'info' : 'question',
                title: case_status == 'MAIL-IN' && status_id == 20 ?
                    "This will change the Warranty Status to Out of Warranty" :
                    "Are you sure?",
                text: [13, 22, 38].includes(status_id) ? "Do you want to cancel?" : "Do you want to proceed?",
                showCancelButton: true,
                confirmButtonColor: "#00b8d9",
                confirmButtonText: [13, 22, 38].includes(status_id) ? "Yes, cancel!" :"Yes, proceed!",
                cancelButtonText: "Cancel",
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#top-loader').show();
                    $(".buttonSubmit").attr("disabled", "disabled");

                    $.ajax({
                        url: "{{ route('change-status') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            $('#top-loader').hide();
                            if (status_id == 'save') {
                                $(".buttonSubmit").removeAttr("disabled");

                                Swal.fire({
                                    title: "Success!",
                                    text: "Transaction Details are saved.",
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                });

                            } else {
                                const statusMessages = {
                                    8: "STATUS: TO PAY DIAGNOSTIC",
                                    12: "AWAITING CUSTOMER APPROVAL (MAIL-IN)",
                                    14: "FOR INPUT GSX KBB (MAIL IN)",
                                    13: "CALLOUT: FOR PICK UP BY CUSTOMER (CANCELLED – MAIL IN)",
                                    15: "FOR MAIL IN KBB (MAIL IN)",
                                    16: "AWAITING FOR PICK UP (LOGISTICS)",
                                    17: "AWAITING APPLE REPAIR",
                                    18: "FOR TECH ASSESSMENT",
                                    19: "CALLOUT: AWAITING CUSTOMER PICK UP (GOOD UNIT)",
                                    20: "CALLOUT: FOR CUSTOMER PAYMENT (PARTS)",
                                    21: "AWAITING CUSTOMER APPROVAL (MAIL-IN)",
                                    22: "CALLOUT: FOR PICK UP BY CUSTOMER (CANCELLED – MAIL IN)",
                                    23: "FOR INPUT GSX KBB (MAIL IN)",
                                    24: "FOR MAIL IN KBB (MAIL IN)",
                                    25: "AWAITING FOR PICK UP (LOGISTICS)",
                                    26: "AWAITING APPLE REPAIR (OOW)",
                                    27: "FOR TECH ASSESSMENT",
                                    28: "CALLOUT: AWAITING CUSTOMER PICK UP (GOOD UNIT)",
                                    29: "For Spare part release (Carry In)",
                                    30: "FOR ORDER SPARE PART (CARRY IN)",
                                    31: "SPARE PART RELEASED",
                                    33: "CALLOUT: ORDERING SPARE PARTS",
                                    34: "ON GOING REPAIR",
                                    35: "CALLOUT: ADDITIONAL/DOA SPARE PARTS (CARRY IN)",
                                    38: "CALLOUT: FOR PICK UP BY CUSTOMER (CANCELLED – CARRY IN)",
                                    39: "FOR SPARE PART RELEASE (CARRY IN)",
                                    40: "FOR ORDER SPARE PART (CARRY IN)",
                                    41: "SPARE PART RELEASED",
                                    42: "ON GOING REPAIR",
                                    43: "CALLOUT: ADDITIONAL/DOA SPARE PARTS (CARRY IN)",
                                    45: "CALLOUT: ORDERING SPARE PARTS",
                                    47: "AWAITING APPLE REPAIR (IW)",
                                    48: "CALLOUT: AWAITING CUSTOMER APPROVAL",
                                };

                                if (statusMessages[status_id]) {
                                    Swal.fire({
                                        title: "Info!",
                                        text: statusMessages[status_id],
                                        icon: "info",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        if([34, 42].includes(status_id)){
                                            window.location.href = '/admin/pending_repair/edit/' + header_id;
                                        } else {
                                            window.location.href =
                                                "{{ CRUDBooster::mainpath() }}";
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            });

            return false;
        }

    }

    // confirmation for send quotation button
    $(document).on('click', '#repair', function(e) {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Are you sure?",
            text: "Click the save button to check the transaction details before sending a quotation",
            showCancelButton: true,
            confirmButtonColor: "#5CB85C",
            confirmButtonText: "Send Quotation",
            cancelButtonText: "Cancel",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        }).then((result) => {
            if (result.isConfirmed) {
                return changeStatus(2);
            }
        });
    });

    // confirmation for close button
    $(document).on('click', '#close', function(e) {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Do you want to proceed?",
            text: "Ensure that the customer has received their item before clicking YES.",
            confirmButtonText: "Yes",
            confirmButtonColor: "#5CB85C",
            showCancelButton: true,
            cancelButtonText: "No",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        }).then((result) => {
            if (result.isConfirmed) {
                return changeStatus(6);
            }
        });
    });

    // prevent multiple submit of form
    $('form').submit(function() {
        $(this).find(':submit').attr('disabled', 'disabled');
    });

    // warranty status name
    function WarrantyStatusChange(warranty) {
        if (warranty == 1) {
            $("#warranty_status").val("IN WARRANTY");
        } else if (warranty == 2) {
            $("#warranty_status").val("OUT OF WARRANTY");
        } else if (warranty == 3) {
            $("#warranty_status").val("SPECIAL");
        }
    }

    function callOut(status_id, button = null) {
        let ntf = null; 

        if (button) {
            ntf = button.id;
        }
        let header_id = $('#header_id').val();

        Swal.fire({
            title: "Are you sure you want to call out?",
            text: "This will record the call out!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#008000",
            confirmButtonText: "Yes!",
            cancelButtonText: "No, cancel!",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                let ajaxOptions = {
                    url: "/admin/call_out/call_out",
                    type: "POST",
                    data: {
                        returns_header_id: header_id,
                        status_id: status_id,
                        is_ntf: ntf,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Success!",
                            text: "Call out has been recorded.",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                    }
                };

                // Add beforeSend only for these statuses
                if ([12,13,19,21,22,33,28,38,45,47].includes(status_id)) {
                    ajaxOptions.beforeSend = function () {
                        Swal.fire({
                            icon: "info",
                            title: "Sending Email To Customer",
                            text: "Please wait...",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => Swal.showLoading()
                        });
                    };
                }

                $.ajax(ajaxOptions);
            } else {
                Swal.fire("Cancelled", "Your call out has been cancelled.", "error");
            }
        });
    }

    function validateBeforeChangeStatus(status_id) {
        let form = document.getElementById("SubmitTransactionForm");

        if (!form.checkValidity()) {
            form.reportValidity();
            return false;
        }
        return changeStatus(status_id);
    }

function refund(headerId) {
     const finalInvoiceUploaded = @json($data['transaction_details']->final_invoice);
      let warranty_status = $('#warranty_status').val();
        if (warranty_status === 'OUT OF WARRANTY' && finalInvoiceUploaded == null) {
            let form = document.getElementById("SubmitTransactionForm");
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
        }
    Swal.fire({
        title: 'Loading...',
        didOpen: () => {
            Swal.showLoading();

            $.ajax({
                url: `/admin/callout/refund/${headerId}`,
                type: 'GET',
             success: function(response) {
                   const diagnostic_cost = response.diagnostic_cost;
                    const items = response.items;

                    if (!Array.isArray(items)) {
                        Swal.fire("Error", "Invalid items format", "error");
                        return;
                    }

                    let table = `
                        <table style="width:100%;margin-bottom:10px; text-align:left;" border="1" cellpadding="5">
                            <thead>
                                <tr>
                                    <th style="width: 70%;" class='text-center'>Fees</th>
                                     <th style="width: 15%;" class='text-center'>Cost</th>
                                     <th style="width: 15%;" class='text-center'>Refund Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class='text-center'>Diagnostic Fee</td>
                                    <td class='text-center'>${diagnostic_cost ?? 0}</td>
                                <td>
                                    <input class='input-cus text-center' type="number" step="0.01" id="diagnostic_cost_input"
                                        data-original="${diagnostic_cost ?? 0 }">
                                </td>

                                </tr>
                            </tbody>
                        </table>
                        
                       <table style="width:100%; text-align:left;" border="1" cellpadding="5">
                        <thead>
                            <tr>
                                <th style="width: 70%;"class='text-center'>Item Description</th>
                                <th style="width: 15%;" class='text-center'>Cost</th>
                                <th style="width: 15%;" class='text-center'>Refund Amount</th>
                            </tr>
                        </thead>
                    </table>
                    <div style="max-height:200px; overflow-y:auto; border:1px solid #ccc;">
                        <table style="width:100%; text-align:left;" border="1" cellpadding="5">
                            <tbody>`;
                    
                 // Check if items array is empty
                if (items.length === 0) {
                    table += `
                        <tr>
                            <td colspan="3" class="text-center">No listed item</td>
                        </tr>`;
                } else {
                    items.forEach((item, index) => {
                        table += `
                            <tr>
                                <td style="width: 70%;" class='text-center'>${item.item_description}</td>
                                <td style="width: 15%;" class='text-center'>${item.cost}</td>
                                <td style="width: 15%;">
                                    <input class='input-cus text-center' type="number" step="0.01" name="cost_${index}" 
                                        data-id="${item.id}"
                                        data-description="${item.item_description}"
                                        data-original="${item.cost}" required>
                                </td>
                            </tr>`;
                    });
                }

             table += `</tbody></table></div>`;

                    Swal.fire({
                        title: "Refund Items",
                        html: table,
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonText: "Proceed with Refund",
                        cancelButtonText: "Cancel",
                        confirmButtonColor: "#d33",
                         customClass: 'swal-container2',
                        preConfirm: () => {

                            const diagInput = document.getElementById("diagnostic_cost_input");

                            if (!diagInput.value.trim()) {
                                Swal.showValidationMessage("Diagnostic refund amount is required.");
                                return false;
                            }

                            const diagValue = parseFloat(diagInput.value);
                            const diagOriginal = parseFloat(diagInput.dataset.original);

                            if (diagValue > diagOriginal) {
                                Swal.showValidationMessage(`Diagnostic fee cannot exceed ${diagOriginal}`);
                                return false;
                            }

                            const rows = document.querySelectorAll("input[name^='cost_']");
                            let updatedItems = [];

                            for (const input of rows) {
                                const enteredCost = parseFloat(input.value);
                                const originalCost = parseFloat(input.dataset.original);

                                if (enteredCost > originalCost) {
                                    Swal.showValidationMessage(`Refund Amount for "${input.dataset.description}" cannot exceed ${originalCost}`);
                                    return false; // prevent submission
                                }

                                if (input.value.trim() === "") {
                                    Swal.showValidationMessage(`Refund Amount for "${input.dataset.description}" is required`);
                                    return false;
                                }


                                updatedItems.push({
                                    id: input.dataset.id,
                                    item_description: input.dataset.description,
                                    cost: enteredCost
                                });
                            }

                            return {
                                diagnostic_cost: diagValue,
                                items: updatedItems
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const payload = result.value;

                            // Example AJAX POST to update
                            $.ajax({
                                url: '/admin/callout/update-refund',
                                type: 'POST',
                                contentType: 'application/json',
                               data: JSON.stringify({
                                    header_id: headerId,
                                    diagnostic_cost: payload.diagnostic_cost,
                                    items: payload.items
                                }),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                Swal.fire("Success", "Refund updated successfully.", "success").then(() => {
                                    // window.location.href = window.location.origin + "/admin/to_close/PrintTechnicalReport/" + headerId;
                                     print_technical_from_confirm()
                                });
                                },
                                error: function() {
                                    Swal.fire("Error", "Failed to update refund items.", "error");
                                }
                            });
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire("Error", "Failed to load refund items.", "error");
                }
            });
        }
    });
}


</script>
</script>
