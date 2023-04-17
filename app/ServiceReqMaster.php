<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ServiceReqMaster extends Model
{
    
    public $table = 'service_req_mstr';

    public function getAllApprover()
    {
        return $this->hasMany(ServiceTransApproval::class, 'srta_mstr_id');
    }

    public function getCurrentApprover()
    {
        return $this->hasOne(ServiceTransApproval::class, 'srta_mstr_id')->where('srta_status', '=', 'Waiting for department approval')->orWhere('srta_status', 'Need revise')->orderBy('srta_sequence');
    }

    public function getSRTransAppr()
    {
        if (Auth::user()->role_user == 'ADMIN') {
            return $this->hasOne(ServiceTransApproval::class, 'srta_mstr_id');            
        } else {
            return $this->hasOne(ServiceTransApproval::class, 'srta_mstr_id')->where('srta_dept_approval', Auth::user()->dept_user)->where('srta_role_approval', Auth::user()->role_user);
        }
   }

   public function getUser()
    {
        return $this->belongsTo(User::class, 'sr_req_by');
    }
}
