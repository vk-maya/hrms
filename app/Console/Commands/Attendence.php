<?php
namespace App\Console\Commands;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Attendance;
use App\Models\monthleave;
use App\Models\Admin\Session;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use App\Models\Admin\LeaveMonthAttandance;

class Attendence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attend:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attendence Update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $client = new Client();
        $response = $client->request('POST', 'http://hrmsapi.scrumdigital.in/api/getattendance', ['form_params' => ['date' => $date, ]]);
        $response = json_decode($response->getBody()
            ->getContents());

        foreach ($response->data as $key)
        {
            $user = User::where('employeeID', $key->Empcode)
                ->first();

            if (!empty($user))
            {
                $attend = Attendance::where('user_id', $user->id)
                    ->where('date', $date)->first();

                if (!empty($attend))
                {
                    $attend->in_time = $key->INTime == '--:--' ? '00:00' : $key->INTime;
                    $attend->out_time = $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime;
                    $attend->work_time = $key->WorkTime;
                    $attend->attendance = $key->Status;
                    $attend->status = $key->Status == 'P' ? 1 : 0;
                    $attend->save();
                }
                else
                {
                    Attendance::create(['user_id' => $user->id, 'in_time' => $key->INTime == '--:--' ? '00:00' : $key->INTime, 'out_time' => $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime, 'work_time' => $key->WorkTime, 'date' => date('Y-m-d') , 'day' => date('d') , 'month' => date('m') , 'year' => date('Y') , 'attendance' => $key->Status, 'status' => $key->Status == 'P' ? 1 : 0, ]);
                }
                //leave vs attandance function
                $date = now();
                $date = date('Y-m-d', strtotime($date));
                $id = Attendance::where('user_id', $user->id)
                    ->where('status', 1)
                    ->where('date', $date)->latest()
                    ->first();
                if (isset($id))
                {

                    $id = $id->user_id;
                    $month = date('m', strtotime($date));
                    $data = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date)
                    {
                        $query->where("from", "<=", $date)->where("to", ">=", $date);
                    })->count();
                    $leavedata = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date)
                    {
                        $query->where("from", "<=", $date)->where("to", ">=", $date);
                    })->first();

                    if (isset($leavedata))
                    {
                        $leavetype = settingleave::find($leavedata->type_id);
                        if ($data > 0)
                        {
                            $monthattedance = LeaveMonthAttandance::where('status', 1)->where('user_id', $id)->where('date', $date)->first();
                            if ($monthattedance == null)
                            {
                                if ($monthattedance == null)
                                {
                                    $monthattedance = LeaveMonthAttandance::where('user_id', $id)->where('status', 1)
                                        ->where('month', $month)->first();
                                    $monthattedance = new LeaveMonthAttandance();
                                    $monthattedance->user_id = $id;
                                    $monthattedance->type_id = $leavedata->type_id;
                                    $monthattedance->date = $date;
                                    $monthattedance->month = $month;
                                    if ($leavetype->type == "Annual")
                                    {
                                        $monthattedance->anual = 1;
                                    }
                                    elseif ($leavetype->type == "Sick")
                                    {
                                        $monthattedance->sick = 1;
                                    }
                                    else
                                    {
                                        $monthattedance->other = 1;
                                    }
                                    $monthattedance->save();
                                }
                            }
                        }
                    }
                }
            }           
        }
        $this->info('Attendence Update Successfully');
    }

    public function handlem($id)
    {
        $today = \Carbon\Carbon::now();
        $fristMonthofDay = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $lastMonthofDay = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $leaves = Leaverecord::where('user_id', $id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
            $query->whereBetween('from', [$fristMonthofDay, $lastMonthofDay]);
        })->get();
        $leavesGet = Leaverecord::where('user_id', $id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
            $query->whereBetween('from', [$fristMonthofDay, $lastMonthofDay]);
        })->count();

        // -------------------------------total Leave count----------------------------------

        $leavet = settingleave::where('status', 1)->get();
        if ($leavesGet > 0) {
            foreach ($leaves as $leave) {
                $leavetype = settingleave::find($leave->type_id);
                $monthleave = monthleave::where('user_id', $leave->user_id)->where('status', 1)->where('to', $lastMonthofDay)->first();
                if ($leavetype->type == "Annual") {
                    if ($monthleave != null) {
                        $monthleave->apprAnual = $monthleave->apprAnual + $leave->day;
                    } else {
                        $monthleave->apprAnual = $leave->day;
                    }
                } elseif ($leavetype->type == "Sick") {
                    if ($monthleave != null) {
                        $monthleave->apprSick = $monthleave->apprSick + $leave->day;
                    } else {
                        $monthleave->apprSick = $leave->day;
                    }
                } else {
                    if ($monthleave != null) {
                        $monthleave->other = $monthleave->other + $leave->day;
                    } else {
                        $monthleave->other = $leave->day;
                    }
                }
                $monthleave->status = 1;
                $monthleave->save();
            }
        } else {
            $monthleave = monthleave::where('user_id', $id)->where('status', 1)->first();
            $monthleave->status = 3;
            $monthleave->save();
        }

        // --------------------------------------------------Attendance function --------------  //Attendance Vs Month Leave Table----
      
        $salarymonthLastDate = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $dd = date('d', strtotime($salarymonthLastDate));
        $monthFingerApproved = LeaveMonthAttandance::where('user_id', $id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
            $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);
        })->count();
        if ($monthFingerApproved > 0) {
            $monthFingerApproved = LeaveMonthAttandance::where('user_id', $id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
                $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);
            })->get();

            foreach ($monthFingerApproved as $key => $aLeave) {
                $monthleave = monthleave::where('user_id', $leave->user_id)->where('status', 1)->where('to', $lastMonthofDay)->first();
                $leavetype = settingleave::find($aLeave->type_id);
                if ($leavetype->type == "Annual") {
                    if ($monthleave->apprAnual > 0) {
                        $monthleave->apprAnual = $monthleave->apprAnual - $aLeave->anual;
                    }
                } elseif ($leavetype->type == "Sick") {
                    if ($monthleave->apprSick > 0) {
                        $monthleave->apprSick = $monthleave->apprSick - $aLeave->sick;
                    }
                } else {
                    if ($monthleave->other > 0) {
                        $monthleave->other = $monthleave->other - $aLeave->other;
                    }
                }
                $monthleave->save();
            }
        }

// --------------------------------------------Attendance without leave absunt function--------------
        $monthFingerAbsunt = Attendance::where('user_id', $id)->where('status', 0)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
            $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);})->count();
            if ($monthFingerAbsunt > 0) {
                $monthleave = monthleave::where('user_id', $id)->where('status', 1)->where('to', $lastMonthofDay)->first();
                // dd($monthleave);
                $totalLeave = $monthleave->apprAnual+$monthleave->apprSick + $monthleave->other; //total leave add 
                // dd($monthFingerAbsunt,$totalLeave);
            if ($monthFingerAbsunt > $totalLeave) {
                // dd("kkkkk");
                $netLeave = $monthFingerAbsunt - $totalLeave; //leave diffrance machine and leave compare
                if ($monthleave->other != null) {
                    $monthleave->other = $monthleave->other + $netLeave;
                } else {
                    $monthleave->other = $netLeave;
                }
            }
            $monthleave->status = 3;
            $monthleave->save();
        }

        // ----------------------leave to other leave shift ------------------//monthLeave In status 0 Update Function
              
        $monthleave = monthleave::where('user_id', $id)->where('to', $lastMonthofDay)->where('status', 3)->first();
        // dd($monthleave->toArray());
        if ($monthleave->apprAnual > $monthleave->anualLeave) {
            $netleaveAnual = $monthleave->apprAnual - $monthleave->anualLeave;
            if ($monthleave->other != null) {
                $monthleave->other = $monthleave->other + $netleaveAnual;
            } else {
                $monthleave->other = $netleaveAnual;
            }
        }
        if ($monthleave->apprSick > $monthleave->sickLeave) {
            $netleaveAnual = $monthleave->apprSick - $monthleave->sickLeave;
            if ($monthleave->other != null) {
                $monthleave->other = $monthleave->other + $netleaveAnual;
            } else {
                $monthleave->other = $netleaveAnual;
            }
        }
        $monthleave->save();
        $monthdata = $monthleave;


        // --------------------new row create user in next month controle---------------------//get a new entery month in user
        $session = Session::where('status', 1)->first();
        $fristMonthofDay = Carbon::now()->startOfMonth()->toDateString();
        $lastMonthofDay = Carbon::now()->endOfMonth()->toDateString();
        $monthleave = new monthleave();
        $monthleave->user_id = $id;
        $monthleave->useryear_id = $session->id;
        $monthleave->from = $fristMonthofDay;
        $monthleave->to = $lastMonthofDay;
        $anual = $monthdata->anualLeave - $monthdata->apprAnual;
        if ($anual > 0) {
            foreach ($leavet as $leave) {
                if ($leave->type == "Annual") {
                    $day = $leave->day / 12;
                    $monthleave->anualLeave = $anual + $day;
                }
            }
        } else {
            foreach ($leavet as $leave) {
                if ($leave->type == "Annual") {
                    $day = $leave->day / 12;
                    $monthleave->anualLeave = $day;
                }
            }
        }
        $sick = $monthdata->sickLeave - $monthdata->apprSick; //due day sick
        if ($sick > 0) {
            foreach ($leavet as $leave) {
                if ($leave->type == "Sick") {
                    $day = $leave->day / 12;
                    $monthleave->sickLeave = $sick + $day;
                }
            }
        } else {
            foreach ($leavet as $leave) {
                if ($leave->type == "Sick") {
                    $day = $leave->day / 12;
                    $monthleave->sickLeave = $day;
                }
            }
        }
        $monthleave->status = 1;
        $monthleave->save();
    }
}