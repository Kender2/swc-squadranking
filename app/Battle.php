<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    public $fillable = ['id', 'squad_id', 'score', 'opponent_id', 'opponent_id', 'end_date'];
    
}
