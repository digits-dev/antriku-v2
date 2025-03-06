<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
    
    
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>  -->
    
    <style>
        body {
            overflow-x: hidden;
            background-image: url("{{asset('uploads/2021-08/5a8b7d98bfaf1b5bb5141669236e622a.jpg')}}");
            -webkit-background-size: cover;
            -moz-background-size:  cover;
            -o-background-size: cover;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
        .card {
            padding: 20px;
            margin-top: 20px;
            margin-bottom: 60px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
        }

        .form-control-label {
            margin-bottom: 0
        }

        input,
        textarea,
        button {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 18px !important;
            font-weight: 300
        }

        input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #00BCD4;
            outline-width: 0;
            font-weight: 400
        }

        .btn-block {
            text-transform: uppercase;
            font-size: 15px !important;
            font-weight: 400;
            height: 43px;
            cursor: pointer
        }

        .btn-block:hover {
            color: #fff !important
        }

        button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0
        }

        .requiredField {
            color:red !important;
            font-weight: bold;
        }

        .table-bordered-display { 
            border: 1px solid #B8B8B8 !important;
            padding: 5px;
        }

        .MainScreen .ActionButtons {
    text-align: center;
    background: blueviolet;
}
    </style>
</head>

<body>
    <div class="container-fluid px-1 py-3 mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-10 col-12 text-center">
                <img src="{{asset('uploads/2021-08/7490c5fe894ec42ddfd9eacbf01e958b.png')}}" style="align:middle;width:50%;height:auto;">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row justify-content-between text-left">
                                <label class="col-sm-12 flex-column d-flex"><strong>Payment Information:</strong></label>
                                <div class="col-sm-12 flex-column d-flex">
                                    <table>
                                        <tbody>
                                            <tr style="width: 100%;">
                                                <td class="table-bordered-display col-sm-6"><span>Reference Number: </span></td>
                                                <td class="table-bordered-display col-sm-6"><span><strong>{{$data['transaction_details']->reference_no}}</strong></span></td>
                                            </tr>
                                            <tr style="width: 100%;">
                                                <td class="table-bordered-display col-sm-6"><span>Description: </span></td>
                                                <td class="table-bordered-display col-sm-6">
                                                    @if($data['transaction_details']->repair_status == 8)
                                                        <span>Diagnostic Fee</span> 
                                                    @elseif($data['transaction_details']->repair_status == 2)
                                                        <span>Down Payment Fee</span> 
                                                    @elseif($data['transaction_details']->repair_status == 7)
                                                        <span>Final Payment Fee</span> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr style="width: 100%;">
                                                <td class="table-bordered-display col-sm-6"><span>Amount: </span></td>
                                                <td class="table-bordered-display col-sm-6">
                                                    @if($data['transaction_details']->repair_status == 8)
                                                        <span>₱{{$data['transaction_details']->diagnostic_cost}}</span>
                                                    @elseif($data['transaction_details']->repair_status == 2)
                                                        <span>₱{{$data['transaction_details']->downpayment_cost}}</span>
                                                    @elseif($data['transaction_details']->repair_status == 7)
                                                        <span>₱{{$data['transaction_details']->final_payment_cost}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-between text-left">
                                <label class="col-sm-12 flex-column d-flex"><strong>Billing Details:</strong></label>
                                <div class="col-sm-12 flex-column d-flex">
                                    <table>
                                        <tbody>
                                            <tr style="width: 100%;">
                                                <td class="table-bordered-display col-sm-6"><span>Name: </span></td>
                                                <td class="table-bordered-display col-sm-6"><span>{{$data['transaction_details']->first_name}} {{$data['transaction_details']->last_name}}</span></td>
                                            </tr>
                                            <tr style="width: 100%;">
                                                <td class="table-bordered-display col-sm-6"><span>Email: </span></td>
                                                <td class="table-bordered-display col-sm-6"><span>{{$data['transaction_details']->email}}</span></td>
                                            </tr>
                                            <tr style="width: 100%;">
                                                <td class="table-bordered-display col-sm-6"><span>Contact Number: </span></td>
                                                <td class="table-bordered-display col-sm-6"><span>{{$data['transaction_details']->contact_no}}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br><br>
                        </div>
                        <div class="col-sm-6" style="border-left: 1px solid #B8B8B8 !important;">
                            <div class="row text-center mb-4 w-100" >
                                    @if($data['transaction_details']->repair_status == 8)
                                        <h1 style="width: 100%;margin-bottom: unset !important;"> ₱ {{$data['transaction_details']->diagnostic_cost}}</h1>
                                    @elseif($data['transaction_details']->repair_status == 2)
                                         <h1 style="width: 100%;margin-bottom: unset !important;"> ₱ {{$data['transaction_details']->downpayment_cost}}</h1>
                                    @elseif($data['transaction_details']->repair_status == 7)
                                         <h1 style="width: 100%;margin-bottom: unset !important;"> ₱ {{$data['transaction_details']->final_payment_cost}}</h1>
                                    @endif
                                <span style="width: 100%;">Amount to Pay</span>
                                <img class="m-auto" src="{{asset('img/payment.png')}}" alt="Merchant Equipment Store Credit Card Logos"/>
                            </div>

                            @if(Session::get('success'))
                                <!-- <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>Failed to Submit. {{ session('success') }}</strong>
                                </div> -->
                                <div class="row justify-content-between text-left">
                                    <img class="m-auto" style="max-height:100px;" src="{{asset('img/Green-Round-Tick.png')}}" alt="Success Payment"/>
                                </div>
                                <div class="row justify-content-between text-center" style="margin-top:15px;display:block;">
                                    <strong>{{ session('success') }}</strong>
                                </div>
                            @else

                                <input type="hidden" value="{{ Session::get('pending_payment')['payment_intent_id'] }}" id="payment_intent">
                                <input type="hidden" value="{{ $data['transaction_details']->header_id }}" id="header_id">

                                {{-- <!-- @if($message = Session::get('failed'))
                                    <div class="alert alert-danger"><strong>{{ session('failed') }}</strong></div>
                                @endif -->  --}}

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                
                                @if(Session::get('pending_payment'))
                                    <script>
                                        $(window).load(function(){        
                                            $('#ConfirmPaymentModal').modal('show');
                                        }); 

                                        var payment_intent = document.getElementById("payment_intent").value;
                                        var header_id = document.getElementById("header_id").value;
                                        var monitor = setInterval(function(){
                                            var elem = document.activeElement;
                                            if(elem && elem.tagName == 'IFRAME')
                                            {
                                                $.ajax
                                                ({ 
                                                    url: "{{ URL::to('/CheckPaymentIntent')}}",
                                                    type: "POST",
                                                    data: {
                                                        'header_id': header_id,
                                                        'payment_intent': payment_intent,
                                                        _token: '{!! csrf_token() !!}'
                                                        },
                                                    success: function(result)
                                                    { 
                                                        if($.trim(result)){
                                                            clearInterval(monitor);
                                                        }
                                                    }
                                                });     
                                            }
                                        }, 100);
                                    </script>
                                @endif 

                                <div id="ConfirmPaymentModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float:right;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div tabindex="-1" class="ant-modal-wrap " role="dialog">
                                                    <div role="document" class="ant-modal" style="width: auto;">
                                                        <div tabindex="0" aria-hidden="true" style="width: 0px; height: 0px; overflow: hidden;"></div>
                                                        <div class="ant-modal-content">
                                                            <div class="banner"  bannerid="yyy">
                                                                <iframe src="{{ Session::get('pending_payment')['payment_url'] }}" id="myframe" title="3D Secure" style="width: 100%; height: 70vh; border: 0px;"></iframe>
                                                            </div>
                                                            <div class="ant-modal-footer">
                                                                <button type="button" class="ant-btn" data-dismiss="modal">
                                                                    <span>Close</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div tabindex="0" aria-hidden="true" style="width: 0px; height: 0px; overflow: hidden;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form method="post" action="/payment-gateway-process/{{$data['transaction_details']->header_id}}">                    
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-12 flex-column d-flex"> 
                                            <label class="form-control-label px-3">Card Number<span class="requiredField"> *</span></label> 
                                            <input type="text" id="cardnumber" name="cardnumber" placeholder="Card Number" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex"> 
                                            <label class="form-control-label px-3"> Month and Year<span class="requiredField"> *</span></label> 
                                            <input type="text" id="monthyear" name="monthyear" placeholder="MM/YY" class="form-control" required> 
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex"> 
                                            <label class="form-control-label px-3">CVC<span class="requiredField"> *</span></label> 
                                            <input type="text" id="cvc" name="cvc" placeholder="123" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="form-group col-sm-6"> 
                                            <button type="submit" id="submit_btn" class="btn-block btn-success" onclick="return SubmitForm()">Pay</button> 
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

    // Validating null or empty value
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }

    // Validate card number
    function validateCreditCardNumber(cardNumber) 
    {
        cardNumber = cardNumber.split(' ').join("");
        if (parseInt(cardNumber) <= 0 || (!/\d{15,16}(~\W[a-zA-Z])*$/.test(cardNumber)) || cardNumber.length > 16) {
            return false;
        }
        var carray = new Array();
        for (var i = 0; i < cardNumber.length; i++) {
            carray[carray.length] = cardNumber.charCodeAt(i) - 48;
        }
        carray.reverse();
        var sum = 0;
        for (var i = 0; i < carray.length; i++) {
            var tmp = carray[i];
            if ((i % 2) != 0) {
                tmp *= 2;
                if (tmp > 9) {
                    tmp -= 9;
                }
            }
            sum += tmp;
        }
        return ((sum % 10) == 0);
    }

    // Validate Card Type
    function cardType(cardNumber)
    {
        cardNumber = cardNumber.split(' ').join("");
        var o = {
            electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
            maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
            dankort: /^(5019)\d+$/,
            interpayment: /^(636)\d+$/,
            unionpay: /^(62|88)\d+$/,
            visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
            mastercard: /^5[1-5][0-9]{14}$/,
            amex: /^3[47][0-9]{13}$/,
            diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
            discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
            jcb: /^(?:2131|1800|35\d{3})\d{11}$/
        }
        for(var k in o) {
            if(o[k].test(cardNumber)) {
                return k;
            }
        }
        return null;
    }

    // Month and Year Format
    function matchesMonthAndYear(input){
        return /^(0[1-9]|1[0-2])\/\d{2}$/.test(input);
    }

    function SubmitForm() 
    {
        var cardnumber = document.getElementById("cardnumber").value;
        var monthyear = document.getElementById("monthyear").value;
        var cvc = document.getElementById("cvc").value;

        if(cardnumber == ""){
            alert('Card Number is required.');
            return false;
        }else if(monthyear == ""){
            alert('Month/Year is required.');
            return false;
        }else if(cvc == ""){
            alert('CVC is required.');
            return false;
        }else if(matchesMonthAndYear(monthyear) == false){
            alert('Please enter a valid date in MM/YY format.');
            return false;
        }else{
            return true;
        }

    }

</script>
</html>
