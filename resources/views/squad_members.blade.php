@extends('web')

@section('title'){!! $squad->renderNamePlain() !!} Members @endsection
@section('heading')
    <div class="col-lg-6 col-md-8 col-sm-10 col-xs-10">
        <ul class="list-inline nav-justified nav-pills nav">
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
        <div class="col-lg-8 col-md-9 col-sm-10 col-xs-10">
            <table class="table table-striped table-bordered table-hover">
                <caption class="text-info">Squad members</caption>
                <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th class="rank hidden-xs">Donated</th>
                    <th class="rank hidden-xs">Received</th>
                    <th class="rank hidden-xs hidden-sm">HQ</th>
                    <th class="rank hidden-xs hidden-sm">Rep invested</th>
                    <th class="rank">Base strength</th>
                    <th class="rank">Medals</th>
                    <th class="rank">Att. won</th>
                    <th class="rank">Def. won</th>
                    <th class="hidden-xs hidden-sm">Joined</th>
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
@endsection

