<?php
namespace App;


use Carbon\Carbon;

class MemberProcessor
{

    public function processMembers($members, $squad)
    {
        /*
            "name" : "Lord Byron",
            "isOwner" : false,
            "isOfficer" : true,
            "joinDate" : 1431883988,
            "troopsDonated" : 5296,
            "troopsReceived" : 5163,
            "hqLevel" : 9,
            "reputationInvested" : 52,
            "xp" : 2336,
            "score" : 12626,
            "attacksWon" : 2093,
            "defensesWon" : 811,
            "lastLoginTime" : 1471768278,
            "lastUpdated" : 1471768288,
            "playerId" : "fe6138ab-8846-11e4-a398-06c322004ec3"
         */
        foreach ($members as $member) {
            $commander = Commander::firstOrNew(['playerId' => $member->playerId]);
            $commander->name = $member->name;
            $commander->isOwner = $member->isOwner;
            $commander->isOfficer = $member->isOfficer;
            $commander->joinDate = Carbon::createFromTimestampUTC($member->joinDate);
            $commander->troopsDonated = $member->troopsDonated;
            $commander->troopsReceived = $member->troopsReceived;
            $commander->hqLevel = $member->hqLevel;
            $commander->reputationInvested = $member->reputationInvested;
            $commander->xp = $member->xp;
            $commander->score = $member->score;
            $commander->attacksWon = $member->attacksWon;
            $commander->defensesWon = $member->defensesWon;
            $commander->lastLoginTime = Carbon::createFromTimestampUTC($member->lastLoginTime);
            $commander->lastUpdated = Carbon::createFromTimestampUTC($member->lastUpdated);
            $commander->squadId = $squad->id;
            $commander->faction = $squad->faction;
            $commander->save();
        }

    }

}
