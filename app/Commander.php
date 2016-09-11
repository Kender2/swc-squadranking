<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Commander
 *
 * @property string $playerId
 * @property string $squadId
 * @property string $name
 * @property boolean $isOwner
 * @property boolean $isOfficer
 * @property \Carbon\Carbon $joinDate
 * @property integer $troopsDonated
 * @property integer $troopsReceived
 * @property boolean $hqLevel
 * @property integer $reputationInvested
 * @property integer $xp
 * @property integer $score
 * @property integer $attacksWon
 * @property integer $defensesWon
 * @property \Carbon\Carbon $lastLoginTime
 * @property \Carbon\Carbon $lastUpdated
 * @property string $faction
 * @property string $planet
 * @property-read \App\Squad $squad
 * @method static \Illuminate\Database\Query\Builder|\App\Commander wherePlayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereSquadId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereIsOwner($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereIsOfficer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereJoinDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereTroopsDonated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereTroopsReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereHqLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereReputationInvested($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereXp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereScore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereAttacksWon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereDefensesWon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereLastLoginTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereLastUpdated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander whereFaction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Commander wherePlanet($value)
 * @mixin \Eloquent
 */
class Commander extends Model
{
    use StatisticsTrait;

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

    /**
     * @param array $factions
     * @return array
     */
    public static function getStats(array $factions = ['empire', 'rebel'])
    {
        $columns = [
            'Amount' => 'count(1)',
            'Avg donated' => 'avg(troopsDonated)',
            'Avg received' => 'avg(troopsReceived)',
            'Avg HQ level' => 'avg(hqLevel)',
            'Avg rep invested' => 'avg(reputationInvested)',
            'Avg base score' => 'avg(xp)',
            'Avg medals' => 'avg(score)',
            'Avg attacks won' => 'avg(attacksWon)',
            'Avg defenses won' => 'avg(defensesWon)',
        ];
        $stats = self::getStatsForFactions($factions, $columns);
        self::addTotalsToStats($stats);

        return $stats;
    }

}
