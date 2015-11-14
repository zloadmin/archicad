<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ArhiCAD Service  - @yield('title')</title>
    <link rel="stylesheet" href="/static/styles/bootstrap.min.css">
    <link rel="stylesheet" href="/static/styles/jquery.datetimepicker.css">
    <link rel="stylesheet" href="/static/styles/main.css">
</head>

<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">ArhiCAD Service</a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            @include('layouts.menu')
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="container-fluid">
                <h2 class="sub-header">@yield('title')</h2>
                @yield('content')
            </div>
        </div>
    </div>
</div>


<script src="/static/scripts/jquery.min.js"></script>
<script src="/static/scripts/jquery.datetimepicker.js"></script>
<script src="/static/scripts/bootstrap.min.js"></script>
<script src="/static/scripts/scripts.js"></script>
</body>
</html>