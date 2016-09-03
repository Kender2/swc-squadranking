@extends('web')

@section('title'){!! $squad->renderNamePlain() !!} Members @endsection
@section('heading')
    <div class="col-lg-6 col-md-8 col-sm-10 col-xs-10">
        <ul class="list-inline nav-justified nav-pills nav">
            <li>{!! $squad->renderName() !!}</li>
            <li><a href="{{ route('squadhistory', ['id' => $squad->id]) }}">War History</a></li>
            <li class="active"><a>Members</a></li>
        </ul>
    </div>@endsection

@section('content')
    <div class="row">

    </div>
    <div class="row">
        {{--<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">--}}
        {{--<table class="table table-bordered table-condensed table-hover bg-{{$squad->faction}}">--}}
        {{--<caption>Totals</caption>--}}
        {{--<tr>--}}
        {{--<td>Faction</td>--}}
        {{--<td class="rank text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<td>Rank</td>--}}
        {{--<td class="rank">{!! $squad->rank !!}</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<td>Wars</td>--}}
        {{--<td class="rank">{{$squad->wars}}</td>--}}
        {{--</tr>--}}
        {{--<tr title="Won {{ round($squad->wins/$squad->wars * 100,1) }}% of wars">--}}
        {{--<td>Wins</td>--}}
        {{--<td class="rank">{{$squad->wins}}</td>--}}
        {{--</tr>--}}
        {{--<tr title="Tied {{ round($squad->draws/$squad->wars * 100,1) }}% of wars">--}}
        {{--<td>Draws</td>--}}
        {{--<td class="rank">{{$squad->draws}}</td>--}}
        {{--</tr>--}}
        {{--<tr title="Lost {{ round($squad->losses/$squad->wars * 100,1) }}% of wars">--}}
        {{--<td>Losses</td>--}}
        {{--<td class="rank">{{$squad->losses}}</td>--}}
        {{--</tr>--}}
        {{--<tr title="Captured an average of {{ round($squad->uplinks_captured/$squad->wars) }} uplinks per war">--}}
        {{--<td>Uplinks captured</td>--}}
        {{--<td class="rank">{{$squad->uplinks_captured}}</td>--}}
        {{--</tr>--}}
        {{--<tr title="Saved an average of {{ round($squad->uplinks_saved/$squad->wars) }} uplinks per war">--}}
        {{--<td>Uplinks saved</td>--}}
        {{--<td class="rank">{{$squad->uplinks_saved}}</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<td>TrueSkill™</td>--}}
        {{--<td class="rank">{{$squad->skill}}</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<td>Last updated</td>--}}
        {{--<td class="rank">{{$squad->updated_at->diffForHumans()}}</td>--}}
        {{--</tr>--}}
        {{--</table>--}}

        {{--</div>--}}
        <div class="col-lg-10 col-md-8 col-sm-9 col-xs-10">
            <table class="table table-striped table-bordered table-hover">
                <caption class="strong">Squad members</caption>
                <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th class="rank">Donated</th>
                    <th class="rank">Received</th>
                    {{--<th class="rank">HQ</th>--}}
                    <th class="rank">Rep invested</th>
                    <th class="rank">Base score</th>
                    <th class="rank">Medals</th>
                    <th class="rank">Att. won</th>
                    <th class="rank">Def. won</th>
                    <th>Joined</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    <tr>
                        @if ($member->isOwner)
                            <td class="rank"><span class="glyphicon glyphicon-king" title="Owner"></span></td>
                        @elseif($member->isOfficer)
                            <td class="rank"><span class="glyphicon glyphicon-certificate" title="Officer"></span></td>
                        @else
                            <td class="rank"></td>
                        @endif
                        <td>{{$member->name}}</td>
                        <td class="rank">{{$member->troopsDonated}}</td>
                        <td class="rank">{{$member->troopsReceived}}</td>
                        {{--                        <td class="rank">{{$member->hqLevel}}</td>--}}
                        <td class="rank">{{$member->reputationInvested}}</td>
                        <td class="rank">{{$member->xp}}</td>
                        <td class="rank">{{$member->score}}</td>
                        <td class="rank">{{$member->attacksWon}}</td>
                        <td class="rank">{{$member->defensesWon}}</td>
                        <td>{{$member->joinDate->toDateString()}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <small>*Note: <em>Wars from before June 22nd 2016 are not included.</em></small>
        </div>
    </div>
@endsection

