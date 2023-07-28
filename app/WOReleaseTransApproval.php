<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WOReleaseTransApproval extends Model
{
    public $table = 'release_trans_approval';

    public function getWOMaster()
    {
        return $this->belongsTo(WOMaster::class, 'retr_mstr_id');
    }
}
