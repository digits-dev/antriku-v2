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
                    {{-- <div class="stat-trend-dash {{ $percentage_change >= 0 ? 'trend-down-dash' : 'trend-up-dash' }}">
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
              {{-- <div class="stat-trend-dash trend-down-dash">
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
@endpush
