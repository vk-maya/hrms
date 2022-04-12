<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDerpartmentController;


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
    // ------------------------------Departments Rots-------------------
    Route::get('departments',[AdminDerpartmentController::class,'departmentscreate'])->name('departments');
    Route::post('departments',[AdminDerpartmentController::class,'departmentsstore'])->name('departments');
    Route::get('designation',[HomeController::class,'create'])->name('designation');
    Route::post('designation',[HomeController::class,'store'])->name('designation');
    Route::get('employees',[HomeController::class,'employeecreate'])->name('employees');
});