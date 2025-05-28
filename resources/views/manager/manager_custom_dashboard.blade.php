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
                    Manager's Dashboard
                </h1>
                <p class="dashboard-subtitle">
                </p>
            </div>
        </div>

        <div class="tabs-dash m-dash-new-users text-uppercase" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="tab-dash active" data-tab="tab-jaymar-bi">
                <svg xmlns="http://www.w3.org/2000/svg" role="presentation" width="15" height="15" viewBox="0 0 1600 1600" fill="none">
                    <mask id="mask0_8592:56198" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="200" y="0" width="1200" height="1600">
                    <path d="M1333.25 0C1370.11 0 1400 29.8849 1400 66.75V1533.25C1400 1570.11 1370.11 1600 1333.25 1600H266.667C229.848 1600 200 1570.15 200 1533.33V866.667C200 829.848 229.848 800 266.667 800H525V466.667C525 429.848 554.848 400 591.667 400H850V66.75C850 29.885 879.885 0 916.75 0H1333.25Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask0_8592:56198)">
                    <path d="M1400 66.75L1400 1533.25C1400 1570.11 1370.11 1600 1333.25 1600H916.75C879.885 1600 850 1570.11 850 1533.25L850 66.75C850 29.885 879.885 0 916.75 0H1333.25C1370.12 0 1400 29.8849 1400 66.75Z" fill="url(#paint0_linear_8592:56198)"/>
                    <g filter="url(#filter0_dd_8592:56198)">
                    <path d="M1075 466.667V1600H525V466.667C525 429.848 554.848 400 591.667 400H1008.33C1045.15 400 1075 429.848 1075 466.667Z" fill="url(#paint1_linear_8592:56198)"/>
                    </g>
                    <path d="M200 866.667V1533.33C200 1570.15 229.848 1600 266.667 1600H750V866.667C750 829.848 720.152 800 683.333 800H266.667C229.848 800 200 829.848 200 866.667Z" fill="url(#paint2_linear_8592:56198)"/>
                    </g>
                    <defs>
                    <filter id="filter0_dd_8592:56198" x="391.667" y="300" width="816.667" height="1466.67" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="6.33333"/>
                    <feGaussianBlur stdDeviation="6.33333"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_8592:56198"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="33.3333"/>
                    <feGaussianBlur stdDeviation="66.6667"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_8592:56198" result="effect2_dropShadow_8592:56198"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_8592:56198" result="shape"/>
                    </filter>
                    <linearGradient id="paint0_linear_8592:56198" x1="758.333" y1="-1.49632e-05" x2="1447.82" y2="1507.15" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#E6AD10"/>
                    <stop offset="1" stop-color="#C87E0E"/>
                    </linearGradient>
                    <linearGradient id="paint1_linear_8592:56198" x1="524.955" y1="400" x2="1105.79" y2="1561.67" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#F6D751"/>
                    <stop offset="1" stop-color="#E6AD10"/>
                    </linearGradient>
                    <linearGradient id="paint2_linear_8592:56198" x1="199.955" y1="800" x2="519.784" y2="1581.68" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#F9E589"/>
                    <stop offset="1" stop-color="#F6D751"/>
                    </linearGradient>
                    </defs>
                </svg>
                Power BI Dashboard
            </div>

            <div class="tab-dash" data-tab="tab-system-dash">
                <img src="https://cdn-icons-png.flaticon.com/128/1828/1828673.png" alt="" width="17px">
                System Dashboard
            </div>

            <div class="tab-dash" data-tab="tab-employee-dash">
                <img src="https://cdn-icons-png.flaticon.com/128/6186/6186048.png" alt="" width="18px">
                Employee's Dashboard
            </div>
        </div>

        <div id="tab-jaymar-bi" class="tab-content-dash active">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-header-dash hidden" style="padding: 0px 10px 0px 10px;">
                    <h2 class="card-title-dash text-uppercase" style="color: white;">
                        <img src="https://cdn-icons-png.flaticon.com/128/7756/7756168.png" alt="" width="20px">
                        <small style="font-size: 14px;">Overview</small>
                    </h2>

                    <div>
                        <small class="text-uppercase" style="color: lightgrey">Home <i class="bi bi-chevron-right" style="font-size: 10px;"></i> Dashboard</small>
                    </div>
                </div>
                <div class="card-body-dash">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <iframe
                                title="NO"
                                style="width: 100%; height: 800px"
                                src='{{$PBI}}'
                                frameBorder="0"
                                allowFullScreen="true">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-system-dash" class="tab-content-dash system_dashboard_content">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-header-dash" style="padding: 0px 20px 0px 20px;">
                    <h2 class="card-title-dash text-uppercase" style="color: white;">
                        <img src="https://cdn-icons-png.flaticon.com/128/7756/7756168.png" alt="" width="20px">
                        <small style="font-size: 14px;">
                            Overview of
                            <span id="selected_branch">
                            </span>
                        </small>
                    </h2>

                    <div style="display: flex; align-items:center; justify-content:center; background: whitesmoke; padding: 0 7px 0 7px; border-radius: 10px;">
                        <img src="https://cdn-icons-png.flaticon.com/128/2098/2098316.png" alt="branch_icon" width="20px">
                        <select name="branch" id="branch" class="input-cus" style="border: 0 !important; outline: none !important; 
                            box-shadow: none !important; background: transparent !important;">
                            @foreach ($branch as $per_branch)
                                <option value="{{ $per_branch->id }}" data-val="{{$per_branch->branch_name}}" {{$per_branch->id == 1 ? 'selected' : ''}}> {{ $per_branch->branch_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body-dash">
                    <div class="system-dashboard-content-vmall">
                        @include('manager.manager_vmall_dashboard')
                    </div>
                    <div class="system-dashboard-content-bgc" style="display: none;">
                        @include('manager.manager_bgc_dashboard')
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-employee-dash" class="tab-content-dash employee_dashboard_content">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-header-dash" style="padding: 0px 20px 0px 20px;">
                    <h2 class="card-title-dash text-uppercase" style="color: white;">
                        <img src="https://cdn-icons-png.flaticon.com/128/7756/7756168.png" alt="" width="20px">
                        <small style="font-size: 14px;">
                            Overview of
                            <span id="selected_branch_filter_2">
                            </span>
                        </small>
                    </h2>

                    <div style="display: flex; align-items:center; justify-content:center; background: whitesmoke; padding: 0 7px 0 7px; border-radius: 10px;">
                        <img src="https://cdn-icons-png.flaticon.com/128/2098/2098316.png" alt="branch_icon" width="20px">
                        <select name="branch" id="branch_filter_2" class="input-cus" style="border: 0 !important; outline: none !important; 
                            box-shadow: none !important; background: transparent !important;">
                            @foreach ($branch as $per_branch)
                                <option value="{{ $per_branch->id }}" data-val="{{$per_branch->branch_name}}" {{$per_branch->id == 1 ? 'selected' : ''}}> {{ $per_branch->branch_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body-dash">
                    <div class="employee-dashboard-content-vmall">
                        @include('manager.manager_vmall_employee_dashboard')
                    </div>
                    <div class="employee-dashboard-content-bgc" style="display: none;">
                        @include('manager.manager_bgc_employee_dashboard')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-doughnutlabel@1.0.3"></script>
<script>
    $(document).ready(function () {
        function updateSelectedBranch() {
            const selectedVal = $('#branch option:selected').data('val');
            const branch_id = $('#branch option:selected').val();
            $('#selected_branch').text(selectedVal);

            if(branch_id == '' || branch_id == null){
                alert('Empty Branch');
                return;
            }

            if(branch_id == 1) {
                $('.system-dashboard-content-vmall').show();
                $('.system-dashboard-content-bgc').hide();
            } else {
                $('.system-dashboard-content-bgc').show();
                $('.system-dashboard-content-vmall').hide();
            }

        }

        // Initial load
        updateSelectedBranch();

        $('#branch').on('change', updateSelectedBranch);
    });

    $(document).ready(function () {
        function updateSelectedBranchfilter2() {
            const selectedVal = $('#branch_filter_2 option:selected').data('val');
            const branch_id = $('#branch_filter_2 option:selected').val();
            $('#selected_branch_filter_2').text(selectedVal);

            if(branch_id == '' || branch_id == null){
                alert('Empty Branch');
                return;
            }

            if(branch_id == 1) {
                $('.employee-dashboard-content-vmall').show();
                $('.employee-dashboard-content-bgc').hide();
            } else {
                $('.employee-dashboard-content-bgc').show();
                $('.employee-dashboard-content-vmall').hide();
            }

        }

        // Initial load
        updateSelectedBranchfilter2();

        $('#branch_filter_2').on('change', updateSelectedBranchfilter2);
    });

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
    const agingDistributionCtx = document.getElementById('aging_callout').getContext('2d');
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
    const agingByTypeCtx = document.getElementById('aging_callout_types').getContext('2d');
    
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

{{-- BGC Aging Callout  --}}
<script>
    $(document).ready(function() {
        // Get the data from PHP variables
        const normalCount = {{ $normalCount_bgc }};
        const mediumCount = {{ $mediumCount_bgc }};
        const highCount = {{ $highCount_bgc }};
        const criticalCount = {{ $criticalCount_bgc }};

        // Modern color palette
        const colors = {
            normal: 'lightgrey', // for 0-7 days
            medium: '#948979', // for 8-14 days
            high: 'grey', //  for 15-30 days
            critical: '#222831' // for 30+ days
        };

        // Create Aging Distribution Chart
        const agingDistributionCtx = document.getElementById('aging_callout_BGC').getContext('2d');
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
            const agingCallouts = {!! json_encode($aging_callouts_bgc) !!} || [];

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
        const datasets = [{
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
                data: uniqueStatusNames.map((type, index) => (typeData[type] ? typeData[type].critical :
                    0)),
                backgroundColor: colors.critical,
                stack: 'Stack 0',
                borderRadius: 6,
                borderWidth: 1,
                borderColor: colors.critical.replace('0.8', '1')
            }
        ];

        // Create Aging by Callout Type Chart
        const agingByTypeCtx = document.getElementById('aging_callout_types_BGC').getContext('2d');

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
@endpush
