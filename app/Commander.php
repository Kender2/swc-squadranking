<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commander extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'playerId';
    protected $guarded = [];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'joinDate',
        'lastLoginTime',
        'lastUpdated'
    ];

    /**
     * Get the squad that the player belongs to.
     */
    public function squad()
    {
        return $this->belongsTo('App\Squad', 'id');
    }
}
