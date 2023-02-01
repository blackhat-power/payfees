<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Accounts\Http\Controllers\AccountsController;
use Modules\Accounts\Http\Controllers\PaymentsController;
use Modules\Accounts\Http\Controllers\PaymentSettingsController;
use Modules\Accounts\Http\Controllers\PaymentsReviewController;
use Modules\Accounts\Http\Controllers\ReportsController;
use Modules\Accounts\Http\Controllers\StudentAccountingController;

Route::middleware(['tenant','auth'])->group(function() {
    // routes
    Route::prefix('accounts')->group(function() {
        Route::get('/invoices/datatable', [AccountsController::class, 'invoiceDatatable'])->name('accounts.invoices.datatable');
        Route::get('', [AccountsController::class, 'index'])->name('accounts.invoice');
        Route::get('/invoices-list-pdf', [AccountsController::class, 'printing'])->name('accounts.invoices.printouts');
        Route::post('/invoices-store', [AccountsController::class, 'storeInvoice'])->name('accounts.invoices.store');
        Route::post('/invoices-filter-fee', [AccountsController::class, 'filterFeeStructure'])->name('accounts.invoices.filter.fee_structure');
        Route::get('/invoices-new/{c_id?}/{acc_id?}/{std_id?}/{season_id?}', [AccountsController::class, 'create'])->name('accounts.invoices.create');
        Route::get('/specific-invoice-new/{c_id?}/{acc_id?}/{std_id?}', [AccountsController::class, 'specificStudentInvoiceCreate'])->name('accounts.invoices.student.create');
        // Route::get('/invoices-new/{c_id?}/{s_id?}/{acc_id?}/{std_id?}', [AccountsController::class, 'create'])->name('accounts.invoices.create');
        Route::post('/invoices-student-class-filter', [AccountsController::class, 'filterStudentByClass'])->name('accounts.invoices.class.students.filter');
    
    
    
        
        Route::get('generate-pdf/{id}', [AccountsController::class, 'generateInvoicePdf'])->name('accounts.invoices.pdf');
        Route::get('receipts', [AccountsController::class, 'receiptsIndex'])->name('accounts.receipts');
        Route::post('/receipts/datatable/{id}', [AccountsController::class, 'receiptsTable'])->name('accounts.receipts.table');
        Route::get('/receipts/create', [AccountsController::class, 'receiptsCreate'])->name('accounts.receipts.create');
        Route::post('/receipts/invoice-filter', [AccountsController::class, 'studentsInvoiceFilter'])->name('accounts.receipts.invoices.filter');
        Route::post('/receipts/selected-bill-filter', [AccountsController::class, 'selectedBillFilter'])->name('accounts.receipts.selected.filter');
        Route::post('/receipts/store', [AccountsController::class, 'receiptsSave'])->name('accounts.receipts.store');
        Route::post('/receipts-store/print', [AccountsController::class, 'receiptsSavePrint'])->name('accounts.receipts.store.print');
        Route::get('/debtors-list', [AccountsController::class, 'debtorsList'])->name('accounts.debtors.list');
        Route::get('/debtors-list-datatable', [AccountsController::class, 'debtorsListDatatable'])->name('accounts.debtors.list.datatable');
        Route::get('/individual-debtors-list-datatable/{id}', [AccountsController::class, 'individualDebtorsListDatatable'])->name('accounts.individual.debtors.list.datatable');
        Route::get('/individual-debtors-list/{id}', [AccountsController::class, 'individualDebtorsList'])->name('accounts.individual.debtors.list');
        Route::get('debtors-list-pdf', [AccountsController::class, 'generateDebtorsListPdf'])->name('accounts.debtors.list.pdf');
        Route::get('/individual-debtors-list-pdf/{id}', [AccountsController::class, 'generateIndividualDebtorsListPdf'])->name('accounts.debtors.individual.list.pdf');
        Route::get('/receipts-pdf/{id}', [AccountsController::class, 'generateReceiptsPdf'])->name('accounts.receipts.pdf');
        Route::get('/receipt-current-pdf/{id}/{receipt_id}', [AccountsController::class, 'generateOneReceiptPdf'])->name('accounts.receipt.pdf');
        Route::get('/individual-debtor-pdf/{id}', [AccountsController::class, 'generateIndividualDebtorPdf'])->name('accounts.debtors.individual.pdf');
        Route::get('/invoices/individual/datatable/{id}', [AccountsController::class, 'individualInvoiceDatatable'])->name('accounts.invoices.individual.datatable');

        Route::get('/invoices/individual-invoice/{id}', [AccountsController::class, 'individualInvoiceView'])->name('accounts.invoices.individual.view');
    
        Route::get('/payments', [PaymentsController::class, 'index'])->name('accounts.students.payments');
        Route::get('/payments-datatable', [PaymentsController::class, 'studentPaymentsDatatable'])->name('accounts.students.payments.datatable');
        Route::get('/individual-student-payments/{id}', [PaymentsController::class, 'individualStudentPaymentsList'])->name('accounts.students.individual.payments');
        Route::get('/individual-student-payments-datatable/{id}', [PaymentsController::class, 'individualDebtorsListDatatable'])->name('accounts.payments.individual.datatable');
        // Route::get('/individual-incomplete-student-payments', [PaymentsController::class, 'individualIncompleteStudentPaymentsDatatable'])->name('accounts.students.individual.payments');
        
        /* Payments Review */

        Route::get('payments-review', [PaymentsReviewController::class, 'index'])->name('accounts.student.payments.review.index');
        Route::get('payments-review-datatable', [PaymentsReviewController::class, 'datatable'])->name('accounts.student.payments.review.datatable');
        Route::post('payments-review-update-status/{id}', [PaymentsReviewController::class, 'paymentApproval'])->name('accounts.student.payments.review.update');
        Route::get('payments-review/printing', [PaymentsReviewController::class,'printing'])->name('accounts.student.payments.review.printing'); 


        /* Payments */
    
        Route::get('manage/{class_id?}', [PaymentsController::class, 'manage'])->name('accounts.students.payments.manage');
        Route::get('invoice/{id}/{year?}', [PaymentsController::class, 'invoice'])->name('accounts.students.payments.invoice');
        Route::get('receipts/{id}', [PaymentsController::class, 'receipts'])->name('accounts.students.payments.receipts');
        Route::get('payments/create/{invoice_id}/{balance}/{student}', [PaymentsController::class, 'create'])->name('accounts.students.payments.create');
        Route::post('payments/store', [PaymentsController::class, 'store'])->name('accounts.students.payments.store');
    
    /* fee structure Settings */
    
        Route::post('fee-structure-store',[PaymentSettingsController::class,'store'])->name('accounts.school.fee.structure.store');
        Route::get('profile/fee_structure', [PaymentSettingsController::class,'feeStructure'])->name('accounts.fee_structure.settings');
        Route::delete('profile/fee_structure-delete/{fee_structure_id}/delete', [PaymentSettingsController::class,'feeStructureDelete'])->name('accounts.school.fee_structure.delete');
        Route::get('profile/fee_structure-edit/{structure_id}', [PaymentSettingsController::class,'edit'])->name('accounts.school.fee_structure.edit');
        Route::get('fee_structure', [PaymentSettingsController::class,'create'])->name('accounts.school.fee_structure.create');
        Route::get('fee-structure/datatable', [PaymentSettingsController::class,'datatable'])->name('accounts.fee_structure.datatable');  
        Route::get('fee-structure-class/{id}', [PaymentSettingsController::class,'individualClassFeeStructure'])->name('accounts.school.fee_structure.class'); 
        
        Route::get('individual-class-fee-structure/datatable/{id}', [PaymentSettingsController::class,'individualClassGroupFeeStructureDatatable'])->name('accounts.fee_structure.group.datatable');
        
        Route::post('fee-structure-group-filter', [PaymentSettingsController::class,'feeStructureGroupFilter'])->name('school.fee.structure.group.filter'); 
        
        
       /* CHARTS OF ACCOUNTS */
       Route::get('charts-of-accounts', [ReportsController::class,'chartsOfAccountsIndex'])->name('charts.of.accounts');
       Route::get('charts-of-accounts/new-account-form/{id?}', [ReportsController::class,'chartsOfAccountForm'])->name('charts.of.accounts.new.form');
       Route::get('charts-of-accounts/datatable', [ReportsController::class,'chartsOfAccountDatatable'])->name('charts.of.accounts.datatable');
       Route::post('charts-of-accounts/store', [ReportsController::class,'chartsOfAccountStore'])->name('charts.of.accounts.store');
       Route::delete('charts-of-accounts/delete/{id}', [ReportsController::class,'deleteChartOfAccount'])->name('charts.of.accounts.delete'); 
       Route::get('charts-of-accounts/printing', [ReportsController::class,'chartsOfAccountprinting'])->name('charts.of.accounts.printing'); 
       
       /* fee type groups */
       
       Route::get('fee-type-groups/datatable', [AccountsController::class,'fee_type_group_datatable'])->name('fee_type_groups.datatable');  
       Route::post('fee-type-groups/store', [AccountsController::class,'fee_type_group_store'])->name('fee_type_groups.store');

       Route::get('fee-type-groups/load', [AccountsController::class,'loadGroupTypes'])->name('fee_type_groups.load');
        
       Route::get('accounts-sub-groups/index', [AccountsController::class,'accountSubGroupIndex'])->name('accounts.sub.groups.index');
       Route::get('accounts-sub-groups/new', [AccountsController::class,'accountSubGroupForm'])->name('accounts.sub.groups.form');
       Route::get('accounts-sub-groups/datatable', [AccountsController::class,'accountSubGroupDatatable'])->name('accounts.sub.groups.datatable');
       Route::post('accounts-sub-groups/store', [AccountsController::class,'accountSubGroupStore'])->name('accounts.sub.groups.store');
       Route::get('accounts-sub-groups/print', [AccountsController::class, 'subAccountGroupPrinting'])->name('accounts.sub.groups.printouts');
       
       Route::get('accounts-ledgers-list/index', [AccountsController::class,'accountLedgerIndex'])->name('accounts.ledgers.index');
       Route::post('accounts-ledgers-list/store', [AccountsController::class,'accountLedgerStore'])->name('accounts.ledgers.store');
       Route::get('accounts-ledgers-list/datatable', [AccountsController::class,'accountLedgerDatatable'])->name('accounts.ledgers.datatable');
       Route::get('accounts-ledgers-list/form', [AccountsController::class,'accountLedgerForm'])->name('accounts.ledgers.form');
       Route::get('accounts-ledgers-list/print', [AccountsController::class, 'ledgerprinting'])->name('accounts.ledgers.printouts');



       /* FEE REMINDER SETTINGS */
       
       Route::get('fee-reminder-index', [AccountsController::class,'feeReminderIndex'])->name('accounts.fee_reminder.settings');  
       Route::post('fee-reminder-store', [AccountsController::class,'feeReminderStore'])->name('accounts.fee_reminder.store');
       Route::get('fee-reminder-datatable', [AccountsController::class,'feeReminderDatatable'])->name('accounts.fee_reminder.datatable');
       Route::get('fee-reminder-create', [AccountsController::class,'feeReminderCreate'])->name('accounts.fee_reminder.create');





       /* COLLECTION */

       Route::get('collection/index', [AccountsController::class, 'collectionIndex'])->name('accounts.collection.index');
       Route::get('collection/datatable', [AccountsController::class, 'collectionDatatable'])->name('accounts.collection.datatable');
       Route::get('collection/print', [AccountsController::class, 'collectionPrint'])->name('accounts.collection.print');


       /* Transactions */

       Route::get('payment-voucher/index', [AccountsController::class,'paymentVoucherIndex'])->name('accounts.payment.voucher.index');
       Route::get('journal-voucher/index', [AccountsController::class,'journalVoucherIndex'])->name('accounts.journal.voucher.index');
       Route::get('receipt-voucher/index', [AccountsController::class,'receiptVoucherIndex'])->name('accounts.receipts.voucher.index');
       Route::get('contra-voucher/index', [AccountsController::class,'contraVoucherIndex'])->name('accounts.contra.voucher.index');


       Route::get('payment-voucher/form', [AccountsController::class,'paymentVoucherForm'])->name('accounts.payment.voucher.form');
       Route::get('journal-voucher/form', [AccountsController::class,'journalVoucherForm'])->name('accounts.journal.voucher.form');
       Route::get('receipt-voucher/form', [AccountsController::class,'receiptVoucherForm'])->name('accounts.receipts.voucher.form');
       Route::get('contra-voucher/form', [AccountsController::class,'contraVoucherForm'])->name('accounts.contra.voucher.form');


       Route::get('payment-voucher/datatable', [AccountsController::class,'paymentVoucherDatatable'])->name('accounts.payment.voucher.datatable');
       Route::get('journal-voucher/datatable', [AccountsController::class,'journalVoucherDatatable'])->name('accounts.journal.voucher.datatable');
       Route::get('receipt-voucher/datatable', [AccountsController::class,'receiptVoucherDatatable'])->name('accounts.receipts.voucher.datatable');
       Route::get('contra-voucher/datatable', [AccountsController::class,'contraVoucherDatatable'])->name('accounts.contra.voucher.datatable');


       Route::post('payment-voucher/store', [AccountsController::class,'paymentVoucherStore'])->name('accounts.payment.voucher.store');
       Route::post('journal-voucher/store', [AccountsController::class,'journalVoucherStore'])->name('accounts.journal.voucher.store');
       Route::post('receipt-voucher/store', [AccountsController::class,'receiptVoucherStore'])->name('accounts.receipts.voucher.store');
       Route::post('contra-voucher/store', [AccountsController::class,'contraVoucherStore'])->name('accounts.contra.voucher.store');

       Route::get('journal-voucher/preview/{id}', [AccountsController::class,'journalVoucherPreview'])->name('accounts.journal.voucher.preview');
       Route::get('payment-voucher/preview/{id}', [AccountsController::class,'paymentVoucherPreview'])->name('accounts.payment.voucher.preview');
       Route::get('contra-voucher/preview/{id}', [AccountsController::class,'contraVoucherPreview'])->name('accounts.contra.voucher.preview');


        /* student invoice */

        Route::get('student-create-invoice', [StudentAccountingController::class,'index'])->name('accounts.student.invoice.create');



        /* NEW FEE STRUCTURE JAN 2023 */

        Route::get('fee-structure-master',[PaymentSettingsController::class,'feeMaster'])->name('accounts.school.fee.structure.master');
        Route::get('fee-structure-master/particulars',[PaymentSettingsController::class,'feeMasterParticulars'])->name('accounts.school.fee.structure.master.particulars');
        Route::get('fee-structure-master/particulars/datatable',[PaymentSettingsController::class,'feeMasterParticularsDatatable'])->name('accounts.school.fee.structure.master.particulars.datatable');


        Route::post('fee-structure-master/particulars-store',[PaymentSettingsController::class,'feeParticularStore'])->name('accounts.school.fee.structure.master.particulars.store');
        Route::get('fee-structure-master/fee/categories',[PaymentSettingsController::class,'feeMasterCategories'])->name('accounts.school.fee.structure.master.categories.index');

        Route::post('fee-structure-master/fee/categories-store',[PaymentSettingsController::class,'feeMasterCategoryStore'])->name('accounts.school.fee.structure.master.categories.store');

        Route::post('fee-structure-master/fee-category/particular-store',[PaymentSettingsController::class,'feeCategoryParticularStore'])->name('accounts.school.fee.structure.patcl.store');
        Route::get('fee-structure-master/fee-category/particular-index',[PaymentSettingsController::class,'feeCategoryParticularIndex'])->name('accounts.school.fee.structure.patcl.index');

        Route::post('fee-structure-master/fee-category/particular-category',[PaymentSettingsController::class,'feeCategoryParticularCategory'])->name('accounts.school.fee.structure.patcl.category');

        Route::post('fee-structure-master/fee-category/particular-category-store',[PaymentSettingsController::class,'feeCategoryParticularCategoryStore'])->name('accounts.school.fee.structure.patcl.category.store');


        

        /* new fee view structure  */

        
        Route::get('fee-structure/new-master/index',[PaymentSettingsController::class,'newFeeStructureIndex'])->name('accounts.school.new.fee.structure');
        Route::get('fee-structure/new-master/datatable',[PaymentSettingsController::class,'newFeeStructureDatatable'])->name('accounts.school.new.fee.structure.datatable');
        Route::get('fee-structure-master/new-master/preview',[PaymentSettingsController::class,'newFeeStructureIndex'])->name('accounts.school.new.fee.structure');


        /* GET CATEGORY CLASSES */
        Route::post('fee-structure-master/new-master/category-classes',[PaymentSettingsController::class,'newFeeStructureCategoryClasses'])->name('accounts.school.new.fee.structure.category.classes');

        /* GET PAYMENT PARTICULARS */
        Route::post('fee-structure-master/new-master/fee-items',[PaymentSettingsController::class,'newFeeStructureStudentFeeItems'])->name('accounts.school.new.fee.structure.student.fee.items');
    });
    
});
