<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceTransApproval extends Model
{
    public $table = 'sr_trans_approval';

    public $timestamps = true;

    public function getDeptApprover()
    {
        return $this->belongsTo(User::class, 'srta_dept_approval');
    }

    public function getRoleApprover()
    {
        return $this->belongsTo(User::class, 'srta_role_approval');
    }

    public function getSRMaster()
    {
        return $this->belongsTo(ServiceReqMaster::class, 'srta_mstr_id');
    }
}
