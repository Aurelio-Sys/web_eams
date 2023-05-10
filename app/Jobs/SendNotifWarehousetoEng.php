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

class SendNotifWarehousetoEng implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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


        $getdatawo = DB::table('wo_mstr')
                    ->where('wo_number', '=', $wonumber)
                    ->first();

        $engineerlist_array = explode(';', $getdatawo->wo_list_engineer);

        $emails = '';
        foreach($engineerlist_array as $username){
            $getemail = DB::table('users')
                        ->where('username','=', $username)
                        ->first();

            $emails .= $getemail->email_user.',';

            $user = App\User::where('id', '=', $getemail->id)->first();
            $details = [
                'body' => 'Work Order Transfer Success for '.$wonumber.'',
                'url' => 'wojoblist',
                'nbr' => $wonumber,
                'note' => 'Please check'

            ]; // isi data yang dioper

            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                
        }

        $emails = substr($emails, 0, strlen($emails) - 1);
        
        $array_email = explode(',', $emails);

        Mail::send('emailsendwhtoeng',[
            'wonumber' => $wonumber,
        ],function ($message) use($array_email,$wonumber){
            $message->subject('eAMS - Work Order Transfer Success for '.$wonumber.'');
            $message->to($array_email);
        });


    }
}
