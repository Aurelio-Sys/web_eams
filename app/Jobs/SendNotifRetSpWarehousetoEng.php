<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App;
use Illuminate\Support\Facades\Mail;

// class SendNotifRetSpWarehousetoEng implements ShouldQueue
class SendNotifRetSpWarehousetoEng
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


        $getdatars = DB::table('ret_sparepart')
            ->where('ret_sp_number', '=', $rsnumber)
            ->first();

        // $emails = '';
        $getemail = DB::table('users')
            ->where('username', '=', $getdatars->ret_sp_return_by)
            ->first();

        // $emails .= $getemail->email_user.',';

        $user = App\User::where('id', '=', $getemail->id)->first();
        $details = [
            'body' => 'Sparepart Return Success for ' . $rsnumber . '',
            'url' => 'retsp',
            'nbr' => $rsnumber,
            'note' => 'Please check'

        ]; // isi data yang dioper

        $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                

        Mail::send('emailretspwhtoeng', [
            'rsnumber' => $rsnumber,
        ], function ($message) use ($getemail, $rsnumber) {
            $message->subject('eAMS - Sparepart Return Success for ' . $rsnumber . '');
            $message->to($getemail->email_user);
        });
    }
}
