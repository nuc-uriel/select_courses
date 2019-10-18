<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>选课系统-@yield('title', '首页')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>

<body>
@section('menu')
@show
<div class="head">
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <h2 class="col-lg-12">选课系统</h2>
            </div>
            <div class="row">
                <p class="col-lg-12 text-right">-@yield('title', '首页')</p>
            </div>
        </div>
    </div>
</div>

<div class="main">
    @section('center')
    @show
</div>
<div class="jumbotron footer" style="margin: 0px;">
    <div class="container">
        <span class="text-center" style="display: block;">CopyRight © 2018 xxxx公司 All Rights Reserved</span>
        <span class="text-center" style="display: block;">电话：010-****888 京ICP备*******8号</span>
    </div>
</div>
@section('javascript')
@show
</body>

</html>