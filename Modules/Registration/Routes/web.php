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

use Modules\Registration\Http\Controllers\GraduateStudentsMakeController;
use Modules\Registration\Http\Controllers\StudentPromotionsController;
use Modules\Registration\Http\Controllers\StudentsProfileController;
use Modules\Registration\Http\Controllers\StudentsRegistrationController;

Route::middleware(['tenant','auth'])->group(function() {

Route::prefix('students')->group(function() {
    Route::get('', [StudentsRegistrationController::class,'index'])->name('students.registration');
    Route::post('store', [StudentsRegistrationController::class,'studentsStore'])->name('students.store');
    Route::get('datatable', [StudentsRegistrationController::class,'studentsDatatable'])->name('students.datatable');
    Route::get('{id}/profile', [StudentsProfileController::class,'studentProfile'])->name('students.profile');
    Route::get('registration/excel', [StudentsRegistrationController::class,'studentsExcelTemplateExport'])->name('students.registration.excel');
    Route::post('registration/edit', [StudentsRegistrationController::class,'editStudent'])->name('students.registration.edit');
    Route::post('students-import', [StudentsRegistrationController::class,'importStudents'])->name('students.excel.import');
    Route::delete('registration-delete/{id}', [StudentsRegistrationController::class,'deleteStudent'])->name('students.registration.delete');

    /* class filters to streams */

    Route::get('to_class/edit', [StudentPromotionsController::class,'fromClassFilter'])->name('students.to_class.filter');
    Route::get('from_class/edit', [StudentPromotionsController::class,'toClassFilter'])->name('students.from_class.filter');

    /* Graduates */
    // Route::get('promotion/{fc?}/{fstr?}/{tc?}/{ts?}', [StudentPromotionsController::class,'promotion'])->name('students.promotion');
    // Route::post('student-promotion-list', [StudentPromotionsController::class,'getPromotionList'])->name('students.promotions.list');
    // Route::post('promote/{fc}/{fs}/{tc}/{ts}', [StudentPromotionsController::class,'promote'])->name('students.promote');

   
    Route::post('student-graduands-list', [GraduateStudentsMakeController::class,'getGraduandsList'])->name('students.graduands.list');
    Route::get('graduands-fetch/{fc?}/{fs?}', [GraduateStudentsMakeController::class,'index'])->name('students.graduate.index');
    Route::post('students-graduate/{fc}/{fs}', [GraduateStudentsMakeController::class,'graduate'])->name('students.graduants.graduate');


    /* THE OTHER PART */
    Route::get('graduates-list', [StudentsRegistrationController::class,'graduatedStudentsIndex'])->name('students.graduates');
    Route::get('graduates-list-datatable', [StudentsRegistrationController::class,'graduatedStudentsDatatable'])->name('students.graduates.datatable');


    Route::post('profile-pic-update/{id}', [StudentsRegistrationController::class,'profilePicUpdate'])->name('students.profile.pic.update');
    Route::post('attachments-store/{id}', [StudentsRegistrationController::class,'storeAttachments'])->name('students.attachments.store');
    Route::post('attachments-delete/{id}', [StudentsRegistrationController::class,'deleteAttachments'])->name('students.attachments.delete');
    Route::get('attachments-datatable/{id}', [StudentsRegistrationController::class,'attachmentsDatatable'])->name('students.attachments.datatable');

    

    Route::get('promotion/{fc?}/{tc?}/{fstr?}/{ts?}', [StudentPromotionsController::class,'promotion'])->name('students.promotion');
    Route::post('student-promotion-list', [StudentPromotionsController::class,'getPromotionList'])->name('students.promotions.list');
    Route::post('promote/{fc}/{tc}/{fs?}/{ts?}', [StudentPromotionsController::class,'promote'])->name('students.promote');

    Route::get('promotions/manage', [StudentPromotionsController::class,'manage'])->name('students.manage.promotion');
    Route::delete('promotion/reset/{pid}', [StudentPromotionsController::class,'reset'])->name('students.promotion_reset');
    Route::post('promotion/reset_all', [StudentPromotionsController::class,'reset_all'])->name('students.promotion_reset_all');


    /* printouts */

    Route::get('students-printouts',[StudentsRegistrationController::class,'printing'])->name('students.printouts');
    

    /* students profile */
    Route::delete('students-contact-people-delete/{id}',[StudentsProfileController::class,'contactPeopleDestroy'])->name('student.profile.contact.people.destroy');
    Route::get('students-contact-people/{id}',[StudentsProfileController::class,'contactPeople'])->name('student.profile.contact.people');
    Route::post('students-contact-people-save',[StudentsProfileController::class,'contactPeopleStore'])->name('student.profile.contact.people.store');
    Route::post('students-contact-people-edit/{id}',[StudentsProfileController::class,'editContactPeople'])->name('student.profile.contact.people.edit');
    Route::get('student-attachments/{id}',[StudentsProfileController::class,'studentAttachment'])->name('student.profile.view.attachments');
    Route::get('student-invoices-list/{id}',[StudentsProfileController::class,'studentInvoiceList'])->name('student.profile.view.invoices');
    Route::post('student-update-status',[StudentsProfileController::class,'studentUpdateStatus'])->name('student.update.status');

    
});


});
