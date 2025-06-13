@extends('crudbooster::admin_template')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .space-y-6>*+* {
            margin-top: 24px;
        }

        .space-y-4>*+* {
            margin-top: 16px;
        }

        .space-y-3>*+* {
            margin-top: 12px;
        }

        .space-y-2>*+* {
            margin-top: 8px;
        }

        /* Card */
        .card-sync {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .card-header-sync {
            padding: 8px 24px 0 24px;
        }

        .card-title-sync {
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .card-description-sync {
            color: #6b7280;
            font-size: 14px;
        }

        .card-content-sync {
            padding: 24px;
        }

        /* Form Elements */
        .form-grid-sync {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        @media (min-width: 768px) {
            .form-grid-sync {
                grid-template-columns: 1fr 1fr;
            }
        }

        .form-group-sync {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .label-sync {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .input-sync {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .input-sync:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .input-sync:disabled {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }

        /* Button */
        .button-sync {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            gap: 8px;
        }

        .button-primary-sync {
            background-color: #2563eb;
            color: white;
            flex: 1;
        }

        .button-primary-sync:hover:not(:disabled) {
            background-color: #1d4ed8;
        }

        .button-primary-sync:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }

        .button-outline-sync {
            background-color: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .button-outline-sync:hover {
            background-color: #f9fafb;
        }

        .button-group-sync {
            display: flex;
            gap: 12px;
        }

        /* Badge */
        .badge-sync {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            gap: 8px;
        }

        .badge-secondary-sync {
            background-color: #f3f4f6;
            color: #374151;
        }

        .badge-success-sync {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-error-sync {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .badge-info-sync {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-outline-sync {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
        }

        .badge-status-active-sync {
            background-color: #dcfce7;
            color: #166534;
        }

        /* Progress Bar */
        .progress-container-sync {
            width: 100%;
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-sync {
            height: 100%;
            background-color: #2563eb;
            transition: width 0.3s ease;
        }

        .progress-text-sync {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #6b7280;
        }

        /* Alert */
        .alert-sync {
            padding: 12px;
            border-radius: 6px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .alert-success-sync {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .alert-error-sync {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        /* Table */
        .table-container-sync {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: auto;
            height: 350px;
        }

        .table-sync {
            width: 100%;
            border-collapse: collapse;
        }

        .table-sync th {
            background-color: #f9fafb;
            padding: 12px;
            text-align: left;
            font-weight: 500;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-sync td {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .table-sync tr:last-child td {
            border-bottom: none;
        }

        .table-sync .text-right {
            text-align: right;
        }

        .table-sync .font-medium {
            font-weight: 500;
        }

        /* Icons */
        .icon-sync {
            width: 16px;
            height: 16px;
            display: inline-block;
        }

        .icon-lg-sync {
            width: 20px;
            height: 20px;
        }

        .icon-xl-sync {
            width: 24px;
            height: 24px;
        }

        .icon-2xl-sync {
            width: 48px;
            height: 48px;
        }

        /* Animations */
        .animate-spin-sync {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Skeleton Loading */
        .skeleton-sync {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 4px;
            height: 16px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Empty State */
        .empty-state-sync {
            text-align: center;
            padding: 32px;
            color: #6b7280;
        }

        .empty-state-sync .icon-2xl {
            margin: 0 auto 16px;
            opacity: 0.5;
        }

        .empty-state-sync p {
            margin-bottom: 4px;
        }

        .empty-state-sync .text-sm {
            font-size: 14px;
        }

        /* Utility Classes */
        .hidden {
            display: none;
        }

        .text-sm-sync {
            font-size: 14px;
        }

        .text-green-600-sync {
            color: #059669;
        }

        .text-red-600-sync {
            color: #dc2626;
        }

        .text-gray-500-sync {
            color: #6b7280;
        }

        .text-gray-600-sync {
            color: #6b7280;
        }

        .ml-2-sync {
            margin-left: 8px;
        }

        .mb-4-sync {
            margin-bottom: 16px;
        }

        .pt-6-sync {
            padding-top: 24px;
        }
    </style>
@endpush

@section('content')
    <div class="panel panel-default" style="margin: 0; padding:0">
        <div class="dashboard-title-content" style="margin: 15px 15px 0 15px;">
            <h1 class="dashboard-title">
                <span class="dashboard-title-icon">
                    <img src="https://cdn-icons-png.flaticon.com/128/9610/9610557.png" width="20px" alt="">
                </span>
                Spare Part Item Master Manual Sync
            </h1>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-sync">
                        <div class="card-header-sync">
                            <h2 class="card-title-sync">
                                <svg class="icon-lg-sync" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date Range Selection
                            </h2>
                            <p class="card-description-sync">Select the date range for synchronizing spare part item master
                                data</p>
                        </div>
                        <div class="card-content-sync space-y-6">
                            <!-- Date Inputs -->
                            <div class="form-grid-sync">
                                <div class="form-group-sync">
                                    <label for="dateFrom" class="label-sync">Date From</label>
                                    <input type="date" id="dateFrom" class="input-sync">
                                </div>
                                <div class="form-group-sync">
                                    <label for="dateTo" class="label-sync">Date To</label>
                                    <input type="date" id="dateTo" class="input-sync">
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                <span id="statusBadge" class="badge-sync badge-secondary-sync">
                                    <svg class="icon-sync" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Ready to sync</span>
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div id="progressSection" class="hidden space-y-2">
                                <div class="progress-text-sync">
                                    <span>Syncing records...</span>
                                    <span id="progressPercent">0%</span>
                                </div>
                                <div class="progress-container-sync">
                                    <div id="progressBar" class="progress-bar-sync" style="width: 0%"></div>
                                </div>
                                <p class="text-sm-sync text-gray-500-sync">
                                    <span id="recordsProcessed">0</span> records processed
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="button-group-sync">
                                <button id="syncButton" class="button-sync button-primary-sync">
                                    <svg class="icon-sync" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Start Sync
                                </button>
                                <button id="resetButton" class="button-sync button-outline-sync hidden">Reset</button>
                            </div>

                            <!-- Success/Error Messages -->
                            <div id="successAlert" class="alert-sync alert-success-sync hidden">
                                <svg class="icon-sync" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span id="successMessage"></span>
                            </div>

                            <div id="errorAlert" class="alert-sync alert-error-sync hidden">
                                <svg class="icon-sync" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Sync failed. Please ensure both date fields are filled and the date range is
                                    valid.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="previewCard" class="card-sync">
                        <div class="card-header-sync">
                            <h2 class="card-title-sync">
                                <svg class="icon-lg-sync" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Data Preview
                                <span id="previewCount" class="badge-sync badge-secondary-sync ml-2-sync hidden"></span>
                            </h2>
                            <p class="card-description-sync">Preview of spare part items that will be synchronized for the
                                selected date range</p>
                        </div>
                        <div class="card-content-sync">
                            <!-- Loading Skeleton -->
                            <div id="previewLoading" class="space-y-3 hidden">
                                <div class="skeleton-sync"></div>
                                <div class="skeleton-sync"></div>
                                <div class="skeleton-sync"></div>
                                <div class="skeleton-sync"></div>
                            </div>

                            <!-- Data Table -->
                            <div id="previewTable" class="table-container-sync hidden">
                                <table class="table-sync">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase"><b>Digits Code</b></th>
                                            <th class="text-uppercase"><b>Spare Part</b></th>
                                            <th class="text-uppercase"><b>Item Description</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="previewTableBody">
                                    </tbody>
                                </table>
                            </div>

                            <!-- Empty State -->
                            <div id="previewEmpty" class="empty-state-sync ">
                                <img src="https://cdn-icons-png.flaticon.com/128/7486/7486754.png" width="70px"
                                    alt="">
                                <p>No spare part items found for the selected date range</p>
                                <p class="text-sm">Try adjusting your date selection</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('bottom')
<script>
    $(document).ready(function() {
        // State management
        const syncState = {
            status: "idle",
            progress: 0,
            syncedRecords: 0,
            previewData: [],
        };

        // DOM elements (jQuery objects)
        const $domElements = {
            dateFromInput: $('#dateFrom'),
            dateToInput: $('#dateTo'),
            statusBadge: $('#statusBadge'),
            progressSection: $('#progressSection'),
            progressBar: $('#progressBar'),
            progressPercent: $('#progressPercent'),
            recordsProcessed: $('#recordsProcessed'),
            syncButton: $('#syncButton'),
            resetButton: $('#resetButton'),
            successAlert: $('#successAlert'),
            errorAlert: $('#errorAlert'),
            successMessage: $('#successMessage'),
            previewCard: $('#previewCard'),
            previewLoading: $('#previewLoading'),
            previewTable: $('#previewTable'),
            previewTableBody: $('#previewTableBody'),
            previewEmpty: $('#previewEmpty'),
            previewCount: $('#previewCount'),
        };

        // UI Update Functions
        const ui = {
            updateSyncButton: function() {
                const dateFrom = $domElements.dateFromInput.val();
                const dateTo = $domElements.dateToInput.val();
                const canSync = dateFrom && dateTo && syncState.status !== "syncing";
                $domElements.syncButton.prop('disabled', !canSync);
            },

            updateStatusBadge: function() {
                const $statusBadge = $domElements.statusBadge;
                const $icon = $statusBadge.find('svg');
                const $text = $statusBadge.find('span');

                // Remove all status classes
                $statusBadge.attr('class', 'badge-sync');

                switch (syncState.status) {
                    case 'syncing':
                        $statusBadge.addClass('badge-info-sync');
                        $icon.addClass('animate-spin-sync');
                        $text.text('Syncing in progress...');
                        break;
                    case 'success':
                        $statusBadge.addClass('badge-success-sync');
                        $icon.removeClass('animate-spin-sync');
                        $text.text('Sync completed successfully');
                        break;
                    case 'error':
                        $statusBadge.addClass('badge-error-sync');
                        $icon.removeClass('animate-spin-sync');
                        $text.text('Sync failed - Please check date range');
                        break;
                    default:
                        $statusBadge.addClass('badge-secondary-sync');
                        $icon.removeClass('animate-spin-sync');
                        $text.text('Ready to sync');
                }
            },

            showProgress: function() {
                $domElements.progressSection.removeClass('hidden');
            },

            hideProgress: function() {
                $domElements.progressSection.addClass('hidden');
            },

            updateProgress: function() {
                $domElements.progressBar.css('width', syncState.progress + '%');
                $domElements.progressPercent.text(syncState.progress + '%');
                $domElements.recordsProcessed.text(syncState.syncedRecords.toLocaleString());
            },

            showAlert: function(type) {
                ui.hideAlerts();

                if (type === 'success') {
                    const dateFrom = $domElements.dateFromInput.val();
                    const dateTo = $domElements.dateToInput.val();
                    const message = `Successfully synchronized ${syncState.syncedRecords.toLocaleString()} spare part records from ${dateFrom} to ${dateTo}.`;
                    $domElements.successMessage.text(message);
                    $domElements.successAlert.removeClass('hidden');
                } else if (type === 'error') {
                    $domElements.errorAlert.removeClass('hidden');
                }
            },

            hideAlerts: function() {
                $domElements.successAlert.addClass('hidden');
                $domElements.errorAlert.addClass('hidden');
            },

            showPreviewLoading: function() {
                $domElements.previewLoading.removeClass('hidden');
                $domElements.previewTable.addClass('hidden');
                $domElements.previewEmpty.addClass('hidden');
                $domElements.previewCount.addClass('hidden');
            },

            hidePreviewLoading: function() {
                $domElements.previewLoading.addClass('hidden');
            },

            showPreviewTable: function() {
                $domElements.previewTable.removeClass('hidden');
                $domElements.previewEmpty.addClass('hidden');

                // Clear existing rows
                $domElements.previewTableBody.empty();

                // Add data rows
                $.each(syncState.previewData, function(index, item) {
                    const statusClass = item.status === 'Active' ? 'badge-status-active-sync' : 'badge-secondary-sync';
                    const row = `
                        <tr>
                            <td class="font-medium">${item.digits_code}</td>
                            <td>${item.supplier_item_code}</td>
                            <td>${item.item_description}</td>
                        </tr>
                    `;
                    $domElements.previewTableBody.append(row);
                });
            },

            showPreviewEmpty: function() {
                $domElements.previewTable.addClass('hidden');
                $domElements.previewEmpty.removeClass('hidden');
                $domElements.previewCount.addClass('hidden');
            },

            updatePreviewCount: function() {
                $domElements.previewCount.text(`${syncState.previewData.length} items`);
                $domElements.previewCount.removeClass('hidden');
            },

            showPreviewCard: function() {
                $domElements.previewCard.removeClass('hidden');
            },

            hidePreviewCard: function() {
                $domElements.previewCard.addClass('hidden');
            }
        };

        // Event Handlers
        function handleDateChange() {
            const dateFrom = $domElements.dateFromInput.val();
            const dateTo = $domElements.dateToInput.val();

            if (dateFrom && dateTo) {
                loadPreview(dateFrom, dateTo);
            } else {
                ui.hidePreviewCard();
            }

            ui.updateSyncButton();
        }

        function handleSync() {
            const dateFrom = $domElements.dateFromInput.val();
            const dateTo = $domElements.dateToInput.val();

            if (!dateFrom || !dateTo || syncState.previewData.length === 0) {
                syncState.status = "error";
                ui.updateStatusBadge();
                ui.showAlert('error');
                return;
            }

            syncState.status = "syncing";
            syncState.progress = 0;
            syncState.syncedRecords = 0;

            ui.updateStatusBadge();
            ui.updateSyncButton();
            ui.showProgress();
            ui.hideAlerts();

            $.ajax({
                url: '{{ route("save_manual_sync_get_apple_items") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    items: syncState.previewData
                }),
                success: function(response) {
                    syncState.status = "success";
                    syncState.syncedRecords = syncState.previewData.length;
                    syncState.progress = 100;
                    ui.updateProgress();
                    ui.updateStatusBadge();
                    ui.updateSyncButton();
                    ui.hideProgress();
                    ui.showAlert('success');
                    $domElements.resetButton.removeClass('hidden');
                },
                error: function(xhr, status, error) {
                    syncState.status = "error";
                    ui.updateStatusBadge();
                    ui.showAlert('error');
                    ui.hideProgress();
                    console.error("Sync error:", error);
                }
            });
        }


        function resetSync() {
            syncState.status = "idle";
            syncState.progress = 0;
            syncState.syncedRecords = 0;
            syncState.previewData = [];

            ui.updateStatusBadge();
            ui.updateSyncButton();
            ui.hideProgress();
            ui.hideAlerts();
            ui.hidePreviewCard();
            $domElements.resetButton.addClass('hidden');
            $domElements.dateFromInput.val('');
            $domElements.dateToInput.val('');
        }

        function loadPreview(dateFrom, dateTo) {
            if (!dateFrom || !dateTo) {
                ui.hidePreviewCard();
                return;
            }

            ui.showPreviewCard();
            ui.showPreviewLoading();
            ui.hideAlerts();

            // jQuery AJAX request
            $.ajax({
                url: '{{route("manual_sync_get_apple_items")}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    dateFrom: dateFrom,
                    dateTo: dateTo
                }),
                success: function(response) {
                    syncState.previewData = response.data;
                    ui.hidePreviewLoading();

                    if (syncState.previewData.length > 0) {
                        ui.showPreviewTable();
                        ui.updatePreviewCount();
                    } else {
                        ui.showPreviewEmpty();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading preview data:', error);
                    ui.hidePreviewLoading();
                    ui.showPreviewEmpty();
                    
                    // Optionally show error message
                    // syncState.status = "error";
                    // ui.updateStatusBadge();
                    // ui.showAlert('error');
                }
            });
        }

        // Event listeners using jQuery
        $domElements.dateFromInput.on('change', handleDateChange);
        $domElements.dateToInput.on('change', handleDateChange);
        $domElements.syncButton.on('click', handleSync);
        $domElements.resetButton.on('click', resetSync);

        // Initial UI state
        ui.updateSyncButton();
        ui.updateStatusBadge();
        ui.hidePreviewCard();
    });
</script>
@endpush
