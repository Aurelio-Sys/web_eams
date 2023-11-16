<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailWOGen /*implements ShouldQueue */
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $failOnTimeout = false;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $pesan;
    public function __construct($pesan)
    {
        //

        $this->pesan = $pesan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $pesan = $this->pesan;

        $file_path = storage_path('app/temp_excel_wogenerate.xlsx');

        Mail::send(
            'email.emailwogenerate',
            [
                'pesan' => $pesan,
            ],
            function ($message) /*use ($alamatemail) */ use($file_path) {
                $message->subject('WO Generator Create');
                $message->to('tommy@ptimi.co.id');
                $message->attach($file_path);
            }
        );
    }
}
