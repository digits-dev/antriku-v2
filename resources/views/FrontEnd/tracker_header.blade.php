<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoxTalks Ticketing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #374151;
        }

        .bg-gradient-CLD {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .container-CLD {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles */
        .header-CLD {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #e5e7eb;
        }

        .header-content-CLD {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        .header-left-CLD {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-right-CLD {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-CLD {
            background: #111827;
            padding: 0rem 0.5rem;
            border-radius: 0.5rem;
            color: white;
            font-size: 1.5rem;
        }

        .logo-text-CLD h1 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #111827;
        }

        .logo-text-CLD p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .btn-CLD {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary-CLD {
            background: #2563eb;
            color: white;
        }

        .btn-primary-CLD:hover {
            background: #1d4ed8;
        }

        .btn-outline-CLD {
            background: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-outline-CLD:hover {
            background: #f9fafb;
        }

        .btn-ghost-CLD {
            background: transparent;
            color: #6b7280;
            border: none;
            padding: 0.5rem;
        }

        .btn-ghost-CLD:hover {
            background: #f3f4f6;
        }

        .btn-CLD:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Card Styles */
        .card-CLD {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .card-header-CLD {
            padding: 1.5rem 1.5rem 0;
        }

        .card-title-CLD {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-description-CLD {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .card-content-CLD {
            padding: 1.5rem;
        }

        /* Form Styles */
        .form-group-CLD {
            margin-bottom: 1rem;
        }

        .form-label-CLD {
            display: block;
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: #374151;
        }

        .form-input-CLD {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .form-input-CLD:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .input-group-CLD {
            position: relative;
        }

        .input-group-CLD .toggle-btn-CLD {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
        }

        /* Search Screen */
        .search-screen-CLD {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 4rem);
            padding: 1rem;
        }

        .search-container-CLD {
            width: 100%;
            max-width: 28rem;
        }

        .welcome-icon-CLD {
            background: #dbeafe;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .welcome-icon-CLD i {
            font-size: 2rem;
            color: #2563eb;
        }

        .text-center-CLD {
            text-align: center;
        }

        .welcome-title-CLD {
            font-size: 1.5rem;
            font-weight: bold;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle-CLD {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        /* Error Alert */
        .alert-CLD {
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .alert-error-CLD {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-info-CLD {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        /* Loading Spinner */
        .spinner-CLD {
            width: 1rem;
            height: 1rem;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Main Content */
        .main-content-CLD {
            padding: 2rem 0;
        }

        .status-overview-CLD {
            margin-bottom: 2rem;
        }

        .status-header-CLD {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .status-title-CLD {
            font-size: 1.5rem;
            font-weight: bold;
            color: #111827;
        }

        .status-subtitle-CLD {
            color: #6b7280;
        }

        .badge-CLD {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-blue-CLD {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-green-CLD {
            background: #dcfce7;
            color: #166534;
        }

        .badge-gray-CLD {
            background: #f3f4f6;
            color: #4b5563;
        }

        .progress-card-CLD {
            background: linear-gradient(135deg, #111827 0%, #111827 100%);
            color: white;
        }

        .progress-content-CLD {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .progress-bar-CLD {
            width: 100%;
            height: 0.5rem;
            background: rgba(59, 130, 246, 0.3);
            border-radius: 9999px;
            margin: 1rem 0;
            overflow: hidden;
        }

        .progress-fill-CLD {
            height: 100%;
            background: white;
            border-radius: 9999px;
            transition: width 0.3s ease;
        }

        .progress-text-CLD {
            color: #bfdbfe;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .days-remaining-CLD {
            text-align: right;
        }

        .days-number-CLD {
            font-size: 2rem;
            font-weight: bold;
        }

        .days-label-CLD {
            color: #bfdbfe;
        }

        /* Grid Layout */
        .grid-CLD {
            display: grid;
            gap: 2rem;
        }

        .grid-cols-1-CLD {
            grid-template-columns: 1fr;
        }

        .grid-cols-2-CLD {
            grid-template-columns: repeat(2, 1fr);
        }

        @media (min-width: 1024px) {
            .lg-grid-cols-3-CLD {
                grid-template-columns: 2fr 1fr;
            }
        }

        @media (min-width: 768px) {
            .md-grid-cols-2-CLD {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Timeline */
        .timeline-CLD {
            position: relative;
        }

        .timeline-item-CLD {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .timeline-icon-CLD {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .timeline-connector-CLD {
            width: 1px;
            height: 3rem;
            margin-top: 0.5rem;
        }

        .timeline-connector-CLD.completed-CLD {
            background: #bbf7d0;
        }

        .timeline-connector-CLD.pending-CLD {
            background: #e5e7eb;
        }

        .timeline-content-CLD {
            flex: 1;
        }

        .timeline-header-CLD {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        .timeline-title-CLD {
            font-weight: 500;
        }

        .timeline-title-CLD.completed-CLD {
            color: #059669;
        }

        .timeline-title-CLD.current-CLD {
            color: #2563eb;
        }

        .timeline-title-CLD.pending-CLD {
            color: #6b7280;
        }

        .timeline-date-CLD {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .timeline-note-CLD {
            font-size: 0.875rem;
            color: #2563eb;
            margin-top: 0.25rem;
        }

        /* Parts List */
        .parts-list-CLD {
            border-top: 1px solid #e5e7eb;
        }

        .parts-item-CLD {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .parts-item-CLD:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.125rem;
        }

        .parts-name-CLD {
            font-weight: 500;
        }

        .parts-desc-CLD {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .parts-price-CLD {
            font-weight: 600;
        }

        /* Sidebar */
        .sidebar-CLD {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .quick-actions-CLD {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .service-info-CLD {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .service-icon-CLD {
            background: #dbeafe;
            padding: 0.5rem;
            border-radius: 0.5rem;
            color: #2563eb;
        }

        .contact-list-CLD {
            list-style: none;
        }

        .contact-item-CLD {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .contact-item-CLD i {
            color: #9ca3af;
            width: 1rem;
        }

        /* Device Photos */
        .photo-grid-CLD {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .photo-placeholder-CLD {
            aspect-ratio: 1;
            background: #f3f4f6;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .photo-placeholder-CLD i {
            font-size: 1.5rem;
            color: #9ca3af;
            margin-bottom: 0.25rem;
        }

        .photo-label-CLD {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Notifications */
        .notification-item-CLD {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .notification-dot-CLD {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            margin-top: 0.5rem;
        }

        .notification-dot-CLD.blue-CLD {
            background: #3b82f6;
        }

        .notification-dot-CLD.green-CLD {
            background: #10b981;
        }

        .notification-title-CLD {
            font-weight: 500;
            font-size: 0.875rem;
        }

        .notification-time-CLD {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Avatar */
        .avatar-CLD {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
        }

        .avatar-sm-CLD {
            width: 1.5rem;
            height: 1.5rem;
            font-size: 0.75rem;
        }

        /* Stars */
        .stars-CLD {
            display: flex;
            gap: 0.125rem;
        }

        .star-CLD {
            color: #fbbf24;
            font-size: 0.75rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container-CLD {
                padding: 0 0.5rem;
            }
            
            .header-content-CLD {
                padding: 0 1rem;
            }
            
            .status-header-CLD {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .progress-content-CLD {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .days-remaining-CLD {
                text-align: left;
            }
        }

        /* Utility Classes */
        .hidden-CLD {
            display: none !important;
        }

        .flex-CLD {
            display: flex;
        }

        .items-center-CLD {
            align-items: center;
        }

        .justify-between-CLD {
            justify-content: space-between;
        }

        .gap-2-CLD {
            gap: 0.5rem;
        }

        .gap-4-CLD {
            gap: 1rem;
        }

        .mb-4-CLD {
            margin-bottom: 1rem;
        }

        .mb-6-CLD {
            margin-bottom: 1.5rem;
        }

        .mt-2-CLD {
            margin-top: 0.5rem;
        }

        .w-full-CLD {
            width: 100%;
        }

        .text-sm-CLD {
            font-size: 0.875rem;
        }

        .text-xs-CLD {
            font-size: 0.75rem;
        }

        .font-medium-CLD {
            font-weight: 500;
        }

        .font-bold-CLD {
            font-weight: bold;
        }

        .text-gray-500-CLD {
            color: #6b7280;
        }

        .text-gray-600-CLD {
            color: #4b5563;
        }

        .text-blue-600-CLD {
            color: #2563eb;
        }

        .separator-CLD {
            height: 1px;
            background: #e5e7eb;
            margin: 1rem 0;
        }



        .uploaded-files-list {
            list-style: none;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .file-item:hover {
            background: #e3f2fd;
            border-color: #2196f3;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(33, 150, 243, 0.15);
        }

        .file-item:last-child {
            margin-bottom: 0;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .file-icon i {
            color: white;
            font-size: 18px;
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-name {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-size {
            font-size: 12px;
            color: #6c757d;
        }

        .file-actions {
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .file-item:hover .file-actions {
            opacity: 1;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .view-btn {
            background: #e3f2fd;
            color: #1976d2;
        }

        .view-btn:hover {
            background: #bbdefb;
        }

        .delete-btn {
            background: #ffebee;
            color: #d32f2f;
        }

        .delete-btn:hover {
            background: #ffcdd2;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Different file type icons */
        .file-icon.jpg, .file-icon.jpeg, .file-icon.png, .file-icon.gif {
            background: linear-gradient(135deg, #4CAF50, #45a049);
        }

        .file-icon.pdf {
            background: linear-gradient(135deg, #f44336, #d32f2f);
        }

        .file-icon.doc, .file-icon.docx {
            background: linear-gradient(135deg, #2196F3, #1976D2);
        }

        @media (max-width: 767px) {
            .logo-text-CLD {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="bg-gradient-CLD" style="overflow: auto">
    <!-- Header -->
    <header class="header-CLD">
        <div class="container-CLD">
            <div class="header-content-CLD">
                <div class="header-left-CLD">
                    @if($jo_details)
                        <a href="/customer-jo-tracker" id="backBtn" class="btn-ghost-CLD">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif
                    <div class="logo-CLD">
                        <img src="{{ asset('/img/btbt.png') }}" width="35px" style="padding-top: 5px;" alt="">
                    </div>
                    <div class="logo-text-CLD">
                        <h1>BoxTalks Ticketing</h1>
                        <p>{{ $jo_details->branch_name ?? 'Service Center Branch' }}</p>
                    </div>
                </div>
                <div class="header-right-CLD">
                    @if($jo_details)
                        <div id="userInfo" style="text-align: right; margin-right: 1rem;">
                            <p class="font-medium-CLD text-sm-CLD">{{ $jo_details->first_name . ' ' . $jo_details->last_name }}</p>
                            <p class="text-xs-CLD text-gray-500-CLD" id="userReference">Ref. {{ $jo_details->reference_no }}</p>
                        </div>
                    @endif
                    {{-- <button class="btn-ghost-CLD">
                        <i class="fas fa-bell"></i>
                    </button> --}}
                    <div class="avatar-CLD">
                        <img src="https://cdn-icons-png.flaticon.com/128/149/149071.png" width="30px" alt="">
                    </div>
                </div>
            </div>
        </div>
    </header>