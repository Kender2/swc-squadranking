@extends('web')

@section('title'){!! $totals['squad']->renderNamePlain() !!}@endsection
@section('heading'){!! $totals['squad']->renderName() !!}@endsection


@section('content')
    <div class="row">
        <div class="col-lg-2">
            <table class="table table-bordered table-condensed table-hover">
                <caption>Totals</caption>
                <tr>
                    <td>Faction</td>
                    <td>{{ucfirst($totals['squad']->faction)}}</td>
                </tr>
                <tr>
                    <td>Rank</td>
                    <td class="rank">{{$totals['rank']}}</td>
                </tr>
                <tr>
                    <td>Skill</td>
                    <td class="rank">{{$totals['skill']}}</td>
                </tr>
                <tr>
                    <td>Wars</td>
                    <td class="rank">{{$totals['wars']}}</td>
                </tr>
                <tr>
                    <td>Uplinks captured</td>
                    <td class="rank">{{$totals['uplinksCaptured']}}</td>
                </tr>
                <tr>
                    <td>Uplinks saved</td>
                    <td class="rank">{{$totals['uplinksSaved']}}</td>
                </tr>
                <tr>
                    <td>Wins</td>
                    <td class="rank">{{$totals['wins']}}</td>
                </tr>
                <tr>
                    <td>Draws</td>
                    <td class="rank">{{$totals['draws']}}</td>
                </tr>
                <tr>
                    <td>Losses</td>
                    <td class="rank">{{$totals['losses']}}</td>
                </tr>
            </table>

        </div>
        <div class="col-lg-8">
            <table class="table table-striped table-bordered table-hover">
                <caption class="strong">Battle history</caption>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Opponent</th>
                    <th>Result</th>
                    <th class="rank">Score</th>
                    <th class="rank">Opponent score</th>
                </tr>
                </thead>
                <tbody>
                @foreach($battles as $date => $battle)
                    <tr>
                        <td>{{$date}}</td>
                        <td><a href="{{$battle['opponent']->id}}">{!! $battle['opponent']->renderName() !!}</a>
                        </td>
                        <td>{{$battle['result']}}</td>
                        <td class="rank">{{$battle['score']}}</td>
                        <td class="rank">{{$battle['opponent_score']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12"><small>*Note: <em>Wars from before June 22th 2016 are not included.</em></small></div>
    </div>
@endsection
