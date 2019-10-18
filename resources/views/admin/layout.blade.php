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
                    <li class='{{Request::getPathInfo() == "/admin/teacher" ? "active" : ""}}'><a
                                href="/admin/teacher">教师管理</a></li>
                    <li class='{{Request::getPathInfo() == "/admin/student" ? "active" : ""}}'><a
                                href="/admin/student">学生管理</a></li>
                    <li class="{{Request::getPathInfo() == "/admin/course" ? "active" : ""}}{{Request::getPathInfo() == "/admin/course/info" ? "active" : ""}}">
                        <a href="/admin/course">课程管理</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="javascript:void(0);">{{session('u_name')}}</a></li>
                    <li><a href="/logout">退出</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop