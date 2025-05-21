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
                    Spare Custodian's Dashboard
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
        </div>

        <div id="overview" class="tab-content-dash active">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-body-dash">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="m-dash-card m-dash-new-users" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                            <div class="m-dash-card-header">
                                <div class="m-dash-card-title">📩Pending Mail-In Shipment</div>
                            </div>
                            <div class="m-dash-card-value" id="filtered-callouts-value">
                                {{count($pending_mail_in_shipment_dash)}}
                            </div>
                            <div class="m-dash-card-change m-dash-positive">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="m-dash-card m-dash-non-users" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                            <div class="m-dash-card-header">
                                <div class="m-dash-card-title">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-labelledby="receiveIconTitle" style="vertical-align: -0.125em; margin-right: 1px;">
                                      <title id="receiveIconTitle">Inventory Receiving Quantity</title>
                                      <!-- Truck body -->
                                      <path d="M1 3h15v13H1z" fill="#e8f5e9" />
                                      <!-- Truck cabin -->
                                      <path d="M16 8h4l3 3v5h-7V8z" fill="#c8e6c9" />
                                      <!-- Wheels -->
                                      <circle cx="5.5" cy="18.5" r="2.5" />
                                      <circle cx="18.5" cy="18.5" r="2.5" />
                                      <!-- Package in the back of the truck -->
                                      <rect x="7" y="8" width="5" height="5" rx="1" fill="#81c784" />
                                      <!-- Quantity badge -->
                                      <circle cx="19" cy="5" r="4" fill="#ff9800" stroke="#ff9800" />
                                      <text x="19" y="7" dominant-baseline="middle" text-anchor="middle" fill="white" style="font-size: 6px; font-weight: bold;">+</text>
                                  </svg>
                                  Spare Parts Receiving
                                </div>
                            </div>
                            <div class="m-dash-card-value" id="filtered-callouts-value">
                                {{count($spare_parts_receiving_dash)}}
                            </div>
                            <div class="m-dash-card-change m-dash-positive">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="m-dash-card m-dash-transactions" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                            <div class="m-dash-card-header">
                              <div class="m-dash-card-title">
                                📦
                                Spare Parts Releasing
                              </div>
                            </div>
                            <div class="m-dash-card-value" id="filtered-callouts-value">
                                {{count($spare_parts_releasing_dash)}}
                            </div>
                            <div class="m-dash-card-change m-dash-positive">
                            </div>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <br>
                        <div class="card-dash">
                              <div class="card-header-dash">
                                  <h2 class="card-title-dash">
                                      <div class="card-icon-dash icon-employe-dash">
                                        📃
                                      </div>
                                      Job Order Summary
                                  </h2>
                              </div>
                              <div class="card-body-dash">
                                <div style="height: 320px; overflow: auto;">
                                  <table class="transactions-table" autofocus>
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
                                                <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" alt="">
                                              </center>
                                              <center>
                                                <small class="text-uppercase">No Data Entry. Please select <br> what report you want to check.</small>
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
                                      <div class="card-icon-dash icon-employe-dash">
                                        📃    
                                      </div>
                                      Chart Summary
                                  </h2>
                              </div>
                              <div class="card-body-dash">
                                <div class="chart-container" style="position: relative; height: 300px; margin-top: 20px;">
                                  <canvas id="shipmentChart"></canvas>
                                </div>
                              </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
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

<script>
  $(document).ready(function() {
    // Data for the pie chart
    const pendingCount = {{ count($pending_mail_in_shipment_dash) }};
    const receivingCount = {{ count($spare_parts_receiving_dash) }};
    const releasingCount = {{ count($spare_parts_releasing_dash) }};
    
    // Initialize chart
    const ctx = document.getElementById('shipmentChart');
    
    // Data for the pie chart
    const data = {
      labels: ['Pending Mail-In', 'Receiving', 'Releasing'],
      datasets: [{
        data: [pendingCount, receivingCount, releasingCount],
        backgroundColor: [
          'rgba(255, 205, 86, 0.8)',  // yellow for pending
          'rgba(54, 162, 235, 0.8)',  // blue for receiving
          'rgba(75, 192, 192, 0.8)'   // green for releasing
        ],
        borderColor: [
          'rgb(255, 205, 86)',
          'rgb(54, 162, 235)',
          'rgb(75, 192, 192)'
        ],
        borderWidth: 1
      }]
    };
    
    // Chart configuration
    const config = {
      type: 'pie',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
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
        'nearest', 
        { intersect: true }, 
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
      $('.transactions-table tbody').empty();
      
      let data;
      
      // Get the appropriate data based on the type
      if (dataType === 'pending') {
        data = {!! json_encode($pending_mail_in_shipment_dash) !!};
        // Highlight the pending card
        $('.m-dash-card').removeClass('active-card');
        $('.m-dash-new-users').addClass('active-card');
      } else if (dataType === 'receiving') {
        data = {!! json_encode($spare_parts_receiving_dash) !!};
        // Highlight the receiving card
        $('.m-dash-card').removeClass('active-card');
        $('.m-dash-non-users').addClass('active-card');
      } else if (dataType === 'releasing') {
        data = {!! json_encode($spare_parts_releasing_dash) !!};
        // Highlight the releasing card
        $('.m-dash-card').removeClass('active-card');
        $('.m-dash-transactions').addClass('active-card');
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
          $('.transactions-table tbody').append(row);
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
        $('.transactions-table tbody').append(emptyRow);
      }
    }
    
    // Add click handlers to the cards
    $('.m-dash-new-users').click(function() {
      updateTable('pending');
    });
    
    $('.m-dash-non-users').click(function() {
      updateTable('receiving');
    });
    
    $('.m-dash-transactions').click(function() {
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
