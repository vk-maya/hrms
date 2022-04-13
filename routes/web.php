<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDerpartmentController;
use App\Http\Controllers\Admin\EmployeesController;

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
require __DIR__.'/auth.php';
require __DIR__.'/admin_auth.php';
Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/admin','admin/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['admin'])->name('admin.dashboard');

Route::prefix('admin/')->name('admin.')->group(function() {
    // ------------------------------AdminDepartmentsController Routs-------------------
    Route::get('departments',[AdminDerpartmentController::class,'departmentscreate'])->name('departments');
    Route::post('departments',[AdminDerpartmentController::class,'departmentsstore'])->name('departments');
    Route::get('designation',[AdminDerpartmentController::class,'designationcreate'])->name('designation');
    Route::post('designation',[AdminDerpartmentController::class,'designationstore'])->name('designation');
    
    // ---------------------EmployeesController Route-------------------------------------
        Route::get('employees',[EmployeesController::class,'employeecreate'])->name('employees');
        Route::get('add-employees',[EmployeesController::class,'addemployeescreate'])->name('addemployees');
        Route::post('emailv',[EmployeesController::class,'emailv'])->name('emailv');
        Route::post('epid',[EmployeesController::class,'epid'])->name('epid');
        Route::post('save-employees',[EmployeesController::class,'addemployeesstore'])->name('storeemployees');
});