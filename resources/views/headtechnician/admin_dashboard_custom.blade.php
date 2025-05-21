@extends('crudbooster::admin_template')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@section('content')
<style>
    .content-header{
        display: none;
    }

    
    .content {
        padding: 0;
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

<main class="container-dash dashboard-dash cust-ch ">
  <div class="dashboard-title-section" style="margin-bottom: 10px;">
    <!-- Title and subtitle with enhanced styling -->
    <div class="dashboard-title-content">
      <h1 class="dashboard-title" style="margin-top: 8px">
        <span class="dashboard-title-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
        </span>
        Head Technician's Dashboard
      </h1>
      <p class="dashboard-subtitle">
      </p>
    </div>
  </div>

    <div class="tabs-dash" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
    <div class="tab-dash active" data-tab="overview">Overview</div>
    <div class="tab-dash" data-tab="model_section">Model</div>
    <div class="tab-dash" data-tab="time_in_motion_section">Time in Motion</div>
    {{-- <div class="tab-dash" data-tab="model_section">Customer's/Unit Filters</div>
    <div class="tab-dash" data-tab="customer_info_filter">Customer's Information Filter</div> --}}
  </div>

  <div id="overview" class="tab-content-dash active">
    <div class="dashboard-grid-dash" style="margin-top: 10px;  grid-template-columns: repeat(auto-fit, minmax(50px, 1fr)) !important;">
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
            Ongoing Diagnosis
          </h2>
        </div>
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{$myOngoingDiagnosis}}</div>
              <div class="stat-label-dash">My Ongoing Diagnosis</div>
          
            </div>
          </div>
        </div>
      </div>
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
            Ongoing Repair Cases (Carry In)
          </h2>
        </div>
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{$myOngoingRepair}}</div>
              <div class="stat-label-dash">My Total Ongoing Repair Cases</div>
           
            </div>
          </div>
        </div>
      </div>
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
            Awaiting Repair Cases (Mail In)
          </h2>
        
        </div>
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{$myAwaitingRepair}}</div>
              <div class="stat-label-dash">My Awaiting Repair Cases</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <div class="dashboard-grid-dash" style="margin-top: 10px;  grid-template-columns: repeat(auto-fit, minmax(50px, 1fr)) !important;">
      <div class="card-dash">
        <div class="card-header-dash">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-abandoned-dash">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
            </div>
            {{ $greenhills }}
          </h2>
       
        </div>
       <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash" style="display:flex; gap: 20px; justify-content:space-between">
              <div style="flex: 1;">
                  <div class="stat-value-dash">{{ $greenhillsOngoingDiagnosis }}</div>
                <div class="stat-label-dash">Total Ongoing Diagnosis</div>
              </div>
              <div style="flex: 1; border-left: 1px solid #ccc; padding-left: 20px;">
                <div class="stat-value-dash">{{ $greenhillsTotalRepair }}</div>
                <div class="stat-label-dash">Total Ongoing Repair Cases (Carry In)</div>
              </div>
              <div style="flex: 1; border-left: 1px solid #ccc; padding-left: 20px;">
                  <div class="stat-value-dash">{{ $greenhillsAwaitingRepair }}</div>
                <div class="stat-label-dash">Total Awaiting Repair Cases (Mail In)</div>
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
            {{ $bonifacio }}
          </h2>
       
        </div>
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash" style="display:flex; gap: 20px; justify-content:space-between">
              <div style="flex: 1;">
                  <div class="stat-value-dash">{{ $bonifacioOngoingDiagnosis }}</div>
                <div class="stat-label-dash">Total Ongoing Diagnosis</div>
              </div>
          
              <div style="flex: 1; border-left: 1px solid #ccc; padding-left: 20px;">
                <div class="stat-value-dash">{{ $bonifacioTotalRepair }}</div>
                <div class="stat-label-dash">Total Ongoing Repair Cases (Carry In)</div>
              </div>
              <div style="flex: 1; border-left: 1px solid #ccc; padding-left: 20px;">
                  <div class="stat-value-dash">{{ $bonifacioAwaitingRepair }}</div>
                <div class="stat-label-dash">Total Awaiting Repair Cases (Mail In)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
    <div class="dashboard-grid-dash" style="margin-top: 10px;  grid-template-columns: repeat(auto-fit, minmax(50px, 1fr)) !important;">
      {{-- In-warranty --}}
        <div class="card-dash">
        <div class="card-header-dash">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-abandoned-dash">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
            </div>
            In Warranty
          </h2>
        </div>
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{ $totalIW }}</div>
              <div class="stat-label-dash">Total In-Warranty Repair Cases</div>
            </div>
          </div>
        </div>
      </div>
 
        {{-- Out of Warranty --}}
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
            Out of Warranty
          </h2>
        </div>
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{$totalOOW}}</div>
              <div class="stat-label-dash">Total Out of Warranty Repair Cases</div>
           
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
            Carry-In
          </h2>
        </div>
        <div class="card-body-dash">
          <div class="card-stats-dash">
            <div class="stat-dash">
              <div class="stat-value-dash">{{ $totalCarryIn }}</div>
              <div class="stat-label-dash">Total Carry-In Repair Cases</div>
            </div>
          </div>
        </div>
      </div>

       {{-- Mail-In --}}
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
              Mail-In
            </h2>
          </div>
          <div class="card-body-dash">
            <div class="card-stats-dash">
              <div class="stat-dash">
                <div class="stat-value-dash">{{$totalMailIn}}</div>
                <div class="stat-label-dash">Total Mail-in Repair Cases</div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div id="model_section" class="tab-content-dash">
       <!-- Model Section with DataTable -->
       <h2 style="font-weight: bold">Total Repair Per Model</h2>
       <div class="dashboard-grid-dash">
        <div class="card-dash">
            <div class="card-body-dash">
              <table id="modelTable" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>Model Name</th>
                    <th>Total Repairs</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($totalRepairPerModel as $data)
                    <tr>
                      <td>{{ $data->model_name }}</td>
                      <td>{{ $data->total_repairs }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
    <div id="time_in_motion_section" class="tab-content-dash">
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

  <!-- DataTable Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#modelTable').DataTable({
          paging: true,        // Enable pagination
          searching: true,     
          ordering: false,
          info: false 
        });
    });
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

@endsection
