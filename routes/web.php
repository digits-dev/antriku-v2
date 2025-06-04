<?php

use App\Http\Controllers\AdminProductItemMasterController;
use App\Http\Controllers\AdminCustomDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/payment-gateway/{id}', 'PayMongoController@CreatePayment');
Route::post('/payment-gateway-process/{id}', 'PayMongoController@CreatePaymentProcess');

Route::get('/get-gcash-payment-link/{id}', 'PayMongoController@GetGcashLink');
Route::get('/get-grabpay-payment-link/{id}', 'PayMongoController@GetGrabpayLink');
Route::get('/get-chargeable/{id}', 'PayMongoController@Chargeable');

Route::post('/CheckPaymentIntent', 'PayMongoController@CheckPaymentIntent')->name('check-payment');

Route::group(['middleware' => ['web']], function () {

    Route::post('/admin/returns_header/add-transaction-process', 'AdminReturnsHeaderController@AddTransactionProcess')->name('add-transaction'); // CREATE TRANSACTION
    Route::post('/admin/returns_header/model', 'AdminReturnsHeaderController@model')->name('selected-model');    // SET IMAGE FOR SELECTED MODEL
    Route::post('/admin/returns_header/comment', 'AdminReturnsHeaderController@comment')->name('all-comment');   // ADD COMMENT
    Route::post('/admin/pay_diagnostic/DiagnosticPaymentStatus', 'AdminReturnsHeaderController@DiagnosticPaymentStatus')->name('diagnostic-status');     // SEND DIAGNOSTIC PAYMENT EMAIL AND CHANGE STATUS

    Route::post('/admin/to_diagnose/search_item', 'AdminReturnsHeaderController@search_item')->name('search-item');     // SEARCH ITEM FOR DIGITS CODE
    // Route::post('/admin/to_diagnose/diagnose-transaction-process/{id}','AdminToDiagnoseController@DiagnoseTransactionProcess');    // PROCESS AFTER SUBMITTING FORM FOR DIAGNOSE PAGE

    Route::post('/admin/to_diagnose/addQuotation', 'AdminToDiagnoseController@AddQuotation')->name('add-quotation');    // ADDING ROW FOR QUOTATION
    Route::post('/admin/to_diagnose/deleteQuotation', 'AdminToDiagnoseController@DeleteQuotation')->name('delete-quotation');   // DELETE ROW FOR QUOTATION

    Route::post('/admin/to_diagnose/changeTransactionStatus','AdminToDiagnoseController@changeTransactionStatus')->name('change-status');  // CHANGE STATUS OF TRANSACTION
    Route::post('/admin/to_diagnose/saveFinalInvoice','AdminToDiagnoseController@saveFinalInvoice')->name('upload_final_invoice');  // CHANGE STATUS OF TRANSACTION
    Route::post('/admin/to_diagnose/CheckGSX','AdminToDiagnoseController@CheckGSX')->name('check-gsx');    
    Route::post('/admin/to_diagnose/SearchSparePartNo','AdminToDiagnoseController@SearchSparePartNo')->name('search-sparepart');
    Route::post('/admin/to_diagnose/AcceptJob','AdminToDiagnoseController@AcceptJob');      

    Route::post('/admin/pay_diagnostic/edit-transaction-process/{id}', 'AdminReturnsHeaderController@EditTransactionProcess');
    // Route::post('/admin/to_pay_parts/diagnose-transaction-process/{id}','AdminToDiagnoseController@DiagnoseTransactionProcess');
    // Route::post('/admin/repair_in_process/diagnose-transaction-process/{id}','AdminToDiagnoseController@DiagnoseTransactionProcess');
    // Route::post('/admin/pick_up/diagnose-transaction-process/{id}','AdminToDiagnoseController@DiagnoseTransactionProcess');
    // Route::post('/admin/to_close/diagnose-transaction-process/{id}','AdminToDiagnoseController@DiagnoseTransactionProcess');

    Route::get('/admin/PrintStatus', 'AdminReturnsHeaderController@PrintStatus')->name('change-print-status');   // CHANGE PRINT STATUS

    //***********************************PRINT FORM*************************************
    //CREATE TRANSACTION
    Route::get('/admin/returns_header/PrintReceivingForm/{id}', 'AdminReturnsHeaderController@PrintReceivingForm');
    Route::get('/admin/returns_header/PrintTechnicalReport/{id}', 'AdminReturnsHeaderController@PrintTechnicalReport');
    Route::get('/admin/returns_header/PrintReleaseForm/{id}', 'AdminReturnsHeaderController@PrintReleaseForm');
    Route::get('/admin/returns_header/PrintSameDayReleaseForm/{id}', 'AdminReturnsHeaderController@PrintSameDayReleaseForm');

    //TO PAY DIAGNOSTIC
    Route::get('/admin/pay_diagnostic/PrintReceivingForm/{id}', 'AdminReturnsHeaderController@PrintReceivingForm');
    Route::get('/admin/pay_diagnostic/PrintTechnicalReport/{id}', 'AdminReturnsHeaderController@PrintTechnicalReport');
    Route::get('/admin/pay_diagnostic/PrintReleaseForm/{id}', 'AdminReturnsHeaderController@PrintReleaseForm');
    Route::get('/admin/pay_diagnostic/PrintSameDayReleaseForm/{id}', 'AdminReturnsHeaderController@PrintSameDayReleaseForm');

    //DIAGNOSE
    Route::get('/admin/to_diagnose/PrintReceivingForm/{id}', 'AdminReturnsHeaderController@PrintReceivingForm');
    Route::get('/admin/to_diagnose/PrintTechnicalReport/{id}', 'AdminReturnsHeaderController@PrintTechnicalReport');
    Route::get('/admin/to_diagnose/PrintReleaseForm/{id}', 'AdminReturnsHeaderController@PrintReleaseForm');
    Route::get('/admin/to_diagnose/PrintSameDayReleaseForm/{id}', 'AdminReturnsHeaderController@PrintSameDayReleaseForm');

    //TO PAY
    Route::get('/admin/to_pay_parts/PrintReceivingForm/{id}', 'AdminReturnsHeaderController@PrintReceivingForm');
    Route::get('/admin/to_pay_parts/PrintTechnicalReport/{id}', 'AdminReturnsHeaderController@PrintTechnicalReport');
    Route::get('/admin/to_pay_parts/PrintReleaseForm/{id}', 'AdminReturnsHeaderController@PrintReleaseForm');
    Route::get('/admin/to_pay_parts/PrintSameDayReleaseForm/{id}', 'AdminReturnsHeaderController@PrintSameDayReleaseForm');

    //TO REPAIR IN PROCESS
    Route::get('/admin/repair_in_process/PrintReceivingForm/{id}', 'AdminReturnsHeaderController@PrintReceivingForm');
    Route::get('/admin/repair_in_process/PrintTechnicalReport/{id}', 'AdminReturnsHeaderController@PrintTechnicalReport');
    Route::get('/admin/repair_in_process/PrintReleaseForm/{id}', 'AdminReturnsHeaderController@PrintReleaseForm');
    Route::get('/admin/repair_in_process/PrintSameDayReleaseForm/{id}', 'AdminReturnsHeaderController@PrintSameDayReleaseForm');

    //TO CLOSE
    Route::get('/admin/to_close/PrintReceivingForm/{id}', 'AdminReturnsHeaderController@PrintReceivingForm');
    Route::get('/admin/to_close/PrintTechnicalReport/{id}', 'AdminReturnsHeaderController@PrintTechnicalReport');
    Route::get('/admin/to_close/PrintReleaseForm/{id}', 'AdminReturnsHeaderController@PrintReleaseForm');
    Route::get('/admin/to_close/PrintSameDayReleaseForm/{id}', 'AdminReturnsHeaderController@PrintSameDayReleaseForm');

     // CALL OUT PRINT
     Route::get('/admin/mail_in/DownloadTechnicalReport/{id}', 'AdminMailInController@PrintTechnicalReport');
     Route::get('/admin/carry_in/DownloadTechnicalReport/{id}', 'AdminCarryInController@PrintTechnicalReport');
     Route::get('/admin/call_out_releasing/DownloadTechnicalReport/{id}', 'AdminCallOutReleasingController@PrintTechnicalReport');

    //TO TRANSACTION HISTORY
    Route::get('/admin/transaction_history/PrintReceivingForm/{id}', 'AdminReturnsHeaderController@PrintReceivingForm');
    Route::get('/admin/transaction_history/PrintTechnicalReport/{id}', 'AdminReturnsHeaderController@PrintTechnicalReport');
    Route::get('/admin/transaction_history/PrintReleaseForm/{id}', 'AdminReturnsHeaderController@PrintReleaseForm');
    Route::get('/admin/transaction_history/PrintSameDayReleaseForm/{id}', 'AdminReturnsHeaderController@PrintSameDayReleaseForm');
    //************************************************************************************

    Route::get('/admin/to_diagnose/AssignedTechnician', 'AdminTransactionHistoryController@AssignedTechnician');
    Route::get('/admin/to_pay_parts/AssignedTechnician', 'AdminTransactionHistoryController@AssignedTechnician');
    Route::get('/admin/repair_in_process/AssignedTechnician', 'AdminTransactionHistoryController@AssignedTechnician');
    Route::get('/admin/transaction_history/AssignedTechnician', 'AdminTransactionHistoryController@AssignedTechnician');

    //Route::get('/admin/transaction_history/ExportData','AdminTransactionHistoryController@ExportData');
    Route::post('/admin/transaction_history/ExportData', 'AdminTransactionHistoryController@getExportData')->name('exportData');
    Route::get('/admin/returns_appointment/getTime', 'AdminReturnsAppointmentController@getTime')->name('get_time');
    Route::get('/admin/transaction_history/getDetailView/{id}', 'AdminTransactionHistoryController@getDetailView')->name('getDetailView');

    //get Address submasters
    Route::post('/admin/returns_header/getProvinces','AdminReturnsHeaderController@getProvinces')->name('get_provinces');
    Route::post('/admin/returns_header/getCities','AdminReturnsHeaderController@getCities')->name('get_cities');
    Route::post('/admin/returns_header/getBrgy','AdminReturnsHeaderController@getBrgy')->name('get_brgy');

    // email verifier
    Route::post('/admin/returns_header/verifyEmail','AdminReturnsHeaderController@verfiyEmail')->name('verify_email');
    
    // save PDF to drive
    Route::post('/admin/returns_header/uploadPdf','AdminReturnsHeaderController@uploadPdf')->name('upload_pdf');
    
    // send PDF to customer email
    Route::post('/admin/returns_header/sendPdf','AdminReturnsHeaderController@sendPdf')->name('send_pdf_email');

    // clear pop up messege session
    Route::post('/admin/clear-just-logged-in', function () {
        Session::forget('just_logged_in');
        return response()->json(['status' => 'cleared']);
    });
    Route::post('/admin/transaction_history/ExportData','AdminTransactionHistoryController@getExportData')->name('exportData');
    Route::get('/admin/returns_appointment/getTime','AdminReturnsAppointmentController@getTime')->name('get_time'); 
    Route::get('/admin/transaction_history/getDetailView/{id}','AdminTransactionHistoryController@getDetailView')->name('getDetailView');
    
    // Lead Tech assigning
    Route::get('/admin/to_assign/GetTechnicians','AdminToAssignController@GetTechnicians');
    Route::post('/admin/to_assign/AssignTechnician','AdminToAssignController@AssignTechnician');  

    // Call out recorder
    Route::post('/admin/call_out/call_out','AdminCallOutController@callOut');

    // receive_spare_part
    Route::post('/admin/receive_spare_part','AdminSparePartsReceivingController@receiveSparePart')->name('receive_spare_part');

    // filter_doa_spare_part
    Route::post('/admin/filter_spare_part','AdminPendingRepairController@filterDoaSparePart')->name('filter_doa_spare_part');

    // save_doa_spare_part
    Route::post('/admin/save_doa_spare_part','AdminPendingRepairController@saveDoaSparePart')->name('save_add_doa_parts');

    //Inventory
    Route::get('/admin/parts_item_master_stocks/stock_ordering','AdminPartsItemMasterStocksController@stockOrder');
    Route::get('/admin/parts_item_master_stocks/stock_in_manual','AdminPartsItemMasterStocksController@stockInManual');
    Route::get('/admin/parts_item_master_stocks/dispose_stocks','AdminPartsItemMasterStocksController@disposeStocks');
    Route::post('/admin/parts_item_master_stocks/store-parts-manual','AdminPartsItemMasterStocksController@storePartsManual')->name('store-parts-manual');
    Route::post('/admin/parts_item_master_stocks/dispose-stocks','AdminPartsItemMasterStocksController@saveDisposeStocks')->name('dispose-stocks');
    Route::post('/admin/parts_item_master_stocks/stock-order','AdminPartsItemMasterStocksController@saveStockOrder')->name('stock-order');
    
    Route::post('/admin/stock_disposal_request/reject-disposal','AdminStockDisposalRequestController@rejectDisposalRequest')->name('reject-disposal');
    Route::post('/admin/stock_disposal_request/approve-disposal','AdminStockDisposalRequestController@approveDisposalRequest')->name('approve-disposal');


    // ITEM MASTER API
    // Route::get('/admin/apple_items_created', [AdminProductItemMasterController::class, 'getItemsCreatedAPI']);

    // Timeline
    Route::post('/admin/get_timeline', [AdminCustomDashboardController::class, 'getTimeline'])->name('get_timeline');

    Route::get('/admin/manager-dashboard', [AdminCustomDashboardController::class, 'managerDashboard'])->name('manager.dashboard');
    Route::post('/admin/manager-dashboard/employee-data', [AdminCustomDashboardController::class, 'managerDashboardPerEmployee'])->name('manager_dash_per_employee');
    Route::post('/admin/manager-dashboard/employee-data-tech', [AdminCustomDashboardController::class, 'managerDashboardPerEmployeeTech'])->name('manager_dash_per_employee_tech');

    Route::get('/admin/custodian-dashboard', [AdminCustomDashboardController::class, 'custodianDashboard'])->name('custodian.dashboard');

    Route::get('/admin/frontliner-dashboard', [AdminCustomDashboardController::class, 'index'])->name('frontliner.dashboard');
    Route::get('/admin/technician-dashboard', [AdminCustomDashboardController::class, 'technicianDashboard'])->name('technician.dashboard');
    Route::get('/admin/headtechnician-dashboard', [AdminCustomDashboardController::class, 'headTechnicianDashboard']);
    Route::post('/admin/filter_customers_units', [AdminCustomDashboardController::class, 'filterCustomerUnit'])->name('filter_customers_units');

    // Refund
    Route::get('/admin/callout/refund/{id}', 'AdminCallOutController@refund');
    Route::post('/admin/callout/update-refund', 'AdminCallOutController@updateRefund');

    // Manager uploaded invoices config
    Route::post('/admin/returns-header/config-invoices', 'AdminReturnsHeaderController@updateInvoicesConfigViewing')->name('invoices-config');

});

 