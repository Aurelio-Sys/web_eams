<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTempTable
{
    //

    public function createSparePartUsed($data){
        // dd($data);
        // Schema::dropIfExists('temp_group');
        if(!Schema::hasTable('temp_sp')){
            Schema::create('temp_sp', function ($table) {
                $table->increments('id');
                $table->string('sp_code');
                $table->string('sp_qty_req');
                $table->temporary();
            });
        }
        

        foreach($data as $datas){
            DB::table('temp_sp')->insert([
                'sp_code' => $datas->insd_part,
                'sp_qty_req' => $datas->insd_req,
            ]);
        }

        // $table_sparepart = DB::table('temp_group')->get();

        // dd($table_sparepart);

        // $groupso = DB::table('temp_group')->groupBy('so_nbr')->get();


        // Schema::dropIfExists('temp_group');

        // return [$table_so,$groupso];
    }

    public function createTempCost($data){
        Sche
    }
}
