<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App;

class SendWorkOrderWarehouseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $failOnTimeout = false;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $wonumber;

    public function __construct($wonumber)
    {
        //
        $this->wonumber = $wonumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $wonumber = $this->wonumber;

        $getUserWH = DB::table('users')
                        ->where('role_user', '=', 'WHS')
                        ->where('active','=', 'Yes')
                        ->get();

        $emails = '';

        foreach ($getUserWH as $email) {
            $emails .= $email->email_user . ',';
        }

        $emails = substr($emails, 0, strlen($emails) - 1);
        
        $array_email = explode(',', $emails);
        
        if ($getUserWH->count()){
            Mail::send('emailsendtowh',
                [
                    'wonumber' => $wonumber,
                ],function ($message) use($array_email,$wonumber){
                        $message->subject('eAMS - Work Order Transfer Needed for '.$wonumber.'');
                        $message->to($array_email);
                });


            foreach ($getUserWH as $approver) {
                $user = App\User::where('id', '=', $approver->id)->first();
                $details = [
                    'body' => 'Work Order Transfer Needed',
                    'url' => 'womaint',
                    'nbr' => $wonumber,
                    'note' => 'Please check'

                ]; // isi data yang dioper

                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                

            }
        }
        
    }
}
