<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPTypeMstr extends Model
{
    //

    public $table = 'sp_type';

    protected $fillable = [
        'ID',
        'spt_code',
        'spt_desc'
    ];
}
