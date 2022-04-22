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
            // ---------------departments--------------------
    Route::get('departments',[AdminDerpartmentController::class,'departmentscreate'])->name('departments');
    Route::post('departments',[AdminDerpartmentController::class,'departmentsstore'])->name('departments');
    Route::post('departments/status',[AdminDerpartmentController::class,'departmentsstatus'])->name('departments.status');
    Route::get('departments/edit/{id}',[AdminDerpartmentController::class,'departmentscreate'])->name('departments.edit');
    Route::get('departments/delete/{id}',[AdminDerpartmentController::class,'departmentdelete'])->name('departments.delete');
   
    Route::get('designation',[AdminDerpartmentController::class,'designationcreate'])->name('designation');
    Route::post('designation',[AdminDerpartmentController::class,'designationstore'])->name('designation');
    Route::post('designation/status',[AdminDerpartmentController::class,'designationstatus'])->name('designation.status');
    Route::get('designation/edit/{id}',[AdminDerpartmentController::class,'designationcreate'])->name('designation.edit');
    Route::get('designation/delete/{id}',[AdminDerpartmentController::class,'designationdelete'])->name('designation.delete');
    
    // ---------------------EmployeesController Route-------------------------------------
        Route::get('employees',[EmployeesController::class,'employeecreate'])->name('employees');
        Route::any('employees/list',[EmployeesController::class,'emplist'])->name('employees.list');
        Route::post('country',[EmployeesController::class,'country'])->name('country.name');
        Route::post('state',[EmployeesController::class,'state'])->name('country.state.name');
        Route::get('add-employees',[EmployeesController::class,'addemployeescreate'])->name('addemployees');
        Route::post('emailv',[EmployeesController::class,'emailv'])->name('emailv');
        Route::post('epid',[EmployeesController::class,'epid'])->name('epid');
        Route::post('designationd',[EmployeesController::class,'designationfatch'])->name('designation.name');
        Route::post('save-employees',[EmployeesController::class,'addemployeesstore'])->name('storeemployees');
        Route::get('employees/edid/{id}',[EmployeesController::class,'addemployeescreate'])->name('employees.edit');
        Route::get('employees/delete/{id}',[EmployeesController::class,'employeesdestroy'])->name('employees.delete');
});