@push('head')
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.2/sweetalert2.min.css">

@endpush

@if(request()->segment(3) == "edit" && in_array($transaction_details->repair_status, [20, 21]))
<div class="row">
    <div class="col-md-12">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card-header-cust">
                    <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
                        <i class="bi bi-tools"></i>
                    </div>
                    Replacement Parts Fee
                </div>
            </div> 
        </div> 
        
        <div class="upload-receipt">
                <div class="upload-card">
                    <span class="header">Upload RPF Invoice</span>
                    <p> Upload image (Invoice).</p>
                    <div class="upload-file-container">
                        <label for="rpf_invoice" id="drop-area-rpf-invoice" class="drop-area">
                            <input required id="rpf_invoice" name="rpf_invoice" type="file" accept="image/*"
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
            <div class="preview" id="preview">
                <span class="header">RPF Invoice Image Preview</span>
                <p>View and verify your RPF invoice image before uploading</p>
                <div class="image-preview" id="image-preview">
                    <div id="no-receipt-message" style="font-size: 14px; color: #777;">
                        <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 40px"></i>
                        <p  class="header">
                            No Image Selected
                        </p>
                        <p>
                            Upload an RPF invoice using the form on the left to see a preview here
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@else
    @if (!is_null($transaction_details->rpf_invoice))
    <div class="row">
        <div class="col-md-12">
            <div class="row"> 
                <div class="col-md-12">
                    <div class="card-header-cust">
                        <div style="background: rgba(255, 255, 255, 0.911); padding: 2px 7px 2px 7px; border-radius: 20%; margin-right: 3px">
                            <i class="bi bi-tools"></i>
                        </div>
                        Replacement Parts Fee
                    </div>
                </div> 
            </div> 
            <div class="card-body-cust">
                <div class="info-label-cust">RPF Invoice</div>
                <div class="uploaded-image-container">
                    <img class="uploaded-image" src="{{ Storage::url('rpf_invoice/' . $transaction_details->rpf_invoice) }}" alt="rpf_invoice">
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
            const inputFileRPF = $("#rpf_invoice");
            const imageView = $("#image-preview");
            const removeBtn = $("#remove-btn");
            const fileNameText = $("#file-name");
            const fileInfo = $(".file-info");
            const uploadText = $("#upload-text");
            const noReceiptMessage = $("#no-receipt-message");
            const modal = $("#myModal");
            const modalImg = $("#img01");
            const captionText = $("#caption");

  

            inputFileRPF.on("change", uploadImageRPF);
            removeBtn.on("click", removeImage);
     
            function uploadImageRPF() {
                $(".image-upload").remove();
                let file = inputFileRPF.prop("files")[0]; 

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
                inputFileRPF.val(""); 
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


        $('#drop-area-rpf-invoice').on('dragover', function(e) {
            e.preventDefault();
            dropArea.addClass("drag-over");
        })
        $('#drop-area-rpf-invoice').on("dragleave", function(e) {
            e.preventDefault();
            dropArea.removeClass("drag-over");
            imageView.removeClass("drag-over");
        });

        $('#drop-area-rpf-invoice').on('drop', function(e) {
            e.preventDefault();
            dropArea.removeClass("drag-over"); 
            imageView.addClass("drag-over"); 

            const droppedFiles = e.originalEvent.dataTransfer.files;
            if (droppedFiles.length > 0) {
                inputFileRPF.prop("files", droppedFiles);
                uploadImageRPF();
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
