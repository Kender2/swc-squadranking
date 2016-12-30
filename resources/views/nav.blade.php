<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('squadranking') }}">Squad ranking</a>
            <form class="navbar-form navbar-left" role="search" method="get"
                  action="{{ action('SquadController@squadSearch') }}">
                <div class="input-group col-xs-6 col-sm-10 col-lg-12">
                    <input class="form-control input" type="search" name="q" value="{{ request('q') }}"
                           placeholder="Search squad">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <form class="navbar-form navbar-right" role="search" method="get"
                  action="{{ action('SquadController@commanderSearch') }}">
                <div class="input-group col-xs-6 col-sm-10 col-lg-12">
                    <input class="form-control input" type="search" name="sq" value="{{ request('sq') }}"
                           placeholder="Search commander">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </form>

	  </div>
    </div>
</nav>
