@extends('crudbooster::admin_template')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@section('content')
<style>
    .content-header{
        display: none;
    }
</style>

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
              <div class="stat-value-dash">{{$fl_pending_call_out_dash_count}}</div>
              <div class="stat-label-dash">Total Pending</div>
              <div class="stat-trend-dash trend-up-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
                12% from yesterday
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
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
              <div class="stat-value-dash">23</div>
              <div class="stat-label-dash">Total Abandoned</div>
              <div class="stat-trend-dash trend-down-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                5% from last week
              </div>
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
              <div class="stat-value-dash">31</div>
              <div class="stat-label-dash">Total Aging</div>
              <div class="stat-trend-dash trend-up-dash">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
                8% from last week
              </div>
            </div>
            <div class="stat-dash">
              <div class="stat-value-dash">15</div>
              <div class="stat-label-dash">Over 30 Days</div>
            </div>
          </div>

          <div class="status-list-dash">
            <div class="status-item-dash">
              <div class="status-info-dash">
                <div>
                  <div class="status-name-dash">30+ Days</div>
                  <div class="status-details-dash">Critical attention needed</div>
                </div>
              </div>
              <div class="status-value-dash">15</div>
            </div>
            <div class="progress-container-dash">
              <div class="progress-bar-dash progress-critical-dash" style="width: 48%;"></div>
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
              <div class="status-value-dash">9</div>
            </div>
            <div class="progress-container-dash">
              <div class="progress-bar-dash progress-warning-dash" style="width: 29%;"></div>
            </div>
          </div>

          <div class="status-list-dash">
            <div class="status-item-dash">
              <div class="status-info-dash">
                <div>
                  <div class="status-name-dash">7-14 Days</div>
                  <div class="status-details-dash">Needs follow-up</div>
                </div>
              </div>
              <div class="status-value-dash">7</div>
            </div>
            <div class="progress-container-dash">
              <div class="progress-bar-dash progress-normal-dash" style="width: 23%;"></div>
            </div>
          </div>
        </div>
        <div class="card-footer-dash">
          <span class="card-footer-text-dash">Last updated: Today, 10:45 AM</span>
          <a href="#" class="btn-dash btn-primary-dash btn-sm-dash">View All</a>
        </div>
      </div>
    </div>
  </main>
@endsection
