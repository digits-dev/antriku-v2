<style>
    .timeline-container {
        height: 425px;
        overflow: auto;
        margin-top: 10px;
        box-shadow: 0 -1px 0 0 rgba(173, 170, 170, 0.1);
        padding-top: 30px;
    }

    #transaction-timeline {
        position: relative;
        max-width: 900px;
        overflow: auto;
        margin: auto;
    }

    #transaction-timeline::after {
        content: '';
        position: absolute;
        width: 4px;
        background: #06d6a0;
        top: 0;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }

    .status-name-motion{
        color: #06d6a0;
    }

    .timeline-step-motion {
        padding: 20px 40px;
        position: relative;
        width: 50%;
        box-sizing: border-box;
    }

    .timeline-step-motion:nth-child(odd) {
        left: 0;
    }

    .timeline-step-motion:nth-child(even) {
        left: 50%;
    }

    .timeline-step-motion::before {
        content: "\1F463";
        position: absolute;
        width: 30px;
        height: 30px;
        top: 15px;
        right: -15px;
        background: #06d6a0;
        color: white !important;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        z-index: 1;
    }

    .timeline-step-motion:nth-child(even)::before {
        left: -15px;
        right: auto;
    }

    .content-motion {
        background: white;
        position: relative; /* ensure relative for ::after */
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .content-motion:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .content-motion h3 {
        margin-top: 0;
        font-size: 1.5rem;
    }

    .content-motion p {
        margin: 10px 0 0;
        color: #555;
        line-height: 1.6;
    }

    /* Arrow triangles */
    .content-motion::after {
        content: '';
        position: absolute;
        top: 30px; /* vertically align with content */
        width: 0;
        height: 0;
        border: 10px solid transparent;
    }

    .timeline-step-motion:nth-child(odd) .content-motion::after {
        right: -20px; /* stick out on the right */
        border-left-color: rgb(199, 199, 199);
    }

    .timeline-step-motion:nth-child(even) .content-motion::after {
        left: -20px; /* stick out on the left */
        border-right-color: rgb(199, 199, 199);
    }

    @media (max-width: 768px) {
        #transaction-timeline::after {
            left: 20px;
        }

        .timeline-step-motion {
            width: 100%;
            padding-left: 60px;
            padding-right: 25px;
        }

        .timeline-step-motion:nth-child(even),
        .timeline-step-motion:nth-child(odd) {
            left: 0;
        }

        .timeline-step-motion::before {
            left: 15px;
            right: auto;
        }

        /* On mobile, optionally hide the arrows */
        .content-motion::after {
            display: none;
        }
    }

    .swal2-topmost {
        z-index: 100000 !important;
    }
</style>
<table class="transactions-table">
    <thead>
        <tr>
            <th>Reference No.</th>
            <th>Customer Name</th>
            <th>Created Date</th>
            <th>Release Date</th>
            <th>Duration</th>
            <th>Current Status</th>
            <th>-</th>
        </tr>
    </thead>
    <tbody id="transactions-body">
        @foreach ($time_motion as $per_transaction)
            <tr>
                <td>{{ $per_transaction->reference_no }}</td>
                <td>{{ $per_transaction->last_name . ',' . $per_transaction->first_name }}</td>
                <td>{!! $per_transaction->created_at ?? '<span style="color: #ef4444">No call out logs</span>' !!}</td>
                <td>{!! $per_transaction->end_timestamp ?? '<span style="color: #ef4444">No release date logs</span>' !!}</td>
                <td>
                    @if (empty($per_transaction->created_at) || empty($per_transaction->end_timestamp))
                        <svg xmlns="http://www.w3.org/2000/svg" style="color: #2563eb" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="time-icon">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span style="color: #2563eb">Pending</span>
                    @else
                        @php
                            if ($per_transaction->created_at && $per_transaction->end_timestamp) {
                                $start = \Carbon\Carbon::parse($per_transaction->created_at);
                                $end = \Carbon\Carbon::parse($per_transaction->end_timestamp);

                                $duration = $start->diff($end);
                                $parts = [];

                                if ($duration->d > 0) {
                                    $parts[] = $duration->d . ' day/s';
                                }
                                if ($duration->h > 0) {
                                    $parts[] = $duration->h . ' hr/s';
                                }
                                if ($duration->i > 0) {
                                    $parts[] = $duration->i . ' min/s';
                                }
                                if ($duration->s > 0 || empty($parts)) {
                                    $parts[] = $duration->s . ' sec/s';
                                }

                                $formattedDuration = implode(', ', $parts);
                            } else {
                                $formattedDuration = '<span class="text-danger">Incomplete data</span>';
                            }
                        @endphp
                        <svg xmlns="http://www.w3.org/2000/svg" style="color: #06d6a0" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="time-icon">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        {!! '<span style="color: #06d6a0">' . $formattedDuration . '</span>' !!}
                    @endif
                </td>
                <td>
                    <span
                        class="status-badge {{ $per_transaction->repair_status == 6 ? 'status-completed' : 'status-processing' }}">
                        @if ($per_transaction->repair_status == 6)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" style="color: #2563eb" width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="time-icon">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        @endif
                        {{ $per_transaction->status_name }}
                    </span>
                </td>
                <td class="text-primary" style="cursor: pointer">
                    <a href="#" class="transaction-details" data-id="{{ $per_transaction->id }}"
                        data-reference="{{ $per_transaction->reference_no }}"
                        data-customer="{{ $per_transaction->last_name . ', ' . $per_transaction->first_name }}"
                        data-amount="{{ $formattedDuration ?? 'N/A' }}"
                        data-status="{{ $per_transaction->status_name }}"
                        data-ended="{{ $per_transaction->end_timestamp }}"
                        data-started="{{ $per_transaction->created_at ?? 'N/A' }}"
                        data-assinged="{{$per_transaction->technician_assigned_at}}"
                        data-accepted="{{$per_transaction->technician_accepted_at}}"
                        data-creator="{{$per_transaction->creator}}"
                        data-lead="{{$per_transaction->lead_tech}}"
                        data-tech="{{$per_transaction->technician}}">
                        <u>View Details</u>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Transaction Details Modal -->
<div class="modal-cust" id="transaction-modal">
    <div class="modal-content-cust">
        <div class="modal-header-cust">
            <h3 class="modal-title-cust">📃 Transaction Details</h3>
            <button class="modal-close-cust" id="modal-close">&times;</button>
        </div>
        <div id="transaction-details-content">
            <div class="transaction-info">
                <div class="row">
                    <div class="col-md-4">
                        <p class="text-uppercase"><strong>Reference No.:</strong><span id="modal-transaction-id"></span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-uppercase"><strong>Customer:</strong> <span id="modal-customer"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>DURATION:</strong> <span id="modal-amount"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-uppercase"><strong>Status:</strong> <span id="modal-status"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-uppercase"><strong>Created Date:</strong> <span id="modal-started"></span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-uppercase"><strong>Release Date:</strong> <span id="modal-ended"></span></p>
                    </div>
                </div>

                <div class="timeline-container">
                    <div id="transaction-timeline">
                        {{-- dynamically display  --}}
                    </div>
                </div>
            </div>

            <div class="transaction-timeline" id="modal-timeline">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.addEventListener("click", function (e) {
            const modal = document.getElementById("transaction-modal");

            if (!modal) return;

            // Handle "View Details" click (open modal)
            if (e.target.closest(".transaction-details")) {
                e.preventDefault();
                const link = e.target.closest(".transaction-details");

                modal.classList.add("active");

                document.getElementById("modal-transaction-id").textContent = link.dataset.reference;
                document.getElementById("modal-customer").textContent = link.dataset.customer;
                document.getElementById("modal-amount").textContent = link.dataset.amount;
                document.getElementById("modal-status").textContent = link.dataset.status;
                document.getElementById("modal-started").textContent = link.dataset.started;
                document.getElementById("modal-ended").textContent = link.dataset.ended;

                $('#transaction-timeline').empty();

                $.ajax({
                    url: '{{ route('get_timeline') }}',
                    type: 'POST',
                    data: { id: link.dataset.id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success == true) {
                            const manualSteps = [
                                { status_name: 'JOB ORDER CREATION DATE', name: link.dataset.creator, transacted_at: link.dataset.started },
                                { status_name: 'TECHNICIAN ASSIGNED DATE', name: link.dataset.lead, transacted_at: link.dataset.assinged },
                                { status_name: 'TECHNICIAN ACCEPTED DATE', name: link.dataset.tech, transacted_at: link.dataset.accepted }
                            ];

                            const combinedSteps = [...manualSteps, ...response.data];
                            combinedSteps.sort((a, b) => new Date(a.transacted_at) - new Date(b.transacted_at));

                            combinedSteps.forEach((item, index) => {
                                let durationText = '';
                                if (index > 0) {
                                    const currentTime = new Date(item.transacted_at);
                                    const previousTime = new Date(combinedSteps[index - 1].transacted_at);
                                    const diffMs = currentTime - previousTime;
                                    const diffSeconds = Math.floor(diffMs / 1000);
                                    const hours = Math.floor(diffSeconds / 3600);
                                    const minutes = Math.floor((diffSeconds % 3600) / 60);
                                    const seconds = diffSeconds % 60;
                                    durationText = `${hours} hr/s, ${minutes} min/s, ${seconds} sec/s`;
                                } else {
                                    durationText = 'Start';
                                }

                                $('#transaction-timeline').append(`
                                    <div class="timeline-step-motion">
                                        <div class="content-motion">
                                            <h3 class="status-name-motion"><b>${item.status_name}</b></h3>
                                            <p><b>🧑‍💻</b> ${item.name}</p>
                                            <p><b>📅</b> ${item.transacted_at}</p>
                                            <p><b>⌚</b> DURATION: ${durationText}</p>
                                            ${item.callout_total ? `
                                                <p><b>📞</b> CALLOUT: <b>${item.callout_total}</b> 
                                                    <small onclick="view_callouts(${item.returns_header_id}, ${item.status_id})" 
                                                        class="text-uppercase text-info" 
                                                        style="cursor:pointer;">
                                                        <i>view details</i>
                                                    </small> 
                                                 </p>`
                                            : ''}
                                        </div>
                                    </div>
                                `);
                            });

                        } else {
                            $('#transaction-timeline').append(
                                '<div class="timeline-step-motion"><div class="content-motion"><p>No additional details found.</p></div></div>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#transaction-timeline').append(
                            '<div class="timeline-step-motion"><div class="content-motion"><p>Error fetching details.</p></div></div>'
                        );
                    }
                });
            }

            // Handle modal close (button or background click)
            if (e.target.matches("#modal-close") || e.target === modal) {
                modal.classList.remove("active");
            }
        });
    });

    function view_callouts(header_id, status_id){

        $.ajax({ 
            url: "{{ route('view-callout-details') }}",
            type: "POST",
            data: {
                'header_id': header_id,
                'status_id': status_id,
                _token: '{!! csrf_token() !!}'
            },
            success: function(response)
            {
                if(response.success == true) {
                   let tableRows = '';
                    response.data.forEach((item, index) => {
                        tableRows += `
                            <tr>
                                <td style="text-align: left;">CallOut No.${index + 1}</td> 
                                <td style="text-align: left;">${item.callout_by_name}</td>
                                <td style="text-align: left;">${item.call_out_at}</td>
                            </tr>`;
                    });

                    Swal.fire({
                        html: `
                            <div class="transactions-header" style="margin-top: 0%;">
                                <h2 class="card-title-dash" style="margin:0%">
                                    <div class="card-icon-dash icon-default">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" style="color: white" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="time-icon">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                    Call Outs Logs
                                </h2>
                            </div>
                            <div style="max-height: 400px; overflow-y: auto; border: 1px solid lightgrey;">
                                <table class="transactions-table">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">No.</th>
                                            <th class="text-uppercase">CallOut By</th>
                                            <th class="text-uppercase">CallOut At</th>
                                        </tr>
                                    </thead>
                                    <tbody id="transactions-body">
                                        ${tableRows}
                                    </tbody>
                                </table>
                            </div>
                        `,
                        width: '70%', 
                        allowOutsideClick: false,
                        confirmButtonText: 'Okay, Close',
                        customClass: {
                            popup: 'swal2-topmost',
                            confirmButton: 'btn btn-info btn-sm',
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error request, Please try again. Thank you!',
                    });
                }
            }                    
        });
    }
</script>
