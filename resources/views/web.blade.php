<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/all.css">

</head>
<body>
<div class="container">
    <div class="title">
        @hasSection ('heading')
        @yield('heading')
        @else
            @yield('title')
        @endif
    </div>
    @include('nav')
    <div class="content">
        @yield('content')
    </div>
</div>

<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@yield('scripts')
</body>
</html>
