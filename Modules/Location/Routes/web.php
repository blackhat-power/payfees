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

use Modules\Location\Http\Controllers\DistrictsController;
use Modules\Location\Http\Controllers\RegionsController;
use Modules\Location\Http\Controllers\VillagesController;
use Modules\Location\Http\Controllers\WardsController;
use Modules\Location\Http\Controllers\ZonesController;

Route::group(['prefix'=>'location', 'middleware'=>'auth'],  function() {
    Route::get('/', 'LocationController@index');

    Route::get('/zones',[ZonesController::class,'index' ])->name('location.zones');
    Route::get('/zones-datatable',[ZonesController::class,'zonesDatatable' ])->name('location.zones.datatable');
    Route::post('/zones-store',[ZonesController::class,'zoneStore' ])->name('location.zones.store');
     Route::post('/zones-edit/{id}',[ZonesController::class,'edit' ])->name('location.zones.edit');
     Route::delete('/zones-delete/{id}',[ZonesController::class,'destroyZone' ])->name('location.zones.destroy');
    

     Route::get('/regions',[RegionsController::class,'index' ])->name('location.regions');
     Route::post('/regions-store',[RegionsController::class,'regionStore' ])->name('location.regions.store');
     Route::delete('/regions-delete/{id}',[RegionsController::class,'destroyRegion' ])->name('location.regions.destroy');
     Route::get('/regions-datatable',[RegionsController::class,'regionsDatatable' ])->name('location.regions.datatable');
    //  Route::get('/regions-datatable',[RegionsController::class,'regionsDatatable' ])->name('location.regions.datatable');
     Route::post('/regions-edit/{id}',[RegionsController::class,'edit' ])->name('location.regions.edit');
     


     Route::get('/districts',[DistrictsController::class,'index' ])->name('location.districts');
     Route::post('/districts-store',[DistrictsController::class,'districtStore' ])->name('location.districts.store');
     Route::delete('/districts-delete/{id}',[DistrictsController::class,'destroyDistrict' ])->name('location.districts.destroy');
     Route::get('/districts-datatable',[DistrictsController::class,'districtsDatatable' ])->name('location.districts.datatable');
    //  Route::get('/districts-datatable',[DistrictsController::class,'districtsDatatable' ])->name('location.districts.datatable');
     Route::post('/districts-edit/{id}',[DistrictsController::class,'edit' ])->name('location.districts.edit');


     Route::get('/wards',[WardsController::class,'index' ])->name('location.wards');
     Route::post('/wards-store',[WardsController::class,'wardStore' ])->name('location.wards.store');
     Route::delete('/wards-delete/{id}',[WardsController::class,'destroyWard' ])->name('location.wards.destroy');
     Route::get('/wards-datatable',[WardsController::class,'wardsDatatable' ])->name('location.wards.datatable');
     Route::post('/wards-edit/{id}',[WardsController::class,'edit' ])->name('location.wards.edit');

     Route::get('/villages',[VillagesController::class,'index' ])->name('location.villages');
});
