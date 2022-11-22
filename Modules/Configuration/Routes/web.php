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

use Modules\Configuration\Http\Controllers\ConfigurationsController;
use Modules\Configuration\Http\Controllers\MyAccountController;
use Modules\Configuration\Http\Controllers\SystemSettingsController;
use Modules\Configuration\Http\Controllers\UserSettingsController;
use Modules\Configuration\Http\Controllers\UserManualController;

Route::middleware(['tenant','auth'])->group(function() {

    Route::prefix('configurations')->group(function() {
        Route::get('/', [ConfigurationsController::class,'index'])->name('configurations.index');
        Route::resource('configurations', 'ConfigurationsController')->names([
            'create'=>'configurations.create',
            'edit'=>'configurations.edit',  
            'show'=>'configurations.show',
            'store'=>'configurations.store',
            'update'=>'configurations.update',
        ]);
        Route::prefix('school')->group(function() {
            Route::post('store',[ConfigurationsController::class,'schoolRegistrationStore'])->name('configurations.school.store');
            Route::post('edit',[ConfigurationsController::class,'schoolRegistrationEdit'])->name('configurations.school.edit');
            Route::post('districts',[ConfigurationsController::class,'districtsOptions'])->name('configurations.districts.option');
            Route::post('wards',[ConfigurationsController::class,'wardsOptions'])->name('configurations.wards.option');
            Route::post('villages',[ConfigurationsController::class,'villagesOptions'])->name('configurations.villages.option');
            Route::post('fee-structure/{id}',[ConfigurationsController::class,'saveFeeStructurePayments'])->name('configurations.school.fee.structure.store');
            Route::get('{id}/dashboard',[ConfigurationsController::class,'schoolDashboard'])->name('configurations.school.dashboard');
    
            /* SCHOOL PROFILE SETTINGS       */
    
            Route::get('settings-edit',[SystemSettingsController::class,'editSchoolSettings'])->name('school.settings.edit');
            
            Route::get('settings-modal-edit/{id}',[SystemSettingsController::class,'editModal'])->name('school.settings.modal.edit');
            Route::post('settings/{id}/store-season',[SystemSettingsController::class,'schoolAcademicYearStore'])->name('school.settings.seasons.store');
            Route::post('settings-update-season/{id}',[SystemSettingsController::class,'schoolAcademicYearUpdate'])->name('school.settings.seasons.update');
            Route::get('settings-profile',[SystemSettingsController::class,'academicYearProfile'])->name('school.settings.profile')->middleware('auth');
            // Route::get('settings-academic-year-edit/season/{season_id}', [SystemSettingsController::class,'academicYearEdit'])->name('school.settings.academic_year.edit');
            Route::get('settings-academic-year', [SystemSettingsController::class,'academicYear'])->name('school.settings.academic_year');
            Route::get('settings-academic-datatable/{id}', [SystemSettingsController::class,'datatable'])->name('school.settings.academic_year.datatable');
    
            Route::post('settings-school-store', [SystemSettingsController::class,'schoolRegistrationStore'])->name('school.settings.store');
            Route::get('settings-school-create', [SystemSettingsController::class,'create'])->name('school.settings.create');
            Route::get('settings-school-datatable', [SystemSettingsController::class,'schoolDatatable'])->name('school.settings.datatable');
            
    
    
    
            
    
            /* END */
    
    
            // Route::get('',[UserSettingsController::class,'index'])->name('configuration.myaccount');
            Route::get('users',[UserSettingsController::class,'index'])->name('configuration.users.index');
            Route::post('users-store',[UserSettingsController::class,'store'])->name('configuration.users.store');
            Route::post('users-myprofile-update',[UserSettingsController::class,'myProfileUpdate'])->name('configuration.users.my_profile.update');
            Route::get('users/datatable',[UserSettingsController::class,'datatable'])->name('configuration.users.datatable');
            Route::get('users/create/{id?}',[UserSettingsController::class,'create'])->name('configuration.users.create');
            Route::delete('user/{id}/destroy',[UserSettingsController::class,'delete'])->name('configuration.users.delete');
            Route::get('user-profile/{id}',[UserSettingsController::class,'profile'])->name('configuration.users.profile');
    
            Route::get('my_account',[MyAccountController::class,'index'])->name('configuration.users.myaccount');
            Route::get('my_account/password-reset',[MyAccountController::class,'passwordResetIndex'])->name('configuration.users.myaccount.password.reset.index');
            Route::put('my_account/password-update',[MyAccountController::class,'updatePassword'])->name('configuration.users.password.update');
    
            
            /* TODAYYY */
            
            Route::post('{id}/store-season',[ConfigurationsController::class,'schoolAcademicYearStore'])->name('configurations.school.seasons.store');
            Route::get('profile/{id}/{db}',[ConfigurationsController::class,'schoolProfile'])->name('configurations.school.profile')->middleware('auth');
            Route::get('school-profile-students-list/{id}/{db}',[ConfigurationsController::class,'schoolProfileStudentsList'])->name('configurations.school.profile.students.list')->middleware('auth');
            Route::get('school-profile-students-list-datatable/{id}/{db}',[ConfigurationsController::class,'schoolProfileStudentsListDatatable'])->name('configurations.school.profile.students.list');
            // Route::get('profile1/{id}',[ConfigurationsController::class,'schoolProfile1'])->name('configurations.school.profile1');
            Route::get('datatable',[ConfigurationsController::class,'schoolDatatable'])->name('configurations.school.datatable');

            Route::get('/school-class-groups-datatable/{id}',[ConfigurationsController::class,'classesDatatable'])->name('configurations.classes.datatable');

            /* BIZYTECHS VIEW */
            Route::get('/bizy-school-class-groups-datatable/{id}/{db}',[ConfigurationsController::class,'classesBizyDatatable'])->name('configurations.bizy.classes.datatable');
          
    
            // Route::get('dashboard',[ConfigurationsController::class,'dashboard'])->name('configurations.school.dashboard');
            Route::get('academic-year/{id}', [ConfigurationsController::class,'academicYear'])->name('configurations.school.academic_year');
            Route::get('academic-year-edit/{id}/season/{season_id}', [ConfigurationsController::class,'academicYearEdit'])->name('configurations.school.academic_year.edit');
            Route::get('profile/academic_year_datatable/datatable/{id}', [ConfigurationsController::class,'academicYearDatatable'])->name('configurations.classes.academic_year.datatable');


        });
       
        


        /* SENSA          ACADEMIC ( CLASSES, STREAMS AND ACADEMIC YEAR ) */

        Route::get('classes', [SystemSettingsController::class,'classes'])->name('configurations.school.classes');
        Route::get('classes/create', [SystemSettingsController::class,'createClass'])->name('configurations.school.classes.new');
        Route::post('classes/store', [SystemSettingsController::class,'storeClass'])->name('configurations.school.classes.store');
        Route::get('classes/ediṭ/{id}', [SystemSettingsController::class,'editClass'])->name('configurations.school.classes.edit');
        Route::get('classes/datatable', [SystemSettingsController::class,'classDatatable'])->name('configurations.school.classes.datatable');
        Route::delete('class-delete/{id}', [SystemSettingsController::class,'classDelete'])->name('configurations.school.class.delete');


        Route::get('academic-year', [SystemSettingsController::class,'academicYearIndex'])->name('configurations.school.academic.year.index');
        Route::get('academic-year-datatable', [SystemSettingsController::class,'academicYearDatatable'])->name('configurations.school.academic.year.datatable');
        Route::get('academic-year-create', [SystemSettingsController::class,'academicYearCreate'])->name('configurations.school.academic.year.create');
        Route::get('academic-year-edit/{id}', [SystemSettingsController::class,'academicYearEdit'])->name('configurations.school.academic.year.edit');
        Route::post('academic-year-store', [SystemSettingsController::class,'academicYearStore'])->name('configurations.school.academic.year.store');
        Route::delete('academic-year-delete/{id}', [SystemSettingsController::class,'academicYearDelete'])->name('configurations.school.academic.year.delete');

        /* SEMESTERS */
        Route::get('academic-year/{id}/semesters', [SystemSettingsController::class,'semesterIndex'])->name('configurations.school.academic.year.semester.index');
        Route::get('academic-year/{id}/semester-create/{s_id?}', [SystemSettingsController::class,'semesterCreate'])->name('configurations.school.academic.year.semester.create');
        Route::post('academic-year/{id}/semester-store', [SystemSettingsController::class,'semesterStore'])->name('configurations.school.academic.year.semester.store');
        Route::get('academic-year-datatable/{id}/semesters', [SystemSettingsController::class,'semesterDatatable'])->name('configurations.school.academic.year.semester.datatable');
        Route::delete('academic-year/{id}/semester-delete/{s_id}', [SystemSettingsController::class,'semesterDelete'])->name('configurations.school.academic.year.semester.delete');
        /* END SEMESTERS */

        Route::get('streams', [SystemSettingsController::class,'streams'])->name('configurations.school.streams');
        Route::get('classes/{id}/streams', [SystemSettingsController::class,'streamsPerClass'])->name('configurations.school.classes.streams');
        Route::get('class-streams/{id}/datatable', [SystemSettingsController::class,'classStreamDatatable'])->name('configurations.school.class.streams.datatable');
        Route::get('class-streams-edit/{class_id}/{stream_id}', [SystemSettingsController::class,'classStreamEdit'])->name('configurations.school.class.streams.edit');
        Route::get('class-streams-create/{id}', [SystemSettingsController::class,'classStreamCreate'])->name('configurations.school.class.streams.new');
        Route::get('streams/create', [SystemSettingsController::class,'createStream'])->name('configurations.school.streams.new');
        Route::get('streams/ediṭ/{id}', [SystemSettingsController::class,'editStream'])->name('configurations.school.streams.edit');
        Route::post('streams/store', [SystemSettingsController::class,'storeStream'])->name('configurations.school.streams.store');
        Route::get('streams/datatable', [SystemSettingsController::class,'StreamDatatable'])->name('configurations.school.streams.datatable');
        Route::post('student-class', [SystemSettingsController::class,'studentClass'])->name('configurations.school.student.class');
        Route::delete('stream-delete/{id}', [SystemSettingsController::class,'streamDelete'])->name('configurations.school.stream.delete');

    
            /* END */
        Route::prefix('classes')->group(function() {
            Route::get('s-profile/{id}', [ConfigurationsController::class,'classProfile'])->name('configurations.school.classes.profile');
            Route::get('profile/datatable/{id}', [ConfigurationsController::class,'classProfileDatatable'])->name('configurations.school.classes.profile.datatable');
           
            Route::get('profile/academic-year/{id}', [ConfigurationsController::class,'academicYearProfile'])->name('configurations.school.academic_year.profile');
            Route::get('profile/students/{id}', [ConfigurationsController::class,'classProfileStudents'])->name('configurations.school.classes.profile.students');
            Route::get('profile/students/datatable/{id}', [ConfigurationsController::class,'classProfileStudentsDatatable'])->name('configurations.school.classes.profile.students.datatable');
        });
     
        Route::get('profile/{school_id}/fee_structure', [ConfigurationsController::class,'feeStructure'])->name('configurations.school.fee_structure');
        Route::delete('profile/{school_id}/fee_structure/{fee_structure_id}/delete', [ConfigurationsController::class,'feeStructureDelete'])->name('configurations.school.fee_structure.delete');
        Route::get('profile/{school_id}/fee_structure/{structure_id}', [ConfigurationsController::class,'feeStructureEdit'])->name('configurations.school.fee_structure.edit');
        Route::get('profile/fee_structure', [ConfigurationsController::class,'feeStructureProfile'])->name('configurations.school.fee_structure.profile');
        Route::get('profile/fee_structure/datatable/{id}', [ConfigurationsController::class,'feeStructureProfileDatatable'])->name('configurations.school.fee_structure.datatable');
       
    
        Route::get('/school-banks',[ConfigurationsController::class,'banks'])->name('configurations.banks');
        Route::get('/school-banks-datatable',[ConfigurationsController::class,'banksDatatable'])->name('configurations.banks.datatable');
        Route::post('/banks-save',[ConfigurationsController::class,'saveBankDetails'])->name('configurations.banks.store');
        Route::delete('/banks-delete/{id}',[ConfigurationsController::class,'destroyBank'])->name('configurations.banks.destroy');
        Route::get('/banks-edit/{id}',[ConfigurationsController::class,'editBank'])->name('configurations.banks.edit');
        Route::put('/banks-update',[ConfigurationsController::class,'updateBank'])->name('configurations.banks.update');
    

        /* CONTACT PEOPLE */

        Route::get('{id}/student-contact-people',[ConfigurationsController::class,'contactPeopleDatatable'])->name('configurations.contact.people');
        Route::post('edit-contact-people/{id}',[ConfigurationsController::class,'contactPersonEdit'])->name('configurations.contact.people.edit');
       
        
        /* USER MANUAL */
        Route::get('user-manual', [UserManualController::class,'index'])->name('configurations.users.manual');
    
    });
    


});

    