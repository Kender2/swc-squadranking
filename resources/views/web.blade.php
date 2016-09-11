<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <style>.rank{text-align:right}body{padding-top:70px}.bg-rebel{background-color:#2e4053}.bg-empire{background-color:#293b4e}.text-rebel{color:gold}.text-empire{color:#d9534f}.text-WIN{color:#4cae4c}.text-LOSS{color:#d14}.footer{background-color:#2a323a}</style>
    {!! Analytics::render() !!}
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
        @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif
        @yield('content')
    </div>
    @include('footer')
</div>

<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@yield('scripts')
</body>
</html>
