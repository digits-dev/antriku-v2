@extends('crudbooster::admin_template')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<style>
    .content-header{
        display: none;
    }
</style>
@endpush
@section('content')
<main class="container-dash dashboard-dash">
    <div class="dashboard-header-dash">
      <h1 class="dashboard-title-dash">Frontliner's Dashboard</h1>
      <p class="dashboard-subtitle-dash">Overview of pending call-outs, abandoned units, and aging service requests</p>
    </div>

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
                    {{-- <div class="stat-trend-dash-dash {{ -dash$percentage_change >= 0 ? 'trend-down-dash' : 'trend-up-dash' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="{{ $percentage_change >= 0 ? '6 9 12 15 18 9' : '18 15 12 9 6 15' }}"></polyline>
                        </svg>
                        {{ abs($percentage_change) }}% from Yesterday
                    </div> --}}
                </div>
            </div>
        </div>        
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="/admin/call_out" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
              {{-- <div class="stat-trend-dash-dash tre-dashnd-down-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                0% from Last Week
              </div> --}}
            </div>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="/admin/call_out" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
            Total cases handled
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
                <div class="employee-value">{{$my_handled_case->total_creations}} / {{$handle_overall_total}}</div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
            <div class="card-footer-dash">
              <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
              <a href="/admin/call_out" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
            </div>
          </div>

        <!-- Employee Performance Card -->
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
            Total cases handled per Employee
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
        <div class="card-body-dash" style="height: 295px; overflow-y:auto">
          <div class="employee-chart">
            @foreach ($handle_for_all_employee as $per_employee)
              <div class="employee-row">
                <div class="employee-badge {{ $loop->iteration == 1 ? 'badge-1' : ($loop->iteration == 2 ? 'badge-2' : ($loop->iteration == 3 ? 'badge-3' : '')) }}">
                  {{ $loop->iteration }}
                </div>
                <div class="employee-avatar" style="background: #14b8a6; color:aliceblue">
                  {{ strtoupper(substr($per_employee->created_by_user, 0, 1)) }}
                  {{ strtoupper(substr(strrchr($per_employee->created_by_user, ' '), 1, 1)) }}
                </div>
                <div class="employee-info">
                  <div class="employee-name">{{$per_employee->created_by_user}}</div>
                  <div class="employee-position">{{$per_employee->privilege_name}}</div>
                </div>
                <div class="employee-bar-container">
                  @php
                      // Prevent division by zero error
                      $total_case_handled_per_employee_percentage = $handle_overall_total > 0 
                      ? ($per_employee->total_creations / $handle_overall_total) * 100 
                      : 0;
                  @endphp
                  <div class="employee-bar" style="width: {{$total_case_handled_per_employee_percentage}}%;"></div>
                </div>
                <div class="employee-value">{{$per_employee->total_creations}} / {{$handle_overall_total}}</div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
        </div>
      </div>
    </div>

    <div class="dashboard-grid-dash">
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
          <div class="card-actions-dash" style="width: 200px">
            <select id="timeFilter" class="input-cus">
                <option value="weekly" selected>Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="ytd">YTD</option>
            </select>
            <select id="yearFilter" class="input-cus">
              <option value="2021" selected>2021</option>
            </select>
          </div>
        </div>
        <div class="card-body-dash">
            <canvas id="salesChart"></canvas>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View Details</a>
        </div>
      </div>
    </div>

    {{-- <div class="dashboard-grid-dash">
        <!-- Time Tracker Table Card -->
        <div class="card-dash">
          <div class="card-header-dash">
            <h2 class="card-title-dash">
              <div class="card-icon-dash icon-time-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"></circle>
                  <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
              </div>
              Time and Motion
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
          <div class="filter-controls">
            <div class="filter-group">
              <label class="filter-label" for="date-filter">Date:</label>
              <input type="date" id="date-filter" class="filter-input" value="2021-09-05">
            </div>
            <div class="filter-group">
              <label class="filter-label" for="user-filter">User:</label>
              <select id="user-filter" class="filter-select">
                <option value="all">All Users</option>
                <option value="kailash" selected>Kailash</option>
                <option value="john">John</option>
                <option value="sarah">Sarah</option>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label" for="duration-filter">Duration:</label>
              <select id="duration-filter" class="filter-select">
                <option value="all">All Durations</option>
                <option value="short">Short (< 10s)</option>
                <option value="medium">Medium (10s - 30s)</option>
                <option value="long">Long (> 30s)</option>
              </select>
            </div>
            <button class="btn-dash btn-primary-dash btn-sm-dash">Apply Filters</button>
          </div>
          <div class="tracker-table-container">
            <table class="tracker-table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Transaction ID</th>
                  <th>User ID</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Duration</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>5-Sep-21</td>
                  <td>2323</td>
                  <td>Kailash</td>
                  <td>11:51 AM</td>
                  <td>11:51 AM</td>
                  <td class="duration-cell short-duration">0:00:03</td>
                </tr>
                <tr>
                  <td>5-Sep-21</td>
                  <td>5255</td>
                  <td>Kailash</td>
                  <td>11:51 AM</td>
                  <td>11:52 AM</td>
                  <td class="duration-cell short-duration">0:00:07</td>
                </tr>
                <tr>
                  <td>5-Sep-21</td>
                  <td>3525</td>
                  <td>Kailash</td>
                  <td>11:52 AM</td>
                  <td>11:52 AM</td>
                  <td class="duration-cell medium-duration">0:00:11</td>
                </tr>
                <tr>
                  <td>5-Sep-21</td>
                  <td>6225</td>
                  <td>Kailash</td>
                  <td>11:52 AM</td>
                  <td>11:52 AM</td>
                  <td class="duration-cell short-duration">0:00:07</td>
                </tr>
                <tr>
                  <td>5-Sep-21</td>
                  <td>5272</td>
                  <td>Kailash</td>
                  <td>11:52 AM</td>
                  <td>11:52 AM</td>
                  <td class="duration-cell short-duration">0:00:07</td>
                </tr>
                <tr>
                  <td>5-Sep-21</td>
                  <td>7363</td>
                  <td>Kailash</td>
                  <td>11:53 AM</td>
                  <td>11:53 AM</td>
                  <td class="duration-cell medium-duration">0:00:33</td>
                </tr>
                <tr>
                  <td>5-Sep-21</td>
                  <td>8124</td>
                  <td>Kailash</td>
                  <td>11:54 AM</td>
                  <td>11:55 AM</td>
                  <td class="duration-cell medium-duration">0:00:22</td>
                </tr>
                <tr>
                  <td>5-Sep-21</td>
                  <td>9235</td>
                  <td>Kailash</td>
                  <td>11:55 AM</td>
                  <td>11:56 AM</td>
                  <td class="duration-cell long-duration">0:01:05</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Showing 8 of 24 transactions</span>
          <div class="pagination" style="margin: 0">
            <button class="pagination-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            </button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div> --}}
  </main>

  <main class="container-dash dashboard-dash">
    <div class="dashboard-header-dash">
      <h1 class="dashboard-title-dash">Customer & Unit Management</h1>
      <p class="dashboard-subtitle-dash">Filter and manage customer information and unit details</p>
    </div>

    <div class="dashboard-grid-dash">
      <!-- Unit Details Card -->
      <div class="card-dash">
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
        <input type="text" class="search-input input-cus" placeholder="Search by customer name, ID, or unit details...">
      </div>
      
      <div class="filter-grid">
        <!-- Unit Filters -->
        <div class="filter-group">
          <label class="label-cus" for="unit-type-filter">Unit Type</label>
          <select id="unit-type-filter" class="filter-select">
            <option value="all" selected>All Units</option>
            <option value="iMac">iMac</option>      
            <option value="iPhone">iPhone</option>      
            <option value="macbook">MacBook</option>      
            <option value="mac mini">Mac Mini</option>      
            <option value="airpods">AirPods</option>      
            <option value="keyboard">Keyboard</option>      
            <option value="mouse">Mouse</option>      
            <option value="iPad">iPad</option>      
            <option value="Apple watch">Apple Watch</option>      
            <option value="trackpad">TrackPad</option>      
            <option value="apple tv">Apple TV</option>      
            <option value="studio display">Studio Display</option>      
            <option value="MAC Pro">MAC Pro</option>      
            <option value="Mac Studio">Mac Studio</option>      
            <option value="beats headphones">Beats Headphones</option>      
            <option value="beats earphone">Beats Earphones</option>
          </select>
        </div>
        
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
        <button class="btn-dash btn-outline-dash btn-sm-dash">Reset Filters</button>
        <button class="btn-dash btn-primary-dash btn-sm-dash" id="apply_filters">Apply Filters</button>
      </div>

          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{number_format($customers_units)}}</div>
              <div class="stat-label-dash">Total Customers with Units</div>
              <div class="stat-trend-dash trend-up-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
                12% from last month
              </div>
            </div>
          </div>

          <div class="unit-table-container">
            <table class="unit-table">
              <thead>
                <tr>
                  <th>Reference</th>
                  <th>Unit Type</th>
                  <th>Customer</th>
                  <th>Location</th>
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
          <span class="card-footer-text-dash">Showing 5 of 2,156 units</span>
          <div class="pagination" style="margin: 0">
            <button class="pagination-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            </button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="dashboard-grid-dash">
      <!-- Customer Details Card -->
      <div class="card-dash">
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

          <!-- Filter Section -->
      <h2 class="filter-title">
        <div class="filter-icon">
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
        <input type="text" class="search-input" placeholder="Search by customer name, ID, or unit details...">
      </div>
      
      <div class="filter-grid">
        <!-- Customer Location Filters -->
        <div class="filter-group">
          <label class="filter-label" for="country-filter">Country</label>
          <select id="country-filter" class="filter-select">
            <option value="">All Countries</option>
            <option value="philippines">Philippines</option>
            <option value="malaysia">Malaysia</option>
            <option value="singapore">Singapore</option>
            <option value="indonesia">Indonesia</option>
            <option value="thailand">Thailand</option>
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label" for="city-filter">City</label>
          <select id="city-filter" class="filter-select">
            <option value="">All Cities</option>
            <option value="manila">Manila</option>
            <option value="quezon">Quezon City</option>
            <option value="makati">Makati</option>
            <option value="pasig">Pasig</option>
            <option value="taguig">Taguig</option>
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label" for="barangay-filter">Barangay</label>
          <select id="barangay-filter" class="filter-select">
            <option value="">All Barangays</option>
            <option value="barangay1">Barangay 1</option>
            <option value="barangay2">Barangay 2</option>
            <option value="barangay3">Barangay 3</option>
            <option value="barangay4">Barangay 4</option>
            <option value="barangay5">Barangay 5</option>
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label" for="date-range">Date Range</label>
          <input type="date" id="date-range" class="filter-input">
        </div>
      </div>
      
      <div class="filter-actions">
        <button class="btn-dash btn-outline-dash btn-sm-dash">Reset Filters</button>
        <button class="btn-dash btn-primary-dash btn-sm-dash">Apply Filters</button>
      </div>

          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">1,248</div>
              <div class="stat-label-dash">Total Customers</div>
              <div class="stat-trend-dash trend-up-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
                8% from last month
              </div>
            </div>
          </div>

          <div class="customer-table-container">
            <table class="customer-table">
              <thead>
                <tr>
                  <th>Customer ID</th>
                  <th>Name</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>Barangay</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>C-1001</td>
                  <td>Maria Santos</td>
                  <td>Philippines</td>
                  <td>Manila</td>
                  <td>Barangay 128</td>
                  <td><span class="status-badge status-active">Active</span></td>
                </tr>
                <tr>
                  <td>C-1002</td>
                  <td>Juan Dela Cruz</td>
                  <td>Philippines</td>
                  <td>Quezon City</td>
                  <td>Barangay Loyola</td>
                  <td><span class="status-badge status-active">Active</span></td>
                </tr>
                <tr>
                  <td>C-1003</td>
                  <td>Roberto Tan</td>
                  <td>Philippines</td>
                  <td>Makati</td>
                  <td>Barangay Poblacion</td>
                  <td><span class="status-badge status-inactive">Inactive</span></td>
                </tr>
                <tr>
                  <td>C-1004</td>
                  <td>Elena Reyes</td>
                  <td>Philippines</td>
                  <td>Pasig</td>
                  <td>Barangay Pinagbuhatan</td>
                  <td><span class="status-badge status-active">Active</span></td>
                </tr>
                <tr>
                  <td>C-1005</td>
                  <td>Michael Garcia</td>
                  <td>Philippines</td>
                  <td>Taguig</td>
                  <td>Barangay Fort Bonifacio</td>
                  <td><span class="status-badge status-pending">Pending</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="pagination">
            <button class="pagination-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            </button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
              </svg>
            </button>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Showing 5 of 1,248 customers</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">Export Data</a>
        </div>
      </div>
    </div>  
  </main>
@endsection
@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
      yearFilter.val(startYear);
  });
</script>
<script>
$('#apply_filters').on('click', function () {
    let unit_type = $('#unit-type-filter').val();
    let date_range_from = $('#date-range-from').val();
    let date_range_to = $('#date-range-to').val();

    if (unit_type || date_range_from || date_range_to) {
        $.ajax({
            url: "{{ route('filter_customers_units') }}",
            type: "POST",
            data: { 
              unit_type: unit_type, 
              date_range_from: date_range_from, 
              date_range_to: date_range_to 
            },
            success: function (response) {
                let results = response.filter_results;
                let tbody = $('.unit-table tbody');
                tbody.empty(); // Clear previous results

                if (results.length > 0) {
                    $.each(results, function (index, item) {
                        let row = `
                            <tr>
                                <td>${item.reference_no}</td>
                                <td>${item.unit_type}</td>
                                <td>${item.last_name}, ${item.first_name}</td>
                                <td>${item.city}</td>
                                <td>${item.created_at}</td>
                                <td>${item.warranty_status}</td>
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
            }
        });
    } else {
        alert("Request Invalid!");
    }
});
</script>
@endpush
