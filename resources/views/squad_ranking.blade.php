@extends('web')

@section('title')SQUAD WAR RANKING @endsection
@section('heading')SQUAD WAR RANKING <em class="text-danger">*BETA*</em> @endsection

@section('content')
    <div class="row">
        <div class="col-lg-2 col-sm-2 col-md-3 col-xs-7">
            <table class="table table-bordered table-condensed table-hover">
                <caption class="text-info">Statistics</caption>
                <tr>
                    <td>Squads in database:</td>
                    <td class="rank">{{ number_format(\App\Squad::whereIn('faction', ['rebel', 'empire'])->count()) }}</td>
                </tr>
                <tr>
                    <td>Wars in database:</td>
                    <td class="rank">{{ number_format(\App\Battle::count()) }}</td>
                </tr>
                <tr>
                    <td>Latest battle:</td>
                    <td class="rank">{{ \App\Battle::mostRecentBattleDate()->diffForHumans() }}</td>
                </tr>
                <tr>
                    <td colspan="2"><a href="{{ route('stats') }}">more stats..</a></td>
                </tr>
            </table>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-7 col-xs-10">
            <h3 class="pull-left">Ranks {{ $squads->firstItem() }} - {{ $squads->lastItem() }}</h3>
            {!! $squads->render() !!}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="rank">Rank</th>
                    <th>Name</th>
                    <th class="rank">Skill points</th>
                    <th class="rank hidden-xs">Avg base strength</th>
                    <th class="rank">Won</th>
                    <th class="rank">Tied</th>
                    <th class="rank">Lost</th>
                    <th class="rank hidden-xs">UL killed</th>
                    <th class="rank hidden-xs">UL saved</th>
                    <th>Faction</th>
                </tr>
                </thead>
                @foreach($squads as $index => $squad)
                    <tr class="bg-{{$squad->faction}}">
                        <td class="rank">{{$index + $squads->firstItem()}}</td>
                        <td><a href="{{ route('squadhistory', ['id' => $squad->id]) }}">{!! $squad->renderName() !!}</a></td>
                        <td class="rank">{{number_format($squad->skill)}}</td>
                        <td class="rank hidden-xs">{{number_format($squad->averageBaseScore)}}</td>
                        <td class="rank" title="{{ number_format($squad->wins/$squad->wars * 100,1) }}%">{{number_format($squad->wins)}}</td>
                        <td class="rank" title="{{ number_format($squad->draws/$squad->wars * 100,1) }}%">{{number_format($squad->draws)}}</td>
                        <td class="rank" title="{{ number_format($squad->losses/$squad->wars * 100,1) }}%">{{number_format($squad->losses)}}</td>
                        <td class="rank hidden-xs" title="{{ number_format($squad->uplinks_captured/$squad->wars,1) }} / war">{{number_format($squad->uplinks_captured)}}</td>
                        <td class="rank hidden-xs" title="{{ number_format($squad->uplinks_saved/$squad->wars,1) }} / war">{{number_format($squad->uplinks_saved)}}</td>
                        <td class="text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>
                    </tr>
                @endforeach
            </table>
            {!! $squads->render() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <small>*Note: <em>Squads with less than {{ config('sod.win_threshold') }} victories are not included.</em></small>
        </div>
    </div>
@endsection
