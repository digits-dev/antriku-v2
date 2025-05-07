@extends('crudbooster::admin_template')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@section('content')
<style>
    .content-header{
        display: none;
    }
</style>

<main class="container-dash dashboard-dash" style="margin-top: 50px;">
  <div class="dashboard-title-section">
    <!-- Top section with breadcrumbs and actions -->
    <div class="dashboard-header-top">
      <div class="breadcrumbs">
        <div class="breadcrumb-item">
          <a href="#">Home</a>
        </div>
        <div class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </div>
        <div class="breadcrumb-item active">Technician</div>
      </div>
      
      <div class="dashboard-actions">
        <button class="action-button primary" style="display: none">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
          </svg>
          Export Report
        </button>
      </div>
    </div>
    
    <!-- Title and subtitle with enhanced styling -->
    <div class="dashboard-title-content">
      <h1 class="dashboard-title">
        <span class="dashboard-title-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
        </span>
       Technician's Dashboard
      </h1>
      <p class="dashboard-subtitle">
        Overview of Ongoing Repair Cases, Pending Customer's Payment, Total Count of In Warranty and Out of Warranty, Total Count of Carry-In and Mail-in and, Total Repair per Model.
      </p>
    </div>
  </div>

    <div class="tabs-dash" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
      <div class="tab-dash active" data-tab="overview">Overview</div>
      <div class="tab-dash" data-tab="model_section">Model</div>
      {{-- <div class="tab-dash" data-tab="model_section">Customer's/Unit Filters</div>
      <div class="tab-dash" data-tab="customer_info_filter">Customer's Information Filter</div> --}}
    </div>
    <div id="overview" class="tab-content-dash active">
      <div class="dashboard-grid-dash" style="margin-top: 10px;  grid-template-columns: repeat(auto-fit, minmax(50px, 1fr)) !important;">
        {{-- <div class="card-dash">
          <div class="card-header-dash">
            <h2 class="card-title-dash">
              <div class="card-icon-dash icon-abandoned-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
              </div>
              {{ $branchName }}
            </h2>
          </div>
          <div class="card-body-dash">
            <div class="card-stats-dash">
              <div class="stat-dash">
                <div class="stat-value-dash">{{ $totalOngoingRepair }}</div>
                <div class="stat-label-dash">Total Ongoing Repair Cases</div>
              
              </div>
            </div>
          </div>
      
        </div> --}}

            {{-- Ongoing Repair Cases --}}
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
                Ongoing Repair Cases
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
                Pending Customer's Payment
              </h2>
            </div>
            <div class="card-body-dash">
              <div class="card-stats-dash">
                <div class="stat-dash">
                  <div class="stat-value-dash">{{$totalPendingCustomerPayment}}</div>
                  <div class="stat-label-dash">Total Pending Customer's Payment</div>
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
        
        {{-- Carry-In --}}
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
                <div class="stat-label-dash">Total Repair of Carry-In</div>
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
                  <div class="stat-label-dash">Total Repair of Mail-In</div>
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
                     <tbody>
                       @if($totalRepairPerModel->isEmpty())
                         <tr>
                             <td colspan="2" class="text-center">No repair data found.</td>
                         </tr>
                     @else
                         @foreach($totalRepairPerModel as $data)
                             <tr>
                                 <td>{{ $data->model_name }}</td>
                                 <td>{{ $data->total_repairs }}</td>
                             </tr>
                         @endforeach
                     @endif
                   </tbody>
                   </tbody>
               </table>
               <div class="pagination-container">
                 {{ $totalRepairPerModel->links() }}  
               </div>
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
          "paging": false,
          "ordering": false,
          'searching': false,
          "info": false
        });
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

@endsection
