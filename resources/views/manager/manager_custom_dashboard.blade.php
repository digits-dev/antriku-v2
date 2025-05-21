@extends('crudbooster::admin_template')
@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .content {
            padding: 0;
        }

        .content-header {
            display: none;
        }

        .cust-ch {
            margin-top: 50px !important;
        }

        @media (max-width: 767px) {
            .cust-ch {
                margin-top: 100px;
            }
        }

        .swal2-popup {
            border-radius: 10px !important;
        }
    </style>
@endpush
@section('content')
    <main class="container-dash dashboard-dash cust-ch">

        <div class="tabs-dash m-dash-new-users text-uppercase" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">

            <div class="tab-dash active" data-tab="tab-jaymar-bi">
                <img src="https://cdn-icons-png.flaticon.com/128/1698/1698561.png" alt="" width="20px">
                Dashboard Ni Jaymar
            </div>

            @foreach ($branch as $index => $per_branch)
                {{-- <div class="tab-dash {{ $index === 0 ? 'active' : '' }}" data-tab="tab-{{ $per_branch->id }}"> --}}
                <div class="tab-dash" data-tab="tab-{{ $per_branch->id }}">
                    <img src="https://cdn-icons-png.flaticon.com/128/1698/1698561.png" alt="" width="20px">
                    {{ $per_branch->branch_name }}
                </div>
            @endforeach

        </div>

        <div id="tab-jaymar-bi" class="tab-content-dash active">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-header-dash" style="padding: 0px 10px 0px 10px;">
                    <h2 class="card-title-dash text-uppercase" style="color: white;">
                        <img src="https://cdn-icons-png.flaticon.com/128/1828/1828673.png" alt="dash_icon" width="18">
                        <small style="font-size: 14px;">Dashboard Overview</small>
                    </h2>

                    <div>
                        <small class="text-uppercase" style="color: lightgrey">Home <i class="bi bi-chevron-right" style="font-size: 10px;"></i> Dashboard</small>
                    </div>
                </div>
                <div style="margin-left: 15px">
                    <h5>
                        <i class="bi bi-box-fill"></i>
                        Dashboard ni Jaymar
                    </h5>
                </div>
                <div class="card-body-dash">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                                <iframe
                                    title="NO"
                                    style="width: 100%; height: 800px"
                                    src='{{$PBI}}'
                                    frameBorder="0"
                                    allowFullScreen="true">
                                </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($branch as $index => $per_branch)
            {{-- <div id="tab-{{ $per_branch->id }}" class="tab-content-dash {{ $index === 0 ? 'active' : '' }}"> --}}
            <div id="tab-{{ $per_branch->id }}" class="tab-content-dash">
                <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                    <div class="card-header-dash" style="padding: 0px 10px 0px 10px;">
                        <h2 class="card-title-dash text-uppercase" style="color: white;">
                            <img src="https://cdn-icons-png.flaticon.com/128/1828/1828673.png" alt="dash_icon" width="18">
                            <small style="font-size: 14px;">Dashboard Overview of {{ $per_branch->branch_name }}</small>
                        </h2>

                        <div>
                            <small class="text-uppercase" style="color: lightgrey">Home <i class="bi bi-chevron-right" style="font-size: 10px;"></i> Dashboard</small>
                        </div>
                    </div>
                    <div style="margin-left: 15px">
                        <h5>
                            <i class="bi bi-box-fill"></i>
                            Frontliner Dashboard
                        </h5>
                    </div>
                    <div class="card-body-dash">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        {{-- PENDING CALLOUTS  --}}
                                        @php
                                            $branchData = $fl_pending_call_out_dash_count_all->get($per_branch->id)['data'] ?? collect();
                                        @endphp
                                        <div class="m-dash-card m-dash-new-users m-dash-card-clickable" 
                                            data-cardname="Pending Call-Outs" 
                                            data-branchname="{{ $per_branch->branch_name }}" 
                                            data-branch="{{ $per_branch->id }}" 
                                            data-branch-data='@json($branchData)'
                                            style="cursor: pointer;">
                                            
                                            <div class="m-dash-card-header">
                                                <div class="m-dash-card-title">Pending Call-outs</div>
                                            </div>
                                            <div class="m-dash-card-value" id="filtered-callouts-value">
                                                {{ $fl_pending_call_out_dash_count_all[$per_branch->id]['total'] ?? 0 }}
                                            </div>
                                            <div class="m-dash-card-change m-dash-positive">
                                                +12% from yesterday
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="m-dash-card m-dash-non-users m-dash-card-clickable" data-cardname="Abandoned Units" data-branchname="{{ $per_branch->branch_name }}" data-branch="{{ $per_branch->id }}" style="cursor: pointer;">
                                            <div class="m-dash-card-header">
                                                <div class="m-dash-card-title">Abandoned Units</div>
                                            </div>
                                            <div class="m-dash-card-value">{{ $fl_abandoned_units_dash_count_all[$per_branch->id] ?? 0 }}</div>
                                            <div class="m-dash-card-change m-dash-negative">-4% from yesterday</div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <br>
                                        <div class="card-dash" style="background: #FAF6E9;">
                                            <div class="card-header-dash">
                                            <h2 class="card-title-dash">
                                                <div class="card-icon-dash icon-sales">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                                </svg>
                                                </div>
                                                Total Sales
                                            </h2>
                                            <div class="card-actions-dash">
                                                <select id="timeFilter-{{ $per_branch->id }}" class="filter-select time-filter" data-branch="{{ $per_branch->id }}">
                                                    <option value="weekly" selected>Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="ytd">YTD</option>
                                                </select>
                                                <select id="yearFilter-{{ $per_branch->id }}" class="filter-select year-filter" data-branch="{{ $per_branch->id }}">
                                                    <option value="2025" selected>2025</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="card-body-dash" style="height: 350px;">
                                                {{-- <canvas id="salesChart"></canvas> --}}
                                                <canvas id="salesChart-{{ $per_branch->id }}"></canvas>
                                            </div><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                @php
                                    $employees = $handle_per_employee[$per_branch->id] ?? collect();
                                    $total_per_branch = $handle_overall_total[$per_branch->id] ?? 0;
                                @endphp
                                <div class="card-dash" style="background: #FAF6E9">
                                    <div class="card-header-dash">
                                        <h2 class="card-title-dash">
                                            <div class="card-icon-dash icon-employe-dash">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="9" cy="7" r="4"></circle>
                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                </svg>
                                            </div>
                                            Cases Handled Per Employee
                                        </h2>
                                        <div class="card-actions-dash">
                                        <button class="card-action-btn-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                        </div>
                                    </div>
                                    <div class="card-body-dash" >
                                        <div class="employee-chart" style="height: 150px; overflow-y:auto">
                                            @foreach ($employees as $my_handled_case)
                                                <div class="employee-row" style="cursor:pointer">
                                                    <div class="employee-badge {{ $loop->iteration == 1 ? 'badge-1' : ($loop->iteration == 2 ? 'badge-2' : ($loop->iteration == 3 ? 'badge-3' : '')) }}">
                                                        @if ($loop->iteration == 1)
                                                            <img src="https://cdn-icons-png.flaticon.com/128/5406/5406792.png" width="20px" alt="">
                                                        @elseif($loop->iteration == 2)
                                                            <img src="https://cdn-icons-png.flaticon.com/128/11881/11881956.png" width="20px" alt="">
                                                        @elseif($loop->iteration == 3)
                                                            <img src="https://cdn-icons-png.flaticon.com/128/11881/11881954.png" width="20px" alt="">
                                                        @else
                                                            {{$loop->iteration}}
                                                        @endif
                                                    </div>
                                                        @php
                                                            $photo = $my_handled_case->user_profile;
                                                            $name = $my_handled_case->created_by_user;
                                                            $initials = strtoupper(substr($name, 0, 1)) . strtoupper(substr(strrchr($name, ' '), 1, 1));
                                                        @endphp

                                                        <div class="employee-avatar" style="background: #14b8a6; color: aliceblue">
                                                            @if(empty($photo) || $photo == 'https://cdn-icons-png.flaticon.com/128/3177/3177440.png')
                                                                {{ $initials }}
                                                            @else
                                                                <img src="{{ asset($photo) }}" class="employee-avatar" alt="User Image"/>
                                                            @endif
                                                        </div>
                                                    <div class="employee-info">
                                                        <div class="employee-name">{{ $my_handled_case->created_by_user }}</div>
                                                        <div class="employee-position">{{ $my_handled_case->privilege_name }}</div>
                                                    </div>
                                                    <div class="employee-bar-container">
                                                        @php
                                                        $percentage = $total_per_branch > 0 
                                                            ? ($my_handled_case->total_creations / $total_per_branch) * 100 
                                                            : 0;
                                                        @endphp
                                                        <div class="employee-bar" style="width: {{ $percentage }}%;"></div>
                                                    </div>
                                                    <div class="employee-value">
                                                        {{ number_format($my_handled_case->total_creations) }} / {{ number_format($total_per_branch) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <br>
                                <div class="transactions-container" style="background: #FAF6E9">
                                    <div class="transactions-header" style="margin: 0%">
                                        <h2 class="card-title-dash">
                                            <div class="card-icon-dash icon-unit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" style="color: white" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="time-icon">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            </div>
                                            Releasing Time-in-Motion
                                        </h2>
                                        <div class="search-container">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            <input type="text" class="search-input" placeholder="Search transactions...">
                                        </div>
                                    </div>
                                    <div id="time_motion_data" style="height: 200px; overflow-y:auto">
                                        @include('manager.manager_tm_table')
                                    </div>
                                    <div class="card-footer-dash">
                                        <span class="card-footer-text-dash" id="showing_data_time_motion">
                                            Showing 10 of 100
                                        </span>
                                    
                                        <div class="pagination-cust" id="pagination_time_motion" style="margin: 0">
                                            <!-- Previous Button -->
                                            <button class="pagination-btn-cust pagination-link" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="15 18 9 12 15 6"></polyline>
                                                </svg>    
                                            </button>
                                        
                                                <button class="pagination-btn-cust pagination-link">1</button>
                                                <button class="pagination-btn-cust pagination-link active">2</button>
                                                <button class="pagination-btn-cust pagination-link">100</button>
                                        
                                            <!-- Next Button -->
                                            <button class="pagination-btn-cust pagination-link" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg>  
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>  


                    {{-- <div style="margin-left: 15px">
                        <h5>
                            <i class="bi bi-box-fill"></i>
                            Technician Dashboard
                        </h5>
                    </div>
                    <div class="card-body-dash">
                        <div class="dashboard-grid-dash">
                            <div class="card-dash">
                                <div class="card-header-dash">
                                    <h2 class="card-title-dash">
                                        <div class="card-icon-dash icon-pending-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </div>
                                        Ongoin Repair Cases
                                    </h2>
                                    <div class="card-actions-dash">
                                        <button class="card-action-btn-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body-dash">
                                    <div class="card-stats-dash">
                                        <div class="stat-dash">
                                            <div class="stat-value-dash">
                                                {{ $tech_ongoing_repair_cases[$per_branch->id] ?? 0 }}
                                            </div>
                                            <div class="stat-label-dash">Total Ongoing Repair Cases</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-dash">
                                <div class="card-header-dash">
                                    <h2 class="card-title-dash">
                                        <div class="card-icon-dash icon-pending-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </div>
                                        Awaiting Repair Cases

                                    </h2>
                                    <div class="card-actions-dash">
                                        <button class="card-action-btn-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body-dash">
                                    <div class="card-stats-dash">
                                        <div class="stat-dash">
                                            <div class="stat-value-dash">
                                                {{ $tech_awaiting_repair_cases[$per_branch->id] ?? 0 }}
                                            </div>
                                            <div class="stat-label-dash">Awaiting Repair Cases</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-dash">
                                <div class="card-header-dash">
                                    <h2 class="card-title-dash">
                                        <div class="card-icon-dash icon-pending-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </div>
                                        In Warranty

                                    </h2>
                                    <div class="card-actions-dash">
                                        <button class="card-action-btn-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body-dash">
                                    <div class="card-stats-dash">
                                        <div class="stat-dash">
                                            <div class="stat-value-dash">
                                                {{ $totalIW[$per_branch->id] ?? 0 }}
                                            </div>
                                            <div class="stat-label-dash">Total In-Warranty Repair Cases</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-dash">
                                <div class="card-header-dash">
                                    <h2 class="card-title-dash">
                                        <div class="card-icon-dash icon-pending-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </div>
                                        Out Of Warranty

                                    </h2>
                                    <div class="card-actions-dash">
                                        <button class="card-action-btn-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body-dash">
                                    <div class="card-stats-dash">
                                        <div class="stat-dash">
                                            <div class="stat-value-dash">
                                                {{ $totalOOW[$per_branch->id] ?? 0 }}
                                            </div>
                                            <div class="stat-label-dash">Total Out of Warranty Repair Cases</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-dash">
                                <div class="card-header-dash">
                                    <h2 class="card-title-dash">
                                        <div class="card-icon-dash icon-pending-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </div>
                                        Carry-In

                                    </h2>
                                    <div class="card-actions-dash">
                                        <button class="card-action-btn-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body-dash">
                                    <div class="card-stats-dash">
                                        <div class="stat-dash">
                                            <div class="stat-value-dash">
                                                {{ $totalCarryIn[$per_branch->id] ?? 0 }}
                                            </div>
                                            <div class="stat-label-dash">Total Repair of Carry-In</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-dash">
                                <div class="card-header-dash">
                                    <h2 class="card-title-dash">
                                        <div class="card-icon-dash icon-pending-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </div>
                                        Mail-In

                                    </h2>
                                    <div class="card-actions-dash">
                                        <button class="card-action-btn-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body-dash">
                                    <div class="card-stats-dash">
                                        <div class="stat-dash">
                                            <div class="stat-value-dash">
                                                {{ $totalMailIn[$per_branch->id] ?? 0 }}
                                            </div>
                                            <div class="stat-label-dash">Total Repair of Mail-In</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}
                    
                </div>
            </div>
        @endforeach
    </main>
@endsection
@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function() {
        window.scrollTo(0, 0);
    };

    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-dash');
        const tabContents = document.querySelectorAll('.tab-content-dash');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>

<script>
    let filteredCalloutData = [];

    $(document).on('change', '.pending-call-outs', function () {
        const statusId = $(this).val();
        const branchId = $(this).data('branch');

        $.ajax({
            url: '{{ route("get.filtered.callouts.count") }}',
            type: 'POST',
            data: {
                status_id: statusId,
                branch_id: branchId
            },
            success: function (response) {
                $('#filtered-callouts-value').text(response.count);
                filteredCalloutData = response.data; // Store data globally
            },
            error: function () {
                alert('Something went wrong while fetching filtered count.');
            }
        });
    });

    $(document).on('click', '.view-details', function () {
        if (filteredCalloutData.length === 0) {
            Swal.fire('No data', 'Please select a status to load data first.', 'warning');
            return;
        }

        const clickedBranchId = $(this).data('branchid');

        // Filter the data by branch
        const branchFilteredData = filteredCalloutData.filter(item => item.branch == clickedBranchId);

        if (branchFilteredData.length === 0) {
            Swal.fire('No data', 'No records found for this branch with selected status.', 'info');
            return;
        }

        const rows = branchFilteredData.map(item => `
            <tr>
                <td>${item.reference_no}</td>
                <td>${item.first_name + ' ' + item.last_name || 'N/A'}</td>
                <td>${item.email}</td>
                <td>${item.contact_no}</td>
                <td>${item.created_at}</td>
            </tr>
        `).join('');

        const tableHtml = `
            <div style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-striped" style="width: 100%; text-align: left;">
                    <thead>
                        <tr style="background: grey; color: white">
                            <th>Reference No.</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
        `;

        Swal.fire({
            title: `Callouts for Branch ${clickedBranchId} (${branchFilteredData.length})`,
            html: tableHtml,
            width: '90%',
            showCloseButton: true,
            confirmButtonText: 'Okay, Got it'
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Store chart instances by branch ID
        let salesCharts = {};
        
        // Initialize charts for visible tabs only
        initializeVisibleCharts();
        
        // Initialize chart when tab becomes active
        $('.tab-dash').on('click', function() {
            let tabId = $(this).data('tab');
            
            // Give the DOM time to render the tab content
            setTimeout(function() {
                if (!salesCharts[tabId]) {
                    initializeChart(tabId);
                } else {
                    // Redraw existing chart
                    salesCharts[tabId].update();
                }
            }, 100);
        });
        
        function initializeVisibleCharts() {
            $('.tab-content-dash.active').each(function() {
                let tabId = $(this).attr('id');
                initializeChart(tabId);
            });
        }
        
        function initializeChart(tabId) {
            let branchId = tabId.replace('tab-', '');
            let canvas = $(`#${tabId} #salesChart-${branchId}`);
            
            if (canvas.length === 0 || !canvas[0].getContext) {
                console.error(`Canvas not found for ${tabId} with ID salesChart-${branchId}`);
                return;
            }
            
            // console.log(`Initializing chart for branch ${branchId} in tab ${tabId}`);
            
            let ctx = canvas[0].getContext("2d");
            salesCharts[tabId] = new Chart(ctx, {
                type: "line",
                data: {
                    labels: [],
                    datasets: [{
                        label: "Total Sales Graph",
                        data: [],
                        borderColor: "#14b8a6",
                        backgroundColor: "#14b8a543",
                        borderWidth: 2,
                        pointBackgroundColor: "#14b8a6",
                        pointRadius: 5,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return "₱" + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
            
            // Fetch data for this chart using the branch-specific filters
            let selectedYear = $(`#yearFilter-${branchId}`).val();
            let selectedRange = $(`#timeFilter-${branchId}`).val();
            fetchSalesData(tabId, selectedYear, selectedRange);
        }
        
        function fetchSalesData(tabId, year, range) {
            let branchId = tabId.replace('tab-', '');
            
            // console.log(`Fetching sales data for branch ${branchId}, year ${year}, range ${range}`);
            
            let requestData = {
                branch_id: branchId
            };
            
            if (range !== "ytd") {
                requestData.year = year;
            }
            
            $.ajax({
                url: "{{ route('getSalesData') }}",
                type: "GET",
                data: requestData,
                success: function(response) {
                    if (salesCharts[tabId]) {
                        salesCharts[tabId].data.labels = response[range].labels;
                        salesCharts[tabId].data.datasets[0].data = response[range].data;
                        salesCharts[tabId].update();
                        // console.log(`Updated chart for ${tabId} with ${response[range].data.length} data points`);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching sales data:", error);
                }
            });
        }
        
        // Event listeners for filters - use class selectors instead of ID
        $(document).on('change', '.time-filter', function() {
            let branchId = $(this).data('branch');
            let tabId = `tab-${branchId}`;
            let selectedRange = $(this).val();
            let selectedYear = $(`#yearFilter-${branchId}`).val();
            
            // Update chart for this specific branch
            fetchSalesData(tabId, selectedYear, selectedRange);
            
            // Show/hide year filter based on selection
            if (selectedRange === 'ytd') {
                $(`#yearFilter-${branchId}`).hide();
            } else {
                $(`#yearFilter-${branchId}`).show();
            }
        });
        
        $(document).on('change', '.year-filter', function() {
            let branchId = $(this).data('branch');
            let tabId = `tab-${branchId}`;
            let selectedYear = $(this).val();
            let selectedRange = $(`#timeFilter-${branchId}`).val();
            
            // Only update if not YTD
            if (selectedRange !== "ytd") {
                fetchSalesData(tabId, selectedYear, selectedRange);
            }
        });
        
        // Year filter population
        function populateYearFilters() {
            let startYear = 2021;
            let currentYear = new Date().getFullYear();
            
            $('.year-filter').each(function() {
                let select = $(this);
                // Clear existing options
                select.empty();
                
                // Generate options from startYear to currentYear
                for (let year = startYear; year <= currentYear; year++) {
                    select.append(`<option value="${year}">${year}</option>`);
                }
                
                // Set the latest year as selected
                select.val(currentYear);
            });
        }
        
        // Call this function to populate all year filters
        populateYearFilters();
    });
</script>

<script>
    $(document).ready(function() {
        $('.m-dash-card-clickable').on('click', function() {
            let branchId = $(this).data('branch');
            let cardName = $(this).data('cardname');
            let branchname = $(this).data('branchname');
            let data = $(this).data('branchData') || [];
            window.allCallOutStatuses = @json($all_call_out_status ?? []);
            
            if (typeof data === 'string') {
                try {
                    data = JSON.parse(data);
                } catch(e) {
                    console.error("Error parsing branch data JSON", e);
                    data = [];
                }
            }

            // Build table rows
            let rowsHtml = '';
            if (!data || !data.length) {
                rowsHtml = `
                    <tr>
                        <td colspan="6" style="text-align:center; color: #ef4444;">No Data found</td>
                    </tr>`;
            } else {
                data.forEach(item => {
                    rowsHtml += `
                        <tr>
                            <td>${item.reference_no || 'N/A'}</td>
                            <td>${item.warranty_status || 'N/A'}</td>
                            <td>${item.last_name + ', ' + item.first_name || 'N/A'}</td>
                            <td>${item.email || 'N/A'}</td>
                            <td>${item.contact_no || 'N/A'}</td>
                            <td>${item.status_name || 'N/A'}</td>
                        </tr>`;
                });
            }

            // Check if SweetAlert is available
            if (typeof Swal === 'undefined') {
                console.error("SweetAlert is not defined. Make sure it's properly loaded.");
                alert("Error: SweetAlert library not loaded");
                return;
            }

            Swal.fire({
                html: `
                    <div>
                        <h5 class="pull-left text-uppercase"><i class="bi bi-menu-button-wide-fill"></i> ${cardName} of ${branchname}</h5>
                    </div>
                    <br><br>
                    <select class="input-cus ${cardName == 'Pending Call-Outs' ? '' : 'hidden'}" autofocus>
                        <option selected disabled>Filter Different types of Pending Call-Outs here...</option>
                        ${window.allCallOutStatuses.map(status => `
                            <option value="${status.id}">${status.status_name} - (${status.warranty_status})</option>
                        `).join('')}
                    </select>
                    ${cardName == 'Pending Call-Outs' ? '<br><br>' : ''}
                    <table class="transactions-table" autofocus>
                        <thead>
                            <tr>
                                <th style="font-size: 14px" class="text-uppercase"><i class="bi bi-upc-scan"></i> Reference No.</th>
                                <th style="font-size: 14px" class="text-uppercase"><i class="bi bi-patch-question-fill"></i> Warranty Type</th>
                                <th style="font-size: 14px" class="text-uppercase"><i class="bi bi-person-fill"></i> Customer</th>
                                <th style="font-size: 14px" class="text-uppercase"><i class="bi bi-envelope-at-fill"></i> Email</th>
                                <th style="font-size: 14px" class="text-uppercase"><i class="bi bi-telephone-outbound-fill"></i> Contact No.</th>
                                <th style="font-size: 14px" class="text-uppercase"><i class="bi bi-clock-fill"></i> Status</th>
                            </tr>
                        </thead>
                        <tbody id="transactions-body" style="text-align: left;">
                            ${rowsHtml}
                        </tbody>
                    </table>
                `,
                width: '80%',
                showCloseButton: true,
                confirmButtonText: 'Close',
                showConfirmButton: false,
                focusConfirm: false
            }).catch(error => {
                console.error("SweetAlert error:", error);
            });
        });
    });
</script>
@endpush
