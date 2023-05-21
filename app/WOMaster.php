<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WOMaster extends Model
{
    public $table = 'wo_mstr';

    public function getCurrentApprover()
    {
        return $this->hasOne(WOTransApproval::class, 'wotr_mstr_id')
            ->where('wotr_status', '=', 'waiting for approval')
            ->orWhere('wotr_status', '=', 'need revision')
            ->orderBy('wotr_sequence');
    }

    public function getWOTransAppr()
    {
        if (Auth::user()->role_user == 'ADMIN') {
            return $this->hasOne(WOTransApproval::class, 'wotr_mstr_id');            
        } else {
            return $this->hasOne(WOTransApproval::class, 'wotr_mstr_id')->where('wotr_role_approval', Auth::user()->role_user);
        }
   }
}
