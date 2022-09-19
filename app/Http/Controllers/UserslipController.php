<?php

namespace App\Http\Controllers;

// use PDF;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use App\Models\Admin\UserSlip;
use App\Models\Admin\CompanyProfile;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;

class UserslipController extends Controller
{
    public function userSlip(){
        $salipList= UserSlip::where('user_id',Auth::guard('web')->user()->id)->orderBy('id','desc')->get();
        return view('employees.payroll.salary-slip',compact('salipList'));
    }
    public function slipview($id){
        $company = CompanyProfile::where('status', 1)->first();
        $slip = UserSlip::find($id);
        $user=User::with('designation')->find(Auth::guard('web')->user()->id);
        // dd($user->toArray());
        return response()->json(compact('company', 'slip','user'));
    }
    public function downloadPdf($id){
        $company = CompanyProfile::where('status', 1)->first();
        $employeesalary = UserSlip::with(['user.userDesignation'])->find($id);      
        // dd($employeesalary->toArray());
        // view()->share('employees.payroll.export-pdf', $employeesalary,$company);
        $pdf = PDF::loadView('employees.payroll.export-pdf', ['employeesalary' => $employeesalary,'company'=>$company]);
        // return view('employees.payroll.export-pdf', ['employeesalary' => $employeesalary,'company'=>$company]);
        return $pdf->download('slip.pdf');
    }
}
