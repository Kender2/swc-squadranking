<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class PlayerPool
{

    /**
     * The expiration time of a player in minutes.
     *
     * @var int|null
     */
    protected $expire = 180;


    public function getPlayer()
    {
        $player = $this->getNextAvailablePlayer();
        if (!$player) {
            $this->addNewPlayer();
        }
    }


    /**
     * Get the next available player from the pool.
     *
     * @return \StdClass|null
     * @throws \InvalidArgumentException
     */
    protected function getNextAvailablePlayer()
    {
        $player = Player::getQuery()->lockForUpdate()->where(function ($query) {
            $this->isAvailable($query);
            $this->isReservedButExpired($query);
        })->orderBy('lastLoginTime', 'asc')->first();

        return $player ? (object)$player : null;
    }


    /**
     * Modify the query to check for available players.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isAvailable(Builder $query)
    {
        $query->where(function ($query) {
            $query->where('reserved', 0);
            $query->where('banned', 0);
        });
    }


    /**
     * Modify the query to check for players that are reserved but have expired.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     *
     * @return void
     */
    protected function isReservedButExpired(Builder $query)
    {
        $expiration = Carbon::now()->subMinutes($this->expire)->getTimestamp();

        $query->orWhere(function ($query) use ($expiration) {
            $query->where('reserved', 1);
            $query->where('reserved_at', '<=', $expiration);
        });
    }


    protected function addPlayerToPool($player)
    {
        $player = $client->createNewPlayer();
    }


    /**
     * Mark the given player ID as reserved.
     *
     * @param Player $player
     *
     * @return Player
     */
    protected function markPlayerAsReserved(Player $player)
    {
        $player->reserved = 1;
        $player->reserved_at = $this->getTime();
        $player->save();

        return $player;
    }


    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    protected function getTime()
    {
        return time();
    }

}
