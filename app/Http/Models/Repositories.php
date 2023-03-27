<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Repositories extends Model
{
    // protected $table = 'ag_grid';

    protected $fillable = [
        'name',
        'type',
        'actions',
        'used_space',
        'is_active'
    ];
}
