<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPMstr extends Model
{
    //

    public $table = 'sp_mstr';

    protected $fillable = [
        'ID',
        'spm_code',
        'spm_desc',

    ];
}
