// Function to assign a technician
function assignTechnician(id, reference_no, branch_id, technician_id) {
    fetch('to_assign/GetTechnicians')
        .then(response => response.json())
        .then(data => {
            let optionsHtml = `<select id="technicianSelect" class="js-example-basic-single" name="technician" style="width: 100%;">`;
            optionsHtml += `<option value="">Choose a technician</option>`;
    
            optionsHtml += `<optgroup label="${branch_id === 1 ? "Greenhills VMall" : "Bonifacio High Street Central"}">`;

            data.forEach(technician => {

                if ((technician.id_cms_privileges == 8 || technician.branch_id == branch_id) && technician.id !== technician_id) {
                    optionsHtml += `<option value="${technician.id}">${technician.name} - ${technician.id}</option>`;
                }
            });
            
            optionsHtml += `</optgroup></select>`;

            // // Group technicians based on branch_id
            // let groupedTechnicians = {
            //     "VMALL": [],
            //     "GREENHILLS": []
            // };

            // data.forEach(technician => {
            //     if (technician.id !== technician_id) { 
            //         let branchGroup = technician.branch_id === 1 ? "Greenhills VMall" : "Bonifacio High Street Central";

            //         if (!groupedTechnicians[branchGroup]) {
            //             groupedTechnicians[branchGroup] = [];
            //         }

            //         groupedTechnicians[branchGroup].push(`<option value="${technician.id}">${technician.name}</option>`);
            //     }
            // });

            // // Build optgroups
            // for (let branch in groupedTechnicians) {
            //     if (groupedTechnicians[branch].length > 0) {
            //         optionsHtml += `<optgroup label="${branch}">`;
            //         optionsHtml += groupedTechnicians[branch].join('');
            //         optionsHtml += `</optgroup>`;
            //     }
            // }

            // optionsHtml += `</select>`;

            // Show SweetAlert modal with Select2
            Swal.fire({
                title: technician_id ? 'Do you want to reassign?' : 'Select Technician to Assign',
                html: `
                    <p>${technician_id ? `Warning: the reference: ${reference_no} has already assigned a technician` : `Reference No: ${reference_no}`}</p>
                    ${optionsHtml}
                `,
                icon: technician_id ? 'warning' : 'question',
                width: '40rem',
                showCancelButton: true,
                confirmButtonText: 'Assign',
                didOpen: () => {
                    // Initialize Select2 inside SweetAlert after the modal is rendered
                    $('#technicianSelect').select2({
                        dropdownParent: $('.swal2-popup'), // Prevents dropdown from hiding behind modal
                        placeholder: 'Choose a technician',
                        allowClear: true
                    });
                },
                preConfirm: () => {
                    let technicianId = $('#technicianSelect').val();
                    if (!technicianId) {
                        Swal.showValidationMessage('You need to select a technician');
                    }
                    return technicianId;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let technicianId = result.value;

                    fetch(`to_assign/AssignTechnician`, {
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
                                location.reload(); 
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

// Function to accept a job
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
