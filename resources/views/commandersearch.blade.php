@extends('web')

@section('title')
    COMMANDER SEARCH
@endsection

@section('content')
    <div class="row">
        @if (isset($results) && count($results) > 0)
            <div class="col-sm-offset-2 col-sm-6">
                <table class="table table-bordered">
                    <thead>
                    <tr>
			<th>Name</th>
			<th>HQ Level</th>
			<th>Faction</th>
			<th>Squad</th>
                    </tr>
                    </thead>
                    @foreach($results as $comm)
                        <tr class="bg-{{$comm->faction}}">
                            <td>{!! $comm->name !!}</td>
                            <td class="rank">{!! $comm->hqLevel !!}</td>
			    <td class="text-{{$comm->faction}}">{{ucfirst($comm->faction)}}</td>
                            <td><a href="{{ route('squadmembers', ['id' => $comm->squad->id]) }}">{!! \App\Squad::colorName($comm->squad->name) !!}</a></td>
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
