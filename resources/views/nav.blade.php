<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('squadranking') }}">Squad ranking</a>
            <form class="navbar-form navbar-left" role="search" method="get"
                  action="{{ action('SquadController@search') }}">
                <div class="input-group col-xs-6 col-sm-10 col-lg-12">
		    <div class="ddl-select input-group-btn">
                    	<select id="searchtype" class="selectpicker form-control" data-style="btn-primary">
                  	    <option value="" data-hidden="true" class="type-title">SEARCH</option>
                  	    <option value="squad">Squad</option>
                  	    <option value="player">Player</option>
			</select>
                    </div>
		    /* ^ http://www.bootply.com/gWOb4RcY86 */
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
