<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppMstr extends Model
{
    //
    public $table = 'supp_mstr';

    protected $fillable = [
        'ID',
        'supp_code',
        'supp_desc',
        'created_at',
        'updated_at'
    ];
}
