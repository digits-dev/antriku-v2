@extends('crudbooster::admin_template')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
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
</style>
@endpush
@section('content')
    <main class="container-dash dashboard-dash cust-ch">
        <!-- Enhanced Dashboard Title Section -->
        <div class="dashboard-title-section" style="margin-bottom: 10px;">
            <div class="dashboard-title-content">
                <h1 class="dashboard-title" style="margin-top: 8px">
                    <span class="dashboard-title-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </span>
                    Frontliner's Dashboard
                </h1>
                <p class="dashboard-subtitle">
                </p>
            </div>
        </div>

        <div class="tabs-dash text-uppercase" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="tab-dash active" data-tab="overview">
              <img src="https://cdn-icons-png.flaticon.com/128/7756/7756168.png" alt="" width="20px">
              Overview
            </div>
            <div class="tab-dash" data-tab="aging_callouts">
              <img src="https://cdn-icons-png.flaticon.com/128/4943/4943769.png" alt="" width="20px">
              Aging Callouts
            </div>
            <div class="tab-dash" data-tab="time_and_motion">
              <img src="https://cdn-icons-png.flaticon.com/128/3652/3652191.png" alt="" width="20px">
              Job Order Time-in-Motion
            </div>
            <div class="tab-dash" data-tab="customers_unit_filter">
              <img src="https://cdn-icons-png.flaticon.com/128/13635/13635492.png" alt="" width="20px">
              Customer's/Unit Filters
            </div>
        </div>

        <div id="overview" class="tab-content-dash active">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-body-dash">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                              <div class="col-md-6">
                                <!-- Pending Call-outs Card -->
                                <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                                    <div class="m-dash-card-header" style="margin: 0">
                                        <div class="m-dash-card-title">
                                          <i class="bi bi-telephone-minus-fill" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                          Pending Call-outs
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="m-dash-card-value" id="filtered-callouts-value">
                                        {{ $fl_pending_call_out_dash_count_all ?? 0 }}
                                    </div>
                                    <div class="m-dash-card-change m-dash-positive">
                                        {{-- +12% from yesterday --}}
                                    </div>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <!-- Abandoned Units Card -->
                                <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                                    <div class="m-dash-card-header" style="margin: 0">
                                        <div class="m-dash-card-title">
                                          <i class="bi bi-emoji-frown-fill" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                          Abandoned Units
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="m-dash-card-value" id="filtered-callouts-value">
                                        {{ $fl_abandoned_units_dash_count ?? 0 }}
                                    </div>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <br>
                                <div class="transactions-container">
                                  <div class="transactions-header" style="margin: 0%">
                                      <h2 class="card-title-dash">
                                          <div class="card-icon-dash icon-default">
                                              <i class="bi bi-table" style="font-size: 12px"></i>
                                          </div>
                                          Summary of Data
                                      </h2>
                                      {{-- <div class="search-container">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                              viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                              class="search-icon">
                                              <circle cx="11" cy="11" r="8"></circle>
                                              <line x1="21" y1="21" x2="16.65" y2="16.65">
                                              </line>
                                          </svg>
                                          <input type="text" class="search-input"
                                              placeholder="Search transactions...">
                                      </div> --}}
                                  </div>
                                <div style="height: 295px; overflow: auto;">
                                  <table class="transactions-table" autofocus>
                                    <thead>
                                        <tr>
                                            <th style="font-size: 10px" class="text-uppercase">
                                              Reference No.
                                            </th>
                                            <th style="font-size: 10px" class="text-uppercase">
                                              Warranty Type
                                            </th>
                                            <th style="font-size: 10px" class="text-uppercase hidden">
                                              Case Type
                                            </th>
                                            <th style="font-size: 10px" class="text-uppercase">
                                              Model
                                            </th>
                                            <th style="font-size: 10px" class="text-uppercase">
                                              Customer
                                            </th>
                                            <th style="font-size: 10px" class="text-uppercase hidden">
                                              Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: left; background: rgba(240, 246, 247, 0.7);">
                                        @if (!empty($my_cases))
                                          @foreach ($my_cases as $item)
                                            <tr>
                                              <td style="font-size: 12px">{{$item->reference_no}}</td>
                                              <td style="font-size: 12px">{{$item->warranty_status}}</td>
                                              <td class="hidden" style="font-size: 12px">{{$item->case_status}}</td>
                                              <td style="font-size: 12px">{{$item->model_name}}</td>
                                              <td style="font-size: 12px">{{$item->last_name . ',' .$item->first_name}}</td>
                                              <td class="hidden" style="font-size: 12px">{{$item->status_name}}</td>
                                            </tr>
                                          @endforeach
                                        @else 
                                        <tr>
                                          <td colspan="6" style="font-size: 12px">No Data Available!</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                  </table>
                                </div>
                                <div class="card-footer-dash">
                                    <span class="card-footer-text-dash showing_data_tech_overview" id="showing_data_tech_overview">
                                        Showing {{count($my_cases)}} Total of Data
                                    </span>
                                </div>
                                </div>
                              </div>
                          </div>          
                        </div>

                        <div class="col-md-5">
                          <!-- Total case/s handled -->
                          <div class="card-dash">
                              <div class="card-header-dash">
                                  <h2 class="card-title-dash">
                                      <div class="card-icon-dash icon-default">
                                        <i class="bi bi-file-text-fill" style="font-size: 15px"></i>
                                      </div>
                                      My Total Case/s Handled
                                  </h2>
                              </div>
                              <div class="card-body-dash">
                                <div class="chart-container" style="position: relative; height: 240px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                                  <canvas id="caseStatusChart"></canvas>
                                </div>
                                
                                <div class="filter-buttons" style="display: flex; gap: 10px; justify-content: center; margin: 20px 0;">
                                  <button id="filterAll" class="filter-btn active" style="padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #4b5563; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 6px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                    All Cases
                                  </button>
                                  <button id="filterCompleted" class="filter-btn" style="padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #4b5563; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 6px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                    Completed
                                  </button>
                                  <button id="filterOngoing" class="filter-btn" style="padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #4b5563; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 6px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Ongoing
                                  </button>
                                </div>
                                
                                <div class="case-stats" style="display: flex; justify-content: space-around; margin: 20px 0; padding: 15px; background-color: #f9fafb; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                  <div class="stat-item" style="text-align: center; padding: 0 10px;">
                                    <div style="font-size: 28px; font-weight: 700; line-height: 1.2;" id="totalCases">0</div>
                                    <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">Total Cases</div>
                                  </div>
                                  <div class="stat-item" style="text-align: center; padding: 0 10px;">
                                    <div style="font-size: 28px; font-weight: 700; line-height: 1.2; color: #948979;" id="completedCases">0</div>
                                    <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">Completed</div>
                                  </div>
                                  <div class="stat-item" style="text-align: center; padding: 0 10px;">
                                    <div style="font-size: 28px; font-weight: 700; line-height: 1.2; color: #222831;" id="ongoingCases">0</div>
                                    <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">Ongoing</div>
                                  </div>
                                </div>
                                
                                <div class="table-filter-info" style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 12px 16px; background-color: #f9fafb; border-radius: 8px; font-weight: 500; font-size: 14px;">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6b7280;"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                                  <span id="tableFilterStatus">All Cases</span> (<span id="filteredCount">0</span>)
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="aging_callouts" class="tab-content-dash">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-body-dash">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-3">
                                <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs" style="cursor: pointer;">
                                  <div class="m-dash-card-header" style="margin: 0">
                                    <div class="m-dash-card-title">
                                      <i class="bi bi-graph-up-arrow" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                      Normal (0-7 days)
                                    </div>
                                    <hr>
                                  </div>
                                  <div class="m-dash-card-value">
                                    {{ $normalCount }}
                                  </div>
                                  <div class="m-dash-card-change m-dash-positive">
                                    {{-- Range: (0-7 days) --}}
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs" style="cursor: pointer;">
                                  <div class="m-dash-card-header" style="margin: 0">
                                    <div class="m-dash-card-title">
                                      <i class="bi bi-graph-up-arrow" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                      Medium (8-14 days)
                                    </div>
                                    <hr>
                                  </div>
                                  <div class="m-dash-card-value">
                                    {{ $mediumCount }}
                                  </div>
                                  <div class="m-dash-card-change m-dash-positive">
                                    {{-- Range: (8-14 days) --}}
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs" style="cursor: pointer;">
                                  <div class="m-dash-card-header" style="margin: 0">
                                    <div class="m-dash-card-title">
                                      <i class="bi bi-graph-up-arrow" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                      High (15-30 days)
                                    </div>
                                    <hr>
                                  </div>
                                  <div class="m-dash-card-value">
                                    {{ $highCount }}
                                  </div>
                                  <div class="m-dash-card-change m-dash-negative">
                                    {{-- Range: (15-30 days) --}}
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs" style="cursor: pointer;">
                                  <div class="m-dash-card-header" style="margin: 0">
                                    <div class="m-dash-card-title">
                                      <i class="bi bi-graph-up-arrow" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                      Critical (30+ days)
                                    </div>
                                    <hr>
                                  </div>
                                  <div class="m-dash-card-value">
                                    {{ $criticalCount }}
                                  </div>
                                  <div class="m-dash-card-change m-dash-negative">
                                    {{-- Range: (30+ days) --}}
                                  </div>
                                </div>
                              </div>
                            </div>         
                        </div>
                         <div class="col-md-4">
                          <br>
                          <div class="card-dash">
                            <h4 class="label-cus text-uppercase" style="margin: 20px 20px 0 20px">
                              <i class="bi bi-clock-history"></i>
                              <b>Aging Distribution</b>
                            </h4>
                            <div class="card-body-dash" style="height: 425px">
                              <canvas id="agingDistributionChart" height="300"></canvas>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-8">
                          <br>
                          <div class="card-dash">
                            <h4 class="label-cus text-uppercase" style="margin: 20px 20px 0 20px">
                              <i class="bi bi-clock-history"></i>
                              <b>Aging Callout By Type</b>
                            </h4>
                            <div class="card-body-dash"s0tyle="height: 500px">
                              <canvas id="agingByTypeChart" height="300"></canvas>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="customers_unit_filter" class="tab-content-dash">
            <div class="dashboard-grid-dash">
                <!-- Unit Details Card -->
                <div class="card-dash" style="border-radius: 0%">
                    <div class="card-header-dash">
                        <h2 class="card-title-dash">
                            <div class="card-icon-dash icon-default">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            Customer & Unit Details
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

                        <!-- Filter Section -->
                        <h2 class="filter-title">
                            <div class="filter-icon" style="margin-top: 0px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                </svg>
                            </div>
                            Filter Options
                        </h2>

                        <div class="search-box">
                            <div class="search-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <input type="text" class="search-input"
                                placeholder="Search by customer last name, first name, contact_no, reference_no, status or unit details..."
                                id="searchInput">
                        </div>

                        <div class="filter-grid" style="display: none;">
                            <div class="filter-group">
                                <label class="label-cus" for="date-range">Date Range From</label>
                                <input type="date" id="date-range-from" class="filter-input">
                            </div>
                            <div class="filter-group">
                                <label class="label-cus" for="date-range">Date Range To</label>
                                <input type="date" id="date-range-to" class="filter-input">
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button class="btn-dash btn-outline-dash btn-sm-dash" id="reset_cus_unit_filter">Reset
                                Filters</button>
                            <button class="btn-dash btn-primary-dash btn-sm-dash" id="apply_filters">Apply
                                Filters</button>
                        </div>

                        <div class="card-stats-dash">
                            <div class="stat-dash">
                                <div class="stat-value-dash">{{ number_format($customers_units) }}</div>
                                <div class="stat-label-dash">Total Customers with Units</div>
                            </div>
                        </div>

                        <div class="unit-table-container">
                            <table class="unit-table">
                                <thead>
                                    <tr>
                                        <th>Reference No.</th>
                                        <th>Model</th>
                                        <th>Customer</th>
                                        <th>Contact</th>
                                        <th>Created at</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6">
                                            <div
                                                style="display:flex; align-items:center; justify-content:center; margin: 30px 30px 0px 30px;">
                                                <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png"
                                                    width="100px" alt="">
                                            </div>
                                            <p style="text-align: center" class="stat-label-dash">Please filter data</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer-dash">
                        <span class="card-footer-text-dash" id="showing_data_cus_unit"></span>
                        <div class="pagination-cust" id="pagination_cus_unit" style="margin: 0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="time_and_motion" class="tab-content-dash">
            <div class="transactions-container" style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                <div class="transactions-header" style="margin-top: 0%">
                    <h2 class="card-title-dash">
                        <div class="card-icon-dash icon-default">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" style="color: white" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="time-icon">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        Time-in-motion
                    </h2>
                    {{-- <div class="search-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="search-icon">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" class="search-input" placeholder="Search transactions...">
                    </div> --}}
                </div>
                <div style="overflow:auto" id="time_motion_data">
                    @include('frontliner.admin_dashboard_tm_table')
                </div>
                <div class="card-footer-dash">
                    <span class="card-footer-text-dash" id="showing_data_time_motion">
                        Showing {{ $time_motion->count() }} of {{ $time_motion->total() }}
                    </span>

                    <div class="pagination-cust" id="pagination_time_motion" style="margin: 0">
                        <!-- Previous Button -->
                        <button type="button" class="pagination-btn-cust pagination-link"
                            data-url="{{ $time_motion->previousPageUrl() }}"
                            {{ $time_motion->onFirstPage() ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>

                        <!-- Page Numbers (Limited to 5) -->
                        @php
                            $totalPages = $time_motion->lastPage();
                            $currentPage = $time_motion->currentPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $startPage + 4);
                            $startPage = max(1, $endPage - 4);
                        @endphp

                        @if ($startPage > 1)
                            <button type="button" class="pagination-btn-cust pagination-link"
                                data-url="{{ $time_motion->url(1) }}">1</button>
                            @if ($startPage > 2)
                                <span>...</span>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <button type="button" class="pagination-btn-cust pagination-link {{ $i == $currentPage ? 'active' : '' }}"
                                data-url="{{ $time_motion->url($i) }}">
                                {{ $i }}
                            </button>
                        @endfor

                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <span>...</span>
                            @endif
                            <button type="button" class="pagination-btn-cust pagination-link"
                                data-url="{{ $time_motion->url($totalPages) }}">{{ $totalPages }}</button>
                        @endif

                        <!-- Next Button -->
                        <button type="button" class="pagination-btn-cust pagination-link" data-url="{{ $time_motion->nextPageUrl() }}"
                            {{ $time_motion->currentPage() == $time_motion->lastPage() ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Transaction Details Modal -->
    <div class="modal" id="transaction-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Transaction Details</h3>
                <button class="modal-close" id="modal-close">&times;</button>
            </div>
            <div id="transaction-details-content">
                <div class="transaction-info">
                    <p><strong>Transaction ID:</strong> <span id="modal-transaction-id"></span></p>
                    <p><strong>Customer:</strong> <span id="modal-customer"></span></p>
                    <p><strong>Amount:</strong> <span id="modal-amount"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    <p><strong>Started:</strong> <span id="modal-started"></span></p>
                </div>

                <div class="transaction-timeline" id="modal-timeline">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

{{-- customer unit filter  --}}
<script>
    function fetchData(page = 1) {
        let date_range_from = $('#date-range-from').val();
        let date_range_to = $('#date-range-to').val();
        let search_input = $('#searchInput').val();

        $.ajax({
            url: "{{ route('filter_customers_units') }}?page=" + page,
            type: "POST",
            data: {
                date_range_from: date_range_from,
                date_range_to: date_range_to,
                search_input: search_input
            },
            success: function(response) {
                let results = response.data;
                let tbody = $('.unit-table tbody');
                tbody.empty(); // Clear previous results

                if (results.length > 0) {
                    $.each(results, function(index, item) {
                        let row = `
                    <tr>
                        <td>${item.reference_no}</td>
                        <td>${item.model_name}</td>
                        <td>${item.last_name}, ${item.first_name}</td>
                        <td>${item.contact_no}</td>
                        <td>${item.created_at}</td>
                        <td>${item.status_name}</td>
                    </tr>
                `;
                        tbody.append(row);
                    });
                } else {
                    tbody.html(`
                <tr>
                    <td colspan="6">
                        <div style="display:flex; align-items:center; justify-content:center; margin: 30px 30px 0px 30px;">
                            <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" width="100px" alt="">
                        </div>
                        <p style="text-align: center" class="stat-label-dash">No records found</p>
                    </td>
                </tr>
            `);
                }

                $('#showing_data_cus_unit').text(
                    `Showing ${response.to - response.from + 1} of ${response.total}`);

                // Update Pagination Links
                let paginationLinks = '';
                let totalPages = response.last_page;
                let currentPage = response.current_page;
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);

                if (response.prev_page_url) {
                    paginationLinks += `<button class="pagination-btn-cust" onclick="fetchData(${currentPage - 1})">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>    
            </button>`;
                }

                for (let i = startPage; i <= endPage; i++) {
                    paginationLinks +=
                        `<button class="pagination-btn-cust ${i === currentPage ? 'active' : ''}" onclick="fetchData(${i})">${i}</button>`;
                }

                if (response.next_page_url) {
                    paginationLinks += `<button class="pagination-btn-cust" onclick="fetchData(${currentPage + 1})">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>  
            </button>`;
                }

                $('#pagination_cus_unit').html(paginationLinks);
            }
        });
    }

    // Trigger AJAX when filters are applied
    $('#apply_filters').on('click', function() {
        fetchData();
    });

    $('#reset_cus_unit_filter').on('click', function() {
        $('#searchInput').val('');

        let tbody = $('.unit-table tbody');
        tbody.empty();

        tbody.html(`
            <tr>
                <td colspan="6">
                    <div style="display:flex; align-items:center; justify-content:center; margin: 30px 30px 0px 30px;">
                        <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" width="100px" alt="">
                    </div>
                    <p style="text-align: center" class="stat-label-dash">Please filter data</p>
                </td>
            </tr>
        `);
    });
</script>

{{-- Time-in-Motion  --}}
<script>
  $(document).ready(function() {
      $('.pagination-link').on('click', function(e) {
          e.preventDefault();
          
          let url = $(this).data('url');
          if (!url) return;

          $.ajax({
              url: url,
              type: 'GET',
              beforeSend: function() {
                  $('#time_motion_data').html(`
                    <div style="display: flex; justify-content: center">
                      <img width="100" src="https://cdn-icons-gif.flaticon.com/10282/10282620.gif"/>
                    </div>
                    <center><p style="text-align:center">Loading data, please wait...</p></center>`);
              },
              success: function(data) {
                  $('#time_motion_data').html($(data.table));
                  $('#pagination_time_motion').html($(data.pagination));
              },
              error: function() {
                  alert('Error loading data.');
              }
          });
      });
  });
</script>

{{-- my cases  --}}
<script>
  // Add this to your existing JavaScript
  $(document).ready(function() {
    const caseData = @json($my_cases);
    let completedCount = 0;
    let ongoingCount = 0;
    
    const completedStatuses = ['COMPLETE', 'Closed', 'Resolved', 'Fixed'];
    
    // Process the data
    caseData.forEach(caseItem => {
      if (completedStatuses.includes(caseItem.status_name)) {
        completedCount++;
      } else {
        ongoingCount++;
      }
    });
    
    // Update the stats with animation
    animateCounter('totalCases', caseData.length);
    animateCounter('completedCases', completedCount);
    animateCounter('ongoingCases', ongoingCount);
    $('#filteredCount').text(caseData.length);
    
    const completedColor = {
      background: '#B6B09F',
      border: 'white',
      hover: '#B6B09F'
    };
    
    const ongoingColor = {
      background: '#222831',
      border: 'white',
      hover: '#222831'
    };
    
    // Create the pie chart
    const ctx = document.getElementById('caseStatusChart').getContext('2d');
    const caseStatusChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Completed', 'Ongoing'],
        datasets: [{
          data: [completedCount, ongoingCount],
          backgroundColor: [
            completedColor.background,
            ongoingColor.background
          ],
          borderColor: [
            completedColor.border,
            ongoingColor.border
          ],
          hoverBackgroundColor: [
            completedColor.hover,
            ongoingColor.hover
          ],
          borderWidth: 5,
          hoverOffset: 10,
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '50%',
        layout: {
          padding: 20
        },
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: {
                size: 12
              },
              generateLabels: function(chart) {
                const data = chart.data;
                if (data.labels.length && data.datasets.length) {
                  return data.labels.map(function(label, i) {
                    const meta = chart.getDatasetMeta(0);
                    const style = meta.controller.getStyle(i);
                    
                    return {
                      text: `${label}: ${data.datasets[0].data[i]}`,
                      fillStyle: data.datasets[0].backgroundColor[i],
                      strokeStyle: data.datasets[0].borderColor[i],
                      lineWidth: 2,
                      pointStyle: 'circle',
                      hidden: !chart.getDataVisibility(i),
                      index: i
                    };
                  });
                }
                return [];
              }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(255, 255, 255, 0.95)',
            titleColor: '#111827',
            bodyColor: '#4b5563',
            borderColor: 'rgba(0, 0, 0, 0.1)',
            borderWidth: 1,
            padding: 12,
            boxPadding: 6,
            usePointStyle: true,
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.raw || 0;
                const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                const percentage = Math.round((value / total) * 100);
                return `${label}: ${value} (${percentage}%)`;
              }
            }
          }
        },
        animation: {
          animateScale: true,
          animateRotate: true,
          duration: 1000,
          easing: 'easeOutCirc'
        },
        onClick: (event, elements) => {
          if (elements.length > 0) {
            const index = elements[0].index;
            if (index === 0) {
              filterTable('COMPLETE');
              updateActiveButton('filterCompleted');
            } else {
              filterTable('Ongoing');
              updateActiveButton('filterOngoing');
            }
          }
        }
      }
    });
    
    // Add center text to doughnut chart
    Chart.register({
      id: 'doughnutCenterText',
      beforeDraw: function(chart) {
        if (chart.config.type === 'doughnut') {
          // Get ctx from chart
          const ctx = chart.ctx;
          
          // Get options from the center object in options
          const centerConfig = {
            text: caseData.length,
            subText: 'Total',
            color: '#111827',
            subColor: '#6b7280',
            fontFamily: 'Arial, sans-serif',
            fontSize: 30,
            subFontSize: 14
          };
          
          // Set text alignment and baseline
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          
          // Get the center of the chart
          const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
          const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;
          
          // Draw text
          ctx.font = `bold ${centerConfig.fontSize}px ${centerConfig.fontFamily}`;
          ctx.fillStyle = centerConfig.color;
          ctx.fillText(centerConfig.text, centerX, centerY - 10);
          
          // Draw sub text
          ctx.font = `${centerConfig.subFontSize}px ${centerConfig.fontFamily}`;
          ctx.fillStyle = centerConfig.subColor;
          ctx.fillText(centerConfig.subText, centerX, centerY + 15);
        }
      }
    });
    
    // Animate counter function
    function animateCounter(id, endValue) {
      const obj = document.getElementById(id);
      const duration = 1000;
      const startValue = 0;
      const increment = Math.ceil(endValue / (duration / 16)); // 60fps
      
      let currentValue = startValue;
      const timer = setInterval(() => {
        currentValue += increment;
        
        if (currentValue >= endValue) {
          obj.textContent = endValue;
          clearInterval(timer);
        } else {
          obj.textContent = currentValue;
        }
      }, 16);
    }
    
    // Filter table function
    function filterTable(filter) {
      if (filter === 'All') {
        $('table.transactions-table tbody tr').show();
        $('#tableFilterStatus').text('All Cases');
        $('#filteredCount').text(caseData.length);
      } else if (filter === 'COMPLETE') {
        $('table.transactions-table tbody tr').hide();
        
        // Show only completed cases
        $('table.transactions-table tbody tr').each(function() {
          const status = $(this).find('td:last').text().trim();
          if (completedStatuses.includes(status)) {
            $(this).show();
          }
        });
        
        $('#tableFilterStatus').text('Completed Cases');
        $('#filteredCount').text(completedCount);
      } else if (filter === 'Ongoing') {
        $('table.transactions-table tbody tr').hide();
        
        // Show only ongoing cases
        $('table.transactions-table tbody tr').each(function() {
          const status = $(this).find('td:last').text().trim();
          if (!completedStatuses.includes(status)) {
            $(this).show();
          }
        });
        
        $('#tableFilterStatus').text('Ongoing Cases');
        $('#filteredCount').text(ongoingCount);
      }
    }
    
    // Update active button styles
    function updateActiveButton(buttonId) {
      // Remove active class from all buttons
      $('.filter-btn').removeClass('active');
      $('.filter-btn').css({
        'background-color': '#f9fafb',
        'color': '#4b5563',
        'border-color': '#e5e7eb'
      });
      
      // Add active class to selected button
      $(`#${buttonId}`).addClass('active');
      
      // Style based on button type
      if (buttonId === 'filterAll') {
        $(`#${buttonId}`).css({
          'background-color': '#f3f4f6',
          'color': '#111827',
          'border-color': '#d1d5db'
        });
      } else if (buttonId === 'filterCompleted') {
        $(`#${buttonId}`).css({
          'background-color': '#948979',
          'color': '#ffff',
          'border-color': '#948979'
        });
      } else if (buttonId === 'filterOngoing') {
        $(`#${buttonId}`).css({
          'background-color': '#222831',
          'color': '#ffff',
          'border-color': '#222831'
        });
      }
    }
    
    // Button click handlers
    $('#filterAll').click(function() {
      filterTable('All');
      updateActiveButton('filterAll');
    });
    
    $('#filterCompleted').click(function() {
      filterTable('COMPLETE');
      updateActiveButton('filterCompleted');
    });
    
    $('#filterOngoing').click(function() {
      filterTable('Ongoing');
      updateActiveButton('filterOngoing');
    });
    
    // Initialize with all cases shown
    filterTable('All');
    updateActiveButton('filterAll');
  });
</script>

{{-- Aging Callout  --}}
<script>
  $(document).ready(function() {
    // Get the data from PHP variables
    const normalCount = {{ $normalCount }};
    const mediumCount = {{ $mediumCount }};
    const highCount = {{ $highCount }};
    const criticalCount = {{ $criticalCount }};
    
    // Modern color palette
    const colors = {
      normal: 'lightgrey',    // for 0-7 days
      medium: '#948979',    // for 8-14 days
      high: 'grey',     //  for 15-30 days
      critical: '#222831'  // for 30+ days
    };
    
    // Create Aging Distribution Chart
    const agingDistributionCtx = document.getElementById('agingDistributionChart').getContext('2d');
    new Chart(agingDistributionCtx, {
      type: 'bar',
      data: {
        labels: ['0-7 days', '8-14 days', '15-30 days', '30+ days'],
        datasets: [{
          label: 'TOTAL',
          data: [normalCount, mediumCount, highCount, criticalCount],
          backgroundColor: [
            colors.normal,
            colors.medium,
            colors.high,
            colors.critical
          ],
          borderColor: [
            colors.normal.replace('0.8', '1'),
            colors.medium.replace('0.8', '1'),
            colors.high.replace('0.8', '1'),
            colors.critical.replace('0.8', '1')
          ],
          borderWidth: 1,
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              drawBorder: false,
              color: 'rgba(200, 200, 200, 0.15)'
            },
            ticks: {
              precision: 0,
              font: {
                size: 11
              }
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              font: {
                size: 11
              }
            }
          }
        },
        plugins: {
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.7)',
            padding: 10,
            cornerRadius: 6,
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.raw;
              }
            }
          },
          legend: {
            display: false
          },
          datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#fff',
            font: {
              weight: 'bold',
              size: 12
            },
            formatter: function(value) {
              if (value > 0) return value;
              return '';
            },
            textShadow: '0px 0px 2px rgba(0, 0, 0, 0.3)'
          }
        }
      },
      plugins: [ChartDataLabels]
    });
    
    // For the second chart - Aging by Callout Type
    let calloutTypeObjects = [];
    let statusIdToName = {};
    
    try {
      // Get callout type objects from PHP
      calloutTypeObjects = {!! json_encode($callout_type) !!} || [];
      
      // Create mapping from ID to name
      calloutTypeObjects.forEach(type => {
        if (type && type.id && type.status_name) {
          statusIdToName[type.id] = type.status_name;
        }
      });
    } catch (e) {
      console.error("Error loading callout types:", e);
      // Fallback to default types if there's an error
      statusIdToName = {
        12: 'NULL',
        13: 'NULL',
        19: 'NULL',
        21: 'NULL',
        22: 'NULL',
        26: 'NULL',
        28: 'NULL',
        33: 'NULL',
        35: 'NULL',
        38: 'NULL',
        43: 'NULL',
        45: 'NULL',
        47: 'NULL',
        48: 'NULL'
      };
    }
    
    // Get unique status names (to combine same names with different IDs)
    const uniqueStatusNames = [...new Set(Object.values(statusIdToName))];
    
    // Add "Other" category for unmapped statuses
    uniqueStatusNames.push("Other");
    
    // Initialize data structure for each unique status name
    const typeData = {};
    uniqueStatusNames.forEach(typeName => {
      typeData[typeName] = {
        normal: 0,
        medium: 0,
        high: 0,
        critical: 0
      };
    });
    
    // Process aging callouts data
    try {
      const agingCallouts = {!! json_encode($aging_callouts) !!} || [];
      
      agingCallouts.forEach(callout => {
        if (!callout) return; // Skip if callout is null or undefined
        
        // Get the type name from the mapping, or use "Other" if not found
        const typeName = statusIdToName[callout.repair_status] || "Other";
        
        // Get age in days, default to 0 if not available
        const ageDays = callout.age_days || 0;
        
        // Categorize based on age and increment the appropriate counter
        if (ageDays <= 7) {
          typeData[typeName].normal++;
        } else if (ageDays <= 14) {
          typeData[typeName].medium++;
        } else if (ageDays <= 30) {
          typeData[typeName].high++;
        } else {
          typeData[typeName].critical++;
        }
      });
    } catch (e) {
      console.error("Error processing aging callouts:", e);
      
      // Use sample data if processing fails
      uniqueStatusNames.forEach(typeName => {
        if (typeName !== "Other") {
          typeData[typeName] = {
            normal: Math.floor(Math.random() * 5),
            medium: Math.floor(Math.random() * 5),
            high: Math.floor(Math.random() * 5),
            critical: Math.floor(Math.random() * 5)
          };
        }
      });
    }
    
    // Remove "Other" category if it has no data
    if (
      typeData["Other"].normal === 0 && 
      typeData["Other"].medium === 0 && 
      typeData["Other"].high === 0 && 
      typeData["Other"].critical === 0
    ) {
      const otherIndex = uniqueStatusNames.indexOf("Other");
      if (otherIndex !== -1) {
        uniqueStatusNames.splice(otherIndex, 1);
      }
      delete typeData["Other"];
    }
    
    // Create shortened labels and a mapping to full names for tooltips
    const shortLabels = [];
    const fullLabels = {};
    
    uniqueStatusNames.forEach(name => {
      // Extract the main part of the status name
      let shortName = name;
      
      // Remove "CALLOUT: " prefix if it exists
      // if (shortName.startsWith("CALLOUT: ")) {
      //   shortName = shortName.substring(9);
      // }
      
      // If still too long, truncate
      if (shortName.length > 15) {
        // shortName = shortName.substring(0, 100) + "...";
      }
      
      shortLabels.push(shortName);
      fullLabels[shortName] = name;
    });
    
    // Prepare datasets for the chart
    const datasets = [
      {
        label: '0-7 days',
        data: uniqueStatusNames.map((type, index) => (typeData[type] ? typeData[type].normal : 0)),
        backgroundColor: colors.normal,
        stack: 'Stack 0',
        borderRadius: 6,
        borderWidth: 1,
        borderColor: colors.normal.replace('0.8', '1')
      },
      {
        label: '8-14 days',
        data: uniqueStatusNames.map((type, index) => (typeData[type] ? typeData[type].medium : 0)),
        backgroundColor: colors.medium,
        stack: 'Stack 0',
        borderRadius: 6,
        borderWidth: 1,
        borderColor: colors.medium.replace('0.8', '1')
      },
      {
        label: '15-30 days',
        data: uniqueStatusNames.map((type, index) => (typeData[type] ? typeData[type].high : 0)),
        backgroundColor: colors.high,
        stack: 'Stack 0',
        borderRadius: 6,
        borderWidth: 1,
        borderColor: colors.high.replace('0.8', '1')
      },
      {
        label: '30+ days',
        data: uniqueStatusNames.map((type, index) => (typeData[type] ? typeData[type].critical : 0)),
        backgroundColor: colors.critical,
        stack: 'Stack 0',
        borderRadius: 6,
        borderWidth: 1,
        borderColor: colors.critical.replace('0.8', '1')
      }
    ];
    
    // Create Aging by Callout Type Chart
    const agingByTypeCtx = document.getElementById('agingByTypeChart').getContext('2d');
    
    new Chart(agingByTypeCtx, {
      type: 'bar',
      data: {
        labels: shortLabels,
        datasets: datasets
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y', // Change to horizontal bar chart for better label display
        scales: {
          x: {
            beginAtZero: true,
            stacked: true,
            grid: {
              drawBorder: false,
              color: 'rgba(200, 200, 200, 0.15)'
            },
            ticks: {
              precision: 0,
              font: {
                size: 11
              }
            }
          },
          y: {
            stacked: true,
            grid: {
              display: false
            },
            ticks: {
              font: {
                size: 11
              }
            }
          }
        },
        plugins: {
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.7)',
            padding: 10,
            cornerRadius: 6,
            callbacks: {
              title: function(context) {
                // Show the full label in the tooltip title
                const shortLabel = context[0].label;
                return fullLabels[shortLabel] || shortLabel;
              },
              label: function(context) {
                return context.dataset.label + ': ' + context.raw;
              }
            }
          },
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 15,
              font: {
                size: 11
              }
            }
          },
          datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#fff',
            font: {
              weight: 'bold',
              size: 11
            },
            formatter: function(value) {
              if (value > 0) return value;
              return '';
            },
            textShadow: '0px 0px 2px rgba(0, 0, 0, 0.3)'
          }
        }
      },
      plugins: [ChartDataLabels]
    });
  });
</script>

{{-- tab  --}}
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
@endpush
