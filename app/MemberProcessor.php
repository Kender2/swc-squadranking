<?php
namespace App;


use Carbon\Carbon;
use Log;

class MemberProcessor
{

    /**
     * Store member information on a squad.
     *
     * @param array $members
     * @param Squad $squad
     */
    public function processMembers($members, $squad)
    {
        // Delete all squad members first.
        $squad->members()->delete();
        // Add the current members.
        foreach ($members as $member) {
            try {
                Commander::findOrNew($member->playerId)
                    ->fill([
                        'playerId' => $member->playerId,
                        'name' => $member->name,
                        'isOwner' => $member->isOwner,
                        'isOfficer' => $member->isOfficer,
                        'joinDate' => Carbon::createFromTimestampUTC($member->joinDate),
                        'troopsDonated' => $member->troopsDonated,
                        'troopsReceived' => $member->troopsReceived,
                        'hqLevel' => $member->hqLevel,
                        'reputationInvested' => $member->reputationInvested,
                        'xp' => $member->xp,
                        'score' => $member->score,
                        'attacksWon' => $member->attacksWon,
                        'defensesWon' => $member->defensesWon,
                        'planet' => $this->mapPlanet($member->planet),
                        'lastLoginTime' => Carbon::createFromTimestampUTC($member->lastLoginTime),
                        'lastUpdated' => Carbon::createFromTimestampUTC($member->lastUpdated),
                        'squadId' => $squad->id,
                        'faction' => $squad->faction,
                    ])
                    ->save();
            } catch (\Exception $e) {
                Log::error('Duplicate ID? ' . $member->playerId);
            }
        }
    }

    /**
     * Map internal planet ids to human readable names.
     *
     * @param string $planet
     * @return string
     */
    protected function mapPlanet($planet)
    {
        $mapping = [
            'planet1' => 'Tatooine',
            'planet21' => 'Hoth',
            'planet22' => 'Kashyyyk',
            'planet23' => 'Takodana',
            'planet3' => 'Dandoran',
            'planet6' => 'Er\'Kit',
            'planet8' => 'Yavin 4',
        ];
        if (array_key_exists($planet, $mapping)) {
            return $mapping[$planet];
        }
        return 'Unknown';
    }

}
