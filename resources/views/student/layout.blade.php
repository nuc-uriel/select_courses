@extends('common.layout')
@section('menu')
    <div class="navbar navbar-default navbar-static-top" style="margin-bottom: 0px;">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">SC</a>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li class='{{Request::getPathInfo() == "/student/sc" ? "active" : ""}}'><a href="/student/sc">选课</a></li>
                    <li class='{{Request::getPathInfo() == "/student/scr" ? "active" : ""}}'><a href="/student/scr">课表查询</a></li>
                    <li class='{{Request::getPathInfo() == "/student/center" ? "active" : ""}}'><a href=/student/center>个人中心</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="center">{{session('u_name')}}</a></li>
                    <li><a href="/logout">退出</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop