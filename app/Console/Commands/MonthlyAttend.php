<?php

namespace App\Console\Commands;

use App\Models\Admin\LeaveMonthAttandance;
use App\Models\Attendance;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class MonthlyAttend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'month:attend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Attendence';

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
        $first_date = date('Y-m-').'01';
        $new_date = $first_date;
        // $new_date = Carbon::createFromDate('2022-08-07');

        for ($i=1; $new_date <= date('Y-m-d'); $i++) {
            // $date = date('Y-m-d', strtotime($new_date));
            $date = Carbon::createFromDate($new_date);

            $sat1 = Carbon::createFromDate($new_date)->nthOfMonth(1, Carbon::SATURDAY);
            $sat3 = Carbon::createFromDate($new_date)->nthOfMonth(3, Carbon::SATURDAY);

            $sat1 = $sat1->format('Y-m-d');
            $sat3 = $sat3->format('Y-m-d');

            // $current = $new_date;

            if (!$date->isSunday()) {
                $client = new Client();
                $response = $client->request('POST', 'http://hrmsapi.scrumdigital.in/api/getattendance', ['form_params' => ['date' => $date,]]);
                $response = json_decode($response->getBody()
                    ->getContents());

                foreach ($response->data as $key) {
                    $user = User::where('employeeID', $key->Empcode)->first();
                    if (!empty($user)) {
                        $attend = Attendance::where('user_id', $user->id)->where('date', $date)->first();
                        if (!empty($attend)) {
                            $attend->in_time = $key->INTime == '--:--' ? '00:00' : $key->INTime;
                            $attend->out_time = $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime;
                            if ($attend->in_time != '00:00' && $attend->out_time != '00:00') {
                                $out_time = Carbon::parse($attend->out_time)->format('H:i A');
                                $work_time = Carbon::parse($attend->in_time)->diff(\Carbon\Carbon::parse($attend->out_time))->format('%H:%I:%S');
                                $work_time = Carbon::parse($work_time . "- 1 hour")->toTimeString();
                                $attend->work_time = $work_time;
                            } else {
                                $attend->work_time = '00:00';
                            }
                            $attend->attendance = $key->Status;
                            $attend->status = $key->Status == 'P' ? 1 : 0;
                            $attend->save();
                        } else {
                            Attendance::create(['user_id' => $user->id, 'in_time' => $key->INTime == '--:--' ? '00:00' : $key->INTime, 'out_time' => $key->OUTTime == '--:--' ? '00:00' : $key->OUTTime, 'work_time' => $key->WorkTime, 'date' => date('Y-m-d', strtotime($date)), 'day' => date('d', strtotime($date)), 'month' => date('m', strtotime($date)), 'year' => date('Y', strtotime($date)), 'attendance' => $key->Status, 'status' => $key->Status == 'P' ? 1 : 0,]);
                        }
                        //leave vs attandance function
                        $date = date('Y-m-d', strtotime($date));
                        $id = Attendance::where('user_id', $user->id)->where('status', 1)->where('date', $date)->latest()->first();
                        if (isset($id)) {

                            $id = $id->user_id;
                            $month = date('m', strtotime($date));
                            $data = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) {
                                $query->where("from", "<=", $date)->where("to", ">=", $date);
                            })->count();
                            $leavedata = Leaverecord::where('user_id', $id)->where('status', 1)->where(function ($query) use ($date) {
                                $query->where("from", "<=", $date)->where("to", ">=", $date);
                            })->first();

                            if (isset($leavedata)) {
                                $leavetype = settingleave::find($leavedata->type_id);
                                if ($data > 0) {
                                    $monthattedance = LeaveMonthAttandance::where('status', 1)->where('user_id', $id)->where('date', $date)->first();
                                    if ($monthattedance == null) {
                                        $monthattedance = LeaveMonthAttandance::where('user_id', $id)->where('status', 1)
                                            ->where('month', $month)->first();
                                        $monthattedance = new LeaveMonthAttandance();
                                        $monthattedance->user_id = $id;
                                        $monthattedance->type_id = $leavedata->type_id;
                                        $monthattedance->date = $date;
                                        $monthattedance->month = $month;
                                        if ($leavetype->type == "Annual") {
                                            $monthattedance->anual = 1;
                                        } elseif ($leavetype->type == "Sick") {
                                            $monthattedance->sick = 1;
                                        } else {
                                            $monthattedance->other = 1;
                                        }
                                        $monthattedance->save();
                                    }
                                }
                            }
                        }
                    }
                }
                $this->info($new_date.' - Attendence Update Successfully');
            }
            $new_date = date('Y-m-d', strtotime($new_date.'+1 day'));
        }
    }
}
