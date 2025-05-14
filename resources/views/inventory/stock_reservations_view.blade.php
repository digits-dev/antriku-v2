@extends('crudbooster::admin_template')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --radius: 0.5rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Table Styles */
        .table-container-stock-reserve {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
        }

        thead {
            background-color: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
        }

        th {
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: var(--gray-700);
            white-space: nowrap;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .status-completed {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .reserved-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-light);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Job Order Details */
        .job-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .detail-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 12px;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            font-weight: 600;
            color: var(--gray-800);
        }

        .section-title {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Reserved Parts Table */
        .reserved-parts-table th:first-child,
        .reserved-parts-table td:first-child {
            padding-left: 1.5rem;
        }

        .reserved-parts-table th:last-child,
        .reserved-parts-table td:last-child {
            padding-right: 1.5rem;
        }

        .part-name {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .part-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius);
            background-color: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .part-details {
            display: flex;
            flex-direction: column;
        }

        .part-sku {
            font-size: 10px;
            color: var(--gray-500);
        }

        .stock-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 12px;
        }

        .stock-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .stock-pending {
            background-color: var(--primary);
        }

        .stock-confirmed-deducted {
            background-color: var(--success);
        }

        .stock-warning {
            background-color: var(--warning);
        }

        .stock-critical {
            background-color: var(--danger);
        }

        .quantity {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .reference-badge-cust-2 {
            display: flex;
            align-items: center;
            background-color: rgba(38, 37, 37, 0.3);
            color: #f5f5f5;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
    <div class="panel panel-default" style="margin: 0; padding:0">
        <div class="dashboard-title-content" style="margin: 15px 15px 0 15px;">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="dashboard-title">
                        <span class="dashboard-title-icon">
                            <img src="https://cdn-icons-png.flaticon.com/128/8890/8890077.png" width="20px" alt="">
                        </span>
                        Stock Reservations Per Job Order
                    </h1>
                </div>
                <div class="col-md-6">
                    <div class="reference-badge-cust-2 pull-right">
                        Reference No.:
                        <strong style="margin-left: 4px;">{{$get_jo_reference}}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-12">
                    <div>
                        <div class="section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M20.91 8.84 8.56 2.23a1.93 1.93 0 0 0-1.81 0L3.1 4.13a2.12 2.12 0 0 0-.05 3.69l12.22 6.93a2 2 0 0 0 1.94 0L21 12.51a2.12 2.12 0 0 0-.09-3.67Z">
                                </path>
                                <path
                                    d="m3.09 8.84 12.35-6.61a1.93 1.93 0 0 1 1.81 0l3.65 1.9a2.12 2.12 0 0 1 .1 3.69L8.73 14.75a2 2 0 0 1-1.94 0L3 12.51a2.12 2.12 0 0 1 .09-3.67Z">
                                </path>
                                <line x1="12" y1="22" x2="12" y2="13"></line>
                                <path
                                    d="M20 13.5v3.37a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13.5">
                                </path>
                            </svg>
                            Reserved Parts (<span id="modalPartsCount">{{count($stock_reservations_data)}}</span>)
                        </div>

                        <div class="table-container-stock-reserve" style="height: 430px; overflow:auto">
                            <table class="reserved-parts-table">
                                <thead>
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Reserved Qty</th>
                                        <th>Stock Status</th>
                                        <th>Reserved Date</th>
                                    </tr>
                                </thead>
                                <tbody id="reservedPartsTableBody">
                                    @foreach ($stock_reservations_data as $item)
                                        <tr>
                                            <td>
                                                <div class="part-name">
                                                    <div class="part-icon">
                                                        📦
                                                    </div>
                                                    <div class="part-details">
                                                        <div>{{$item->spare_parts}}</div>
                                                        <div class="part-sku">{{$item->item_description}}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="quantity">{{$item->reserved_qty}}</span>
                                            </td>
                                            <td>
                                                <div class="stock-status">
                                                    <div class="stock-indicator {{$item->status == 'Pending' ? 'stock-pending' : 'stock-confirmed-deducted'}}"></div>
                                                    {{$item->status}}
                                                </div>
                                            </td>
                                            <td>
                                                {{$item->reserve_date}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('bottom')
    <script></script>
@endpush
