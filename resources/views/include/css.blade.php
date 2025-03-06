<style>
    .limitedNumbChosen, .limitedNumbSelect2{
        width: 400px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid slategray !important;
    }
    /* .select2-container--default .select2-selection--multiple {
        border: 1px solid #d2d6de !important;
    } */
    .select2-container {
        width: 100% !important;
    }
    .form-control {
        border-color: slategray;
    }

    .requiredField {
        color:red !important;
        font-weight: bold;
    }

    .error-content {
        display: block;
        margin-top: 3px;
        color: red !important;
        font-size: 0.9em;
        font-weight: bolder;
        margin-left: 3px;
        line-height: 1.5 !important;
    }

    .fixed-textarea {
        resize: none;
    }

    .comment-col {
        height:  300px;
        border: 1px solid #ccc;
        border-color: slategray; 
        padding: 11px 25px 0 30px; 
        overflow-y: scroll;
        display: flex;
        flex-direction: column-reverse;

    }
    .comment-cloud {
        /* border: 1px solid #27CBD3;  */
        color: white;
        background: #4B79A1; 
        background: -webkit-linear-gradient(to right, #283E51, #4B79A1); 
        background: linear-gradient(to right, #283E51, #4B79A1);
        font-family: system-ui;
        margin-bottom: 20px; 
        padding: 5px; 
        border-radius: 10px; 
        height:auto; 
        overflow-wrap: break-word;
        width:75%;
    }
    .comment-date {
        margin: 0 !important; 
        font-size: 11px; 
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: white !important;
        pointer-events: none !important;
        opacity: 0.5 !important;
    }
    .no-comment {
        text-align: center;margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        color: slategrey;
    }

    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    .text-primary {
        color: #1266F1 !important;
    }

    .text-info {
        color: #39C0ED !important;
    }

    .text-success {
        color: #00B74A !important;
    }

    .text-warning {
        color: #FFA900 !important;
    }

    .text-danger {
        color: #F93154 !important;
    }

    .input-icon {
        position: relative;
    }

    .input-icon > i {
        position: absolute;
        display: block;
        transform: translate(0, -50%);
        top: 50%;
        pointer-events: none;
        width: 25px;
        text-align: center;
        font-style: normal;
    }

    .input-icon > input {
        padding-left: 25px;
        padding-right: 0;
    }

    .input-icon-right > i {
        right: 0;
    }

    .input-icon-right > input {
        padding-left: 0;
        padding-right: 25px;
        text-align: right;
    }
    
    .center-img {
        height: 80%;
        max-width: 100%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .table-bordered-display { border: 1px solid #B8B8B8 !important; }

    .btn-default {
        border-color: #B8B8B8 !important;
    }

    .diagnose-header {
        background: #4B79A1; 
        background: -webkit-linear-gradient(to right, #283E51, #4B79A1); 
        background: linear-gradient(to right, #283E51, #4B79A1);
        padding: 6px;
        color:white;
        text-align:center;
    }

    .borderline {
        border-top-style: solid;
        border-top-color: #B8B8B8;
        border-top-width: 1px;
        padding-top: 10px;
    }
   
    .sparepartlist{
        border: 1px solid slategray !important;
        position: absolute;
        display:none; 
        min-width: 170px;
        width: auto;
        height: auto;
        white-space: nowrap;
    }

    .li-padding {
        padding: 3px 5px;
    }
    
    .li-padding:hover {
        background-color: #3c8dbc;
        color:white;
    }
    
    .body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
    }
    
    .sweet-alert button.cancel {
        color: #fff;
        background-color: #d9534f !important;
        border-color: #d43f3a !important;
    }
    
    .ui-widget.ui-widget-content {
        height:auto;
        max-height:300px; 
        overflow: hidden visible;
    }
</style>