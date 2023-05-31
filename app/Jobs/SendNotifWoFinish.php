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

class SendNotifWoFinish implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $wonumber;
    protected $userrole;

    public function __construct($wonumber,$userrole)
    {
        //
        $this->wonumber = $wonumber;
        $this->userrole = $userrole;
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
        $userrole = $this->userrole;

        $getUsersEmail = DB::table('users')
                            ->where('role_user', '=', $userrole)
                            ->where('active', '=', 'Yes')
                            ->get();

        $emails = '';
        
        foreach ($getUsersEmail as $email) {
            $emails .= $email->email_user . ',';
        }

        $emails = substr($emails, 0, strlen($emails) - 1);
        
        $array_email = explode(',', $emails);

        if ($getUsersEmail->count()){
            Mail::send('emailsend-wofinish',
                [
                    'wonumber' => $wonumber,
                ],function ($message) use($array_email,$wonumber){
                        $message->subject('eAMS - Work Order Approval Needed for '.$wonumber.'');
                        $message->to($array_email);
                });


            foreach ($getUsersEmail as $approver) {
                $user = App\User::where('id', '=', $approver->id)->first();
                $details = [
                    'body' => 'Work Order Approval needed for '.$wonumber.'',
                    'url' => 'woapprovalbrowse',
                    'nbr' => $wonumber,
                    'note' => 'Please review and provide approval promptly'

                ]; // isi data yang dioper

                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                

            }
        }
    }
}
