
<div class="col-md-8">
    <div class="row">
        <div class="col-md-5">
            <div class="row">
            <div class="col-md-12">
                <div class="m-dash-card m-dash-default clickable_card1" id="clickable_card1"
                    style="cursor: pointer;">
                    <div class="m-dash-card-header" style="margin: 0">
                        <div class="m-dash-card-title">
                            <i class="bi bi-clipboard2-check-fill"
                                style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                            Total Ongoing Diagnosis
                        </div>
                        <hr>
                    </div>
                    <div class="m-dash-card-value" id="filtered-callouts-value">
                        {{ count($myOngoingDiagnosis) ?? 0 }}
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <br>
                <div class="m-dash-card m-dash-default clickable_card1" id="clickable_card1"
                    style="cursor: pointer;">
                    <div class="m-dash-card-header" style="margin: 0">
                        <div class="m-dash-card-title">
                            <i class="bi bi-clipboard2-check-fill"
                                style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                            Total Ongoing Repair Cases (Carry-In)
                        </div>
                        <hr>
                    </div>
                    <div class="m-dash-card-value" id="filtered-callouts-value">
                        {{ count($myOngoingRepair) ?? 0 }}
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <br>
                <div class="m-dash-card m-dash-default clickable_card1" id="clickable_card1"
                    style="cursor: pointer;">
                    <div class="m-dash-card-header" style="margin: 0">
                        <div class="m-dash-card-title">
                            <i class="bi bi-clipboard2-check-fill"
                                style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                            Total Awaiting Repair Cases (Mail-In)
                        </div>
                        <hr>
                    </div>
                    <div class="m-dash-card-value" id="filtered-callouts-value">
                        {{ count($myAwaitingRepair) ?? 0 }}
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="row">
            <div class="col-md-12">
                <div class="transactions-container">
                    <div class="transactions-header" style="margin: 0%">
                        <h2 class="card-title-dash" style="margin-top: 1px">
                            <div class="card-icon-dash icon-default">
                                <i class="bi bi-pie-chart-fill" style="font-size: 12px"></i>
                            </div>
                            Assigning Job Order Distribution
                        </h2>
                    </div>
                    <div class="card-body-dash">
                        <div class="chart-container"
                            style="position: relative; height: 330px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                            <canvas id="assigningJoChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
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
                    <div class="search-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65">
                            </line>
                        </svg>
                        <input type="text" class="search-input search-input-tech"
                            placeholder="Search transactions...">
                    </div>
                </div>
                <div style="height: 360px; overflow: auto;">
                    <table class="transactions-table" autofocus>
                        <thead>
                            <tr>
                                <th style="font-size: 12px" class="text-uppercase">
                                    Reference No.
                                </th>
                                <th style="font-size: 12px" class="text-uppercase">
                                    Warranty Type
                                </th>
                                <th style="font-size: 12px" class="text-uppercase">
                                    Case Type
                                </th>
                                <th style="font-size: 12px" class="text-uppercase">
                                    Model
                                </th>
                                <th style="font-size: 12px" class="text-uppercase">
                                    Customer
                                </th>
                                <th style="font-size: 12px" class="text-uppercase">
                                    Assigned Tech
                                </th>
                                <th style="font-size: 12px" class="text-uppercase">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tech-tbody" style="text-align: left; background: rgba(240, 246, 247, 0.7);">
                            @php
                                $allData = [];

                                // Helper function to merge with unique status labels
                                function mergeTechData(&$allData, $collection, $label)
                                {
                                    foreach ($collection as $item) {
                                        $id = $item->id ?? ($item->reference_no ?? uniqid()); // fallback in case no ID

                                        if (!isset($allData[$id])) {
                                            $item->status_labels = [$label];
                                            $allData[$id] = $item;
                                        } else {
                                            // If already exists, just add the label
                                            if (!in_array($label, $allData[$id]->status_labels)) {
                                                $allData[$id]->status_labels[] = $label;
                                            }
                                        }
                                    }
                                }

                                mergeTechData($allData, $myOngoingDiagnosis, 'diagnosing');
                                mergeTechData($allData, $myOngoingRepair, 'repairing');
                                mergeTechData($allData, $myAwaitingRepair, 'awaiting');

                                mergeTechData($allData, $totalCarryIn, 'carry-in');
                                mergeTechData($allData, $totalMailIn, 'mail-in');
                                mergeTechData($allData, $totalIW, 'in-warranty');
                                mergeTechData($allData, $totalOOW, 'out-of-warranty');

                                mergeTechData($allData, $totalToAsign, 'to-assign-jo');
                                mergeTechData($allData, $totalPedningAssigned, 'pending-assigned-jo');

                                // Just for chart counts
                                $total_carry_in = $totalCarryIn->count();
                                $total_mail_in = $totalMailIn->count();
                                $total_iw = $totalIW->count();
                                $total_oow = $totalOOW->count();

                                $total_to_assing_jo = $totalToAsign->count();
                                $total_pending_assigned_jo = $totalPedningAssigned->count();
                            @endphp

                            @foreach ($allData as $item)
                                <tr data-status="{{ implode(' ', $item->status_labels) }}">
                                    <td style="font-size: 12px">{!! $item->reference_no ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                                    <td style="font-size: 12px">{!! $item->warranty_status ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                                    <td style="font-size: 12px">{!! $item->case_status ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                                    <td style="font-size: 12px">{!! $item->model_name ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                                    <td style="font-size: 12px">{!! $item->last_name . ', ' . $item->first_name ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                                    <td style="font-size: 12px">{!! $item->assigned_tech ?? '<small class="m-dash-negative">Un-Assigned JO</small>' !!}</td>
                                    <td
                                        style="font-size: 12px; color:{{ $item->status_name == 'COMPLETE' ? 'limegreen' : 'darkorange' }}">
                                        {!! $item->status_name ?? '<small class="m-dash-negative">Empty</small>' !!}
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="no-data-row" style="display: none;">
                                <td colspan="7"
                                    style="text-align: center; font-size: 14px; padding: 20px; color: #888;">
                                    <br>
                                    <center>
                                        <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png"
                                            alt="">
                                    </center>
                                    <center>
                                        <small class="text-uppercase">Empty Data. Please select
                                            <br> what report you want to check.</small>
                                    </center>
                                    <br><br>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer-dash">
                    {{-- <span class="card-footer-text-dash showing_data_tech_overview"
                        id="showing_data_tech_overview">
                        Showing {{ count($allData) }} Total of Data
                    </span> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="row">
        <div class="col-md-12">
            <div class="transactions-container">
                <div class="transactions-header" style="margin: 0%;">
                    <h2 class="card-title-dash" style="margin-top: 1px">
                        <div class="card-icon-dash icon-default">
                            <i class="bi bi-bar-chart-line-fill" style="font-size: 12px"></i>
                        </div>
                        Overall Warranty Type Distribution
                    </h2>
                </div>
                <div class="card-body-dash">
                    <div class="chart-container"
                        style="position: relative; height: 330px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                        <canvas id="warrantyChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br>
            <div class="transactions-container">
                <div class="transactions-header" style="margin: 0%">
                    <h2 class="card-title-dash" style="margin-top: 1px">
                        <div class="card-icon-dash icon-default">
                            <i class="bi bi-pie-chart-fill" style="font-size: 12px"></i>
                        </div>
                        Overall Case Type Distribution
                    </h2>
                </div>
                <div class="card-body-dash">
                    <div class="chart-container"
                        style="position: relative; height: 387px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                        <canvas id="repairTypeChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-doughnutlabel@1.0.3"></script>

<script>
    $(document).ready(function() {
        $('.clickable_card1').on('click', function() {
            const title = $(this).find('.m-dash-card-title').text().trim();
            let status = '';

            if (title === 'Total Ongoing Diagnosis') {
                status = 'diagnosing';
            } else if (title === 'Total Ongoing Repair Cases (Carry-In)') {
                status = 'repairing';
            } else if (title === 'Total Awaiting Repair Cases (Mail-In)') {
                status = 'awaiting';
            }

            $('.clickable_card1').removeClass('active-card');
            $(this).addClass('active-card');

            let visibleCount = 0;

            $('.tech-tbody tr').each(function() {
                const rowStatus = $(this).data('status');

                if (!rowStatus) return;

                // Adjusted: check if the status label is contained in rowStatus
                if (rowStatus.includes(status)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            if (visibleCount === 0) {
                $('.no-data-row').show();
            } else {
                $('.no-data-row').hide();
            }

            $('.showing_data_tech_overview').text(`Showing ${visibleCount} Total of Data`);
        });
    });
</script>

<script>
    $(document).ready(function() {
        const tableFilterByStatus = (status) => {
            let visibleCount = 0;

            $('.tech-tbody tr').each(function() {
                const rowStatus = $(this).data('status');
                if (!rowStatus) return;

                if (rowStatus.includes(status)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            if (visibleCount === 0) {
                $('.no-data-row').show();
            } else {
                $('.no-data-row').hide();
            }

            $('.showing_data_tech_overview').text(`Showing ${visibleCount} Total of Data`);
        };

        // ====================
        // Assigning Job Order Doughnut Chart Setup
        // ====================
        const assigningJoCtx = document.getElementById('assigningJoChart').getContext('2d');
        const totalAssigning = {{ $total_to_assing_jo ?? 0 }} + {{ $total_pending_assigned_jo ?? 0 }};
        const assigningChart = new Chart(assigningJoCtx, {
            type: 'doughnut',
            data: {
                labels: ['To Assign JO', 'Pending Assigned JO'],
                datasets: [{
                    data: [{{ $total_to_assing_jo ?? 0 }}, {{ $total_pending_assigned_jo ?? 0 }}],
                    backgroundColor: ['#222831', '#948979'],
                    borderWidth: 5,
                    hoverOffset: 10,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const label = assigningChart.data.labels[elements[0].index];
                        const status = label.toLowerCase().replace(/ /g, '-');
                        tableFilterByStatus(status);
                    }
                },
                cutout: '45%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const percentage = ((value / totalAssigning) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    },
                    doughnutlabel: {
                        labels: [{
                                text: totalAssigning,
                                font: {
                                    size: '30',
                                    weight: 'bold'
                                }
                            },
                            {
                                text: 'Total',
                                font: {
                                    size: '14'
                                }
                            }
                        ]
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // ====================
        // Doughnut Chart Setup
        // ====================
        const repairTypeCtx = document.getElementById('repairTypeChart').getContext('2d');
        const total = {{ $total_carry_in ?? 0 }} + {{ $total_mail_in ?? 0 }};
        const repairChart = new Chart(repairTypeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Carry-In', 'Mail-In'],
                datasets: [{
                    data: [{{ $total_carry_in ?? 0 }}, {{ $total_mail_in ?? 0 }}],
                    backgroundColor: ['#222831', '#948979'],
                    borderWidth: 5,
                    hoverOffset: 10,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const label = repairChart.data.labels[elements[0].index];
                        const status = label.toLowerCase().replace(/ /g, '-'); // e.g., carry-in
                        tableFilterByStatus(status);
                    }
                },
                cutout: '45%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    },
                    doughnutlabel: {
                        labels: [{
                                text: total,
                                font: {
                                    size: '30',
                                    weight: 'bold'
                                }
                            },
                            {
                                text: 'Total',
                                font: {
                                    size: '14'
                                }
                            }
                        ]
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // ====================
        // Bar Chart Setup
        // ====================
        const warrantyCtx = document.getElementById('warrantyChart').getContext('2d');
        const warrantyChart = new Chart(warrantyCtx, {
            type: 'bar',
            data: {
                labels: ['In-Warranty', 'Out-of-Warranty'],
                datasets: [{
                    label: 'Repair Cases',
                    data: [{{ $total_iw ?? 0 }}, {{ $total_oow ?? 0 }}],
                    backgroundColor: ['#948979', '#222831'],
                    borderWidth: 5,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const label = warrantyChart.data.labels[elements[0].index];
                        const status = label.toLowerCase().replace(/ /g, '-');
                        tableFilterByStatus(status);
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Number of Cases'
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.search-input-tech').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            let visibleCount = 0;

            $('.tech-tbody tr').each(function() {
                const rowText = $(this).text().toLowerCase();

                if (rowText.includes(searchTerm)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            // Show/hide "no data" row
            if (visibleCount === 0) {
                $('.no-data-row').show();
            } else {
                $('.no-data-row').hide();
            }

            // Update total count display
            $('.showing_data_tech_overview').text(`Showing ${visibleCount} Total of Data`);
        });
    });
</script>