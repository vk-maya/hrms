<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

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
        $response = $client->request('POST', 'http://hrmsapi.scrumdigital.in/api/getattendance', [
            'form_params' => [
                'date' => $date,
        ]]);
        $response = json_decode($response->getBody()->getContents());

        // var_dump(json_decode($response));
        // ResultJob::dispatch();

        foreach ($response->data as $key) {
            $user = User::where('employeeID', $key->Empcode)->first();

            if (!empty($user)) {
                $attend = Attendance::where('user_id', $user->machineID)->where('date', $date)->first();

                if (!empty($attend)) {
                    $attend->in_time = $key->INTime=='--:--'?'00:00':$key->INTime;
                    $attend->out_time = $key->OUTTime=='--:--'?'00:00':$key->OUTTime;
                    $attend->work_time = $key->WorkTime;
                    $attend->attendance = $key->Status;
                    $attend->status = $key->Status=='P'?1:0;
                    $attend->save();
                }else{
                    Attendance::create([
                        'user_id' => $user->id,
                        'in_time' => $key->INTime=='--:--'?'00:00':$key->INTime,
                        'out_time' => $key->OUTTime=='--:--'?'00:00':$key->OUTTime,
                        'work_time' => $key->WorkTime,
                        'date' => date('Y-m-d'),
                        'day' => date('d'),
                        'month' => date('m'),
                        'year' => date('Y'),
                        'attendance' => $key->Status,
                        'status' => $key->Status=='P'?1:0,
                    ]);
                }
            }
        }

        $this->info('Attendence Update Successfully');
    }
}
