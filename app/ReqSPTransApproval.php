<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReqSPTransApproval extends Model
{
    public $table = 'reqsp_trans_approval';

    public function getReqSPMstr()
    {
        return $this->belongsTo(ReqSPMstr::class, 'rqtr_mstr_id');
    }
}
