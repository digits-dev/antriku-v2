@extends('crudbooster::admin_template')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<style>
    .content{
       padding: 0;
    }
   
    .content-header{
       display: none;
    }
    
    .cust-ch{
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
  <div class="dashboard-title-section">
    <!-- Top section with breadcrumbs and actions -->
    <div class="dashboard-header-top">
      <div class="breadcrumbs">
        <div class="breadcrumb-item">
          <a href="#">Home</a>
        </div>
        <div class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </div>
        <div class="breadcrumb-item active">Frontliner</div>
      </div>
      
      <div class="dashboard-actions">
        <button class="action-button primary" style="display: none">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
          </svg>
          Export Report
        </button>
      </div>
    </div>
    
    <!-- Title and subtitle with enhanced styling -->
    <div class="dashboard-title-content">
      <h1 class="dashboard-title">
        <span class="dashboard-title-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
        </span>
        Frontliner's Dashboard
      </h1>
      <p class="dashboard-subtitle">
        Overview of pending call-outs, abandoned units, aging call-outs, total sales, customer and unit filters.
      </p>
    </div>
  </div>

  <div class="tabs-dash" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
    <div class="tab-dash active" data-tab="overview">Overview</div>
    <div class="tab-dash" data-tab="time_and_motion">Time-in-Motion</div>
    <div class="tab-dash" data-tab="customers_unit_filter">Customer's/Unit Filters</div>
    <div class="tab-dash" data-tab="customer_info_filter">Customer's Information Filter</div>
  </div>
  
  <div id="overview" class="tab-content-dash active">
    <h2>Overview</h2>
    
    <div class="dashboard-grid-dash">
      <!-- Pending Call-outs Card -->
      <div class="card-dash">
        <div class="card-header-dash">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-pending-dash">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
              </svg>
            </div>
            Pending Call-outs
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
        <div class="card-body-dash">
            <div class="card-stats-dash">
                <div class="stat-dash">
                    <div class="stat-value-dash">{{ $fl_pending_call_out_dash_count_all }}</div>
                    <div class="stat-label-dash">Total Pending</div>
                </div>
            </div>
        </div>        
      </div>

      <!-- Abandoned Units Card -->
      <div class="card-dash">
        <div class="card-header-dash">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-abandoned-dash">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
            </div>
            Abandoned Units
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
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{$fl_abandoned_units_dash_count}}</div>
              <div class="stat-label-dash">Total Abandoned</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total case/s handled -->
      <div class="card-dash">
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
            Total Case/s Handled
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
        <div class="card-body-dash">
          <div class="employee-chart">
            @foreach ($handle_per_employee as $my_handled_case)
              <div class="employee-row" style="margin-bottom: 15px">
                <div class="employee-avatar" style="background: #14b8a6; color:aliceblue">
                  {{ strtoupper(substr($my_handled_case->created_by_user, 0, 1)) }}
                  {{ strtoupper(substr(strrchr($my_handled_case->created_by_user, ' '), 1, 1)) }}
                </div>
                <div class="employee-info">
                  <div class="employee-name">{{$my_handled_case->created_by_user}}</div>
                  <div class="employee-position">{{$my_handled_case->privilege_name}}</div>
                </div>
                <div class="employee-bar-container">
                  @php
                      // Prevent division by zero error
                      $total_case_handled_percentage = $handle_overall_total > 0 
                      ? ($my_handled_case->total_creations / $handle_overall_total) * 100 
                      : 0;
                  @endphp
                  <div class="employee-bar" style="width: {{$total_case_handled_percentage}}%;"></div>
                </div>
                <div class="employee-value">{{number_format($my_handled_case->total_creations)}} / {{number_format($handle_overall_total)}}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      </div>
    
      <div class="dashboard-grid-dash">
        <!-- Aging Call-outs Card -->
        <div class="card-dash">
          <div class="card-header-dash">
            <h2 class="card-title-dash">
              <div class="card-icon-dash icon-aging-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"></circle>
                  <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
              </div>
              Aging Call-outs
            </h2>
            <div class="card-stats-dash">
              <div class="stat-dash">
                <center>
                <div class="stat-value-dash">{{$fl_aging_call_out_dash_count_all}}</div>
                <div class="stat-label-dash">Total Aging</div>
                </center>
              </div>
            </div>
          </div>
          <div class="card-body-dash">
            <select id="aging_callout_type" class="input-cus">
              <option value="FOR CALL-OUT (GOOD UNIT)" selected>FOR CALL-OUT (GOOD UNIT)</option>
              <option value="FOR CALL-OUT MAIL-IN">FOR CALL-OUT MAIL-IN</option>
            </select>
            {{-- for call out mail-in --}}
            <div id="fcomi" style="display: none">
              <div class="status-list-dash">
                <div class="status-item-dash">
                  <div class="status-info-dash">
                    <div>
                      <div class="status-name-dash">30+ Days</div>
                      <div class="status-details-dash">Critical attention needed</div>
                    </div>
                  </div>
                  <div class="status-value-dash">{{$fl_aging_call_out_dash_count_30_plus}}</div>
                </div>
            
                @php
                    // Prevent division by zero error
                    $progressPercentage = $fl_aging_call_out_dash_count_all > 0 
                    ? ($fl_aging_call_out_dash_count_30_plus / $fl_aging_call_out_dash_count_all) * 100 
                    : 0;
                @endphp
    
                <div class="progress-container-dash">
                  <div class="progress-bar-dash progress-critical-dash" style="width: {{ $progressPercentage }}%;"></div>
                </div>
              </div>
    
              <div class="status-list-dash">
                <div class="status-item-dash">
                  <div class="status-info-dash">
                    <div>
                      <div class="status-name-dash">15-30 Days</div>
                      <div class="status-details-dash">Escalation required</div>
                    </div>
                  </div>
                  <div class="status-value-dash">{{$fl_aging_call_out_dash_count_15_30}}</div>
                </div>
                @php
                    // Prevent division by zero error
                    $progressPercentage2 = $fl_aging_call_out_dash_count_all > 0 
                        ? ($fl_aging_call_out_dash_count_15_30 / $fl_aging_call_out_dash_count_all) * 100 
                        : 0;
                @endphp
                <div class="progress-container-dash">
                  <div class="progress-bar-dash progress-warning-dash" style="width: {{ $progressPercentage2 }}%;"></div>
                </div>
              </div>
    
              <div class="status-list-dash">
                <div class="status-item-dash">
                  <div class="status-info-dash">
                    <div>
                      <div class="status-name-dash">0-14 Days</div>
                      <div class="status-details-dash">Needs follow-up</div>
                    </div>
                  </div>
                  <div class="status-value-dash">{{$fl_aging_call_out_dash_count_0_14}}</div>
                </div>
                @php
                    // Prevent division by zero error
                    $progressPercentage3 = $fl_aging_call_out_dash_count_all > 0 
                        ? ($fl_aging_call_out_dash_count_0_14 / $fl_aging_call_out_dash_count_all) * 100 
                        : 0;
                @endphp
                <div class="progress-container-dash">
                  <div class="progress-bar-dash progress-normal-dash" style="width: {{$progressPercentage3}}%;"></div>
                </div>
              </div>
            </div>

            {{-- For Call out good unit --}}
            <div id="fcogu">
              <div class="status-list-dash">
                <div class="status-item-dash">
                  <div class="status-info-dash">
                    <div>
                      <div class="status-name-dash">30+ Days</div>
                      <div class="status-details-dash">Critical attention needed</div>
                    </div>
                  </div>
                  <div class="status-value-dash">{{$fl_gu_aging_call_out_dash_count_30_plus}}</div>
                </div>
            
                @php
                    // Prevent division by zero error
                    $progressPercentageGU = $fl_aging_call_out_dash_count_all > 0 
                    ? ($fl_gu_aging_call_out_dash_count_30_plus / $fl_aging_call_out_dash_count_all) * 100 
                    : 0;
                @endphp
    
                <div class="progress-container-dash">
                  <div class="progress-bar-dash progress-critical-dash" style="width: {{ $progressPercentageGU }}%;"></div>
                </div>
              </div>
    
              <div class="status-list-dash">
                <div class="status-item-dash">
                  <div class="status-info-dash">
                    <div>
                      <div class="status-name-dash">15-30 Days</div>
                      <div class="status-details-dash">Escalation required</div>
                    </div>
                  </div>
                  <div class="status-value-dash">{{$fl_gu_aging_call_out_dash_count_15_30}}</div>
                </div>
                @php
                    // Prevent division by zero error
                    $progressPercentageGU2 = $fl_aging_call_out_dash_count_all > 0 
                        ? ($fl_gu_aging_call_out_dash_count_15_30 / $fl_aging_call_out_dash_count_all) * 100 
                        : 0;
                @endphp
                <div class="progress-container-dash">
                  <div class="progress-bar-dash progress-warning-dash" style="width: {{ $progressPercentageGU2 }}%;"></div>
                </div>
              </div>
    
              <div class="status-list-dash">
                <div class="status-item-dash">
                  <div class="status-info-dash">
                    <div>
                      <div class="status-name-dash">0-14 Days</div>
                      <div class="status-details-dash">Needs follow-up</div>
                    </div>
                  </div>
                  <div class="status-value-dash">{{$fl_gu_aging_call_out_dash_count_0_14}}</div>
                </div>
                @php
                    // Prevent division by zero error
                    $progressPercentageGU3 = $fl_aging_call_out_dash_count_all > 0 
                        ? ($fl_gu_aging_call_out_dash_count_0_14 / $fl_aging_call_out_dash_count_all) * 100 
                        : 0;
                @endphp
                <div class="progress-container-dash">
                  <div class="progress-bar-dash progress-normal-dash" style="width: {{$progressPercentageGU3}}%;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    {{-- <div class="dashboard-grid-dash">
      <!-- Sales Overview Card -->
      <div class="card-dash">
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
            <select id="timeFilter" class="filter-select">
                <option value="weekly" selected>Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="ytd">YTD</option>
            </select>
            <select id="yearFilter" class="filter-select">
              <option value="2025" selected>2025</option>
            </select>
          </div>
        </div>
        <div class="card-body-dash">
            <canvas id="salesChart"></canvas>
        </div><br>
      </div>
    </div> --}}
  </div>
  
  <div id="customers_unit_filter" class="tab-content-dash">
    <div class="dashboard-grid-dash">
      <!-- Unit Details Card -->
      <div class="card-dash" style="border-radius: 0%">
        <div class="card-header-dash">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-unit">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
            </div>
            Customer & Unit Details
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
        <div class="card-body-dash">

          <!-- Filter Section -->
      <h2 class="filter-title">
        <div class="filter-icon" style="margin-top: 0px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
          </svg>
        </div>
        Filter Options
      </h2>
      
      <div class="search-box">
        <div class="search-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </div>
        <input type="text" class="search-input" placeholder="Search by customer last name, first name, contact_no, reference_no, status or unit details..." id="searchInput">
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
        <button class="btn-dash btn-outline-dash btn-sm-dash" id="reset_cus_unit_filter">Reset Filters</button>
        <button class="btn-dash btn-primary-dash btn-sm-dash" id="apply_filters">Apply Filters</button>
      </div>

          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{number_format($customers_units)}}</div>
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
                    <div style="display:flex; align-items:center; justify-content:center; margin: 30px 30px 0px 30px;">
                      <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" width="100px" alt="">
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
  
  <div id="customer_info_filter" class="tab-content-dash"> 
    <div class="dashboard-grid-dash">
      <!-- Customer Details Card -->
      <div class="card-dash" style="border-radius: 0%">
        <div class="card-header-dash">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-customer">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            Customer Information
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
        <div class="card-body-dash">
      
      <div class="filter-grid">
        <!-- Customer Location Filters -->
        <div class="filter-group">
          <label class="filter-label" for="country-filter">Country</label>
          <select name="country" id="country" class="js-example-basic-single filter-select" style="width: 100%">
              <option value="" selected disabled>Select country here...</option>
              @foreach($country as $per_count)
                  <option value="{{$per_count->countryDesc}}" data-id="{{$per_count->id}}">{{$per_count->countryDesc}}</option>
              @endforeach
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label" for="province-filter">Province</label>
            <select name="province" autocomplete="off" class="js-example-basic-single filter-select" style="width: 100%" id="province" disabled> 
                <option value="" selected disabled>Select province here...</option>
            </select>
        </div>

        <div class="filter-group">
          <label class="filter-label" for="city-filter">City</label>
            <select name="city" autocomplete="off" class="js-example-basic-single filter-select" style="width: 100%" id="city" disabled> 
                <option value="" selected disabled>Select city here...</option>
            </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label" for="barangay-filter">Barangay</label>
            <select name="barangay" autocomplete="off" class="js-example-basic-single filter-select" style="width: 100%" id="barangay" disabled> 
                <option value="" selected disabled>Select barangay here...</option>
            </select>
        </div>
      </div>
      
      <div class="filter-actions">
        <button class="btn-dash btn-outline-dash btn-sm-dash" id="reset_cus_info_filters">Reset Filters</button>
        <button class="btn-dash btn-primary-dash btn-sm-dash" id="apply_customer_info_filter">Apply Filters</button>
      </div>

          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{number_format($customers_info)}}</div>
              <div class="stat-label-dash">Total Customers</div>
            </div>
          </div>

          <div class="customer-table-container">
            <table class="customer-table">
              <thead>
                <tr>
                  <th>Customer Name</th>
                  <th>Country</th>
                  <th>Province</th>
                  <th>City</th>
                  <th>Barangay</th>
                  <th>Transaction Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="6">
                    <div style="display:flex; align-items:center; justify-content:center; margin: 30px 30px 0px 30px;">
                      <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" width="100px" alt="">
                    </div>
                    <p style="text-align: center" class="stat-label-dash">Please filter data</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash" id="showing_data_cus_info"></span>
          <div class="pagination-cust" id="pagination_cus_info" style="margin: 0">
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div id="time_and_motion" class="tab-content-dash">
    <div class="transactions-container">
      <div class="transactions-header" style="margin-top: 0%">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-unit">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" style="color: white" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="time-icon">
                  <circle cx="12" cy="12" r="10"></circle>
                  <polyline points="12 6 12 12 16 14"></polyline>
              </svg>
            </div>
            Time-in-motion
          </h2>
          <div class="search-container">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <input type="text" class="search-input" placeholder="Search transactions...">
          </div>
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
              <button class="pagination-btn-cust pagination-link" 
                  data-url="{{ $time_motion->previousPageUrl() }}" 
                  {{ $time_motion->onFirstPage() ? 'disabled' : '' }}>
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                  <button class="pagination-btn-cust pagination-link" data-url="{{ $time_motion->url(1) }}">1</button>
                  @if ($startPage > 2)
                      <span>...</span>
                  @endif
              @endif
          
              @for ($i = $startPage; $i <= $endPage; $i++)
                  <button class="pagination-btn-cust pagination-link {{ $i == $currentPage ? 'active' : '' }}" 
                      data-url="{{ $time_motion->url($i) }}">
                      {{ $i }}
                  </button>
              @endfor
          
              @if ($endPage < $totalPages)
                  @if ($endPage < $totalPages - 1)
                      <span>...</span>
                  @endif
                  <button class="pagination-btn-cust pagination-link" data-url="{{ $time_motion->url($totalPages) }}">{{ $totalPages }}</button>
              @endif
          
              <!-- Next Button -->
              <button class="pagination-btn-cust pagination-link" 
                  data-url="{{ $time_motion->nextPageUrl() }}" 
                  {{ $time_motion->currentPage() == $time_motion->lastPage() ? 'disabled' : '' }}>
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
<script>
  $(document).ready(function() {
      $('.js-example-basic-single').select2();
  });
    $(document).ready(function () {
      let ctx = $("#salesChart")[0].getContext("2d");
      let salesChart = new Chart(ctx, {
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
              responsive: false,
              maintainAspectRatio: false,
              scales: {
                  y: {
                      beginAtZero: true,
                      ticks: {
                          callback: function (value) {
                              return "₱" + value.toLocaleString();
                          }
                      }
                  }
              }
          }
      });

      function fetchSalesData(year, range) {
          let requestData = {};

          if (range !== "ytd") {
              requestData.year = year; 
          }

          $.ajax({
              url: "{{ route('getSalesData') }}", 
              type: "GET",
              data: requestData,
              success: function (response) {
                  salesChart.data.labels = response[range].labels;
                  salesChart.data.datasets[0].data = response[range].data;
                  salesChart.update();
              }
          });
      }

      // Initial load (default year and weekly)
      let selectedYear = $("#yearFilter").val();
      let selectedRange = $("#timeFilter").val();
      fetchSalesData(selectedYear, selectedRange);

      // Event listener for time filter
      $("#timeFilter").on("change", function () {
          selectedRange = $(this).val();
          fetchSalesData(selectedYear, selectedRange);

          if (selectedRange === 'ytd') {
                $('#yearFilter').hide();
            } else {
                $('#yearFilter').show();
            }
      });

      // Event listener for year filter (only affects weekly & monthly)
      $("#yearFilter").on("change", function () {
          if (selectedRange !== "ytd") {  
              selectedYear = $(this).val();
              fetchSalesData(selectedYear, selectedRange);
          }
      });
  });

  $('#aging_callout_type').on('change', function () {
    let callout_type = $('#aging_callout_type').val();
    if(callout_type === 'FOR CALL-OUT MAIL-IN'){
      $('#fcogu').fadeOut();
      $('#fcomi').fadeIn();
    }else{
      $('#fcogu').fadeIn();
      $('#fcomi').fadeOut();
    }
  });

  $(document).ready(function () {
      let startYear = 2021;
      let currentYear = new Date().getFullYear();
      let yearFilter = $('#yearFilter');

      // Clear existing options
      yearFilter.empty();

      // Generate options from startYear to currentYear
      for (let year = startYear; year <= currentYear; year++) {
          yearFilter.append(`<option value="${year}">${year}</option>`);
      }

      // Set the latest year as selected
      yearFilter.val(currentYear);
  });
</script>
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
        success: function (response) {
            let results = response.data;
            let tbody = $('.unit-table tbody');
            tbody.empty(); // Clear previous results

            if (results.length > 0) {
                $.each(results, function (index, item) {
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

            $('#showing_data_cus_unit').text(`Showing ${response.to - response.from + 1} of ${response.total}`);

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
                paginationLinks += `<button class="pagination-btn-cust ${i === currentPage ? 'active' : ''}" onclick="fetchData(${i})">${i}</button>`;
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
$('#apply_filters').on('click', function () {
    fetchData();
});

  // get provinces
  $(document).ready(function() {
      $('#country').change(function() {
          let countryID = $(this).find(':selected').data('id');

          if (countryID) {
              $.ajax({
                  url: "{{ route('get_provinces') }}", 
                  type: "POST",
                  data: { country_id: countryID },
                  success: function(data) {
                      $('#province').prop('disabled', false);
                      $('#province').html('<option value="" selected disabled>Select province here...</option>');
                      $.each(data, function(key, value) {
                          $('#province').append('<option value="' + value.provDesc + '" data-id="' + value.provCode + '">' + value.provDesc + '</option>');
                      });
                  }
              });
          } else {
              $('#province').prop('disabled', true);
              $('#province').html('<option value="" selected disabled>Select province here...</option>');
          }
      });
  });

  // get cities 
  $(document).ready(function() {
      $('#province').change(function() {
          let provCode = $(this).find(':selected').data('id');

          if (provCode) {
              $.ajax({
                  url: "{{ route('get_cities') }}", 
                  type: "POST",
                  data: { prov_code: provCode },
                  success: function(data) {
                      $('#city').prop('disabled', false);
                      $('#city').html('<option value="" selected disabled>Select city here...</option>');
                      $.each(data, function(key, value) {
                          $('#city').append('<option value="' + value.citymunDesc + '" data-id="' + value.citymunCode + '" data-code="' + value.provCode + '">' + value.citymunDesc + '</option>');
                      });
                  }
              });
          } else {
              $('#city').prop('disabled', true);
              $('#city').html('<option value="" selected disabled>Select city here...</option>');
          }
      });
  });

  // get brgy 
  $(document).ready(function() {
      $('#city').change(function() {
          let citymunCode = $(this).find(':selected').data('id');
          let provCode = $(this).find(':selected').data('code');

          if (provCode && citymunCode) {
              $.ajax({
                  url: "{{ route('get_brgy') }}", 
                  type: "POST",
                  data: { city_mun_code: citymunCode, prov_code: provCode },
                  success: function(data) {
                      $('#barangay').prop('disabled', false);
                      $('#barangay').html('<option value="" selected disabled>Select barangay here...</option>');
                      $.each(data, function(key, value) {
                          $('#barangay').append('<option value="' + value.brgyDesc + '">' + value.brgyDesc + '</option>');
                      });
                  }
              });
          } else {
              $('#barangay').prop('disabled', true);
              $('#barangay').html('<option value="" selected disabled>Select barangay here...</option>');
          }
      });
  });

  function fetchCustomerInfo(page = 1) {
    let country = $('#country').val();
    let province = $('#province').val();
    let city = $('#city').val();
    let brgy = $('#barangay').val();

    $.ajax({
        url: "{{ route('filter_customers_info') }}?page=" + page,
        type: "POST",
        data: { 
            country: country, 
            province: province, 
            city: city,
            brgy: brgy
        },
        success: function (response) {
            let results = response.data;
            let tbody = $('.customer-table tbody');
            tbody.empty(); // Clear previous results

            if (results.length > 0) {
                $.each(results, function (index, item) {
                    let row = `
                        <tr>
                            <td>${item.last_name}, ${item.first_name}</td>
                            <td>${item.country}</td>
                            <td>${item.province}</td>
                            <td>${item.city}</td>
                            <td>${item.barangay}</td>
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

            $('#showing_data_cus_info').text(`Showing ${response.to - response.from + 1} of ${response.total}`);

            // Update Pagination Links
            let paginationLinksInfo = '';
            let totalPages = response.last_page;
            let currentPage = response.current_page;
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            if (response.prev_page_url) {
                paginationLinksInfo += `<button class="pagination-btn-cust" onclick="fetchCustomerInfo(${currentPage - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="15 18 9 12 15 6"></polyline>
                </svg>    
                </button>`;
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationLinksInfo += `<button class="pagination-btn-cust ${i === currentPage ? 'active' : ''}" onclick="fetchCustomerInfo(${i})">${i}</button>`;
            }

            if (response.next_page_url) {
                paginationLinksInfo += `<button class="pagination-btn-cust" onclick="fetchCustomerInfo(${currentPage + 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="9 18 15 12 9 6"></polyline>
                </svg>  
                </button>`;
            }

            $('#pagination_cus_info').html(paginationLinksInfo);
        }
    });
}

// Trigger AJAX when filters are applied
$('#apply_customer_info_filter').on('click', function () {
  fetchCustomerInfo();
});

  $('#reset_cus_unit_filter').on('click', function(){
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

  $('#reset_cus_info_filters').on('click', function() {
    let tbody = $('.customer-table tbody');
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

  // time & motion pagination 
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
