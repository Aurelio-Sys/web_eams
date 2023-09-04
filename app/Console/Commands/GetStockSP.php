<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetStockSP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getdata:stocksp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengambil data stock spare part dari QAD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    private function httpHeader($req)
    {
        return array(
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: ""',        // jika tidak pakai SOAPAction, isinya harus ada tanda petik 2 --> ""
            'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req))
        );
    }

    public function handle()
    {
        //

        DB::beginTransaction();

        try {

            

        
            DB::commit();

            Log::channel('customlog')->info('Update Stock Berhasil');
        } catch (Exception $err) {
            DB::rollBack();
            Log::channel('customlog')->info('Update Stock Gagal : '.$err.'');
        }
    }
}
