@extends('admin.layout')
@section('title')
    选课详情
@stop
@section('center')
    <div class="container">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">选课详情</div>
            <div class="panel-body">
                <a class="btn btn-success" href="{{url('admin/course')}}" role="button" style="float: right;">返回课程列表</a>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>学号</th>
                    <th>班级</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $k=>$v)
                    <tr>
                        <th scope="row">{{$k+1}}</th>
                        <td>{{$v->username}}</td>
                        <td>{{$v->number}}</td>
                        <td>{{$v->class}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pull-right">
            {!! $students->render() !!}
        </div>
    </div>
@stop