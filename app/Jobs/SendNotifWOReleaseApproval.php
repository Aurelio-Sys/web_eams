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

class SendNotifWOReleaseApproval implements ShouldQueue
// class SendNotifWOReleaseApproval
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $failOnTimeout = false;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $wonumber;
    protected $userrole;
    protected $userdept;

    public function __construct($wonumber,$userrole,$userdept)
    {
        //
        $this->wonumber = $wonumber;
        $this->userrole = $userrole;
        $this->userdept = $userdept;
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
        $userdept = $this->userdept;

        $getUsersEmail = DB::table('users')
                            ->where('role_user', '=', $userrole)
                            ->where('dept_user', '=', $userdept)
                            ->where('active', '=', 'Yes')
                            ->get();

        $emails = '';
        
        foreach ($getUsersEmail as $email) {
            $emails .= $email->email_user . ',';
        }

        $emails = substr($emails, 0, strlen($emails) - 1);
        
        $array_email = explode(',', $emails);

        if ($getUsersEmail->count()){
            Mail::send('emailsend-woreleaseapproval',
                [
                    'wonumber' => $wonumber,
                ],function ($message) use($array_email,$wonumber){
                        $message->subject('eAMS - Work Order Release Approval Needed for '.$wonumber.'');
                        $message->to($array_email);
                });


            foreach ($getUsersEmail as $approver) {
                $user = App\User::where('id', '=', $approver->id)->first();
                $details = [
                    'body' => 'Work Order Release Approval needed for '.$wonumber.'',
                    'url' => 'woreleaseapprovalbrowse',
                    'nbr' => $wonumber,
                    'note' => 'Please review and provide approval promptly'

                ]; // isi data yang dioper

                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                

            }
        }
    }
}
