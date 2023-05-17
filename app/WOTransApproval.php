<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WOTransApproval extends Model
{
    public $table = 'wo_trans_approval';

    public function getWOMaster()
    {
        return $this->belongsTo(WOMaster::class, 'wotr_mstr_id');
    }
}
