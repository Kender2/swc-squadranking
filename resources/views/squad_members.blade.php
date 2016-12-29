@extends('web')

@section('title'){!! $squad->renderNamePlain() !!} Members @endsection
@section('heading')
    <div class="col-lg-6 col-md-8 col-sm-10 col-xs-10">
        <ul class="nav-justified nav-pills nav">
            <li>{!! $squad->renderName() !!}</li>
            <li><a href="{{ route('squadhistory', ['id' => $squad->id]) }}">War History</a></li>
            <li class="active"><a>Members</a></li>
            <li><a href="{{ route('squadpredict', ['id' => $squad->id]) }}">Predict</a></li>
        </ul>
    </div>@endsection

@section('content')
    <div class="row">

    </div>
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
            <table class="table table-bordered table-condensed table-hover bg-{{$squad->faction}}">
                <caption class="text-info">Current member stats</caption>
                <tr>
                    <td>Faction</td>
                    <td class="rank text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>
                </tr>
                @foreach($stats as $label => $value)
                    <tr>
                        <td>{!! $label !!}</td>
                        <td class="rank">{{number_format($value)}}</td>
                    </tr>
                @endforeach
            </table>

        </div>
        <div class="col-lg-8 col-md-9 col-sm-10 col-xs-10">
            <table class="table table-striped table-bordered table-hover">
                <caption class="text-info">Squad members</caption>
                <thead>
                <tr>
                    <th></th>
                    <th>@sortablelink('name', 'Name')</th>
                    <th class="rank hidden-xs">@sortablelink('troopsDonated', 'Donated')</th>
                    <th class="rank hidden-xs">@sortablelink('troopsReceived', 'Received')</th>
                    <th class="rank hidden-xs hidden-sm">@sortablelink('hqLevel', 'HQ')</th>
                    <th class="rank hidden-xs hidden-sm">@sortablelink('reputationInvested', 'Rep invested')</th>
                    <th class="rank">@sortablelink('xp', 'Base strength')</th>
                    <th class="rank">@sortablelink('score', 'Medals')</th>
                    <th class="rank">@sortablelink('attacksWon', 'Att. won')</th>
                    <th class="rank">@sortablelink('defensesWon', 'Def. won')</th>
                    <th class="hidden-xs hidden-sm">@sortablelink('joinDate', 'Joined')</th>
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
                        <td class="rank hidden-xs">{{number_format($member->troopsDonated)}}</td>
                        <td class="rank hidden-xs">{{number_format($member->troopsReceived)}}</td>
                        <td class="rank hidden-xs hidden-sm">{{number_format($member->hqLevel)}}</td>
                        <td class="rank hidden-xs hidden-sm">{{number_format($member->reputationInvested)}}</td>
                        <td class="rank">{{number_format($member->xp)}}</td>
                        <td class="rank">{{number_format($member->score)}}</td>
                        <td class="rank">{{number_format($member->attacksWon)}}</td>
                        <td class="rank">{{number_format($member->defensesWon)}}</td>
                        <td class="hidden-xs hidden-sm">{{$member->joinDate->toDateString()}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <small>*Note: <em>Only members present the last time the bot checked this squad are shown.</em></small>
        </div>
    </div>
@endsection
