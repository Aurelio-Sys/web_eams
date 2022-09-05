<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMstr extends Model
{
    //

    public $table = 'site_mstrs';

    protected $fillable = [
        'site_code',
        'site_desc',
        'created_at',
        'updated_at'
    ];
}
