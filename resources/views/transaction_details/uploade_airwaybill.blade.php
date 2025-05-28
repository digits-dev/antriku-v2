@push('head')
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.2/sweetalert2.min.css">

    <style>
         .upload-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
            text-align: center;
        }

        .upload-header {
            margin-bottom: 30px;
        }

        .upload-title {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .upload-subtitle {
            color: #718096;
            font-size: 16px;
        }

        .upload-area {
            border: 3px dashed #e2e8f0;
            border-radius: 16px;
            padding: 60px 20px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            background: #f8fafc;
        }

        .upload-area:hover {
            border-color: #111827;
            background: #f0f4ff;
            transform: translateY(-2px);
        }

        .upload-area.dragover {
            border-color: #111827;
            background: #f0f4ff;
            transform: scale(1.02);
        }

        .upload-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #111827, #374151);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .upload-text {
            font-size: 18px;
            color: #4a5568;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .upload-hint {
            color: #a0aec0;
            font-size: 14px;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .browse-button {
            background: linear-gradient(135deg, #111827, #374151);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .browse-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .file-list {
            margin-top: 20px;
            text-align: left;
        }

        .file-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .file-item:hover {
            background: #f0f4ff;
            border-color: #667eea;
        }

        .file-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background: #ef4444;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
            font-size: 12px;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
            word-break: break-all;
        }

        .file-size {
            color: #718096;
            font-size: 14px;
        }

        .remove-button {
            background: #fed7d7;
            color: #e53e3e;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .remove-button:hover {
            background: #feb2b2;
            transform: scale(1.1);
        }

        .upload-button {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .upload-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
        }

        .upload-button:disabled {
            background: #e2e8f0;
            color: #a0aec0;
            cursor: not-allowed;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            margin-top: 15px;
            overflow: hidden;
            display: none;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            width: 0%;
            transition: width 0.3s ease;
        }

        .error-message {
            background: #fed7d7;
            color: #e53e3e;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
            display: none;
        }

        .success-message {
            background: #c6f6d5;
            color: #2f855a;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
            display: none;
        }

        @media (max-width: 480px) {
            .upload-container {
                padding: 30px 20px;
            }
            
            .upload-area {
                padding: 40px 15px;
            }
            
            .upload-title {
                font-size: 24px;
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
        @endif
        @if (in_array($transaction_details->repair_status, [16, 25]))
            <div class="upload-receipt" style="flex-direction: column;">
                <div class="info-grid-cust">
                    <div class="info-item-cust" style="width: 800px;">
                        <div class="info-label-cust">Airwaybill Tracking Number</div>
                        <div class="info-value-cust">{{ $transaction_details->airwaybill_tn ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="upload-container">
                    <div class="upload-header">
                        <h1 class="upload-title">Upload PDF Files</h1>
                        <p class="upload-subtitle">Drag and drop your PDF files here or click to browse</p>
                    </div>

                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">📄</div>
                        <div class="upload-text">Drop your PDF files here</div>
                        <div class="upload-hint">or click to browse from your computer</div>
                        <input type="file" class="file-input" id="waybill" accept=".pdf" multiple>
                        <button type="button" class="browse-button" onclick="document.getElementById('waybill').click()">
                            Browse Files
                        </button>
                    </div>

                    <div class="file-list" id="fileList"></div>

                    <div class="progress-bar" id="progressBar">
                        <div class="progress-fill" id="progressFill"></div>
                    </div>

                    <div class="error-message" id="errorMessage"></div>
                    <div class="success-message" id="successMessage"></div>

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
                <div class="info-grid-cust">
                    <div class="info-item-cust">
                        <div class="info-label-cust">Airwaybill Tracking Number</div>
                        <div class="info-value-cust">{{ $transaction_details->airwaybill_tn ?? 'N/A' }}</div>
                    </div>
                    <div class="file-info">
                        <div class="file-icon">PDF</div>
                        <div class="file-details" style="display: flex; align-items: center; gap: 10px;">
                            <div class="file-name">
                                @php
                                    $filename = $transaction_details->airwaybill_upload;
                                    $parts = explode('_', $filename);
                                    $displayName = isset($parts[2]) ? implode('_', array_slice($parts, 2)) : $filename;
                                    $downloadUrl = Storage::url('waybill_upload/' . $filename);
                                @endphp
                                {{ $displayName }}
                            </div>
                            <a href="{{ $downloadUrl }}" title="Download" download style="color: inherit; text-decoration: none; margin-left:15px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5V13a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V10.4a.5.5 0 0 1 1 0V13a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V10.4a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M7.646 10.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 1 0-.708-.708L8.5 9.293V1.5a.5.5 0 0 0-1 0v7.793L5.354 7.146a.5.5 0 1 0-.708.708l3 3z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endif
<div id="myModal" class="modal-view">
    <span class="close">&times;</span>
    <img class="modal-content-view" id="img01">
    <div id="caption"></div>
  </div>
@push('bottom')
    <script type="text/javascript">
          const uploadArea = document.getElementById('uploadArea');
        const waybill = document.getElementById('waybill');
        const fileList = document.getElementById('fileList');
        const uploadButton = document.getElementById('uploadButton');
        const progressBar = document.getElementById('progressBar');
        const progressFill = document.getElementById('progressFill');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');

        let selectedFiles = [];

        // Drag and drop functionality
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = Array.from(e.dataTransfer.files).filter(file => file.type === 'application/pdf');
            addFiles(files);
        });

        // File input change
        waybill.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            addFiles(files);
        });

        function addFiles(files) {
            hideMessages();
            
            const pdfFiles = files.filter(file => file.type === 'application/pdf');
            
            if (pdfFiles.length !== files.length) {
                showError('Only PDF files are allowed');
                return;
            }

            pdfFiles.forEach(file => {
                if (!selectedFiles.find(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });

            renderFileList();
            updateUploadButton();
        }

        function renderFileList() {
            fileList.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <div class="file-info">
                        <div class="file-icon">PDF</div>
                        <div class="file-details">
                            <div class="file-name">${file.name}</div>
                            <div class="file-size">${formatFileSize(file.size)}</div>
                        </div>
                    </div>
                    <button type="button" class="remove-button" onclick="removeFile(${index})">×</button>
                `;
                fileList.appendChild(fileItem);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            renderFileList();
            updateUploadButton();
            hideMessages();
        }

        function updateUploadButton() {
            uploadButton.disabled = selectedFiles.length === 0;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
            successMessage.style.display = 'none';
        }

        function showSuccess(message) {
            successMessage.textContent = message;
            successMessage.style.display = 'block';
            errorMessage.style.display = 'none';
        }

        function hideMessages() {
            errorMessage.style.display = 'none';
            successMessage.style.display = 'none';
        }

        // Upload functionality
        uploadButton.addEventListener('click', () => {
            if (selectedFiles.length === 0) return;

            progressBar.style.display = 'block';
            uploadButton.disabled = true;
            hideMessages();

            // Simulate upload progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    
                    setTimeout(() => {
                        progressBar.style.display = 'none';
                        progressFill.style.width = '0%';
                        showSuccess(`Successfully uploaded ${selectedFiles.length} file(s)!`);
                        selectedFiles = [];
                        renderFileList();
                        updateUploadButton();
                        waybill.value = '';
                    }, 500);
                }
                progressFill.style.width = progress + '%';
            }, 200);
        });
        

    </script>
@endpush
