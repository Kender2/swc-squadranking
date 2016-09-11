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
        <div class="col-lg-10 col-md-8 col-sm-9 col-xs-10">
            <table class="table table-striped table-bordered table-hover">
                <caption class="text-info">Squad members</caption>
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

