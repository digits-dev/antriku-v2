<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="m-dash-card m-dash-default m-dash-pms" style="cursor: pointer;">
                <div class="m-dash-card-header" style="margin: 0">
                    <div class="m-dash-card-title">
                        <i class="bi bi-clipboard2-check-fill"
                            style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                        Pending Mail-In Shipment
                    </div>
                    <hr>
                </div>
                <div class="m-dash-card-value" id="filtered-callouts-value">
                    {{ count($pending_mail_in_shipment_dash_bgc) }}
                </div>
                <div class="m-dash-card-change m-dash-positive">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-dash-card m-dash-default m-dash-spr" style="cursor: pointer;">
                <div class="m-dash-card-header" style="margin: 0">
                    <div class="m-dash-card-title">
                        <i class="bi bi-clipboard2-check-fill"
                            style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                        Spare Parts Receiving
                    </div>
                    <hr>
                </div>
                <div class="m-dash-card-value" id="filtered-callouts-value">
                    {{ count($spare_parts_receiving_dash_bgc) }}
                </div>
                <div class="m-dash-card-change m-dash-positive">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="m-dash-card m-dash-default m-dash-spre" style="cursor: pointer;">
                <div class="m-dash-card-header" style="margin: 0">
                    <div class="m-dash-card-title">
                        <i class="bi bi-clipboard2-check-fill"
                            style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                        Spare Parts Releasing
                    </div>
                    <hr>
                </div>
                <div class="m-dash-card-value" id="filtered-callouts-value">
                    {{ count($spare_parts_releasing_dash_bgc) }}
                </div>
                <div class="m-dash-card-change m-dash-positive">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-8">
    <br>
    <div class="card-dash">
        <div class="card-header-dash">
            <h2 class="card-title-dash">
                <div class="card-icon-dash icon-default">
                    <i class="bi bi-clipboard-data-fill" style="font-size: 15px;"></i>
                </div>
                Summary of Data
            </h2>
        </div>
        <div class="card-body-dash">
            <div style="height: 320px; overflow: auto;">
                <table class="transactions-table transactions-table-custodian" autofocus>
                    <thead>
                        <tr>
                            <th style="font-size: 10px" class="text-uppercase">
                                Reference No.
                            </th>
                            <th style="font-size: 10px" class="text-uppercase">
                                Warranty Type
                            </th>
                            <th style="font-size: 10px" class="text-uppercase">
                                Case Type
                            </th>
                            <th style="font-size: 10px" class="text-uppercase">
                                Model
                            </th>
                            <th style="font-size: 10px" class="text-uppercase">
                                Customer
                            </th>
                        </tr>
                    </thead>
                    <tbody style="text-align: left; background: rgba(240, 246, 247, 0.7);">
                        <tr>
                            <td colspan="6">
                                <div>
                                    <br><br>
                                    <center>
                                        <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png"
                                            alt="">
                                    </center>
                                    <center>
                                        <small class="text-uppercase">No Data Entry. Please select
                                            <br> what report you want to check.</small>
                                    </center>
                                    <br><br><br>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <br>
    <div class="card-dash">
        <div class="card-header-dash">
            <h2 class="card-title-dash">
                <div class="card-icon-dash icon-default">
                    <i class="bi bi-pie-chart-fill" style="font-size: 15px;"></i>
                </div>
                Chart Summary
            </h2>
        </div>
        <div class="card-body-dash">
            <div class="chart-container"
                style="position: relative; height: 330px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                <canvas id="shipmentChart-bgc" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

@push('bottom')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        $(document).ready(function() {
            // Data for the pie chart
            const pendingCount = {{ count($pending_mail_in_shipment_dash_bgc) }};
            const receivingCount = {{ count($spare_parts_receiving_dash_bgc) }};
            const releasingCount = {{ count($spare_parts_releasing_dash_bgc) }};

            // Initialize chart
            const ctx = document.getElementById('shipmentChart-bgc');

            // Data for the pie chart
            const data = {
                labels: ['Pending Mail-In', 'Receiving', 'Releasing'],
                datasets: [{
                    data: [pendingCount, receivingCount, releasingCount],
                    backgroundColor: [
                        '#948979',
                        'grey',
                        '#222831',
                    ],
                    borderColor: [
                        'white',
                    ],
                    borderWidth: 5,
                    hoverOffset: 10,
                    borderRadius: 8
                }]
            };

            // Chart configuration
            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '45%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                boxWidth: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            };

            // Create the chart
            const myChart = new Chart(ctx, config);

            // Add click event to chart
            ctx.onclick = function(evt) {
                const activePoints = myChart.getElementsAtEventForMode(
                    evt,
                    'nearest', {
                        intersect: true
                    },
                    false
                );

                if (activePoints.length > 0) {
                    const clickedIndex = activePoints[0].index;
                    const label = myChart.data.labels[clickedIndex];

                    // Update the table based on the clicked segment
                    let dataType;
                    if (label === 'Pending Mail-In') dataType = 'pending';
                    else if (label === 'Receiving') dataType = 'receiving';
                    else if (label === 'Releasing') dataType = 'releasing';

                    updateTable(dataType);
                }
            };

            // Function to update the table with filtered data
            function updateTable(dataType) {
                // Clear existing table rows
                $('.transactions-table-custodian tbody').empty();

                let data;

                // Get the appropriate data based on the type
                if (dataType === 'pending') {
                    data = {!! json_encode($pending_mail_in_shipment_dash_bgc) !!};
                    // Highlight the pending card
                    $('.m-dash-card').removeClass('active-card');
                    $('.m-dash-pms').addClass('active-card');
                } else if (dataType === 'receiving') {
                    data = {!! json_encode($spare_parts_receiving_dash_bgc) !!};
                    // Highlight the receiving card
                    $('.m-dash-card').removeClass('active-card');
                    $('.m-dash-spr').addClass('active-card');
                } else if (dataType === 'releasing') {
                    data = {!! json_encode($spare_parts_releasing_dash_bgc) !!};
                    // Highlight the releasing card
                    $('.m-dash-card').removeClass('active-card');
                    $('.m-dash-spre').addClass('active-card');
                }

                // Add data to the table
                if (data && data.length > 0) {
                    data.forEach(function(item) {
                        const row = `
            <tr>
              <td style="font-size: 12px">${item.reference_no || ''}</td>
              <td style="font-size: 12px">${item.warranty_status || ''}</td>
              <td style="font-size: 12px">${item.case_status || ''}</td>
              <td style="font-size: 12px">${item.model_name || ''}</td>
              <td style="font-size: 12px">${item.last_name + ',' + item.first_name || ''}</td>
            </tr>
          `;
                        $('.transactions-table-custodian tbody').append(row);
                    });
                } else {
                    // If no data, show empty row
                    const emptyRow = `
          <tr>
            <td colspan="6">
                <div>
                  <br><br>
                  <center>
                    <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" alt="">
                  </center>
                  <center>
                    <small class="text-uppercase">No Data Entry. Please select <br> what report you want to check.</small>
                  </center>
                  <br><br><br>
                </div>
            </td>
          </tr>
        `;
                    $('.transactions-table-custodian tbody').append(emptyRow);
                }
            }

            // Add click handlers to the cards
            $('.m-dash-pms').click(function() {
                updateTable('pending');
            });

            $('.m-dash-spr').click(function() {
                updateTable('receiving');
            });

            $('.m-dash-spre').click(function() {
                updateTable('releasing');
            });

            // Add active-card class for styling
            $('<style>')
                .text(`
        .m-dash-card.active-card {
          box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
          transform: translateY(-5px);
          transition: all 0.3s ease;
        }
      `)
                .appendTo('head');
        });
    </script>
@endpush
