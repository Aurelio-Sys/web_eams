<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReqSPMstr extends Model
{
    public $table = 'req_sparepart';

    public function getCurrentApprover()
    {
        return $this->hasOne(ReqSPTransApproval::class, 'rqtr_mstr_id')
            ->where('rqtr_status', '=', 'waiting for approval')
            ->orWhere('rqtr_status', '=', 'approved')
            ->orWhere('rqtr_status', '=', 'rejected')
            ->orderBy('rqtr_sequence');
    }

    public function getReqSPTransAppr()
    {
        if (Auth::user()->role_user == 'ADMIN') {
            return $this->hasOne(ReqSPTransApproval::class, 'rqtr_mstr_id');            
        } else {
            return $this->hasOne(ReqSPTransApproval::class, 'rqtr_mstr_id')->where('rqtr_role_approval', Auth::user()->role_user);
        }
   }
}
