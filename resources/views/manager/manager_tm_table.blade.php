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
</style>
<table class="transactions-table">
    <thead>
        <tr>
            <th style="font-size: 10px" class="text-uppercase">Reference</th>
            <th style="font-size: 10px" class="text-uppercase">Customer</th>
            <th style="font-size: 10px" class="text-uppercase">Releasing At</th>
            <th style="font-size: 10px" class="text-uppercase">Released At</th>
            <th style="font-size: 10px" class="text-uppercase">Duration</th>
        </tr>
    </thead>
    <tbody id="transactions-body">
            <tr>
                <td>A000000002</td>
                <td>Cris Lloyd Dalina</td>
                <td><span style="color: #ef4444">No for releasing logs</span></td>
                <td><span style="color: #ef4444">No released logs</span></td>
                <td>
                    <span style="color: #2563eb">Pending</span>
                </td>
                {{-- <td class="text-primary" style="cursor: pointer">
                    <a href="#" class="transaction-details" 
                        data-id="{{ $per_transaction->id }}"
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
                        data-tech="{{$per_transaction->technician}}
                        >
                        <u>
                            <i class="bi bi-eye"></i>
                        </u>
                    </a>
                </td> --}}
            </tr>
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

{{-- <script>
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
</script> --}}
