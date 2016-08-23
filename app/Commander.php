<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commander extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'playerId';
    protected $guarded = [];
}
