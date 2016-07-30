@extends('web')

@section('title')SQUAD WAR RANKING @endsection
@section('heading')SQUAD WAR RANKING <em class="text-danger">*BETA*</em> @endsection

@section('content')
    <div class="row">
        <div class="col-sm-2">
            <table class="table table-bordered table-condensed table-hover">
                <caption>Statistics</caption>
                <tr>
                    <td>Squads in database:</td>
                    <td class="rank">{{ number_format(\App\Squad::count()) }}</td>
                </tr>
                <tr>
                    <td>Wars in database:</td>
                    <td class="rank">{{ number_format(\App\Battle::count()) }}</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-6">
            <h3>Ranks {{ $squads->firstItem() }} - {{ $squads->lastItem() }}</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="rank">Rank</th>
                    <th>Name</th>
                    <th class="rank">Wins</th>
                    <th class="rank">Draws</th>
                    <th class="rank">Losses</th>
                    <th class="rank">UL captured</th>
                    <th class="rank">UL saved</th>
                    <th>Faction</th>
                </tr>
                </thead>
                @foreach($squads as $index => $squad)
                    <tr class="bg-{{$squad->faction}}">
                        <td class="rank">{{$index + $squads->firstItem()}}</td>
                        <td><a href="squad/{{$squad->id}}">{!! $squad->renderName() !!}</a></td>
                        <td class="rank" title="{{ round($squad->wins/$squad->wars * 100,1) }}%">{{$squad->wins}}</td>
                        <td class="rank" title="{{ round($squad->draws/$squad->wars * 100,1) }}%">{{$squad->draws}}</td>
                        <td class="rank" title="{{ round($squad->losses/$squad->wars * 100,1) }}%">{{$squad->losses}}</td>
                        <td class="rank" title="{{ round($squad->uplinks_captured/$squad->wars,1) }} / war">{{$squad->uplinks_captured}}</td>
                        <td class="rank" title="{{ round($squad->uplinks_saved/$squad->wars,1) }} / war">{{$squad->uplinks_saved}}</td>
                        <td class="text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>
                    </tr>
                @endforeach
            </table>
            {!! $squads->render() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <small>*Note: <em>Squads with less than 10 victories are not included.</em></small>
        </div>
    </div>
@endsection
