<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li>
                <div class="navbar-brand">
                    <a class="navbar-link" href="{{ route('squadranking') }}"><span
                                class="glyphicon glyphicon-home"> </span></a>
                </div>
            </li>
            @include('search.searchform')
        </ul>
    </div>
</nav>
