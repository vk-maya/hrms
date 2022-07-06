<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employees\Task;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\Employees\DailyTask;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use Symfony\Component\HttpKernel\Profiler\Profile;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\DerpartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Employees\UserController;
use App\Http\Controllers\Admin\AdminLeaveController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Employees\EmpAttendanceController;

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

require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/fill/UserData',[UserController::class,'fill'])->middleware('auth')->name('fill.data');
Route::post('fill/Userstore', [UserController::class, 'fillstore'])->middleware('auth')->name('fill.data.store');
Route::post('country', [UserController::class, 'country'])->name('state.name');
Route::post('state', [UserController::class, 'state'])->name('state.city.name');
Route::get('/',[UserController::class,'empdashboard'])->middleware(['auth','checkdata'])->name('empdashboard');
Route::get('/dashboard',[UserController::class,'empdashboard'])->middleware(['auth','checkdata'])->name('dashboard');

Route::prefix('employees/')->name('employees.')->middleware(['auth','checkdata'])->group(function(){
    // ----------------------leave emloyees route------------------------
    route::get('employees/leave',[LeaveController::class,'leave'])->name('leave');
    Route::get('employees/add/leave',[LeaveController::class,'leaveadd'])->name('add.leave');
    Route::post('employees/store/leave',[LeaveController::class,'storeleave'])->name('store.leave');
    // ------------------------------attendance route--------------------------
    Route::get('employees/attendance',[EmpAttendanceController::class,'get'])->name('attendance');
    // --------------------------Profile route ---------------------------
    Route::get('profiles',[UserController::class,'profile'])->name('profile');
    Route::get('profiles/show',[UserController::class,'profileinfo'])->name('add.moreinfo');
    Route::any('More/info/show/',[UserController::class,'profilemoreinfo'])->name('add.moreinfo.create');
    Route::post('More/info/save/',[UserController::class,'empmoreinfo'])->name('add.moreinfo.save');
    Route::post('save-employees', [UserController::class, 'proPassword'])->name('propassword');
    // -------------------------------------document Attach-----------------------
    Route::get('file/attach/{id}',[UserController::class,'getdocument'])->name('employees.document');
    Route::get('get/file/{id}',[UserController::class,'download'])->name('employees.download');
    // Route::get('get/file', function(){
    //     return Storage::download('path to file');
    // })

    // ----------------task route employees---------------------------
    route::get('task',[Task::class,'task'])->name('task');
    route::post('task/status',[Task::class,'taskstatus'])->name('task.status');
    route::get('task/status/complete/{id}',[Task::class,'taskcomplete'])->name('task-status-complete');
    // -----------------------daily task ------------------------------
    Route::get('emp/daliy/task',[DailyTask::class,'dailytask'])->name('daily.task');
    Route::get('emp/show/task/{id}',[DailyTask::class,'showtaskk'])->name('show-taskk');
    Route::get('emp/task/list',[DailyTask::class,'tasklist'])->name('show-list');
    Route::post('emp/daliy/task',[DailyTask::class,'dailystore'])->name('daily.task.store');
});

// ------------------------------admin Route----------------------------------
Route::redirect('/admin', '/admin/dashboard');
Route::prefix('/admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    // ---------------departments--------------------
    Route::get('departments', [DerpartmentController::class, 'departmentscreate'])->name('departments');
    Route::post('departments', [DerpartmentController::class, 'departmentsstore'])->name('departments');
    Route::post('departments/status', [DerpartmentController::class, 'departmentsstatus'])->name('departments.status');
    Route::get('departments/edit/{id}', [DerpartmentController::class, 'departmentscreate'])->name('departments.edit');
    Route::get('departments/delete/{id}', [DerpartmentController::class, 'departmentdelete'])->name('departments.delete');

    Route::get('designation', [DerpartmentController::class, 'designationcreate'])->name('designation');
    Route::post('designation', [DerpartmentController::class, 'designationstore'])->name('designation');
    Route::post('designation/status', [DerpartmentController::class, 'designationstatus'])->name('designation.status');
    Route::get('designation/edit/{id}', [DerpartmentController::class, 'designationcreate'])->name('designation.edit');
    Route::get('designation/delete/{id}', [DerpartmentController::class, 'designationdelete'])->name('designation.delete');

    // ---------------------EmployeesController Route-------------------------------------
    Route::get('employees', [EmployeesController::class, 'employeecreate'])->name('employees');
    Route::post('employees/info', [EmployeesController::class, 'empinfo'])->name('employees.info');
    Route::get('employees/profile/{id}', [EmployeesController::class, 'profile'])->name('employees.profile');
    Route::get('employees/information/{id}', [EmployeesController::class, 'information'])->name('employees.information');
    Route::get('employees/status/{id}', [EmployeesController::class, 'status'])->name('employees.status');
    Route::any('employees/list', [EmployeesController::class, 'emplist'])->name('employees.list');
    Route::post('country', [EmployeesController::class, 'country'])->name('country.name');
    Route::post('state', [EmployeesController::class, 'state'])->name('country.state.name');
    Route::get('add-employees', [EmployeesController::class, 'addemployeescreate'])->name('addemployees');
    Route::post('emailv', [EmployeesController::class, 'emailv'])->name('emailv');
    Route::post('epid', [EmployeesController::class, 'epid'])->name('epid');
    Route::post('designationd', [EmployeesController::class, 'designationfatch'])->name('designation.name');
    Route::post('save-employees', [EmployeesController::class, 'addemployeesstore'])->name('storeemployees');
    Route::get('employees/edid/{id}', [EmployeesController::class, 'addemployeescreate'])->name('employees.edit');
    Route::get('employees/delete/{id}', [EmployeesController::class, 'employeesdestroy'])->name('employees.delete');
    // -----------------------------------attendance route-----------------------------------------

    Route::any('attendance',[AttendanceController::class,'attendance'])->name('attendance');
    Route::get('attendance/info/{id}',[AttendanceController::class,'attinfo'])->name('attendance.info');
    // -----------------------------------file Document Attach------------------------------------------
    Route::get('file/attach/{id}',[EmployeesController::class,'attachfile'])->name('employees.attach');
    Route::post('file/attach',[EmployeesController::class,'attachfileStore'])->name('employees.attach.store');
    Route::get('get/file/delete{id}',[EmployeesController::class,'filedelete'])->name('fileattach.delete');


    // ---------------------------leave route----------------------------------
    Route::get('setting/leave',[AdminLeaveController::class,'leavesetting'])->name('leave.setting');
    Route::post('leave/type',[AdminLeaveController::class,'leavetype'])->name('leave.type');
    Route::post('leave/type/sick',[AdminLeaveController::class,'leavetype'])->name('leave.type.sick');
    Route::get('leave/list',[AdminLeaveController::class,'leavelist'])->name('leave.list');
    Route::post('leave/report',[AdminLeaveController::class,'leavereport'])->name('leave.report');
    Route::get('holiday',[AdminLeaveController::class,'holidays'])->name('holidays');
    Route::post('holiday',[AdminLeaveController::class,'holidayStore'])->name('holiday');
    Route::any('holiday/edit/{id}',[AdminLeaveController::class,'holidays'])->name('holiday.edit');
    Route::any('holiday/delete/{id}',[AdminLeaveController::class,'holidaydistroy'])->name('holiday.delete');
    Route::get('leave/edit/{id}',[AdminLeaveController::class,'edit'])->name('leave.edit');
    Route::any('leave/update',[AdminLeaveController::class,'update'])->name('leave.update');
    Route::get('leave/delete/{id}',[AdminLeaveController::class,'delete'])->name('leave.delete');
    Route::get('leave/add/employees',[AdminLeaveController::class,'monthleave'])->name('add.employees.leavemonth');


    // ---------------------client route-----------------------
    Route::get('client', [ClientController::class, 'index'])->name('client');
    Route::get('client/create', [ClientController::class, 'create'])->name('client.create');
    Route::any('client/list', [ClientController::class, 'clist'])->name('client.list');
    Route::post('client/cid', [ClientController::class, 'cid'])->name('client.id');
    Route::get('client/edit/{id}', [ClientController::class, 'create'])->name('client.edit');
    Route::get('client/delete/{id}', [ClientController::class, 'delete'])->name('client.delete');
    Route::Post('client/store', [ClientController::class, 'store'])->name('client.store');
    Route::post('client/status', [ClientController::class, 'clientstatus'])->name('client.status');


    // -----------------project route----------------------
    Route::get('project', [ProjectController::class, 'index'])->name('project');
    Route::get('project/list', [ProjectController::class, 'list'])->name('project.list');
    Route::get('project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::get('project/view/{id}', [ProjectController::class, 'view'])->name('project.view');
    Route::post('project/create', [ProjectController::class, 'store'])->name('project.store');
    Route::get('project/edit/{id}', [ProjectController::class, 'create'])->name('project.edit');
    Route::post('project/update', [ProjectController::class, 'update'])->name('project.update');
    Route::get('project/delete/{id}', [ProjectController::class, 'delete'])->name('project.delete');
    Route::get('project/file/delete/{id}', [ProjectController::class, 'filedelete'])->name('project.delete.file');
    Route::Post('project/team/delete/', [ProjectController::class, 'team_member_delete'])->name('project.delete.team.member');
    Route::get('project/task/board/{id}', [ProjectController::class, 'task'])->name('project.task.board');
    Route::post('project/task/board', [ProjectController::class, 'task_board_create'])->name('project.task.board.store');
    Route::any('project/task/add/{id}/{tbid}/', [ProjectController::class, 'task_create'])->name('project.task.add');
    Route::post('project/task/save', [ProjectController::class, 'task_store'])->name('project.task.store');
    Route::get('project/task/board/delete/{id}', [ProjectController::class, 'taskboardelete'])->name('project.delete.task.board');
    Route::get('project/task/task/delete/{id}', [ProjectController::class, 'taskdelete'])->name('project.delete.task');
    // -------------------------daily task route--------------------------------------
    Route::get('daliy/task',[ProjectController::class,'dailytask'])->name('employees.daily.task');
    Route::get('show/task',[ProjectController::class,'showtask'])->name('show-task');
    Route::post('daliy/task',[ProjectController::class,'dailystore'])->name('daily.task.store');
    Route::get('all/emp/task/list',[ProjectController::class,'alltask'])->name('all.task.list');
    Route::get('emp/all/task/{id}',[ProjectController::class,'employeestask'])->name('emp.show-taskk');
    Route::get('task/show/{id}',[ProjectController::class,'empltask'])->name('employ.task.list');

});
