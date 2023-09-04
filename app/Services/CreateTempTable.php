<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTempTable
{
    //

    public function createSparePartUsed($data)
    {
        // dd($data);
        // Schema::dropIfExists('temp_group');
        if (!Schema::hasTable('temp_sp')) {
            Schema::create('temp_sp', function ($table) {
                $table->increments('id');
                $table->string('sp_code');
                $table->string('sp_qty_req');
                $table->temporary();
            });
        }


        foreach ($data as $datas) {
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

    public function createTempCost($data)
    {
        Schema::create('temp_cost', function ($table) {
            $table->string('cost_dom')->nullable();
            $table->string('cost_site')->nullable();
            $table->string('cost_part')->nullable();
            $table->float('cost_cost', 15, 2);
        });

        foreach ($data as $datas) {
            DB::table('temp_cost')->insert([
                'cost_dom' => $datas->t_domain,
                'cost_site' => $datas->t_site,
                'cost_part' => $datas->t_part,
                'cost_cost' => $datas->t_cost,
            ]);
        }

        $table_cost = DB::table('temp_cost')->get();

        Schema::dropIfExists('temp_cost');

        return [$table_cost];
    }

    public function invstockDetail($data){
        Schema::create('temp_invstock', function ($table) {
            $table->string('part')->nullable();
            $table->string('partdesc')->nullable();
            $table->string('site')->nullable();
            $table->string('loc')->nullable();
            $table->string('locdesc')->nullable();
            $table->string('lot')->nullable();
            $table->float('qtyoh', 15, 2);
        });

        foreach ($data as $datas) {
            DB::table('temp_invstock')->insert([
                'part' => $datas->t_part,
                'partdesc' => $datas->t_partdesc,
                'site' => $datas->t_site,
                'loc' => $datas->t_loc,
                'locdesc' => $datas->t_locdesc,
                'lot' => $datas->t_lot,
                'qtyoh' => $datas->t_qtyoh,
            ]);
        }

        $table_invstock = DB::table('temp_invstock')->orderBy('part','asc')->get();

        Schema::dropIfExists('temp_invstock');

        return [$table_invstock];
    }
}
