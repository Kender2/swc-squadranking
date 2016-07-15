@extends('web')

@section('title')
    SQUAD VIEW
@endsection

@section('content')
    <div>
        <div class="col-sm-offset-1 col-sm-6">
            <h2>{{$squadName}} war record:</h2>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Result</th>
                    <th class="rank">Score</th>
                    <th class="rank">Opponent score</th>
                    <th>Opponent</th>
                </tr>
                </thead>
                @foreach($warRecord as $record)
                    <tr>
                        <td>{{$record['endDate']}}</td>
                        <td>{{$record['result']}}</td>
                        <td class="rank">{{$record['score']}}</td>
                        <td class="rank">{{$record['opponentScore']}}</td>
                        <td><a href="squadview?squadId={{$record['opponentId']}}">{!! $record['opponent']!!}</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="col-sm-offset-0 col-sm-12">
            Raw data:
        <pre>
        {{$squad}}
        </pre>
        </div>
    </div>
@endsection
