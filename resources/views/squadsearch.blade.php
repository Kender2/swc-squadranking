@extends('web')

@section('title')
    SQUAD SEARCH
@endsection

@section('content')
    <form class="form-horizontal" method="GET" action="{{ action('SquadController@squadSearch') }}">

        <div class="form-group @if ($errors->has('name')) has-error @endif">
            <div class="col-sm-offset-2 col-sm-4">
                <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Squad name">
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div> @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button class="btn btn-default" id="inputSubmit" type="submit">Search</button>
            </div>
        </div>
    </form>
    @if (isset($results))
        <div class="col-sm-offset-2 col-sm-6">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="rank">Rank</th>
                    <th>Name</th>
                    <th>Faction</th>
                </tr>
                </thead>
                @foreach($results as $squad)
                    <tr>
                        <td class="rank">{{$squad->rank}}</td>
                        <td><a href="squadview?squadId={{$squad->_id}}">{{$squad->name}}</a></td>
                        <td>{{$squad->faction}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
@endsection
