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

class SendWorkOrderCanceledNotification implements ShouldQueue
// class SendWorkOrderCanceledNotification
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $failOnTimeout = false;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $wonumber;
    protected $srnumber;
    protected $notecancel;
    protected $notiftype;
    public function __construct($wonumber, $srnumber, $notecancel, $notiftype)
    {
        //
        $this->wonumber = $wonumber;
        $this->srnumber = $srnumber;
        $this->notecancel = $notecancel;
        $this->notiftype = $notiftype;
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
        $srnumber = $this->srnumber;
        $notecancel = $this->notecancel;
        $notiftype = $this->notiftype;

        if ($notiftype == 'cancel') {
            $getdatasr = DB::table('service_req_mstr')
                ->where('sr_number', '=', $srnumber)
                ->where('wo_number', '=', $wonumber)
                ->first();


            $getemail = DB::table('users')
                ->where('username', $getdatasr->sr_req_by)
                ->first();

            Mail::send(
                'emailsendwocancel',
                [
                    'name' => $getemail->name,
                    'wonumber' => $wonumber,
                    'cancellationNote' => $notecancel,
                    'email' => $getemail->email_user,
                    'srnumber' => $srnumber
                ],
                function ($message) use ($getemail, $wonumber) {
                    $message->subject('eAMS - Service Request Update: Work Order ' . $wonumber . ' Has Been Canceled');
                    $message->to($getemail->email_user);
                }
            );

            $user = App\User::where('id', '=', $getemail->id)->first();
            $details = [
                'body' => 'Service Request Update',
                'url' => 'srbrowse',
                'nbr' => $srnumber,
                'note' => 'Service Request Status Canceled. Please check'

            ]; // isi data yang dioper


            $user->notify(new \App\Notifications\eventNotification($details));
        }

        if ($notiftype == 'delete') {
            $getdatasr = DB::table('service_req_mstr')
                ->where('sr_number', '=', $srnumber)
                ->first();


            $getemail = DB::table('users')
                ->where('username', $getdatasr->sr_req_by)
                ->first();

            Mail::send(
                'emailsendwodelete',
                [
                    'name' => $getemail->name,
                    'wonumber' => $wonumber,
                    'cancellationNote' => $notecancel,
                    'email' => $getemail->email_user,
                    'srnumber' => $srnumber
                ],
                function ($message) use ($getemail, $wonumber) {
                    $message->subject('eAMS - Service Request Update: Work Order ' . $wonumber . ' Has Been Deleted');
                    $message->to($getemail->email_user);
                }
            );

            $user = App\User::where('id', '=', $getemail->id)->first();
            $details = [
                'body' => 'Service Request Update',
                'url' => 'srbrowse',
                'nbr' => $srnumber,
                'note' => 'Service Request Status Open. Please check'

            ]; // isi data yang dioper


            $user->notify(new \App\Notifications\eventNotification($details));
        }
    }
}
