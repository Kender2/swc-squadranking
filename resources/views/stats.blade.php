@extends('web')

@section('title')
    STATISTICS
@endsection

@section('content')
    <div class="row">
        @foreach ($data as $title => $table)
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-10">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <caption class="text-info">{{$title}}</caption>
                    <thead>
                    <th></th>
                    @foreach(array_keys($table) as $faction)
                        <th class="rank">{{$faction}}</th>
                    @endforeach
                    </thead>
                    @foreach (array_keys(current($table)) as $stat)
                        <tr>
                            <td>{{$stat}}</td>
                            @foreach(array_keys($table) as $faction)
                                <td class="rank text-{{lcfirst($faction)}}">{{number_format($table[$faction][$stat])}}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-12">
            <small>*Note: <em>Only squad wars participants are included.</em></small>
        </div>
    </div>
@endsection
