@extends('crudbooster::admin_template')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@section('content')
<style>
    .content-header{
        display: none;
    }
</style>

<main class="container-dash dashboard-dash">
    <div class="dashboard-header-dash">
      <h1 class="dashboard-title-dash">Technician's Dashboard</h1>
      {{-- <p class="dashboard-subtitle-dash">Overview of pending call-outs, abandoned units, and aging service requests</p> --}}
    </div>

    <div class="dashboard-grid-dash">
         {{-- Greenhills --}}
      <div class="card-dash">
        <div class="card-header-dash">
          <h2 class="card-title-dash">
            <div class="card-icon-dash icon-abandoned-dash">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
            </div>
            Greenhills
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
              <div class="stat-value-dash">{{ $totalOngoingRepair }}</div>
              <div class="stat-label-dash">Total Ongoing Repair Cases</div>
            
            </div>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
        </div>
      </div>

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
                <div class="stat-value-dash">{{$myOngoingRepair}}</div>
                <div class="stat-label-dash">My Total Ongoing Repair Cases</div>
             
              </div>
            </div>
          </div>
          <div class="card-footer-dash">
            <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
            <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
                <div class="stat-value-dash">{{$totalPendingCustomerPayment}}</div>
                <div class="stat-label-dash">Total Pending Customer's Payment</div>
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
           <div class="stat-value-dash">0</div>
           <div class="stat-label-dash">Total Repair Sales of In-Warranty</div>
         
         </div>
       </div>
     </div>
     <div class="card-footer-dash">
       <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
       <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
             <div class="stat-value-dash">{{$totalSalesOOW}}</div>
             <div class="stat-label-dash">Total Repair Sales of Out of Warranty</div>
          
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
              <div class="stat-value-dash">{{ $totalCarryIn }}</div>
              <div class="stat-label-dash">Total Repair of Carry-In</div>
            </div>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
                <div class="stat-value-dash">{{$totalMailIn}}</div>
                <div class="stat-label-dash">Total Repair of Mail-In</div>
             
              </div>
            </div>
          </div>
          <div class="card-footer-dash">
            <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
            <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
          </div>
        </div>
    </div>
       <!-- Model Section with DataTable -->
       <div class="dashboard-grid-dash">
        <div class="card-dash">
            <div class="card-header-dash">
                <h2 class="card-title-dash">Total Repair Per Model</h2>
            </div>
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
</script>

@endsection
