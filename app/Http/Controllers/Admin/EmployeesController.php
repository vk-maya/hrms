<?php
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\userinfo;
use App\Models\Countries;
use App\Models\Department;
use App\Models\monthleave;
use App\Models\Designation;
use App\Models\Admin\Attach;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use Illuminate\Validation\Rules;
use App\Models\Leave\settingleave;
use App\Models\Admin\UserleaveYear;
use App\Http\Controllers\Controller;
use App\Models\Admin\SalaryEarenDeduction;
use App\Models\Admin\UserEarndeducation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use phpDocumentor\Reflection\Types\Null_;

class EmployeesController extends Controller
{

    // -----------------------email check get------------
    public function emailv(Request $request)
    {
        $rrr = User::withTrashed()->where('email', $request->x)
            ->count();
        return json_encode(['count' => $rrr]);
    }

    // -----------------employees id get----------------------
    public function epid(Request $request)
    {
        $idd = User::where('employee_id', 'like', "%$request->y%")
            ->count();
        return json_encode(['count' => $idd]);
    }

    // ------------------------designation get------------------
    public function designationfatch(Request $request)
    {
        $designation = Designation::where('department_id', $request->dep)
            ->get();
        return json_encode(['count' => $designation]);
    }

    // ------------------------------state and city ajax------
    public function country(Request $request)
    {
        $state = State::where('country_id', $request->contid)
            ->get();
        return response()
            ->json(['state' => $state]);
    }

    public function state(Request $request)
    {
        $data = City::where('state_id', $request->id)
            ->get();
        return response()
            ->json(['city' => $data]);
    }

    // --------------------delete ajax-----------------------
    public function employeesdestroy($id)
    {
        $delete = User::find($id);
        if ($delete->image != '')
        {
            storage::delete('public/uploads/' . $delete->image);
        }
        $delete->delete();
        return response()
            ->json(['msg' => 'yes']);
    }

    // --------------------laravel request function---------
    public function employeecreate()
    {

        $department = Designation::with('department')->get();
        $employees = User::orderBy('first_name')->get();

        return view('admin.employees.employees', compact('employees', 'department',));
    }

    // ------------------employees list---------------------
    public function emplist()
    {
        $ldepartment = Designation::with('department')->get();
        $lemployees = User::orderBy('first_name')->get();

        return view('admin.employees.employees', compact('lemployees', 'ldepartment',));
    }
    // -----------------------employees form create && edit From  ---------------------
    public function addemployeescreate(Request $request)
    {
        // dd($request->toArray());
        if ($request->id != '')
        {
            $sess = Session::where('status', 1)->first();
            $salared = SalaryEarenDeduction::with('salarymanag')->where('session_id', $sess->id)
                ->where('status', 1)
                ->get();
            $salaryedit = UserEarndeducation::where('User_id', $request->id)
                ->pluck('salary_earndeductionID');
            $employees = User::find($request->id);
            $department = Department::get();
            $count = Countries::all();
            return view('admin.employees.employees-add', compact('department', 'employees', 'count', 'salared', 'salaryedit'));
        }
        else
        {
            $sess = Session::where('status', 1)->first();
            $salared = SalaryEarenDeduction::with('salarymanag')->where('session_id', $sess->id)
                ->where('status', 1)
                ->get();
            $department = Department::get();
            $count = Countries::all();
            $id = User::latest()->first();
            if ($id == !null)
            {
                $emp = explode('-', $id->employeeID);
                $empid = 1 + $emp[2];
            }
            else
            {
                $empid = "SDPL-JAI-0001";
            }

            return view('admin.employees.employees-add', compact('department', 'count', 'empid', 'salared'));
        }
    }

    // ------------------employees store function------------------------
    public function addemployeesstore(Request $request)
    {
        // dd($request->toArray());
        if ($request->id == "")
        {
            $rules = ['first_name' => ['required', 'string', 'max:255'], 'password' => ['required', 'confirmed', Rules\Password::defaults() ], 'joiningDate' => ['string', 'required'], 'department_id' => ['required', 'string', ], 'designation_id' => ['required', 'string', 'numeric', 'max:255'], ];
        }

        if ($request->pincode != null) {
            $rules['pincode'] = ['required', 'integer', 'digits:6'];
            $request->validate($rules);
        }

        if ($request->id == !null)
        {
            $employees = User::find($request->id);
            $leaveyearr = UserleaveYear::where('user_id', $request->id)
                ->where('status', 1)
                ->first();
            // dd($leaveyear->toArray());
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
            if (User::where('email', $request->email)
                ->where('id', '!', $request->id)
                ->count() > 0)
            {
                return response()
                    ->back()
                    ->withErrors(['email' => "Email Already Exist"])
                    ->withInput();
            }
        }
        else
        {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $request->validate($rules);
            $employees = new User();
        }
        // dd("ohoo");
        $employees->first_name = $request->first_name;
        $employees->last_name = $request->last_name;
        $employees->gender = $request->gender;
        $dobmax = Carbon::now()->subMonths(216)
            ->toDateString();
        if ($request->dob <= $dobmax)
        {
            $employees->dob = date('Y-m-d', strtotime($request->dob));
        }
        else
        {
            return back()
                ->withErrors(["dob" => "Min. 18 years be employed or permitted to work"])
                ->withInput();
        }
        $employees->email = $request->email;
        $id = User::latest()->first();
        if ($request->id == null)
        {
            if ($id != null)
            {
                // dd("ddd");
                $emp = explode('-', $id->employeeID);
                $empid = 1 + $emp[2];
                if ($empid < 9)
                {
                    $empid = 'SDPL-JAI-000' . $empid;
                }
                elseif ($empid < 99)
                {
                    $empid = 'SDPL-JAI-00' . $empid;
                }
                elseif ($empid < 100)
                {
                    $empid = 'SDPL-JAI-0' . $empid;
                }
                else
                {
                    $empid = 'SDPL-JAI-' . $empid;
                }

            }
            else
            {
                $empid = "SDPL-JAI-0001";
            }
        }
        else
        {
            $empid = "SDPL-JAI-0001";
        }
        $employees->employeeID = $empid;
        $employees->machineID = $request->machineID;

        if ($request->password != '')
        {

            $employees->password = Hash::make($request->password);
        }
        $companydate = "2019-01-01";
        if ($request->joiningDate >= $companydate && $request->joiningDate <= Carbon::now()
            ->toDateString())
        {

            $employees->joiningDate = date('Y-m-d', strtotime($request->joiningDate));
        }
        else
        {
            return back()
                ->withErrors(["joiningDate" => "as per company rules"])
                ->withInput();
        }
        $employees->phone = $request->phone;
        $employees->department_id = $request->department_id;
        $employees->designation_id = $request->designation_id;
        $employees->address = $request->address;
        $employees->country_id = $request->country_id;
        $employees->state_id = $request->state_id;
        $employees->city_id = $request->city_id;
        $employees->pinCode = $request->pincode;
        $employees->status = ($request->status == 1) ? 1 : 0;
        $employees->workplace = $request->workplace;
        if ($request->hasFile('image') == 1)
        {
            storage::delete('public/uploads/' . $employees->image);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = "sdc" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $ext;
            $file = $request->file('image')
                ->storeAs('public/uploads', $filename);
            $employees->image = $filename;
        }
        $employees->save();
        // dd($employees->toArray());
        // -------------------------yearleave function------------------------
        $sess = Session::where('status', 1)->latest()
            ->first();
        if ($request->id == null)
        {
            $employeesId = User::latest()->first('id');
            $leaveyear = new UserleaveYear();
            $leaveyear->user_id = $employeesId->id;
            $leaveyear->session_id = $sess->id;
        }
        else
        {
            $leaveyear = UserleaveYear::where('user_id', $request->id)
                ->where('status', 1)
                ->latest()
                ->first();
        }
        $allleave = settingleave::where('status', 1)->get();
        $jd = $request->joiningDate;
        if ($jd >= $sess->from)
        {
            $jd = $request->joiningDate;
        }
        else
        {
            $jd = $sess->from;
        }
        $diffr = round(Carbon::parse($jd)->floatDiffInMonths($sess->to));
        foreach ($allleave as $value)
        {
            if ($value->type == 'Annual')
            {
                $day = $diffr *= $value->day / 12;
                $leaveyear->basicAnual = $day;
                // dd($leaveyear->basicAnual);

            }
            elseif ($value->type == 'Sick')
            {
                $day = $diffr *= $value->day / 12;
                $leaveyear->basicSick = $day;
            }
            elseif ($value->type == 'other')
            {
                $day = $diffr = $value->day;
                $leaveyear->other = $day;
            }
            $leaveyear->status = 1;
            // dd($leaveyear->toArray());
            $leaveyear->save();
        }
        // ----------------------------monthleave function--------------------
        if ($request->id == null)
        {
            $leaveyear = UserleaveYear::latest()->first();
            $yearleave = settingleave::where('status', 1)->get();
            foreach ($yearleave as $key => $value)
            {
                if ($value->type == "Annual")
                {
                    $anual = $value->day / 12;
                }
                elseif ($value->type == "Sick")
                {
                    $sickl = $value->day / 12;
                }
            }

            $data = new monthleave();
            $data->user_id = $employeesId->id;
            $data->useryear_id = $leaveyear->id;
            $jd = $employeesId->joiningDate;
            $str = date('Y-m', strtotime($jd));
            $strr = $str . "-15";
            if ($jd >= $sess->from)
            {
                if ($jd < $strr)
                {
                    $jd = date('Y-m', strtotime($jd));
                    $jd = $jd . "-01";
                    // dd($jd);

                }
                else
                {
                    $jd = Carbon::parse($jd)->addMonths();
                    $jd = date('Y-m', strtotime($jd));
                    $jd = $jd . "-01";
                }
            }else{
                $jd = $sess->from;
            }
            $end = now();
            $end = date('Y-m', strtotime($end));
            $end = Carbon::parse($end)->endOfMonth(); //Last Date of Month
            $end = date('Y-m-d', strtotime($end));
            $diffr = round(Carbon::parse($jd)->floatDiffInMonths($end));
            $from = date('Y-m-d', strtotime($jd));
            $to = date('Y-m-d', strtotime($end));
            $data->from = $from;
            $data->to = $to;
            $anual = $diffr * $anual;
            $sick = $diffr * $sickl;
            $data->anualLeave = $anual;
            $data->sickLeave = $sick;
            $data->status = 1;
            $data->save();
        }

        // -----------------------file save function------------------------
        if ($request->hasFile('files'))
        {
            $files = $request->file('files');
            foreach ($files as $file)
            {
                if ($request->id == null)
                {
                    $fileimg = new Attach;
                }
                else
                {
                    $fileimg = Attach::where('user_id', $request->id)
                        ->get();
                }
                $fname = $request->first_name;
                $newfilename = $fname . '_' . rand(0, 10000) . '.' . $file->getClientoriginalExtension();
                $file->storeAs('public/file', $newfilename);
                $fileimg->user_id = $employeesId->id;
                $fileimg->type = "user";
                $file->status = 1;
                $fileimg->fileName = $newfilename;
                $fileimg->save();
            }
        }
        // -------------------------earning and deducation code -----------------------
        // dd($request->toArray());
        if ($request->id != null)
        {
            $user = $request->id;
        }
        else
        {

            $user = $employeesId->id;
        }

        User::find($user)->userSalaryData()
            ->sync($request->earning);

        return redirect()
            ->route('admin.employees');
    }

    public function status($id)
    {
        $idd = User::find($id);
        if ($idd->status == 1)
        {
            $idd->status = 0;
        }
        else
        {
            $idd->status = 1;
        }
        $idd->save();
        return redirect()
            ->back();
    }
    public function profile($id)
    {
        $employees = User::with('department', 'profiledesignation', 'moreinfo')->find($id);
        // dd($employees->toArray());
        return view('admin.employees.profile', compact('employees'));
    }

    public function information($id)
    {
        $userin = userinfo::where('user_id', $id)->count();
        if ($userin != "")
        {
            $data = userinfo::where('user_id', $id)->first();
            $id = $id;
            return view('admin.employees.information', compact('data', 'id'));
        }
        else
        {
            $id = $id;
            return view('admin.employees.information', compact('id'));
        }
    }

    public function empinfo(Request $request)
    {
        $rules = ['nationality' => ['required', 'string', ], 'maritalstatus' => ['required', 'string'], 'children' => ['required', 'string', ], 'bankname' => ['required', 'string', ], 'bankAc' => ['required', 'integer', ], 'ifsc' => ['required', 'string', ], 'pan' => ['required', 'string', ], ];
        if ($request->id)
        {
            $data = userinfo::find($request->id);
        }
        else
        {
            $data = new userinfo();
            $data->user_id = $request->user_id;
        }
        $request->validate($rules);
        $data->nationality = $request->nationality;
        $data->maritalStatus = $request->maritalstatus;
        $data->noOfChildren = $request->children;
        $data->bankname = $request->bankname;
        $data->bankAc = $request->bankAc;
        $data->ifsc = $request->ifsc;
        $data->pan = $request->pan;
        $data->status = 1;
        $data->save();
        return redirect()
            ->route('admin.employees.profile', $request->user_id);
    }
    public function attachfile($id)
    {
        $files = Attach::where('user_id', $id)->get();
        $user = User::find($id);
        return view('admin.attach.user-file', compact('files', 'user'));
    }
    // ------------attach file store function---------------------


    public function attachfileStore(Request $request)
    {
        if ($request->hasFile('files'))
        {
            $files = $request->file('files');
            foreach ($files as $file)
            {
                $fileimg = new Attach;
                $fname = $request->first_name;
                $newfilename = $fname . '_' . rand(0, 10000) . '.' . $file->getClientoriginalExtension();
                $file->storeAs('public/file', $newfilename);
                $fileimg->user_id = $request->user_id;
                $fileimg->type = "user";
                $file->status = 1;
                $fileimg->fileName = $newfilename;
                $fileimg->save();
            }
            return redirect()
                ->back();
        }
    }
    // ---------------save employees file delete function------------
    public function filedelete($id)
    {
        $data = Attach::find($id);
        storage::delete('public/file/' . $data->fileName);
        $data->delete();
        return redirect()
            ->back();
    }

}
