<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPGroupMstr extends Model
{
    //

    public $table = 'sp_group';

    protected $fillable = [
        'ID',
        'spg_code',
        'spg_desc',
    ];
}
