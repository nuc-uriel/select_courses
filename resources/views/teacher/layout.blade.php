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
                    <li class='{{Request::getPathInfo() == "/teacher/course" ? "active" : ""}}{{Request::getPathInfo() == "/teacher/course/info" ? "active" : ""}}'>
                        <a href="/teacher/course">课程管理</a></li>
                    <li class='{{Request::getPathInfo() == "/teacher/center" ? "active" : ""}}'><a
                                href="/teacher/center">个人中心</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="center">{{session('u_name')}}</a></li>
                    <li><a href="/logout">退出</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop