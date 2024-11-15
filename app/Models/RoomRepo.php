<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomRepo extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'owner',
        'repository',
        'branch',
    ];
}
