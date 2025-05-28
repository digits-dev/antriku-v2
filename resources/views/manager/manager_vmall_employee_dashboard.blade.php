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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="card-body-dash" style="height: 450px; overflow-y:auto; cursor:pointer;">
                <div class="employee-chart">
                    @foreach ($handle_for_all_employee_vmall as $per_employee)
                        <div class="employee-row">
                            <div
                                class="employee-badge {{ $loop->iteration == 1 ? 'badge-1' : ($loop->iteration == 2 ? 'badge-2' : ($loop->iteration == 3 ? 'badge-3' : '')) }}">
                                @if ($loop->iteration == 1)
                                    <img src="https://cdn-icons-png.flaticon.com/128/744/744984.png" alt=""
                                        width="20px">
                                @elseif ($loop->iteration == 2)
                                    <img src="https://cdn-icons-png.flaticon.com/128/11881/11881956.png" alt=""
                                        width="20px">
                                @elseif ($loop->iteration == 3)
                                    <img src="https://cdn-icons-png.flaticon.com/128/11881/11881954.png" alt=""
                                        width="20px">
                                @else
                                    {{ $loop->iteration }}
                                @endif
                            </div>
                            <div class="employee-avatar" style="background: #14b8a6; color:aliceblue">
                                {{ strtoupper(substr($per_employee->created_by_user, 0, 1)) }}
                                {{ strtoupper(substr(strrchr($per_employee->created_by_user, ' '), 1, 1)) }}
                            </div>
                            <div class="employee-info">
                                <div class="employee-name">{{ $per_employee->created_by_user }}</div>
                                <div class="employee-position">{{ $per_employee->privilege_name }}</div>
                            </div>
                            <div class="employee-bar-container">
                                @php
                                    // Prevent division by zero error
                                    $total_case_handled_per_employee_percentage =
                                        $handle_overall_total > 0
                                            ? ($per_employee->total_creations / $handle_overall_total) * 100
                                            : 0;
                                @endphp
                                <div class="employee-bar"
                                    style="width: {{ $total_case_handled_per_employee_percentage }}%;"></div>
                            </div>
                            <div class="employee-value">{{ number_format($per_employee->total_creations) }} /
                                {{ number_format($handle_overall_total) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-dash">
            <div class="card-body-dash" style="height: 523px; overflow-y:auto; cursor:pointer;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                            <div class="m-dash-card-header" style="margin: 0">
                                <div class="m-dash-card-title">
                                    <i class="bi bi-telephone-minus-fill" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                    Pending Call-outs
                                </div>
                                <hr>
                            </div>
                            <div class="m-dash-card-value" id="filtered-callouts-value">
                                0
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                            <div class="m-dash-card-header" style="margin: 0">
                                <div class="m-dash-card-title">
                                    <i class="bi bi-emoji-frown-fill" style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                                    Abandoned Units
                                </div>
                                <hr>
                            </div>
                            <div class="m-dash-card-value" id="filtered-callouts-value">
                                0
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card-body-dash">
                            <div class="chart-container" style="position: relative; height: 240px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                                <canvas id="caseStatusChart"></canvas>
                            </div>
                            
                            <div class="filter-buttons" style="display: flex; gap: 10px; justify-content: center; margin: 20px 0;">
                                <button id="filterAll" class="filter-btn active" style="padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #4b5563; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                All Cases
                                </button>
                                <button id="filterCompleted" class="filter-btn" style="padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #4b5563; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                Completed
                                </button>
                                <button id="filterOngoing" class="filter-btn" style="padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb; background-color: #f9fafb; color: #4b5563; font-weight: 500; font-size: 14px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                Ongoing
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Technicians --}}
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="card-body-dash" style="height: 450px; overflow-y:auto; cursor:pointer;">
                <div class="employee-chart">
                    @foreach ($handle_for_all_employee_tech_vmall as $per_employee)
                        <div class="employee-row">
                            <div
                                class="employee-badge {{ $loop->iteration == 1 ? 'badge-1' : ($loop->iteration == 2 ? 'badge-2' : ($loop->iteration == 3 ? 'badge-3' : '')) }}">
                                @if ($loop->iteration == 1)
                                    <img src="https://cdn-icons-png.flaticon.com/128/744/744984.png" alt=""
                                        width="20px">
                                @elseif ($loop->iteration == 2)
                                    <img src="https://cdn-icons-png.flaticon.com/128/11881/11881956.png"
                                        alt="" width="20px">
                                @elseif ($loop->iteration == 3)
                                    <img src="https://cdn-icons-png.flaticon.com/128/11881/11881954.png"
                                        alt="" width="20px">
                                @else
                                    {{ $loop->iteration }}
                                @endif
                            </div>
                            <div class="employee-avatar" style="background: #14b8a6; color:aliceblue">
                                {{ strtoupper(substr($per_employee->created_by_user, 0, 1)) }}
                                {{ strtoupper(substr(strrchr($per_employee->created_by_user, ' '), 1, 1)) }}
                            </div>
                            <div class="employee-info">
                                <div class="employee-name">{{ $per_employee->created_by_user }}</div>
                                <div class="employee-position">{{ $per_employee->privilege_name }}</div>
                            </div>
                            <div class="employee-bar-container">
                                @php
                                    // Prevent division by zero error
                                    $total_case_handled_per_employee_percentage =
                                        $handle_overall_total_tech_vmall > 0
                                            ? ($per_employee->total_creations / $handle_overall_total_tech_vmall) * 100
                                            : 0;
                                @endphp
                                <div class="employee-bar"
                                    style="width: {{ $total_case_handled_per_employee_percentage }}%;"></div>
                            </div>
                            <div class="employee-value">{{ number_format($per_employee->total_creations) }} /
                                {{ number_format($handle_overall_total_tech_vmall) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
</div>
