function showVoidAlert(id) {
    Swal.fire({
        title: 'Void Transaction',
        html: `
            <label for='reason'>Reason for voiding:</label><br>
             <textarea id='reason' name='reason' rows='4' cols='40' 
                placeholder='Enter reason here...'
                style='border-radius: 10px; padding: 8px; border: 1px solid #ccc; width: 100%; box-sizing: border-box;'></textarea>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Void',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const reason = document.getElementById('reason').value.trim();
            if (!reason) {
                Swal.showValidationMessage('Reason is required');
                return false;
            }
            return reason;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const reason = result.value;

            // Send AJAX request
            fetch('/admin/transaction_history/voidTransaction', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: id,
                    reason: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Voided!', data.message, 'success').then(() => {
                        location.reload(); // optional: reload page to reflect changes
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Server error occurred.', 'error');
            });
        }
    });
}
