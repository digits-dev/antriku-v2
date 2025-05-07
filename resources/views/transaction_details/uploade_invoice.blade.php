@push('head')
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.2/sweetalert2.min.css">

@endpush

@if(request()->segment(3) == "edit" && in_array($transaction_details->repair_status, [8]))
<div class="row">
    <div class="col-md-12">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card-header-cust">
                    <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
                        <i class="bi bi-tools"></i>
                    </div>
                    Charges Fee
                </div>
            </div> 
        </div> 
        
        <div class="upload-receipt">
            <div>
                <div style="margin-bottom: 10px;">
                    <label class="label-cus" style="margin-bottom: 6px;">
                        <span class="required">*</span> Diagnostic Fee:
                    </label>
                    <input type="text" id="diagnostic_cost" name="diagnostic_cost" placeholder="Enter Diagnostic Fee"
                            class="input-cus" autocomplete="off" required />
                </div>
                <div style="margin-bottom: 10px;">
                    <label class="label-cus" style="margin-bottom: 6px;">
                        <span class="required">*</span> Invoice Number:
                    </label>
                    <input type="text" id="invoice_number" name="invoice_number" placeholder="Enter Invoice Number"
                            class="input-cus" autocomplete="off" required />
                </div>
                <div class="upload-card">
                    <span class="header">Upload Invoice</span>
                    <p> Upload image (Invoice).</p>
                    <div class="upload-file-container">
                        <label for="invoice" id="drop-area-invoice" class="drop-area">
                            <input required id="invoice" name="invoice" type="file" accept="image/*"
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
                <span class="header"> Invoice Image Preview</span>
                <p>View and verify your invoice image before uploading</p>
                <div class="image-preview" id="image-preview">
                    <div id="no-receipt-message" style="font-size: 14px; color: #777;">
                        <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 40px"></i>
                        <p  class="header">
                            No Image Selected
                        </p>
                        <p>
                            Upload an invoice using the form on the left to see a preview here
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@else
    @if (!is_null($transaction_details->invoice))
    <div class="row">
        <div class="col-md-12">
            <div class="row"> 
                <div class="col-md-12">
                    <div class="card-header-cust">
                        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
                            <i class="bi bi-tools"></i>
                        </div>
                        Charges Fee
                    </div>
                </div> 
            </div> 
            <div class="card-body-cust">
                <div class="info-grid-cust">
                    <div class="info-item-cust">
                        <div class="info-label-cust">Diagnostic Fee</div>
                        <div class="info-value-cust">{{ $transaction_details->diagnostic_cost ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item-cust">
                        <div class="info-label-cust">Invoice Number</div>
                        <div class="info-value-cust">{{ $transaction_details->invoice_number ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="info-label-cust">Invoice</div>
                <div class="uploaded-image-container">
                    <img class="uploaded-image" src="{{ Storage::url('invoice/' . $transaction_details->invoice) }}" alt="invoice">
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
            const inputFile = $("#invoice");
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


        $('#drop-area-invoice').on('dragover', function(e) {
            e.preventDefault();
            dropArea.addClass("drag-over");
        })
        $('#drop-area-invoice').on("dragleave", function(e) {
            e.preventDefault();
            dropArea.removeClass("drag-over");
            imageView.removeClass("drag-over");
        });

        $('#drop-area-invoice').on('drop', function(e) {
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
