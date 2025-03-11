
function assignTechnician(id, reference_no, technician_id) {
    // Fetch dynamic technicians
    fetch('to_diagnose/GetTechnicians') // Change this to your actual endpoint
        .then(response => response.json())
        .then(data => {
            let inputOptions = {};

            data.forEach(technician => {
                if (technician.id !== technician_id) { 
                    inputOptions[technician.id] = technician.name;
                }
            });

            // Show the SweetAlert select input
            Swal.fire({
                title: technician_id ? 'Do you want to reassign?' : 'Select Technician to Assign',
                text: technician_id ? `Warning: the reference: ${reference_no} has already assigned technician` : `Reference No: ${reference_no}`,
                icon: technician_id ? 'warning':'question',
                width: '40rem',
                input: 'select',
                inputOptions: inputOptions,
                inputPlaceholder: 'Choose a technician',
                showCancelButton: true,
                confirmButtonText: 'Assign',
                reverseButtons: true,
                preConfirm: (technicianId) => {
                    if (!technicianId) {
                        Swal.showValidationMessage('You need to select a technician');
                    }
                    return technicianId;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let technicianId = result.value;

                    fetch(`to_diagnose/AssignTechnician`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: id, technician_id: technicianId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', 'Technician assigned successfully.', 'success').then(() => {
                                location.reload(); // Reload the page after successful assignment
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to assign technician.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    });
                }
            });
        });
}


function acceptJob(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to accept this job?",
        icon: "question",
        width: '40rem',
        showCancelButton: true,
        confirmButtonText: "Yes, accept it!",
        cancelButtonText: "No, cancel",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('to_diagnose/AcceptJob', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ensure CSRF token is included
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Accepted!', 'You have accepted the job.', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire("Error", "Something went wrong.", "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire("Error", "Failed to accept job.", "error");
            });
        }
    });
}

