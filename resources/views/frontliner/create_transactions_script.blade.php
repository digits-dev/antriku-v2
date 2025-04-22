<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
function SelectedModel() {
  var model = document.getElementById("model").value

  $.ajax({
    url: "{{ route('selected-model') }}",
    type: "POST",
    data: {
      model: model,
      _token: "{!! csrf_token() !!}",
    },
    success: (result) => {
      var img = "{{ URL::to('/') }}/" + result[0].model_photo
      var showData = "<img src=" + img + " style='border: 1px solid slategray; width: 100%;'/>"

      jQuery("#Photo").html(showData)
      $(".item-img-hov").hide()
      $("#Photo").show()

      $("#Photo").off("click")
      $("#Photo").on("click", () => {
        Swal.fire({
          html: `
                <div class="app-container" id="app">
                    <div class="app-header">
                        <h1 class="app-title">
                            <i class="fa fa-search"></i>
                            Model Inspection
                        </h1>
                        <div class="mode-toggle">
                            <span class="mode-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mode-icon mark-icon"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                Mark
                            </span>
                            <label class="switch">
                                <input type="checkbox" id="eraseToggle">
                                <span class="slider"></span>
                            </label>
                            <span class="mode-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mode-icon erase-icon"><path d="M20 20H7L3 16a1 1 0 0 1 0-1.41l9.71-9.71a1 1 0 0 1 1.41 0l6.88 6.88a1 1 0 0 1 0 1.41L12.7 20"></path></svg>
                                Erase
                            </span>
                        </div>
                    </div>
                    
                    <div id="canvas-container">
                        <canvas id="canvas"></canvas>
                        <div class="tooltip" id="tooltip"></div>
                    </div>
                </div>
            `,
          width: "70%",
          heightAuto: true,
          padding: "1em",
          showCancelButton: true,
          showConfirmButton: true,
          allowOutsideClick: false,
          customClass: {
            popup: "fixed-size-modal",
          },
          cancelButtonText: '<i class="fa fa-times"></i> No, Cancel',
          confirmButtonText: '<i class="fa fa-save"></i> Save Inspection',
          didOpen: () => {
            // Initialize the canvas
            // IMPORTANT: Use a new canvas instance each time
            const canvasEl = document.getElementById("canvas")
            const appEl = document.getElementById("app")

            // Make sure we're working with a fresh canvas
            if (window.activeCanvas) {
              window.activeCanvas.dispose()
            }

            const canvas = new fabric.Canvas("canvas")
            window.activeCanvas = canvas

            let isEraseMode = false
            const marks = [] // Store marks for removal

            // Load the image onto the canvas
            fabric.Image.fromURL(img, (imgObj) => {
              // Calculate responsive dimensions
              const maxWidth = Math.min(window.innerWidth * 0.6, 800)
              const scale = maxWidth / imgObj.width

              // Set canvas dimensions
              canvas.setWidth(imgObj.width * scale)
              canvas.setHeight(imgObj.height * scale)

              // Scale the image
              imgObj.scale(scale)

              // Add image to canvas
              canvas.add(imgObj)

              // Ensure the image is at the bottom
              imgObj.set({
                selectable: false,
                evented: false,
              })
              canvas.sendToBack(imgObj)
            })

            // Handle the toggle switch change event
            document.getElementById("eraseToggle").addEventListener("change", (event) => {
              isEraseMode = event.target.checked
              updateMode()
            })

            // Update the UI based on the current mode
            function updateMode() {
              if (isEraseMode) {
                appEl.classList.add("erase-mode")

                // Force cursor update for eraser
                canvasEl.style.cursor = `url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="%23f72585" fill-opacity="0.2" stroke="%23f72585" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20H7L3 16a1 1 0 0 1 0-1.41l9.71-9.71a1 1 0 0 1 1.41 0l6.88 6.88a1 1 0 0 1 0 1.41L12.7 20"></path></svg>') 3 28, pointer`
              } else {
                appEl.classList.remove("erase-mode")

                // Force cursor update for pen
                canvasEl.style.cursor = `url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="%234361ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path><circle cx="7.5" cy="20.5" r="0.5" fill="%234361ee"/></svg>') 1 30, pointer`
              }
            }

            // Handle the click event to place an "X" on the image or erase a mark
            canvas.on("mouse:down", (event) => {
              const pointer = canvas.getPointer(event.e)
              const x = pointer.x
              const y = pointer.y

              if (isEraseMode) {
                // Check if we clicked near an "X" and remove it
                let removed = false
                canvas.forEachObject((obj) => {
                  if (obj.type === "line" && obj.containsPoint(new fabric.Point(x, y))) {
                    canvas.remove(obj)
                    removed = true
                  }
                })

                if (removed) {
                  showTooltip(x, y, "Mark removed!")
                }
              } else {
                // Create the "X" with improved styling
                const line1 = new fabric.Line([x - 10, y - 10, x + 10, y + 10], {
                  stroke: "red",
                  strokeWidth: 3,
                  strokeLineCap: "round",
                })

                const line2 = new fabric.Line([x + 10, y - 10, x - 10, y + 10], {
                  stroke: "red",
                  strokeWidth: 3,
                  strokeLineCap: "round",
                })

                // Add the lines to the canvas
                canvas.add(line1, line2)

                // Store the lines in the marks array for possible removal
                marks.push(line1, line2)

                // Ensure the "X" is placed above the image
                canvas.bringToFront(line1)
                canvas.bringToFront(line2)

                showTooltip(x, y, "Mark placed!")
              }
            })

            // Show tooltip with message
            function showTooltip(x, y, message) {
              const tooltip = document.getElementById("tooltip")
              tooltip.textContent = message
              tooltip.style.left = `${x + 10}px`
              tooltip.style.top = `${y + 10}px`
              tooltip.style.opacity = "1"

              setTimeout(() => {
                tooltip.style.opacity = "0"
              }, 1500)
            }

            // Initialize the mode
            updateMode()

            // Handle window resize
            window.addEventListener("resize", () => {
              const maxWidth = Math.min(window.innerWidth * 0.6, 800)

              if (canvas.width > maxWidth) {
                const scale = maxWidth / canvas.width
                canvas.setZoom(scale)
                canvas.setDimensions({
                  width: canvas.width * scale,
                  height: canvas.height * scale,
                })
              }
            })
          },
          preConfirm: () => {
            if (window.activeCanvas) {
                const base64Image = window.activeCanvas.toDataURL("image/png");
                document.getElementById("marked_image_base64").value = base64Image;
            }
          },
          willClose: () => {
            // Clean up when the modal closes
            if (window.activeCanvas) {
              window.activeCanvas.dispose()
              window.activeCanvas = null
            }
          },
        })
      })
    },
  })
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

        let purchase_date = new Date($("#purchase_date").val());
        let warranty_expiration_date = new Date($("#warranty_expiration_date").val());

        if (purchase_date > warranty_expiration_date) {
            swal('Error!', 'The purchase date cannot be later than the warranty expiration date. Please double check.', 'error');
            return;
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