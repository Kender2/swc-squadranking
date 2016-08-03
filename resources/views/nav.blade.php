<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('squadranking') }}">Squad ranking</a>
            <form class="navbar-form navbar-left" role="search" method="get"
                  action="{{ action('SquadController@squadSearch') }}">
                <div class="input-group">
                    <input class="form-control" type="text" name="q" value="{{ request('q') }}"
                           placeholder="Search squad">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</nav>
