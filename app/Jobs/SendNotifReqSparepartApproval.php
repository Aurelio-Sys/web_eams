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

// class SendNotifReqSparepartApproval implements ShouldQueue
class SendNotifReqSparepartApproval
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $rsnumber;
    protected $wonumber;
    protected $userrole;
    protected $userdept;

    public function __construct($rsnumber,$wonumber,$userrole,$userdept)
    {
        //
        $this->rsnumber = $rsnumber;
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
        $rsnumber = $this->rsnumber;
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
            Mail::send('emailsend-reqspapproval',
                [
                    'rsnumber' => $rsnumber,
                    'wonumber' => $wonumber,
                ],function ($message) use($array_email,$rsnumber){
                        $message->subject('eAMS - Request Sparepart Approval Needed for '.$rsnumber.'');
                        $message->to($array_email);
                });


            foreach ($getUsersEmail as $approver) {
                $user = App\User::where('id', '=', $approver->id)->first();
                $details = [
                    'body' => 'Request Sparepart Approval needed for '.$rsnumber.'',
                    'url' => 'woreleaseapprovalbrowse',
                    'nbr' => $rsnumber,
                    'note' => 'Please review and provide approval promptly'

                ]; // isi data yang dioper

                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                

            }
        }
    }
}
