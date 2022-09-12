<?php

use App\Http\Controllers\Admin\AdminController;
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
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Employees\UserController;
use App\Http\Controllers\Admin\AdminLeaveController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\EmployeesReport;
use App\Http\Controllers\Employees\EmpAttendanceController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserslipController;

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
Route::get('/test',[TestController::class,'test'])->name('test');

Route::get('/complete-profile',[UserController::class,'fill'])->middleware('auth')->name('fill.data');
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
    Route::get('leave/delete/{id}',[LeaveController::class,'delete'])->name('leave.delete');


    // ------------------------------attendance route--------------------------
    Route::get('employees/attendance',[EmpAttendanceController::class,'get'])->name('attendance');  
    Route::any('search/',[EmpAttendanceController::class,'searchMonthRecordAtt'])->name('search.month.attendance');
    Route::get('attendance/leave/{id}',[LeaveController::class,'attendanceLeave'])->name('attendance.get.leave');
    Route::post('attendance/leave',[LeaveController::class,'attendance'])->name('attendance.leave');
    Route::post('attendance/wfh',[LeaveController::class,'attendanceWfhStore'])->name('attendance.wfh');
    Route::post('attendance/leave/wfh',[LeaveController::class,'attendanceLeaveWfhStore'])->name('attendance.leave.wfh');

    // --------------------------Profile route ---------------------------
    Route::get('profiles',[UserController::class,'profile'])->name('profile');
    Route::get('profiles/show',[UserController::class,'profileinfo'])->name('add.moreinfo');
    Route::any('More/info/show/',[UserController::class,'profilemoreinfo'])->name('add.moreinfo.create');
    Route::post('More/info/save/',[UserController::class,'empmoreinfo'])->name('add.moreinfo.save');
    Route::post('save-employees', [UserController::class, 'proPassword'])->name('propassword');
    // -------------------------------------document Attach-----------------------
    Route::get('file/attach/{id}',[UserController::class,'getdocument'])->name('employees.document');
    Route::get('get/file/{id}',[UserController::class,'download'])->name('employees.download');


    // ----------------task route employees---------------------------
    route::get('task',[Task::class,'task'])->name('task');
    route::post('task/status',[Task::class,'taskstatus'])->name('task.status');
    route::get('task/status/complete/{id}',[Task::class,'taskcomplete'])->name('task-status-complete');
    // -----------------------daily task ------------------------------
    Route::get('emp/daliy/task',[DailyTask::class,'dailytask'])->name('daily.task');
    Route::get('emp/show/task/{id}',[DailyTask::class,'showtaskk'])->name('show-taskk');
    Route::get('emp/task/list',[DailyTask::class,'tasklist'])->name('show-list');
    Route::post('emp/daliy/task',[DailyTask::class,'dailystore'])->name('daily.task.store');
    ///Work From Home
    Route::get('work/from/home',[LeaveController::class,'wfhcreate'])->name('wfh.create');
    Route::Post('work/from/home/save',[LeaveController::class,'wfhstore'])->name('store.wfh');
    //salary slip route
    Route::get('employees/view/slip/{id}',[UserslipController::class,'slipview'])->name('employees.view.slip');
//salary slip route 
    Route::get('salary/slip/list',[UserslipController::class,'userSlip'])->name('salary.slip.list');
    Route::get('payslip-pdf/{id}', [UserslipController::class, 'downloadPdf'])->name('payslip.download');


});

// ------------------------------admin Route----------------------------------//////////

Route::redirect('/admin', '/admin/dashboard');
Route::prefix('/admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/search', [HomeController::class, 'dashboardsearch'])->name('dashboard.search');
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
    Route::any('attendance/search',[AttendanceController::class,'attendanceSearch'])->name('attendance.search');
    Route::any('attendance/employee',[AttendanceController::class,'attendanceEmployee'])->name('attendance.employee');
    Route::any('attendance/employee/search',[AttendanceController::class,'attendanceEmployeeSearch'])->name('attendance.employee.search');
    Route::get('attendance/info/{id}',[AttendanceController::class,'attinfo'])->name('attendance.info');
    Route::get('attendance/employees/month',[AttendanceController::class,'attendanceMonthRecord'])->name('employee.month');
    Route::post('attendance/employees/record',[AttendanceController::class,'recordReport'])->name('employee.month.record.report');
    Route::get('attendance-report',[AttendanceController::class,'attendanceReport'])->name('attendance-report');

    // -----------------------------------file Document Attach------------------------------------------
    Route::get('file/attach/{id}',[EmployeesController::class,'attachfile'])->name('employees.attach');
    Route::post('file/attach',[EmployeesController::class,'attachfileStore'])->name('employees.attach.store');
    Route::get('get/file/delete{id}',[EmployeesController::class,'filedelete'])->name('fileattach.delete');


    // ---------------------------leave route----------------------------------
    Route::get('setting/leave',[AdminLeaveController::class,'leavesetting'])->name('leave.setting');
    Route::post('leave/type',[AdminLeaveController::class,'leavetype'])->name('leave.type');
    Route::post('leave/type/sick',[AdminLeaveController::class,'leavetype'])->name('leave.type.sick');
    Route::get('leave/list',[AdminLeaveController::class,'leavelist'])->name('leave.list');
    Route::get('holiday',[AdminLeaveController::class,'holidays'])->name('holidays');
    Route::post('holiday',[AdminLeaveController::class,'holidayStore'])->name('holiday');
    Route::any('holiday/edit/{id}',[AdminLeaveController::class,'holidays'])->name('holiday.edit');
    Route::any('holiday/delete/{id}',[AdminLeaveController::class,'holidaydistroy'])->name('holiday.delete');
    Route::any('leave/update',[AdminLeaveController::class,'update'])->name('leave.update');
    Route::get('leave/delete/{id}',[AdminLeaveController::class,'delete'])->name('leave.delete');
    Route::get('leave/add/employees',[AdminLeaveController::class,'monthleave'])->name('add.employees.leavemonth');
    Route::get('leave/view/{id}',[AdminLeaveController::class,'moreleave'])->name('leave.view');
    // ---------------------employees salary generate---------------------------------
    Route::post('salary/report',[AdminLeaveController::class,'leavereport'])->name('leave.report');
  // report Route 
    Route::any('month/leave/record/manage',[PayrollController::class,'monthRecordLeaveManage'])->name('month.leave.record.manage');
    Route::any('month/leave/record/manage/all',[PayrollController::class,'monthRecordLeaveManage'])->name('month.leave.record.manage.all');
    Route::any('month/leave/record/salip/generate',[PayrollController::class,'monthslipgenerate'])->name('emp.slip.generate');
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
    // daily task route
    Route::get('daliy/task',[ProjectController::class,'dailytask'])->name('employees.daily.task');
    Route::get('show/task',[ProjectController::class,'showtask'])->name('show-task');
    Route::post('daliy/task',[ProjectController::class,'dailystore'])->name('daily.task.store');
    Route::get('all/emp/task/list',[ProjectController::class,'alltask'])->name('all.task.list');
    Route::get('emp/all/task/{id}',[ProjectController::class,'employeestask'])->name('emp.show-taskk');
    Route::get('task/show/{id}',[ProjectController::class,'empltask'])->name('employ.task.list');
    // salary generate route
    Route::get('employees/salary/generate/{id}',[PayrollController::class,'empreport'])->name('emp.report.emp');
    Route::get('employees/salary/generate',[PayrollController::class,'empreport'])->name('emp.report');
    Route::any('employees/salary/generate/search',[PayrollController::class,'empreportSearch'])->name('emp.report.search');
    Route::post('employees/salary/generate',[PayrollController::class,'salaryGenerate'])->name('employees.salary.generate');
     ///employee increment
    Route::post('employee-increment',[PayrollController::class,'increment'])->name('employee.increment');

       // setings-
    Route::get('salary/earndeduction/{id}',[PayrollController::class,'salaryEarnDeducation'])->name('salary.earn.deducation');
    Route::post('salary/earndeduction/edit',[PayrollController::class,'salarymanagementedit'])->name('salary.earn.deducation.edit');

    //company setting route
    Route::get('settings',[HomeController::class,'settings'])->name('settings');
    Route::post('settings-store',[HomeController::class,'setting_store'])->name('settings-store');

    Route::get('salary',[PayrollController::class,'salary_settings'])->name('salary.settings');
    Route::post('salary-store',[PayrollController::class,'salary_store'])->name('salary.store');
    //..............................view_slip...................................////
    Route::get('slip-generate/{employee_id}',[PayrollController::class,'slip'])->name('employee.slip');
    Route::get('view-slip/{id}',[PayrollController::class,'view_slip'])->name('employee.view_slip');
    Route::get('employee-slip/{id}',[PayrollController::class,'genrateslip'])->name('employee.generate_slip');
    Route::get('employees/view/slip/{id}',[PayrollController::class,'viewSlip'])->name('employees.view.slip');
  // -------------------------payroll--------------------------------------//////
    Route::get('payroll',[PayrollController::class,'payroll'])->name('payroll.list');
    Route::get('salary/info/{id}',[PayrollController::class,'salaryinfo'])->name('salaryinfo');
    Route::post('payroll-store',[PayrollController::class,'store'])->name('payroll.store');
    Route::get('payroll/edit/{id}',[PayrollController::class,'payroll'])->name('payroll.edit');
    Route::get('add/salary/{id}',[PayrollController::class,'parolljs'])->name('add.salary');
    ///////test route
    Route::get('tsetsing/route/{id}',[PayrollController::class,'testroute'])->name('test.link');

    //...................PDF..................//
    Route::get('payslip-pdf/{id}', [PayrollController::class, 'downloadPdf'])->name('payslip.download');

    // WFH Route
  Route::post('workfrom/home/report',[AdminLeaveController::class,'wfhReport'])->name('wfh.report');


    // Shobhit Routes

    // Leaves Type
        Route::get('leave-setting', [AdminController::class, 'leaveSetting'])->name('leave-setting');
        Route::get('add-leave-type', [AdminController::class, 'addLeaveType'])->name('add-leave-type');
        Route::get('edit-leave-type/{id}', [AdminController::class, 'addLeaveType'])->name('edit-leave-type');
        Route::post('store-leave-type', [AdminController::class, 'storeLeaveType'])->name('store-leave-type');
    // End Leaves Type

    // Employees
        Route::get('add-employee', [AdminController::class, 'addEmployee'])->name('add-employee');
        Route::get('edit-employee/{id}', [AdminController::class, 'addEmployee'])->name('edit-employee');
        Route::post('store-employee', [AdminController::class, 'storeEmployee'])->name('store.employee');
    // End Employees

    // End Shobhit Routes


});
