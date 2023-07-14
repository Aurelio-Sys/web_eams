<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAlertRoutineCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $datasendalert;
    protected $datarcm;

    public function __construct($datasendalert,$datarcm)
    {
        //
        $this->datasendalert = $datasendalert;
        $this->datarcm = $datarcm;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $datasendalert = $this->datasendalert;
        $datarcm = $this->datarcm;

        $emailreceiver = $datarcm->ra_emailalert;
        $asset = $datarcm->asset_desc;

        Mail::send('emailalertroutinecheck',[
            'datasendalert' => $datasendalert,
            'datarcm' => $datarcm,
        ],function ($message) use ($emailreceiver, $asset){
            $message->subject('eAMS - Alert From Routine Check for Asset '.$asset.' ');
            $message->to($emailreceiver);
        });


    }
}
