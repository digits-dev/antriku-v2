@include('FrontEnd/tracker_header')
<!-- Main Content -->
<div id="mainContent">
    <div class="container-CLD main-content-CLD">
        <!-- Status Overview -->
        <div class="status-overview-CLD">
            <div class="status-header-CLD">
                <div>
                    <h2 class="status-title-CLD">Repair Status</h2>
                    <p class="status-subtitle-CLD">Track your device repair progress</p>
                </div>
                <span class="badge-CLD badge-blue-CLD {{in_array($jo_details->repair_status, [3,5,6]) ? 'hidden-CLD' : ''}} ">In Progress</span>
            </div>

            <div class="card-CLD progress-card-CLD hidden-CLD">
                <div class="card-content-CLD">
                    <div class="progress-content-CLD">
                        <div style="flex: 1;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Repair Progress</h3>
                            <p class="progress-text-CLD" style="margin-bottom: 1rem;">Your device is currently being repaired</p>
                            <div class="progress-bar-CLD">
                                <div class="progress-fill-CLD" style="width: 70%;"></div>
                            </div>
                            <p class="progress-text-CLD">70% Complete</p>
                        </div>
                        <div class="days-remaining-CLD hidden-CLD">
                            <p class="days-number-CLD">2-3</p>
                            <p class="days-label-CLD"><small>Days Remaining</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-CLD grid-cols-1-CLD lg-grid-cols-3-CLD">
            <!-- Main Content -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem; overflow:auto">
                <!-- Device Information -->
                <div class="card-CLD">
                    <div class="card-header-CLD">
                        <h3 class="card-title-CLD">
                            <i class="fas fa-mobile-alt"></i>
                            Device Information
                        </h3>
                    </div>
                    <div class="card-content-CLD">
                        <div class="grid-CLD grid-cols-1-CLD md-grid-cols-2-CLD gap-4-CLD">
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div>
                                    <p class="text-sm-CLD font-medium-CLD text-gray-500-CLD">Model</p>
                                    <p style="font-size: 1.125rem; font-weight: 600;">{{ $jo_details->model_name     }}</p>
                                </div>
                                <div>
                                    <p class="text-sm-CLD font-medium-CLD text-gray-500-CLD">Issue</p>
                                    <small>{{ $jo_details->problem_details . ',' . $jo_details->problem_details_other}}</small>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div>
                                    <p class="text-sm-CLD font-medium-CLD text-gray-500-CLD">Drop-off Date</p>
                                    <p>{{ \Carbon\Carbon::parse($jo_details->created_at)->format('F j, Y') }}</p>
                                </div>
                                {{-- <div>
                                    <p class="text-sm-CLD font-medium-CLD text-gray-500-CLD">Estimated Completion</p>
                                    <p>January 19, 2024</p>
                                </div> --}}
                                <div>
                                    <p class="text-sm-CLD font-medium-CLD text-gray-500-CLD">Technician</p>
                                    <div class="flex-CLD items-center-CLD gap-2-CLD">
                                        @php
                                            $nameParts = explode(' ', $jo_details->cu_name);
                                            $initials = '';
                                            foreach ($nameParts as $part) {
                                                $initials .= strtoupper(substr($part, 0, 1));
                                            }
                                        @endphp

                                        @if ($initials)
                                            <div class="avatar-CLD avatar-sm-CLD">{{ $initials }}</div>
                                        @endif
                                        <span>{{ $jo_details->cu_name }}</span>

                                        @if($jo_details->cu_name)
                                            <div class="stars-CLD">
                                                <i class="fas fa-star star-CLD"></i>
                                                <i class="fas fa-star star-CLD"></i>
                                                <i class="fas fa-star star-CLD"></i>
                                                <i class="fas fa-star star-CLD"></i>
                                                <i class="fas fa-star star-CLD"></i>
                                            </div>
                                        @else
                                        <small>N/A</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repair Timeline -->
                <div class="card-CLD">
                    <div class="card-header-CLD">
                        <h3 class="card-title-CLD">Repair Timeline</h3>
                        <p class="card-description-CLD">Track the progress of your device repair</p>
                    </div>
                    <div class="card-content-CLD">
                        <div class="timeline-CLD">
                            @php
                                // Status labels mapping
                                $statusLabels = [
                                    1 => 'Technical Test Ongoing',
                                    3 => 'Repair Cancelled',
                                    5 => 'Case Completed',
                                    6 => 'Repair completed',
                                    8 => 'Diagnostic fee required',
                                    9 => 'Diagnose in queue - Technician',
                                    10 => 'Technical Test Ongoing',
                                    11 => 'Sign now - Receiving Form',
                                    12 => 'Customer Approval Required',
                                    13 => 'Claim Now',
                                    14 => 'Apple Dispatch - Ready',
                                    15 => 'Apple Dispatch - Ready',
                                    16 => 'Pick-Up in Progress',
                                    17 => 'Undergoing Repair',
                                    18 => 'Technical Test Ongoing',
                                    19 => 'Claim Now',
                                    20 => 'Payment Required',
                                    21 => 'Customer Approval Required',
                                    22 => 'Claim Now',
                                    23 => 'Apple Dispatch - Ready',
                                    24 => 'Apple Dispatch - Ready',
                                    25 => 'Pick-Up in Progress',
                                    26 => 'Undergoing Repair - Apple',
                                    27 => 'Technical Test Ongoing',
                                    28 => 'Claim Now',
                                    29 => 'Technical Test Ongoing',
                                    30 => 'Parts on the Way',
                                    31 => 'Technical Test Ongoing',
                                    33 => 'Parts on the Way',
                                    34 => 'Technical Test Ongoing',
                                    35 => 'Parts on the Way',
                                    38 => 'Claim Now',
                                    39 => 'Technical Test Ongoing',
                                    40 => 'Parts on the Way',
                                    41 => 'Technical Test Ongoing',
                                    42 => 'Technical Test Ongoing',
                                    43 => 'Parts on the Way',
                                    45 => 'Parts on the Way',
                                    47 => 'Undergoing Repair - Apple',
                                    48 => 'Customer Approval Required',
                                ];

                                // Get status label
                                function getStatusLabel($status_id, $statusLabels) {
                                    return $statusLabels[$status_id] ?? 'Unknown Status';
                                }

                                // Group consecutive logs with same status
                                $grouped_logs = [];
                                $currentGroup = null;
                                
                                foreach ($jo_logs as $log) {
                                    $statusLabel = getStatusLabel($log->status_id, $statusLabels);
                                    
                                    // If this is the first log or status is different from current group
                                    if ($currentGroup === null || $currentGroup['status_label'] !== $statusLabel) {
                                        // Save previous group if exists
                                        if ($currentGroup !== null) {
                                            $grouped_logs[] = $currentGroup;
                                        }
                                        
                                        // Start new group
                                        $currentGroup = [
                                            'status_label' => $statusLabel,
                                            'status_id' => $log->status_id,
                                            'logs' => [$log],
                                            'start_date' => $log->transacted_at,
                                            'end_date' => $log->transacted_at,
                                            'count' => 1
                                        ];
                                    } else {
                                        // Add to current group
                                        $currentGroup['logs'][] = $log;
                                        $currentGroup['end_date'] = $log->transacted_at;
                                        $currentGroup['count']++;
                                    }
                                }
                                
                                // Last group
                                if ($currentGroup !== null) {
                                    $grouped_logs[] = $currentGroup;
                                }
                            @endphp

                            {{-- Grouped timeline --}}
                            @foreach ($grouped_logs as $group)
                                <div class="timeline-item-CLD">
                                    <div class="timeline-icon-CLD">
                                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                                        <div class="timeline-connector-CLD completed-CLD"></div>
                                    </div>
                                    <div class="timeline-content-CLD">
                                        <div class="timeline-header-CLD">
                                            <p class="timeline-title-CLD completed-CLD">
                                                {{ $group['status_label'] }}
                                                @if($group['count'] > 1)
                                                    <span class="badge badge-secondary ml-2" style="font-size: 0.75rem; background-color: #6c757d; color: white; padding: 2px 6px; border-radius: 10px;">
                                                        {{ $group['count'] }}x
                                                    </span>
                                                @endif
                                            </p>
                                            <span class="badge-CLD badge-green-CLD">Completed</span>
                                        </div>
                                        <p class="timeline-date-CLD">
                                            @if($group['count'] == 1)
                                                {{ \Carbon\Carbon::parse($group['start_date'])->format('F j, Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($group['start_date'])->format('F j, Y') }} - 
                                                {{ \Carbon\Carbon::parse($group['end_date'])->format('F j, Y') }}
                                                <small class="text-muted d-block">
                                                    ({{ $group['count'] }} Entries over 
                                                    {{ \Carbon\Carbon::parse($group['start_date'])->diffInDays(\Carbon\Carbon::parse($group['end_date'])) + 1 }} 
                                                    {{ \Carbon\Carbon::parse($group['start_date'])->diffInDays(\Carbon\Carbon::parse($group['end_date'])) == 0 ? 'day' : 'days' }})
                                                </small>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Current Status  --}}
                            <div class="timeline-item-CLD">
                                <div class="timeline-icon-CLD">
                                    <i class="fas fa-tools" style="color: #2563eb; font-size: 1.25rem; animation: pulse 2s infinite;"></i>
                                    <div class="timeline-connector-CLD pending-CLD"></div>
                                </div>
                                <div class="timeline-content-CLD">
                                    <div class="timeline-header-CLD">
                                        <p class="timeline-title-CLD current-CLD">
                                            @if(in_array($jo_details->repair_status, [1, 10, 18, 27, 29, 31, 34, 39, 41, 42]))
                                                Technical Test Ongoing
                                            @elseif($jo_details->repair_status == 3)
                                                Repair Cancelled
                                            @elseif($jo_details->repair_status == 5)
                                                Case Completed
                                            @elseif($jo_details->repair_status == 6)
                                                Repair completed
                                            @elseif($jo_details->repair_status == 8)
                                                Diagnostic fee required
                                            @elseif($jo_details->repair_status == 9)
                                                Diagnose in queue - Technician
                                            @elseif($jo_details->repair_status == 11)
                                                Sign now - Receiving Form
                                            @elseif(in_array($jo_details->repair_status, [12, 21, 48]))
                                                Customer Approval Required
                                            @elseif(in_array($jo_details->repair_status, [13, 19, 22, 28, 38]))
                                                Claim Now
                                            @elseif(in_array($jo_details->repair_status, [14, 15]))
                                                Apple Dispatch - Ready
                                            @elseif(in_array($jo_details->repair_status, [16, 25]))
                                                Pick-Up in Progress
                                            @elseif(in_array($jo_details->repair_status, [17]))
                                                Undergoing Repair
                                            @elseif(in_array($jo_details->repair_status, [26, 47]))
                                                Undergoing Repair - Apple
                                            @elseif($jo_details->repair_status == 20)
                                                Payment Required
                                            @elseif(in_array($jo_details->repair_status, [30, 33, 35, 40, 43, 45]))
                                                Parts on the Way
                                            @endif
                                        </p>
                                        <span class="badge-CLD badge-blue-CLD">In Progress</span>
                                    </div>
                                    <p class="timeline-note-CLD">Current Repair Status</p>
                                </div>
                            </div>

                            @if (!in_array($jo_details->repair_status, [3,5,6]))
                                <div class="timeline-item-CLD">
                                    <div class="timeline-icon-CLD">
                                        <i class="fas fa-clock" style="color: #9ca3af; font-size: 1.25rem;"></i>
                                        <div class="timeline-connector-CLD pending-CLD"></div>
                                    </div>
                                    <div class="timeline-content-CLD">
                                        <div class="timeline-header-CLD">
                                            <p class="timeline-title-CLD pending-CLD">Repair Completed</p>
                                            <span class="badge-CLD badge-gray-CLD">Pending</span>
                                        </div>
                                        <p class="timeline-date-CLD">
                                            Completion
                                            {{-- Est. {{\Carbon\Carbon::parse(now())->format('F j, Y') }} --}}
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar-CLD">

                <!-- Service Center Info -->
                <div class="card-CLD">
                    <div class="card-header-CLD">
                        <h3 class="card-title-CLD">Service Center</h3>
                    </div>
                    <div class="card-content-CLD">
                        <div class="service-info-CLD mb-4-CLD">
                            <div class="service-icon-CLD">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <div>
                                <p class="font-medium-CLD">{{ $jo_details->branch_name }}</p>
                                <p class="text-sm-CLD text-gray-500-CLD">{{ $jo_details->branch_address }}</p>
                            </div>
                        </div>
                        <div class="separator-CLD"></div>
                        <ul class="contact-list-CLD">
                            <li class="contact-item-CLD">
                                <i class="fas fa-phone"></i>
                                <span>{{ $jo_details->branch_contact }}</span>
                            </li>
                            <li class="contact-item-CLD">
                                <i class="fas fa-envelope"></i>
                                <span>servicecenter@beyondthebox.ph</span>
                            </li>
                            <li class="contact-item-CLD">
                                <i class="fas fa-clock"></i>
                                <span>{{ $jo_details->branch_schedule }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Device Photos -->
                <div class="card-CLD">
                    <div class="card-header-CLD">
                        <h3 class="card-title-CLD">
                            <i class="fas fa-camera"></i>
                            Model Photos
                        </h3>
                    </div>
                    <div class="card-content-CLD">
                        <div class="photo-grid-CLD">
                            <div class="photo-placeholder-CLD">
                                @if ($jo_details->inspected_model_photo)
                                    <img src="{{ Storage::url($jo_details->inspected_model_photo) }}" width="170px" alt="model photo">
                                @else
                                    <i class="fas fa-camera"></i>
                                    <p class="photo-label-CLD">1st Diagnosis</p>
                                @endif
                            </div>
                            <div class="photo-placeholder-CLD">
                                 @if ($jo_details->second_inspected_model_photo)
                                    <img src="{{ Storage::url($jo_details->second_inspected_model_photo) }}" width="170px" alt="model photo">
                                @else
                                    <i class="fas fa-camera"></i>
                                    <p class="photo-label-CLD">2nd Diagnosis</p>
                                @endif
                            </div>
                        </div>
                        <p class="text-xs-CLD text-gray-500-CLD">Inspected model photos during diagnosis.</p>
                    </div>
                </div>

                <!-- Uploaded -->
                <div class="card-CLD">
                    <div class="card-header-CLD">
                        <h3 class="card-title-CLD">
                            <i class="fas fa-file-alt"></i>
                            Uploaded Receipt
                        </h3>
                    </div>
                    @php
                        function formatBytes($bytes, $precision = 2) {
                            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                            $bytes = max($bytes, 0);
                            $pow = $bytes ? floor(log($bytes) / log(1024)) : 0;
                            $pow = min($pow, count($units) - 1);
                            $bytes /= pow(1024, $pow);
                            return round($bytes, $precision) . ' ' . $units[$pow];
                        }

                        function shortenFilename($file, $maxLength = 12) {
                            $fileInfo = pathinfo($file);
                            $name = $fileInfo['filename'];
                            $ext = isset($fileInfo['extension']) ? '.' . $fileInfo['extension'] : '';
                            return (strlen($name) > ($maxLength + 2))
                                ? substr($name, 0, $maxLength) . '...' . substr($name, -2) . $ext
                                : $file;
                        }
                    @endphp

                    <div class="card-content-CLD">
                        <!-- Uploaded Files List -->
                        @foreach (['invoice', 'rpf_invoice', 'final_invoice'] as $type)
                            @if (!empty($jo_details->$type))
                                @php
                                    $file = $jo_details->$type;
                                    $path = 'invoice/' . $file;
                                    $fileSize = \Storage::disk('public')->exists($path) ? formatBytes(\Storage::disk('public')->size($path)) : 'N/A';
                                    $shortened = shortenFilename($file);
                                    $url = Storage::url($path);
                                @endphp
                                <ul class="uploaded-files-list" id="filesList">
                                    <li class="file-item">
                                        <div class="file-icon png">
                                            <img src="{{ $url }}" style="border-radius: 5px;" width="30px" height="30px" alt="{{ $type }}">
                                        </div>
                                        <div class="file-info">
                                            <div class="file-name">{{ $shortened }}</div>
                                            <div class="file-size">{{ $fileSize }}</div>
                                        </div>
                                        <div class="file-actions">
                                            <button class="action-btn view-btn" title="View"
                                                    data-img="{{ $url }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <a href="{{ $url }}" download class="action-btn delete-btn" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>

                                        </div>
                                    </li>
                                </ul>
                                @break
                            @endif
                        @endforeach

                        @if(empty($jo_details->invoice) && empty($jo_details->rpf_invoice) && empty($jo_details->final_invoice))
                            <div class="empty-state" id="emptyState">
                                <i class="fas fa-folder-open"></i>
                                <div>No files uploaded yet</div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@include('FrontEnd/tracker_footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function () {
                const imgUrl = this.getAttribute('data-img');
                Swal.fire({
                    title: 'Uploaded Receipt Preview',
                    html: `<img src="${imgUrl}" style="width: 100%; max-width: 500px; border-radius: 10px;" alt="Invoice">`,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: 700,
                });
            });
        });
    });
</script>

