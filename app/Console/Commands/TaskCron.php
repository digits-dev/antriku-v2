<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use CRUDBooster;
use DB;

class TaskCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $data = array();
        $checkDate = DB::table('returns_appointment')->where('scheduled_date','>',date("Y-m-d"))->where('email_reminder','NO')->where('appointment_status','BOOKED')->orderby('scheduled_date')->first();

        if(!empty($checkDate)){
	    
    		$appointment = DB::table('returns_appointment')->leftjoin('branch', 'returns_appointment.branch_id', '=', 'branch.id')->where('returns_appointment.id',$checkDate->id)->first();  
    
    		$data['reference_no'] = $appointment->reference_no;
    		$data['firstname'] = $appointment->firstname;
    		$data['lastname'] = $appointment->lastname;
    		$data['email'] = $appointment->email;
    		$data['branch_name'] = $appointment->branch_name;
    		$data['branch_address'] = $appointment->branch_address;
    		$data['scheduled_date'] = date('F j, Y', strtotime($appointment->scheduled_date));
    		$data['scheduled_time'] = date('g:i A', strtotime($appointment->scheduled_time));
    		
    	
		    if(date("Y-m-d", strtotime('2 days')) == date('Y-m-d', strtotime($checkDate->scheduled_date)))
            {
                CRUDBooster::sendEmail(['to'=>$appointment->email, 'data'=>$data, 'template'=>'reminder_appointment_email','attachments'=>[]]);
                
                DB::table('returns_appointment')->where('returns_appointment.id',$checkDate->id)->where('email_reminder','NO')->update([
    		        'email_reminder' => 'YES'
    	        ]);
    		    
		        Log::info("Appointment Reminder Email sent to: ". $appointment->reference_no);
            }
        }

        $this->info('Demo:Cron Command Run successfully!');
    }
}
