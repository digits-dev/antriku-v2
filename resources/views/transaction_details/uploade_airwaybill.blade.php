@push('head')
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.2/sweetalert2.min.css">

    <style type="text/css">
        .u-input:read-only {
            background-color: #eee;
        }

        .container {
            width: 100%;
        }

        .flex {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .upload-card {
            display: flex;
            flex-direction: column;
            padding: 20px;
            /* border: 2px solid #8c8c8c; */
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
            border-radius: 5px;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .upload-file-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #drop-area-waybill {
            width: 500px;
            height: 150px;
            background: #fff;
            text-align: center;
            border-radius: 20px;
        }

        .image-preview {
            position: relative;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-content: center;
            border-radius: 20px; 
            border: 2px dashed #888888;
            height: 100%;
            width: 100%;
            text-align: center;
        }

       
        .image-upload{
            max-width: 100%;
            height: 270px;
            margin: 5px;
        }

        .image-view {
            display: flex;
            justify-content: center;
            align-content: center;
            flex-direction: column;
            flex-wrap: wrap;
            width: 100%;
            height: 150px;
            overflow: auto;
            border-radius: 20px;
            border: 2px dashed #888888;
            padding: 30px 30px;
            background-position: center;
            background-size: cover;
            cursor: pointer;
        }

        .image-view img {
            max-width: 100%;
            height: auto;
            margin: 5px;
        }

        .drag-over {
            background-color: #e6f1ff;
        }


        .input_container {
            border: 1px solid #e5e5e5;
            width: 80%;
        }

        .upload-receipt {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            gap: 20px;
            padding: 20px;
        }
    
        .preview {
            display: flex;
            flex-direction: column;
            padding: 20px;
            height: 400px;
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
            border-radius: 5px;
        }
        .header {
            font-size: 20px;
            font-weight: bold;
        }
        .pdf_logo {
            justify-content: center;
            background-color: #ffcabb;
            padding: 10px;
            border-radius: 10px;
            width: 50px;
            height: 50px;
        }
        .file-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%; 
            padding: 5px 10px;
        }

        .logo_file_name {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        .modal {
            display: none;
            position: fixed; 
            z-index: 1; 
            padding-top: 100px; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.9); 
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            height: 500px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {  
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)} 
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)} 
            to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #ffffff;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
        }
        </style>
@endpush

@if(request()->segment(3) == "edit" && in_array($transaction_details->repair_status, [15, 16, 24, 25]))
<div class="row">
    <div class="col-md-12">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card-header-cust">
                    <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
                        <i class="bi bi-tools"></i>
                    </div>
                    Airwaybill 
                </div>
            </div> 
        </div> 
      
        @if (is_null($transaction_details->airwaybill_tn))
        <div class="col-md-12" style="margin: 10px;" >
            <div style="width: 50%;">
                <label class="label-cus" style="margin-bottom: 6px;">
                    <span class="required">*</span> Airwaybill Tracking Number
                </label>
                <input type="text" name="airwaybill_tn" placeholder="Enter Airwaybill Tracking Number"
                       class="input-cus" autocomplete="off" required />
            </div>
        </div>
        <br>
        @else
   
        @endif
        @if (in_array($transaction_details->repair_status, [16, 25]))
        <div class="upload-receipt">
            <div>
                <div class="info-grid-cust">
                    <div class="info-item-cust">
                        <div class="info-label-cust">Airwaybill Tracking Number</div>
                        <div class="info-value-cust">{{ $transaction_details->airwaybill_tn ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="upload-card">     
                    <span class="header">Upload Airwaybill</span>
                    <p> Upload image (waybill).</p>
                    <div class="upload-file-container">
                        <label for="waybill" id="drop-area-waybill">
                            <input required id="waybill" name="waybill" type="file" accept="image/*"
                            style="position: absolute; z-index: -1;">
                            <div class="image-view" id="image-view">
                                <div id="upload-text">
                                    <p style="color:#424242">Drag and drop or click here to upload</p>
                                    <span style="font-size: 12px; color: #777;">Upload any file from desktop</span>
                                </div>
                                <div class="file-info" style="display: none; margin-top: 10px;">
                                    <div class="logo_file_name">
                                        <div class="flex pdf_logo">
                                            <span style="font-weight: bold; color: rgb(100, 100, 100);">IMG</span>
                                        </div>
                                        <p id="file-name" style="display: none; margin-top: 10px; text-align:left;"></p>
                                    </div>
                                    <button id="remove-btn" style="display: none; margin-top: 10px; padding: 5px 10px; background-color: #d9534f; color: white; border: none; cursor: pointer; border-radius: 5px; inline-flex items-center justify-center gap-2">
                                        X
                                    </button>
                                </div>
                            </div>
                            
                    </label>
                </div>
            </div>
            </div>
            <div class="preview" id="preview">
                <span class="header"> Airwaybill Image Preview</span>
                <p>View and verify your waybill image before uploading</p>
                <div class="image-preview" id="image-preview">
                    <div id="no-receipt-message" style="font-size: 14px; color: #777;">
                        <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 40px"></i>
                        <p  class="header">
                            No Image Selected
                        </p>
                        <p>
                            Upload a waybill using the form on the left to see a preview here
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
        @endif
    
    </div>
</div>
@else
    @if (!is_null($transaction_details->airwaybill_upload))
    <div class="row">
        <div class="col-md-12">
            <div class="row"> 
                <div class="col-md-12">
                    <div class="card-header-cust">
                        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
                            <i class="bi bi-tools"></i>
                        </div>
                        Uploaded Airwaybill
                    </div>
                </div> 
            </div> 
            <div class="card-body-cust">
                <div class="info-grid-cust" style="width: 50%;">
                    <div class="info-item-cust">
                        <div class="info-label-cust">Airwaybill Tracking Number</div>
                        <div class="info-value-cust">{{ $transaction_details->airwaybill_tn ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="uploaded-image-container">
                    <img class="uploaded-image" src="{{ Storage::url('waybill_upload/' . $transaction_details->airwaybill_upload) }}" alt="Airwaybill">
                </div>
            </div>
        </div>
    </div>
    @endif
@endif
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
  </div>
@push('bottom')
    <script type="text/javascript">
        $(document).ready(function() {
            const dropArea = $("#image-view");
            const inputFile = $("#waybill");
            const imageView = $("#image-preview");
            const removeBtn = $("#remove-btn");
            const fileNameText = $("#file-name");
            const fileInfo = $(".file-info");
            const uploadText = $("#upload-text");
            const noReceiptMessage = $("#no-receipt-message");
            const modal = $("#myModal");
            const modalImg = $("#img01");
            const captionText = $("#caption");

  

            inputFile.on("change", uploadImage);
            removeBtn.on("click", removeImage);
     
            function uploadImage() {
                $(".image-upload").remove();
                let file = inputFile.prop("files")[0]; 

                if (file && isImage(file.name)) {
                    let img = $("<img>").addClass("image-upload");
                    let imgLink = URL.createObjectURL(file);
                    img.attr("src", imgLink);
                img.attr("alt", file.name); 
                img.css("cursor", "pointer"); // Indicate clickable image

                img.on("click", function() {
                    openModal(imgLink, file.name);
                });
                    imageView.addClass("drag-over"); 
                    imageView.append(img);

                    fileNameText.text(file.name).show();
                    uploadText.hide();
                    removeBtn.show();
                    fileInfo.show();

                    noReceiptMessage.hide();
                } else {
                    removeImage();
                }
            }

            function removeImage() {
                inputFile.val(""); 
                fileInfo.hide();
                removeBtn.hide();
                uploadText.show();
                imageView.removeClass("drag-over");
                noReceiptMessage.show();
                $(".image-upload").remove();
            }

            
        function openModal(imgSrc, imgAlt) {
            modal.show();
            modalImg.attr("src", imgSrc);
            captionText.text(imgAlt);
        }

        $(".close").on("click", function() {
            modal.hide();
        });

        $(window).on("click", function(event) {
            if ($(event.target).is(modal)) {
                modal.hide();
            }
        });


        $('#drop-area-waybill').on('dragover', function(e) {
            e.preventDefault();
            dropArea.addClass("drag-over");
        })
        $('#drop-area-waybill').on("dragleave", function(e) {
            e.preventDefault();
            dropArea.removeClass("drag-over");
            imageView.removeClass("drag-over");
        });

        $('#drop-area-waybill').on('drop', function(e) {
            e.preventDefault();
            dropArea.removeClass("drag-over"); 
            imageView.addClass("drag-over"); 

            const droppedFiles = e.originalEvent.dataTransfer.files;
            if (droppedFiles.length > 0) {
                inputFile.prop("files", droppedFiles);
                uploadImage();
            }
        });

        });

        function isImage(filename) {
            const imageExtensions = ["jpg", "jpeg", "png", "gif", "bmp"];
            let ext = filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2).toLowerCase();
            return imageExtensions.includes(ext);
        }

    </script>
@endpush
