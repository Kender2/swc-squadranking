@extends('web')

@section('title')
    SQUAD SEARCH
@endsection

@section('content')
    <div class="row">
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
                            <td><a href="squad/{{$squad->id}}">{!! \App\Squad::colorName($squad->name) !!}</a></td>
                            <td class="text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>
                        </tr>
                    @endforeach
                </table>
                {!! $results->appends(['q' => request('q')])->render() !!}
            </div>
        @else
            <div class="col-sm-offset-2 col-sm-6">
                <h3>No results.</h3>
                </div>
        @endif
    </div>
@endsection
