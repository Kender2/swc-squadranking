<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('squadranking') }}">Squad ranking</a>
            <form class="navbar-form navbar-left" role="search" method="get"
                  action="{{ action('SquadController@search') }}">
                <div class="input-group col-xs-6 col-sm-10 col-lg-12">
		    <div class="ddl-select input-group-btn">
                    	<select id="searchtype" name="searchtype" class="form-control" data-style="btn-primary" value="{{ request('searchtype') }}">
                  	    <option value="squad">Squad</option>
                  	    <option value="commander">Player</option>
			</select>
                    </div>
              	    <input class="form-control input" type="search" name="q" value="{{ request('q') }}"
                           placeholder="Enter here">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </form>
	  </div>
    </div>
</nav>
