@extends('web')

@section('title'){!! $squad->renderNamePlain() !!} Members @endsection
@section('heading')
    <div class="col-lg-6 col-md-8 col-sm-10 col-xs-10">
        <ul class="list-inline nav-justified nav-pills nav">
            <li>{!! $squad->renderName() !!}</li>
            <li><a href="{{ route('squadhistory', ['id' => $squad->id]) }}">War History</a></li>
            <li><a href="{{ route('squadmembers', ['id' => $squad->id]) }}">Members</a></li>
            <li class="active"><a>Predict</a></li>
        </ul>
    </div>@endsection

@section('content')
    <div class="row">

    </div>
    <hr/>
    <div class="row">
        <div class="col-lg-8 col-md-9 col-sm-8 col-xs-9">
            <form class="form-inline" method="get"
                  action="{{ action('SquadController@squadPredict', ['id' => $squad->id]) }}">
                <label for="match">Select a squad to match against {!! $squad->renderNamePlain() !!}</label>
                <div class="input-group">
                    <input class="form-control input" type="search" name="match" value="{{ request('match') }}"
                           placeholder="Search squad">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </form>

        </div>
        @if (isset($results) && count($results) > 0)
            <div class="col-sm-offset-2 col-sm-6">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="rank">Rank</th>
                        <th>Name</th>
                        <th>Faction</th>
                    </tr>
                    </thead>
                    @foreach($results as $squad)
                        <tr class="bg-{{$squad->faction}}">
                            <td class="rank">{!! $squad->rank !!}</td>
                            <td><a href="vs/{{$squad->id}}">{!! \App\Squad::colorName($squad->name) !!}</a></td>
                            <td class="text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>
                        </tr>
                    @endforeach
                </table>
                {!! $results->appends(['match' => request('match')])->render() !!}
            </div>
        @endif
    </div>
    @if (isset($predictions))
        @foreach($predictions as $prediction)
            <div class="row">
                <div class="col-lg-5 col-sm-8 col-md-6 col-xs-10">
                    <table class="table table-bordered">
                        <caption class="text-info">{!! $prediction['text'] !!}</caption>
                        <thead>
                        <tr>
                            <th>Squad</th>
                            <th class="rank">Old skill</th>
                            <th class="rank">New skill</th>
                            <th class="rank">Change</th>
                        </tr>
                        </thead>
                        @foreach ($prediction['data'] as $data)
                            <tr>
                                <td>{!! $data['squad'] !!}</td>
                                <td class="rank">{{ number_format($data['old_skill']) }}</td>
                                <td class="rank">{{ number_format($data['new_skill']) }}</td>
                                <td class="rank">{{ $data['change']  > 0 ? '+' : ''}}{{ number_format($data['change']) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endforeach
    @endif

@endsection

