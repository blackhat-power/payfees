<?php

use App\Http\Controllers\ArtisanCommandsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('tenant')->group(function() {
    Route::get('/', [DashboardController::class,'index'])->middleware(['auth'])->name('dashboard');
    Route::get('students-dashboard',[DashboardController::class,'studentDashboard'])->middleware(['auth'])->name('students.dashboard');
    Route::get('students-ratio', [DashboardController::class,'getStudentsData'])->middleware(['auth'])->name('students.report.total.ratio');
    Route::get('students-accounts-ratio', [DashboardController::class,'getStudentsAccountData'])->middleware(['auth'])->name('students.report.account.total.ratio');
    
});

Route::get('artisan-run', [ArtisanCommandsController::class,'run'])->middleware(['auth'])->name('artisan');
Route::get('clear-view', [ArtisanCommandsController::class,'clearView'])->middleware(['auth'])->name('view.clear');
Route::get('clear-cache', [ArtisanCommandsController::class,'clearCache'])->middleware(['auth'])->name('view.clear.cache');
Route::get('model-create/{modelName}', [ArtisanCommandsController::class,'createModel'])->middleware(['auth'])->name('artisan.model.create');

Route::get('controller-create/{controller}/{module?}', [ArtisanCommandsController::class,'createController'])->middleware(['auth'])->name('artisan.controller.create');




// php artisan make:model ChartOfAccountGroup -m


/* Route::get('/dashboard', function () {
    return view('dashboard');
}) */

require __DIR__.'/auth.php';
