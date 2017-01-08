@extends('web')

@section('title')
    PLAYER SEARCH
@endsection

@section('content')
    <div class="row">
        @if (isset($results) && count($results) > 0)
            <div class="col-sm-offset-2 col-sm-6">
                <table class="table table-bordered">
                    <caption class="text-info">Search results page {{ $results->currentPage() }}</caption>
                    <thead>
                    <tr>
                        <th class="rank">HQ Level</th>
                        <th>Name</th>
                        <th>Squad</th>
                        <th>Faction</th>
                    </tr>
                    </thead>
                    @foreach($results as $commander)
                        <tr class="bg-{{$commander->faction}}">
                            <td class="rank">{!! $commander->hqLevel !!}</td>
                            <td>{!! $commander->renderName() !!}</td>
                            <td>
                                <a href="{{ route('squadmembers', ['id' => $commander->squad->id, 'hl' => $commander->playerId]) }}">{!! $commander->squad->renderName() !!}</a>
                            </td>
                            <td class="text-{{ $commander->faction }}">{{ ucfirst($commander->faction) }}</td>
                        </tr>
                    @endforeach
                </table>
                {!! $results->appends(['q' => request('q'), 'st' => request('st')])->render() !!}
            </div>
        @else
            <div class="col-sm-offset-2 col-sm-6">
                <h3>No player results.</h3>
            </div>
        @endif
    </div>
@endsection
