@extends('web')

@section('title')
    SQUAD SEARCH
@endsection

@section('content')
    <div class="row">
        @if (isset($results) && count($results) > 0)
            <div class="col-sm-offset-2 col-sm-6">
                <table class="table table-bordered">
                    <caption class="text-info">Search results page {{ $results->currentPage() }}</caption>
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
                            <td><a href="squad/{{$squad->id}}">{!! $squad->renderName() !!}</a></td>
                            <td class="text-{{$squad->faction}}">{{ucfirst($squad->faction)}}</td>
                        </tr>
                    @endforeach
                </table>
                {!! $results->appends(['q' => request('q'), 'st' => request('st')])->render() !!}
            </div>
        @else
            <div class="col-sm-offset-2 col-sm-6">
                <h3>No squad results.</h3>
                </div>
        @endif
    </div>
@endsection
