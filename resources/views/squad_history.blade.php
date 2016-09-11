@extends('web')

@section('title'){!! $squad->renderNamePlain() !!} War History @endsection
@section('heading')<div class="col-lg-6 col-md-8 col-sm-10 col-xs-10">
    <ul class="nav-justified nav-pills nav">
        <li>{!! $squad->renderName() !!}</li>
        <li class="active"><a>War History</a></li>
        <li><a href="{{ route('squadmembers', ['id' => $squad->id]) }}">Members</a></li>
    </ul>
</div>@endsection

@section('content')
    <div class="row">

    </div>
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
            <table class="table table-bordered table-condensed table-hover bg-{{$squad->faction}}">
                <caption class="text-info">Totals</caption>
                <tr>
                    <td>Faction</td>
                    <td class="rank text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>
                </tr>
                <tr>
                    <td>Rank</td>
                    <td class="rank">{!! $squad->rank !!}</td>
                </tr>
                <tr>
                    <td>TrueSkill™</td>
                    <td class="rank">{{$squad->skill}}</td>
                </tr>
                <tr>
                    <td>Wars</td>
                    <td class="rank">{{$squad->wars}}</td>
                </tr>
                <tr title="Won {{ round($squad->wins/$squad->wars * 100,1) }}% of wars">
                    <td>Wins</td>
                    <td class="rank">{{$squad->wins}}</td>
                </tr>
                <tr title="Tied {{ round($squad->draws/$squad->wars * 100,1) }}% of wars">
                    <td>Draws</td>
                    <td class="rank">{{$squad->draws}}</td>
                </tr>
                <tr title="Lost {{ round($squad->losses/$squad->wars * 100,1) }}% of wars">
                    <td>Losses</td>
                    <td class="rank">{{$squad->losses}}</td>
                </tr>
                <tr title="Captured an average of {{ round($squad->uplinks_captured/$squad->wars) }} uplinks per war">
                    <td>Uplinks captured</td>
                    <td class="rank">{{$squad->uplinks_captured}}</td>
                </tr>
                <tr title="Saved an average of {{ round($squad->uplinks_saved/$squad->wars) }} uplinks per war">
                    <td>Uplinks saved</td>
                    <td class="rank">{{$squad->uplinks_saved}}</td>
                </tr>
                <tr>
                    <td>Last updated</td>
                    <td class="rank">{{$squad->updated_at->diffForHumans()}}</td>
                </tr>
            </table>

        </div>
        <div class="col-lg-6 col-md-8 col-sm-9 col-xs-10">
            <table class="table table-striped table-bordered table-hover">
                <caption class="text-info">Battle history</caption>
                <thead>
                <tr>
                    <th>Date</th>
                    <th class="rank">Opponent skill</th>
                    <th>Opponent</th>
                    <th>Result</th>
                    <th class="rank">Score</th>
                    <th class="rank">Opponent score</th>
                    <th class="rank">Skill result</th>
                </tr>
                </thead>
                <tbody>
                @foreach($battles as $date => $battle)
                    <tr>
                        <td>{{$date}}</td>
                        <td class="rank">{{ round($battle['skill_difference'] * 100) }}%</td>
                        <td><a href="{{ route('squadhistory', ['id' => $battle['opponent']->id]) }}">{!! $battle['opponent']->renderName() !!}</a></td>
                        <td class="text-{{\App\Battle::result($battle['score'], $battle['opponent_score'])}}">{{\App\Battle::result($battle['score'], $battle['opponent_score'])}}</td>
                        <td class="rank">{{$battle['score']}}</td>
                        <td class="rank">{{$battle['opponent_score']}}</td>
                        <td class="rank">{{$battle['skill_change'] > 0 ? '+' : ''}}{{$battle['skill_change']}}</td>
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
