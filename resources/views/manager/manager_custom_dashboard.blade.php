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
        <div class="tabs-dash" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            @foreach ($branch as $index => $per_branch)
                <div class="tab-dash {{ $index === 0 ? 'active' : '' }}" data-tab="tab-{{ $per_branch->id }}">
                    <img src="https://cdn-icons-png.flaticon.com/128/1698/1698561.png" alt="" width="20px">
                    {{ $per_branch->branch_name }}
                </div>
            @endforeach
        </div>

        @foreach ($branch as $index => $per_branch)
            <div id="tab-{{ $per_branch->id }}" class="tab-content-dash {{ $index === 0 ? 'active' : '' }}">
                <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                    <div class="card-header-dash" style="padding: 0px 10px 0px 10px; background: lightgrey">
                        <h2 class="card-title-dash" style="color: white">
                            {{ $per_branch->branch_name }} Overview
                        </h2>
                    </div>
                    <div style="margin-left: 15px">
                        <h5>
                            <i class="bi bi-box-fill"></i>
                            Frontliner Dashboard
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
                                        Pending Call-outs
                                    </h2>
                                </div>
                                <div class="card-body-dash">
                                    <div class="card-actions-dash">
                                        <select name="pending_call_outs" class="input-cus pending-call-outs" data-branch="{{ $per_branch->id }}">
                                            <option value="default" selected>Filter Callouts here...</option>
                                            @foreach ($all_call_out_status as $per_call_out_status)
                                                <option value="{{$per_call_out_status->id}}">{{$per_call_out_status->status_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div class="card-stats-dash">
                                        <div class="stat-dash">
                                            <div class="stat-value-dash" id="filtered-callouts-value">
                                                {{ $fl_pending_call_out_dash_count_all[$per_branch->id] ?? 0 }}
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="stat-label-dash">Total Pending</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <a class="pull-right view-details" data-branchid="{{$per_branch->id}}" style="cursor: pointer">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                    <div class="stat-value-dash">{{ $fl_abandoned_units_dash_count_all[$per_branch->id] ?? 0 }}</div>
                                    <div class="stat-label-dash">Total Abandoned</div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            @php
                                $employees = $handle_per_employee[$per_branch->id] ?? collect();
                                $total_per_branch = $handle_overall_total[$per_branch->id] ?? 0;
                            @endphp

                            @if ($employees->count())
                                <div class="card-dash">
                                    <div class="card-header-dash">
                                        <h2 class="card-title-dash">
                                        <div class="card-icon-dash icon-employe-dash">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </div>
                                        Total Case/s Handled
                                        </h2>
                                    </div>
                                    <div class="card-body-dash">
                                        <div class="employee-chart">
                                        @foreach ($employees as $my_handled_case)
                                            <div class="employee-row" style="margin-bottom: 15px">
                                            <div class="employee-avatar" style="background: #14b8a6; color:aliceblue">
                                                {{ strtoupper(substr($my_handled_case->created_by_user, 0, 1)) }}
                                                {{ strtoupper(substr(strrchr($my_handled_case->created_by_user, ' '), 1, 1)) }}
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
                            @endif

                        </div>
                    </div>


                    <div style="margin-left: 15px">
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
                    </div>

                </div>
            </div>
        @endforeach

        <br>
        <div>
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
                    <select name="branches" id="branches" class="filter-select">
                        @foreach ($branch as $per_branch_item)
                            <option value="{{$per_branch_item->id}}">{{$per_branch_item->branch_name}}</option>
                        @endforeach
                    </select>
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
        </div>

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

@endpush
