<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocMstr extends Model
{
    public $table = 'loc_mstr';

    protected $fillable = [
        'id',
        'loc_site',
        'loc_code',
        'loc_desc'
    ];
}
