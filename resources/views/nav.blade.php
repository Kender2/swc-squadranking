<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target=".navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Home</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li class="{{Route::currentRouteNamed('squadranking') ? 'active' : ''}}"><a
                            href="{{ route('squadranking') }}">Squad ranking</a></li>
            </ul>
            {{--<form class="navbar-form navbar-right" role="search" method="get"--}}
                  {{--action="{{ action('SquadController@squadSearch') }}">--}}
                {{--<div class="input-group">--}}
                    {{--<input class="form-control" type="text" name="name" value="{{ old('name') }}"--}}
                           {{--placeholder="Search squad">--}}
                    {{--<div class="input-group-btn">--}}
                        {{--<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        </div>
    </div>
</nav>
