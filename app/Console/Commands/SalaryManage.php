<?php

namespace App\Console\Commands;

use App\Models\Admin\LeaveMonthAttandance;
use App\Models\Admin\Session;
use App\Models\Attendance;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use App\Models\monthleave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SalaryManage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salary:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Salary Management';

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
        $user_data = User::where('status', 1)->get();

        foreach ($user_data as $user) {
            $today = \Carbon\Carbon::now();
            $fristMonthofDay = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
            $lastMonthofDay = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
            $leaves = Leaverecord::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
                $query->whereBetween('from', [$fristMonthofDay, $lastMonthofDay]);
            })->get();
            $leavesGet = Leaverecord::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
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
                $monthleave = monthleave::where('user_id', $user->id)->where('status', 1)->first();
                $monthleave->status = 3;
                $monthleave->save();
            }

            // --------------------------------------------------Attendance function --------------  //Attendance Vs Month Leave Table----

            $salarymonthLastDate = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
            $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $dd = date('d', strtotime($salarymonthLastDate));
            $monthFingerApproved = LeaveMonthAttandance::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
                $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);
            })->count();
            if ($monthFingerApproved > 0) {
                $monthFingerApproved = LeaveMonthAttandance::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
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

    // --------------------------------------------Attendance without leave absent function--------------
            $monthFingerAbsunt = Attendance::where('user_id', $user->id)->where('status', 0)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
                $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);})->count();
                if ($monthFingerAbsunt > 0) {
                    $monthleave = monthleave::where('user_id', $user->id)->where('status', 1)->where('to', $lastMonthofDay)->first();
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

            $monthleave = monthleave::where('user_id', $user->id)->where('to', $lastMonthofDay)->where('status', 3)->first();
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
            $monthleave->user_id = $user->id;
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
}
