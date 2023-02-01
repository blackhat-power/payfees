<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\Configuration\Entities\BankDetail;
use Modules\Configuration\Entities\Category;
use Modules\Configuration\Entities\Semester;
use Modules\Location\Entities\District;
use Modules\Location\Entities\Village;

    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create']);
        // ;

        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');

        Route::get('school-new-account',function(){
                $data['districts'] = DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.districts');
                $data['banks']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.bank_details');
                $data['villages']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.villages');
                $data['categories'] = DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.categories');
                $data['currencies']= DB::select('select * from '.env('LANDLORD_DB_DATABASE').'.currencies');
                return view('auth.school_account_registration')->with($data);
            })->name('payfeetz.create.account');  

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
    });

    Route::middleware('auth')->group(function () {
        Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
    });

