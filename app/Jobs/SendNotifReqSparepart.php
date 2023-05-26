<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendNotifReqSparepart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $rsnumber;

    public function __construct($rsnumber)
    {
        //
        $this->rsnumber = $rsnumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $rsnumber = $this->rsnumber;

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
            Mail::send('emailreqsp',
                [
                    'rsnumber' => $rsnumber,
                ],function ($message) use($array_email,$rsnumber){
                        $message->subject('eAMS - Sparepart Transfer Needed for '.$rsnumber.'');
                        $message->to($array_email);
                });


            foreach ($getUserWH as $approver) {
                $user = App\User::where('id', '=', $approver->id)->first();
                $details = [
                    'body' => 'Sparepart Transfer Needed',
                    'url' => 'reqsp',
                    'nbr' => $rsnumber,
                    'note' => 'Please check'

                ]; // isi data yang dioper

                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                

            }
        }
        
    }
}
