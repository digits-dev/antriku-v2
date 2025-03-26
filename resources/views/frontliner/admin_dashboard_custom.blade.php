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
                    <div class="stat-trend-dash {{ $percentage_change >= 0 ? 'trend-down-dash' : 'trend-up-dash' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="{{ $percentage_change >= 0 ? '6 9 12 15 18 9' : '18 15 12 9 6 15' }}"></polyline>
                        </svg>
                        {{ abs($percentage_change) }}% from Yesterday
                    </div>
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
              <div class="stat-trend-dash trend-down-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                0% from Last Week
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="/admin/call_out" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
              <div class="stat-trend-dash trend-up-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
                8% from last week
              </div>
            </div>
          </div>
        </div>
        <div class="card-body-dash">
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
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="/admin/call_out" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
        </div>
      </div>
    </div>

    <div class="dashboard-grid-dash">
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
        <div class="card-body-dash">
          {{-- <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">42</div>
              <div class="stat-label-dash">Avg. Cases per Employee</div>
              <div class="stat-trend-dash trend-up-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
                8% from last month
              </div>
            </div>
          </div> --}}

          <div class="employee-chart">
            <div class="employee-row">
              <div class="employee-badge badge-1">1</div>
              <div class="employee-avatar">JD</div>
              <div class="employee-info">
                <div class="employee-name">John Doe</div>
                <div class="employee-position">Senior Tech</div>
              </div>
              <div class="employee-bar-container">
                <div class="employee-bar" style="width: 100%;"></div>
              </div>
              <div class="employee-value">68</div>
            </div>
            <div class="employee-row">
              <div class="employee-badge badge-2">2</div>
              <div class="employee-avatar">AS</div>
              <div class="employee-info">
                <div class="employee-name">Alice Smith</div>
                <div class="employee-position">Tech Lead</div>
              </div>
              <div class="employee-bar-container">
                <div class="employee-bar" style="width: 85%;"></div>
              </div>
              <div class="employee-value">58</div>
            </div>
            <div class="employee-row">
              <div class="employee-badge badge-3">3</div>
              <div class="employee-avatar">RJ</div>
              <div class="employee-info">
                <div class="employee-name">Robert Johnson</div>
                <div class="employee-position">Field Tech</div>
              </div>
              <div class="employee-bar-container">
                <div class="employee-bar" style="width: 75%;"></div>
              </div>
              <div class="employee-value">51</div>
            </div>
            <div class="employee-row">
              <div class="employee-badge">4</div>
              <div class="employee-avatar">MB</div>
              <div class="employee-info">
                <div class="employee-name">Maria Brown</div>
                <div class="employee-position">Field Tech</div>
              </div>
              <div class="employee-bar-container">
                <div class="employee-bar" style="width: 65%;"></div>
              </div>
              <div class="employee-value">44</div>
            </div>
            <div class="employee-row">
              <div class="employee-badge">5</div>
              <div class="employee-avatar">DW</div>
              <div class="employee-info">
                <div class="employee-name">David Wilson</div>
                <div class="employee-position">Junior Tech</div>
              </div>
              <div class="employee-bar-container">
                <div class="employee-bar" style="width: 55%;"></div>
              </div>
              <div class="employee-value">37</div>
            </div>
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
          <div class="card-actions-dash">
            <select id="timeFilter" class="input-cus">
                <option value="weekly" selected>Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="ytd">YTD</option>
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
  </main>
@endsection
@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
    var ctx = $("#salesChart")[0].getContext("2d");

    // Define datasets for different time ranges
    var chartData = {
        weekly: {
            labels: @json($salesData['weekly']['labels']),
            data: @json($salesData['weekly']['data'])
        },
        monthly: {
            labels: @json($salesData['monthly']['labels']),
            data: @json($salesData['monthly']['data'])
        },
        ytd: {
            labels: @json($salesData['ytd']['labels']),
            data: @json($salesData['ytd']['data'])
        }
    };

    var salesChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: chartData.weekly.labels,
            datasets: [{
                label: "Total Sales Graph",
                data: chartData.weekly.data,
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

    // Event listener for dropdown change
    $("#timeFilter").on("change", function () {
        var selectedRange = $(this).val();
        
        salesChart.data.labels = chartData[selectedRange].labels;
        salesChart.data.datasets[0].data = chartData[selectedRange].data;

        salesChart.update({
            duration: 0,
            lazy: false,
            easing: 'linear'
        });
    });
});
</script>
@endpush
