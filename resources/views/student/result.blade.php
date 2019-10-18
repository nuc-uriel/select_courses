@extends('student.layout')
@section('title')
    课表查询
@stop
@section('center')
    <div class="container">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">课表查询</div>
            <div class="panel-body">
                <form class="form-inline" style="float: right;">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="请输入查询关键字" name="keyword"
                               value="{{Request::input('keyword')}}">
                    </div>
                    <button type="submit" class="btn btn-info">查询</button>
                </form>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>课号</th>
                    <th>课程名称</th>
                    <th>学分</th>
                    <th>任课老师</th>
                    <th>教室</th>
                    <th>上课时间</th>
                    <th>课余量</th>
                    <th>退课</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $k=>$v)
                    <tr target="{{$v->id}}">
                        <th scope="row" class="t_id" target="{{$v->id}}">KK{{str_pad($k+1,4,'0',STR_PAD_LEFT)}}</th>
                        <td class="c_name">{{$v->name}}</td>
                        <td class="c_score">{{$v->score}}</td>
                        <td class="c_teacher" target="{{$v->teacher_id}}">{{$v->teacher}}</td>
                        <td class="c_class">{{$v->class}}</td>
                        <td class="c_time">{{$v->time}}周</td>
                        <td class="c_size">{{$v->num}}/{{$v->size}}</td>
                        <td><a class="btn btn-success select" href="javascript:void(0);" role="button">退课</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pull-right">
            {!! $courses->render() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script type="application/javascript">
        $(function () {
            $('.select').click(function () {
                var id = $(this).parents('tr').attr('target');
                $.get(
                    'scr/un_select?id=' + id,
                    function (data) {
                        alert(data['msg']);
                        if (data['code'] == 0) {
                            window.location.reload();
                        }
                    }
                );
            });
        });
    </script>
@stop