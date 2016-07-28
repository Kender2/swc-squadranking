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
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="rank">Rank</th>
                    <th>Name</th>
                    <th>Faction</th>
                    <th class="rank">Skill</th>
                </tr>
                </thead>
                @foreach($squads as $index => $squad)
                    <tr>
                        <td class="rank">{{$index + $squads->firstItem()}}</td>
                        <td><a href="squad/{{$squad->id}}">{!! $squad->renderName() !!}</a></td>
                        <td>{{$squad->faction}}</td>
                        <td class="rank">{{round($squad->mu * 1000)}}</td>
                    </tr>
                @endforeach
            </table>
            {!! $squads->render() !!}
        </div>
    </div>
@endsection
