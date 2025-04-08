@extends('crudbooster::admin_template')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"> --}}
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('include.css')
@endpush

@section('content') 
    <div class="container-cus">
        <div class="form-card-cus">
            <div class="header-cus-2">
                <div class="title-section-cus">
                    <h1 class="h1-cus">Create Transactions</h1>
                    <p class="p-cus">Complete the form below to submit your transaction request</p>
                </div>
                <div class="theme-toggle-cus" style="display">
                    {{-- <span class="light-icon">☀️</span>
                    <label class="switch-cus">
                        <input type="checkbox" id="theme-switch" class="inputs-cus">
                        <span class="slider-cus round"></span>
                    </label>
                    <span class="dark-icon">🌙</span> --}}
                    <img src="https://cdn-icons-png.flaticon.com/128/4763/4763152.png" alt="" width="45px">
                </div>
            </div>

            <div class="progress-section-cus">
                <div class="progress-text-cus">
                    <span>Form Progress</span>
                    <span id="progress-percentage">0% Complete</span>
                </div>
                <div class="progress-bar-cus">
                    <div class="progress-fill-cus" style="width: 0%"></div>
                </div>
            </div>

            <div class="steps-indicator-cus">
                <div style="cursor: pointer" class="step-cus active">
                    <div class="step-number-cus">1</div>
                    <div class="step-label-cus">Customer Details</div>
                </div>
                <div class="step-line-cus"></div>
                <div style="cursor: pointer" class="step-cus">
                    <div class="step-number-cus">2</div>
                    <div class="step-label-cus">Service Details</div>
                </div>
            </div>

            <form method="post" action="{{CRUDBooster::mainpath('add-transaction-process')}}" id="SubmitTransactionForm">
                <div class="form-step" id="step-1">
                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span> {{ trans('labels.form-label.first_name') }}</label>
                                <input type="input" name="first_name" placeholder="Enter First Name" class="input-cus" autocomplete="off" required/>   
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span>{{ trans('labels.form-label.last_name') }}</label>
                                <input type="input" name="last_name" placeholder="Enter Last Name" class="input-cus" autocomplete="off" required/>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span>{{ trans('labels.form-label.email_address') }}
                                    <small id="email_status" class="text-uppercase"></small>
                                </label>
                                <div class="input-container-cus">
                                    <input type="email" name="email" id="email" placeholder="Enter Email Address e.g.(example@email.com)" class="input-cus" autocomplete="off" required/>
                                    <i class="fa fa-check input-icon-cus success-icon-cus" style="display: none;"></i>
                                    <i class="fa fa-warning input-icon-cus error-icon-cus" style="display: none;"></i>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="required">*</span>{{ trans('labels.form-label.contact_no') }}</label>
                                <input 
                                    type="input" 
                                    name="contact_no" 
                                    placeholder="Enter Contact# e.g.(09xxxxxxxxx)" 
                                    pattern="[09][0-9]{10}" 
                                    maxlength="11" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)"
                                    class="input-cus" 
                                    autocomplete="off" 
                                    required
                                /> 
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus">Company Name:</label>
                                <input type="input" name="company_name" placeholder="Enter Company Name" class="input-cus" autocomplete="off"/>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus">Company Contact#:</label>
                                <input 
                                    type="input" 
                                    name="company_contact_no" 
                                    placeholder="Enter Company Contact# e.g.(09xxxxxxxxx)" 
                                    pattern="[09][0-9]{10}" 
                                    maxlength="11" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11)"
                                    class="input-cus" 
                                    autocomplete="off"
                                />
                            </div>
                        </div>
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label for="country" class="label-cus">Country</label>
                                <select name="country" autocomplete="off" class="js-example-basic-single input-cus" id="country"> 
                                    <option value="" selected disabled>Select country here...</option>
                                        @foreach($country as $per_count)
                                            <option value="{{$per_count->countryDesc}}" data-id="{{$per_count->id}}">{{$per_count->countryDesc}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label for="province" class="label-cus">Province</label>
                                <select name="province" autocomplete="off" class="js-example-basic-single input-cus" id="province" disabled> 
                                    <option value="" selected disabled>Select province here...</option>
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label for="city" class="label-cus">City</label>
                                <select name="city" autocomplete="off" class="js-example-basic-single input-cus" id="city" disabled> 
                                    <option value="" selected disabled>Select city here...</option>
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label for="barangay" class="label-cus">Barangay</label>
                                <select name="barangay" autocomplete="off" class="js-example-basic-single input-cus" id="barangay" disabled> 
                                    <option value="" selected disabled>Select barangay here...</option>
                                </select>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus">Address Line</label>
                                <textarea name="address_line" id="address_line" placeholder="No./Line/Street/Blk/Lot/etc..." rows="5" class="textarea-cus" autocomplete="off"></textarea>
                            </div>
                            <div class="form-group-cus" style="display:none">
                                <label class="label-cus">Address:</label>
                                <textarea name="address" id="address" placeholder="" rows="4" class="textarea-cus" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions-cus" style="margin-top: 0px">
                        <button type="button" id="next-button" class="btn-primary-cus">
                            Continue to Service Details
                            <span class="arrow-icon">→</span>
                        </button>
                    </div>
                </div>

                <div class="form-step" id="step-2" style="display: none;">
                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="require label-cus"><span class="requiredField">*</span>Warranty Status:</label> 
                                <div class="warranty-options-cus">
                                    <label class="warranty-option-cus">
                                        <div class="radio-container-cus">
                                        <input type="radio" name="warranty_status" value="IN WARRANTY">
                                        <span class="radio-custom"></span>
                                        </div>
                                        <div class="option-content-cus">
                                        <div class="option-title-cus">In Warranty</div>
                                        <div class="option-description-cus">Product is covered under manufacturer warranty</div>
                                        </div>
                                    </label>
                                    
                                    <label class="warranty-option-cus">
                                        <div class="radio-container-cus">
                                        <input type="radio" name="warranty_status" value="OUT OF WARRANTY">
                                        <span class="radio-custom"></span>
                                        </div>
                                        <div class="option-content-cus">
                                        <div class="option-title-cus">Out of Warranty</div>
                                        <div class="option-description-cus">Product warranty has expired</div>
                                        </div>
                                    </label>
                                    
                                    <label class="warranty-option-cus">
                                        <div class="radio-container-cus">
                                        <input type="radio" name="warranty_status" value="SPECIAL">
                                        <span class="radio-custom"></span>
                                        </div>
                                        <div class="option-content-cus">
                                        <div class="option-title-cus">Special Coverage</div>
                                        <div class="option-description-cus">Extended warranty or special program</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>{{ trans('labels.form-label.purchase_date') }}</label>
                                <input type="input" name="purchase_date" placeholder="" id="purchase_date" class="input-cus" autocomplete="off" required/>                        
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>{{ trans('labels.form-label.warranty_expiration_date') }}</label>
                                <input type="input" name="warranty_expiration_date" placeholder="" id="warranty_expiration_date" class="input-cus" autocomplete="off" required/>                        
                            </div>
                        </div>
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <div class="row">
                                    <div class="col-md-12" id="model_class">
                                        <label for="model" class="label-cus">Model</label>
                                        <select name="model" autocomplete="off" class="js-example-basic-single input-cus" id="model" onchange="SelectedModel()" required> 
                                            <option value="" selected disabled>Choose Model here...</option>
                                            @foreach($data['Model'] as $key=>$model)
                                                <option value="{{ $model->id }}">{{ $model->model_name }}</option>
                                            @endforeach      
                                        </select> 
                                    </div>
                                    <div class="" id="unitt_type_class" style="display: none;">
                                        <label for="model" class="label-cus">Unit Type</label>
                                        <select name="unit_type" autocomplete="off" class="js-example-basic-single input-cus" id="model" onchange="SelectedModel()"> 
                                            <option value="" selected disabled>Choose Unit type here...</option>
                                            <option value="iMac">iMac</option>      
                                            <option value="iPhone">iPhone</option>      
                                            <option value="macbook">MacBook</option>      
                                            <option value="mac mini">Mac Mini</option>      
                                            <option value="airpods">AirPods</option>      
                                            <option value="keyboard">Keyboard</option>      
                                            <option value="mouse">Mouse</option>      
                                            <option value="iPad">iPad</option>      
                                            <option value="Apple watch">Apple Watch</option>      
                                            <option value="trackpad">TrackPad</option>      
                                            <option value="apple tv">Apple TV</option>      
                                            <option value="studio display">Studio Display</option>      
                                            <option value="MAC Pro">MAC Pro</option>      
                                            <option value="Mac Studio">Mac Studio</option>      
                                            <option value="beats headphones">Beats Headphones</option>      
                                            <option value="beats earphone">Beats Earphones</option>      
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <div class="item-photo-cus">
                                    <img src="https://cdn-icons-png.flaticon.com/128/17522/17522345.png" class="item-img-hov" alt="">
                                    <div class="col-md-8" id="Photo" style="text-align: center; display:none;"></div>
                                </div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>VMI:</label>
                                <textarea placeholder="Type your VMI here" name="summary_of_concern" rows="3" class="textarea-cus" style="padding-bottom: 15px" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="label-cus">Please indicate UPC Code or Item Description</label>
                                <input class="input-cus auto" placeholder="Search Item" id="search">
                                <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" style="display: none; top: 60px; left: 15px; width: 520px;">
                                    <li>Loading...</li>
                                </ul>
                            </div>

                            <div class="form-group-cus">
                                <div class="table-responsive" style="border: none">
                                    <div class="pic-container" style="border: none">
                                        <div class="pic-row" style="border: none">
                                            <table class="table table-bordered" id="pullout-items" style="border-radius: 10px; background-color:#ddd">
                                                <tbody>
                                                    <tr class="tbl_header_color dynamicRows">
                                                        <th width="20%" class="text-center">
                                                            <label class="label-cus">
                                                                <span class="requiredField">*</span>Digits Code
                                                            </label>
                                                        </th>
                                                        <th width="20%" class="text-center">
                                                            <label class="label-cus">
                                                                <span class="requiredField">*</span>UPC Code
                                                            </label>
                                                        </th>
                                                        <th width="44%" class="text-center">
                                                            <label for="" class="label-cus">
                                                                <span class="requiredField">*</span>{{ trans('labels.table.item_description') }}
                                                            </label>
                                                        </th>
                                                        <th width="15%" class="text-center">
                                                            <label class="label-cus">
                                                                <span class="requiredField">*</span>{{ trans('labels.table.serial_no') }}
                                                            </label>
                                                        </th>
                                                        <th width="1%" class="text-center">-</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-columns-cus" style="margin-bottom: 0px">
                        <div class="form-column-cus">
                            <div class="form-group-cus">
                                <label class="label-cus"><span class="requiredField">*</span>Problem Details:</label>
                                <select class="limitedNumbSelect2 input-cus" name="problem_details[]" data-placeholder="Choose problem details here..." id="problem_details" onchange="OtherProblemDetail()" multiple="multiple" style="width:100%;" required>
                                    @foreach($data['ProblemDetails'] as $key=>$pd)
                                    <option value="{{$pd->problem_details}}">{{$pd->problem_details}}</option>
                                    @endforeach
                                </select>
                                <div class="col-md-12" id="show_other_problem"></div>
                            </div>
                            <div class="form-group-cus">
                                <label class="label-cus">Other Remarks:</label>
                                <textarea placeholder="Type your other remarks here" name="other_remarks" rows="3" class="textarea-cus"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions-cus" style="margin-top: 0px">
                        <button type="button" id="prev-button" class="btn-secondary-cus">
                            <span class="arrow-icon">←</span>
                            Back to Customer Details
                        </button>
                        <input type="hidden" name="SubmitStatus" id="SubmitStatus"> 
                        <button type="submit" class="btn-primary-cus buttonSubmit" id="ToPayment"><i class="fa fa-plus" aria-hidden="true"></i> Create Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('bottom')
<script type='text/javascript'>
    @if (!empty($data['success']))
        swal("{{ $data['success'] }}");
    @endif

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $(document).ready(function () {
        $('input[name="warranty_status"]').change(function () {
            const warranty_status = $('input[name="warranty_status"]:checked').val();

            if (warranty_status === "OUT OF WARRANTY") {
                $('#model_class').removeClass('col-md-12').addClass('col-md-7');
                $('#unitt_type_class').addClass('col-md-5').show();
            } else {
                $('#model_class').removeClass('col-md-7').addClass('col-md-12');
                $('#unitt_type_class').removeClass('col-md-5').hide(); // Fix 'removedClass' typo
            }
        });
    });

    // get provinces
    $(document).ready(function() {
        $('#country').change(function() {
            let countryID = $(this).find(':selected').data('id');

            if (countryID) {
                $.ajax({
                    url: "{{ route('get_provinces') }}", 
                    type: "POST",
                    data: { country_id: countryID },
                    success: function(data) {
                        $('#province').prop('disabled', false);
                        $('#province').html('<option value="" selected disabled>Select province here...</option>');
                        $.each(data, function(key, value) {
                            $('#province').append('<option value="' + value.provDesc + '" data-id="' + value.provCode + '">' + value.provDesc + '</option>');
                        });
                    }
                });
            } else {
                $('#province').prop('disabled', true);
                $('#province').html('<option value="" selected disabled>Select province here...</option>');
            }
        });
    });

    // get cities 
    $(document).ready(function() {
        $('#province').change(function() {
            let provCode = $(this).find(':selected').data('id');

            if (provCode) {
                $.ajax({
                    url: "{{ route('get_cities') }}", 
                    type: "POST",
                    data: { prov_code: provCode },
                    success: function(data) {
                        $('#city').prop('disabled', false);
                        $('#city').html('<option value="" selected disabled>Select city here...</option>');
                        $.each(data, function(key, value) {
                            $('#city').append('<option value="' + value.citymunDesc + '" data-id="' + value.citymunCode + '" data-code="' + value.provCode + '">' + value.citymunDesc + '</option>');
                        });
                    }
                });
            } else {
                $('#city').prop('disabled', true);
                $('#city').html('<option value="" selected disabled>Select city here...</option>');
            }
        });
    });

    // get brgy 
    $(document).ready(function() {
        $('#city').change(function() {
            let citymunCode = $(this).find(':selected').data('id');
            let provCode = $(this).find(':selected').data('code');

            if (provCode && citymunCode) {
                $.ajax({
                    url: "{{ route('get_brgy') }}", 
                    type: "POST",
                    data: { city_mun_code: citymunCode, prov_code: provCode },
                    success: function(data) {
                        $('#barangay').prop('disabled', false);
                        $('#barangay').html('<option value="" selected disabled>Select barangay here...</option>');
                        $.each(data, function(key, value) {
                            $('#barangay').append('<option value="' + value.brgyDesc + '">' + value.brgyDesc + '</option>');
                        });
                    }
                });
            } else {
                $('#barangay').prop('disabled', true);
                $('#barangay').html('<option value="" selected disabled>Select barangay here...</option>');
            }
        });
    });

    $(document).ready(function() {
        function updateAddress() {
            let country = $('#country').val() || '';
            let province = $('#province').val() || '';
            let city = $('#city').val() || '';
            let barangay = $('#barangay').val() || '';
            let address_line = $('#address_line').val() || '';
            let fullAddress = `${address_line}, ${barangay}, ${city}, ${province}, ${country}`;

            $('#address').val(fullAddress.trim());
        }

        $('#country, #province, #city, #barangay, #address_line').on('input change', updateAddress);
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('.content-header').hide();

    // // Theme toggle functionality
    // const themeSwitch = document.getElementById("theme-switch")

    // // Check for saved theme preference or use preferred color scheme
    // const savedTheme = localStorage.getItem("theme")
    // const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches

    // if (savedTheme === "dark" || (!savedTheme && prefersDark)) {
    //     document.body.classList.add("dark-theme")
    //     themeSwitch.checked = true
    // }

    // themeSwitch.addEventListener("change", function () {
    //     if (this.checked) {
    //     document.body.classList.add("dark-theme")
    //     localStorage.setItem("theme", "dark")
    //     } else {
    //     document.body.classList.remove("dark-theme")
    //     localStorage.setItem("theme", "light")
    //     }
    // })

    // Multi-step form functionality
    const nextButton = document.getElementById("next-button")
    const prevButton = document.getElementById("prev-button")
    const step1 = document.getElementById("step-1")
    const step2 = document.getElementById("step-2")
    const steps = document.querySelectorAll(".step-cus")
    const progressFill = document.querySelector(".progress-fill-cus")
    const progressPercentage = document.getElementById("progress-percentage")

    nextButton.addEventListener("click", () => {
        // Basic validation for required fields
        const requiredFields = step1.querySelectorAll("[required]")
        let isValid = true

        requiredFields.forEach((field) => {
        if (!field.value.trim()) {
            isValid = false
            field.classList.add("invalid")
        } else {
            field.classList.remove("invalid")
        }
        })

        if (!isValid) {
            Swal.fire({
                title: "Required!",
                text: "Please fill in all required fields.",
                icon: "warning",
            });
            return;
        }

        // let email = $('#email').val();

        // if (email) {
        //     $.ajax({
        //         url: "{{ route('verify_email') }}", 
        //         type: "POST",
        //         data: { email: email },
        //         success: function(data) {
        //             if(data.valid_email){
        //                 // Move to step 2
        //                 step1.style.display = "none"
        //                 step2.style.display = "block"

        //                 // Update steps indicator
        //                 steps[0].classList.remove("active")
        //                 steps[1].classList.add("active")

        //                 // Update progress
        //                 progressFill.style.width = "50%"
        //                 progressPercentage.textContent = "50% Complete"
                        
        //                 $('#email').addClass('success-input');
        //                 $('#email').removeClass('error-input');
        //                 $('#email_status').text(data.valid_email).css('color','#00c853');
        //                 $('.success-icon-cus').show();
        //                 $('.error-icon-cus').hide();
        //             } else if (data.invalid_email){
        //                 console.log(data.invalid_email);
        //                 $('#email').addClass('error-input');
        //                 $('#email').removeClass('success-input');
        //                 $('#email_status').text(data.invalid_email).css('color','#ff4d4f');
        //                 $('.error-icon-cus').show();
        //                 $('.success-icon-cus').hide();
        //                 return;
        //             }
        //         }
        //     });
        // }
        step1.style.display = "none"
        step2.style.display = "block"

        // Update steps indicator
        steps[0].classList.remove("active")
        steps[1].classList.add("active")
    })

    prevButton.addEventListener("click", () => {
        // Move back to step 1
        step2.style.display = "none"
        step1.style.display = "block"

        // Update steps indicator
        steps[1].classList.remove("active")
        steps[0].classList.add("active")
    })

    // Add input validation styling
    const inputs = document.querySelectorAll("input, textarea")

        inputs.forEach((input) => {
            input.addEventListener("blur", function () {
            if (this.hasAttribute("required") && !this.value.trim()) {
                this.classList.add("invalid")
            } else {
                this.classList.remove("invalid")
            }
            })
        })
    })

    document.addEventListener("DOMContentLoaded", () => {
        let progressFill = document.querySelector(".progress-fill-cus");
        let progressPercentage = document.getElementById("progress-percentage");

        // field names 
        const fields = [
            "first_name", "last_name", "email", "company_name", "company_contact_no", 
            "country", "province", "city", "barangay", "address_line"
        ];

        function updateProgress() {
            let filledCount = 0;

            // Count filled fields
            fields.forEach(field => {
                let input = $(`[name="${field}"]`);
                if (input.is("select")) {
                    // Check if a value is selected in a <select> field
                    if (input.val() && input.val() !== "") {
                        filledCount++;
                    }
                } else {
                    // Check for text input fields
                    if (input.val().trim().length > 0) {
                        filledCount++;
                    }
                }
            });

            // Calculate progress dynamically
            let progress = (filledCount / fields.length) * 50;

            // Update progress bar
            progressFill.style.width = `${progress}%`;
            progressPercentage.textContent = `${progress.toFixed(1)}% Complete`;
        }

        // Attach event listeners for text inputs
        fields.forEach(field => {
            let input = $(`[name="${field}"]`);

            if (input.is("select")) {
                // For standard <select> elements
                input.on("change", updateProgress);
                
                // If using Select2, listen for the Select2-specific event
                input.on("select2:select", updateProgress);
            } else {
                // For text inputs
                input.on("input", updateProgress);
            }
        });
    });

</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@include('frontliner.create_transactions_script')
@endpush