$('.print-form').on('click', function () {
  const dbId = $(this).attr('href')?.replace('#', '');
  const currentMainPath = window.location.origin;
  Swal.fire({
    title: 'Please choose type of Print Form',
    html:
      '<button detail-to-view="PrintReceivingForm" style="margin-right: 5px; margin-bottom:5px" class="swal-view-menu btn btn-success">' +
      '<i class="fa fa-print"></i> Print Receive Form' +
      '</button>' +
      '<button detail-to-view="PrintTechnicalReport" style="margin-right: 5px; margin-bottom:5px" class="swal-view-menu btn btn-danger">' +
      '<i class="fa fa-print"></i> ️Print Technical Report ' +
      '</button>' +
      '<button detail-to-view="PrintSameDayReleaseForm" style="margin-right: 5px;" class="swal-view-menu btn btn-primary">' +
      '<i class="fa fa-print"></i> Print Same Day Release Form' +
      '</button>',
    showConfirmButton: false,
    didOpen: () => {
      $('.swal-view-menu').on('click', function () {
        Swal.close();
        const detail = $(this).attr('detail-to-view');
        location.assign(
          `${currentMainPath}/admin/transaction_history/${detail}/${dbId}`
        );
      });
    },
  });
});