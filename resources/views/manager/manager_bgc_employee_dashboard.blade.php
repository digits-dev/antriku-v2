<div style="padding-bottom: 10px;">
    <small class="text-uppercase">
        <i class="bi bi-person-workspace"></i>
        Frontliners
    </small>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card-dash">
          <div class="card-header-dash">
            <h2 class="card-title-dash">
              <div class="card-icon-dash icon-default">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
              </div>
              Total cases handled per Frontliner
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
          <div class="card-body-dash" style="height: 450px; overflow-y:auto; cursor: pointer;">
            <div class="employee-chart">
              @foreach ($handle_for_all_employee_bgc as $per_employee)
                <div class="employee-row fl_employee_row_bgc" data-creator_id="{{$per_employee->created_by_id}}">
                  <div class="employee-badge {{ $loop->iteration == 1 ? 'badge-1' : ($loop->iteration == 2 ? 'badge-2' : ($loop->iteration == 3 ? 'badge-3' : '')) }}">
                    @if ($loop->iteration == 1)
                        <img src="https://cdn-icons-png.flaticon.com/128/744/744984.png" alt="" width="20px">
                    @elseif ($loop->iteration == 2)
                        <img src="https://cdn-icons-png.flaticon.com/128/11881/11881956.png" alt="" width="20px">
                    @elseif ($loop->iteration == 3)
                        <img src="https://cdn-icons-png.flaticon.com/128/11881/11881954.png" alt="" width="20px">
                    @else
                        {{ $loop->iteration }}
                    @endif
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
                        $total_case_handled_per_employee_percentage = $handle_overall_total_bgc > 0 
                        ? ($per_employee->total_creations / $handle_overall_total_bgc) * 100 
                        : 0;
                    @endphp
                    <div class="employee-bar" style="width: {{$total_case_handled_per_employee_percentage}}%;"></div>
                  </div>
                  <div class="employee-value">{{number_format($per_employee->total_creations)}} / {{number_format($handle_overall_total_bgc)}}</div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-dash">
            <div class="card-body-dash" style="height: 523px; overflow-y:auto; cursor:pointer;">
                <div class="loading-area-bgc" style="display: none;">
                    <br><br><br><br><br>
                    <div style="display: flex; justify-content: center; align-items:center">
                      <img width="100" src="https://cdn-icons-gif.flaticon.com/10282/10282620.gif"/>
                    </div>
                    <center><p style="text-align:center">Loading data, please wait...</p></center>
                </div>
                <div class="row main-content-bgc-fl">
                    <div class="col-md-6">
                        <div class="m-dash-card m-dash-default" style="cursor: pointer;">
                            <div class="m-dash-card-header" style="margin: 0">
                                <div class="m-dash-card-title">
                                    <i class="bi bi-telephone-minus-fill" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                    Pending Call-outs
                                </div>
                                <hr>
                            </div>
                            <div class="m-dash-card-value bgc-Pending-Call-outs">
                                0
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="m-dash-card m-dash-default" style="cursor: pointer;">
                            <div class="m-dash-card-header" style="margin: 0">
                                <div class="m-dash-card-title">
                                    <i class="bi bi-emoji-frown-fill" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                    Abandoned Units
                                </div>
                                <hr>
                            </div>
                            <div class="m-dash-card-value bgc-abandoned-units">
                                0
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card-body-dash">
                            <div class="chart-container" style="position: relative; height: 320px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                                <div id="fl-chart">
                                    <canvas id="handledCasesChartBGC"></canvas>
                                </div>
                                <div style="margin-bottom: 40px;" class="chart-empty-data-bgc">
                                    <center>
                                        <img src="https://cdn-icons-png.flaticon.com/128/13543/13543330.png" width="70px" alt="">
                                        <p>Please select a Frontliner</p>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="padding-bottom: 10px; margin-top: 20px;">
    <hr>
    <small class="text-uppercase">
        <i class="bi bi-person-workspace"></i>
        Technicians
    </small>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card-dash">
          <div class="card-header-dash">
            <h2 class="card-title-dash">
              <div class="card-icon-dash icon-default">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
              </div>
              Total cases handled per Technician
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
          <div class="card-body-dash" style="height: 450px; overflow-y:auto; cursor: pointer;">
            <div class="employee-chart">
              @foreach ($handle_for_all_employee_tech_bgc as $per_employee)
                <div class="employee-row tech_employee_row_bgc" data-assigned_id="{{$per_employee->assigned_tech}}">
                  <div class="employee-badge {{ $loop->iteration == 1 ? 'badge-1' : ($loop->iteration == 2 ? 'badge-2' : ($loop->iteration == 3 ? 'badge-3' : '')) }}">
                        @if ($loop->iteration == 1)
                            <img src="https://cdn-icons-png.flaticon.com/128/744/744984.png" alt="" width="20px">
                        @elseif ($loop->iteration == 2)
                            <img src="https://cdn-icons-png.flaticon.com/128/11881/11881956.png" alt="" width="20px">
                        @elseif ($loop->iteration == 3)
                            <img src="https://cdn-icons-png.flaticon.com/128/11881/11881954.png" alt="" width="20px">
                        @else
                            {{ $loop->iteration }}
                        @endif
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
                        $total_case_handled_per_employee_percentage = $handle_overall_total_tech_bgc > 0 
                        ? ($per_employee->total_creations / $handle_overall_total_tech_bgc) * 100 
                        : 0;
                    @endphp
                    <div class="employee-bar" style="width: {{$total_case_handled_per_employee_percentage}}%;"></div>
                  </div>
                  <div class="employee-value">{{number_format($per_employee->total_creations)}} / {{number_format($handle_overall_total_tech_bgc)}}</div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-dash">
            <div class="card-body-dash" style="height: 523px; overflow-y:auto; cursor:pointer;">
                <div class="loading-area-tech-bgc" style="display: none;">
                    <br><br><br><br><br>
                    <div style="display: flex; justify-content: center; align-items:center">
                      <img width="100" src="https://cdn-icons-gif.flaticon.com/10282/10282620.gif"/>
                    </div>
                    <center><p style="text-align:center">Loading data, please wait...</p></center>
                </div>
                <div class="row main-content-bgc-tech">
                    <div class="col-md-6">
                        <div class="m-dash-card m-dash-default" style="cursor: pointer;">
                            <div class="m-dash-card-header" style="margin: 0">
                                <div class="m-dash-card-title">
                                    <i class="bi bi-wrench-adjustable" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                    Ongoing Repair Cases (Carry In)
                                </div>
                                <hr>
                            </div>
                            <div class="m-dash-card-value bgc-ongoin-repair">
                                0
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="m-dash-card m-dash-default" style="cursor: pointer;">
                            <div class="m-dash-card-header" style="margin: 0">
                                <div class="m-dash-card-title">
                                    <i class="bi bi-gear-wide-connected" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                    Awaiting Repair Cases (Mail In)
                                </div>
                                <hr>
                            </div>
                            <div class="m-dash-card-value bgc-awaiting-repair">
                                0
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card-body-dash">
                            <div class="chart-container" style="position: relative; height: 320px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                                <div id="tech-chart">
                                    <canvas id="assigningJOBGC"></canvas>
                                </div>
                                <div style="margin-bottom: 40px;" class="chart-empty-data-tech-bgc">
                                    <center>
                                        <img src="https://cdn-icons-png.flaticon.com/128/13543/13543330.png" width="70px" alt="">
                                        <p>Please select a Technician</p>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartInstanceBGC = null;

    // Custom plugin to draw total in center
    const centerTextPluginBGC = {
        id: 'centerText',
        beforeDraw(chart) {
            const { width, height, ctx } = chart;
            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

            ctx.save();
            ctx.font = 'bold 30px sans-serif';
            ctx.fillStyle = '#000';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(`${total}`, width / 2, height / 2.5);
            ctx.restore();
        }
    };

    $('.fl_employee_row_bgc').on('click', function () {
        let creator_id = $(this).data('creator_id');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('.loading-area-bgc').show();
        $('.main-content-bgc-fl').hide();

        $.ajax({
            url: '{{ route("manager_dash_per_employee") }}',
            method: 'POST',
            data: { creator_id: creator_id },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('.loading-area-bgc').hide();
                $('.chart-empty-data-bgc').hide();
                $('.main-content-bgc-fl').show();

                if (response.success) {
                    $('.bgc-Pending-Call-outs').text(response.pending_callouts_count);
                    $('.bgc-abandoned-units').text(response.abandoned_units_count);

                    // Count repair_status
                    let completedCount = 0;
                    let ongoingCount = 0;

                    response.data.forEach(item => {
                        if (item.repair_status == 6) {
                            completedCount++;
                        } else {
                            ongoingCount++;
                        }
                    });

                    const total = completedCount + ongoingCount;

                    // Prepare chart data
                    const chartData = {
                        labels: [
                            `COMPLETED (${completedCount})`,
                            `PENDING/ONGOING (${ongoingCount})`
                        ],
                        datasets: [{
                            data: [completedCount, ongoingCount],
                            backgroundColor: ['#222831', '#B6B09F'],
                            borderColor: ['#ffffff', '#ffffff'],
                            borderWidth: 5,
                            borderRadius: 8
                        }]
                    };

                    const chartOptions = {
                        responsive: true,
                        cutout: '50%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 20,
                                    padding: 15,
                                    color: '#333',
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    };

                    if (chartInstanceBGC) {
                        chartInstanceBGC.destroy();
                    }

                    const ctx = document.getElementById('handledCasesChartBGC').getContext('2d');
                    chartInstanceBGC = new Chart(ctx, {
                        type: 'doughnut',
                        data: chartData,
                        options: chartOptions,
                        plugins: [centerTextPluginBGC]
                    });
                }
            },
            error: function (xhr, status, error) {
                $('.loading-area-bgc').hide();
                $('.chart-empty-data-bgc').hide();
                $('.main-content-bgc-fl').show();
                console.error('Error:', status, error);
            }
        });
    });

    $('.tech_employee_row_bgc').on('click', function () {
        let assigned_id = $(this).data('assigned_id');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('.loading-area-tech-bgc').show();
        $('.main-content-bgc-tech').hide();

        $.ajax({
            url: '{{ route("manager_dash_per_employee_tech") }}',
            method: 'POST',
            data: { assigned_id: assigned_id },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('.loading-area-tech-bgc').hide();
                $('.chart-empty-data-tech-bgc').hide();
                $('.main-content-bgc-tech').show();

                if (response.success) {
                    $('.bgc-ongoin-repair').text(response.total_ongoing_jo);
                    $('.bgc-awaiting-repair').text(response.total_awaiting_jo);

                    // Count for chart
                    let acceptedJO = response.total_accepted_jo;
                    let unacceptedJO = response.total_unaccepted_jo;
                    let totalJO = acceptedJO + unacceptedJO;

                    // Prepare chart data
                    const assignJoDataBGC = {
                        labels: [
                            `ACCEPTED ASSIGNED JO (${acceptedJO})`,
                            `PENDING ASSIGNED JO (${unacceptedJO})`
                        ],
                        datasets: [{
                            data: [acceptedJO, unacceptedJO],
                            backgroundColor: ['#222831', '#B6B09F'],
                            borderColor: ['#fff', '#fff'],
                            borderWidth: 5,
                            borderRadius: 8
                        }]
                    };

                    // Add total in the center
                    const centerTextPluginAssignJO = {
                        id: 'centerTextPluginAssignJO',
                        beforeDraw: function(chart) {
                            const width = chart.width,
                                height = chart.height,
                                ctx = chart.ctx;
                            ctx.restore();
                            const fontSize = (height / 120).toFixed(2);
                            ctx.font = `${fontSize}em sans-serif`;
                            ctx.textBaseline = "middle";
                            ctx.textAlign = "center";
                            const text = `${totalJO}`;
                            const textX = width / 2;
                            const textY = height / 2.5;
                            ctx.fillText(text, textX, textY);
                            ctx.save();
                        }
                    };

                    // Destroy existing chart if needed
                    if (window.assignJOChart) {
                        window.assignJOChart.destroy();
                    }

                    // Create chart
                    const assignJoCtx = document.getElementById('assigningJOBGC').getContext('2d');
                    window.assignJOChart = new Chart(assignJoCtx, {
                        type: 'doughnut',
                        data: assignJoDataBGC,
                        options: {
                            responsive: true,
                            cutout: '50%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 20,
                                        padding: 15
                                    }
                                }
                            }
                        },
                        plugins: [centerTextPluginAssignJO]
                    });

                }
            },
            error: function (xhr, status, error) {
                $('.loading-area-tech-bgc').hide();
                $('.chart-empty-data-tech-bgc').hide();
                $('.main-content-bgc-tech').show();
                console.error('Error:', status, error);
            }
        });
    });
</script>