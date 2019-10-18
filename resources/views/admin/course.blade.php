@extends('admin.layout')
@section('title')
    课程管理
@stop
@section('center')
    <div class="container">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">课程管理</div>
            <div class="panel-body">
                <form class="form-inline" style="float: left;" action="" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="请输入查询关键字" name="keyword"
                               value="{{Request::input('keyword')}}">
                    </div>
                    <button type="submit" class="btn btn-info">查询</button>
                </form>
                <a class="btn btn-success" href="#" role="button" style="float: right;" data-toggle="modal"
                   data-target="#exampleModal" data-whatever="添加课程">添加课程</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>课号</th>
                    <th>课程名称</th>
                    <th>学分</th>
                    <th>任课老师</th>
                    <th>教室</th>
                    <th>上课时间</th>
                    <th>课余量</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $k => $v)
                    <tr>
                        <th scope="row" class="t_id" target="{{$v->id}}">KK{{str_pad($k+1,4,'0',STR_PAD_LEFT)}}</th>
                        <td class="c_name">{{$v->name}}</td>
                        <td class="c_score">{{$v->score}}</td>
                        <td class="c_teacher" target="{{$v->teacher_id}}">{{$v->teacher}}</td>
                        <td class="c_class">{{$v->class}}</td>
                        <td class="c_time">{{$v->time}}周</td>
                        <td class="c_size">{{$v->num}}/{{$v->size}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="course/info?id={{$v->id}}" class="btn btn-info">查看</a>
                                <a href="javascript:void(0);" class="btn btn-info" data-toggle="modal"
                                   data-target="#exampleModal" data-whatever="编辑课程">编辑</a>
                                <a href="javascript:void(0);" class="btn btn-info delete">删除</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pull-right">
            {!! $courses->render() !!}
        </div>
    </div>
    <!-- 弹出框-添加/修改教师 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">表单</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert" id="error">错误信息提示</div>
                    <form>
                        <div class="form-group">
                            <label for="c_name" class="control-label">课程名称:</label>
                            <input type="text" class="form-control" id="c_name" placeholder="请输入课程名称" name="c_name">
                        </div>
                        <div class="form-group">
                            <label for="c_score" class="control-label">学分:</label>
                            <input type="text" class="form-control" id="c_score" placeholder="请输入学分" name="c_score">
                        </div>
                        <div class="form-group">
                            <label for="c_teacher" class="control-label">任课老师:</label>
                            <select name="c_teacher" id="c_teacher" class="form-control">
                                <option value="">请选择任课老师</option>
                                @foreach($teachers as $k=>$v)
                                    <option value="{{$v->id}}">{{$v->username}}({{$v->number}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="c_class" class="control-label">教室:</label>
                            <input type="text" class="form-control" id="c_class" placeholder="请输入教室" name="c_class">
                        </div>
                        <div class="form-group">
                            <label for="c_time" class="control-label">上课时间(如1-17(六)):</label>
                            <input type="text" class="form-control" id="c_time" placeholder="请输入上课时间" name="c_time">
                        </div>
                        <div class="form-group">
                            <label for="c_size" class="control-label">课容量:</label>
                            <input type="text" class="form-control" id="c_size" placeholder="请输入课容量" name="c_size">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="b_submit">确定</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(function () {
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var recipient = button.data('whatever');
                var modal = $(this);
                modal.find('.modal-title').text(recipient);
                modal.find('.modal-body #c_teacher option').removeAttr('selected').first().attr('selected', 'selected');
                $('#error').addClass('sr-only');
                $('.modal-body form').attr('target', '');
                if (recipient == '编辑课程') {
                    $('.modal-body form').attr('target', button.parents('tr:first').find('.t_id').attr('target'));
                    modal.find('.modal-body #c_name').val(button.parents('tr:first').find('.c_name').text());
                    modal.find('.modal-body #c_score').val(button.parents('tr:first').find('.c_score').text());
                    modal.find('.modal-body #c_class').val(button.parents('tr:first').find('.c_class').text());
                    var c_time = button.parents('tr:first').find('.c_time').text();
                    c_time = c_time.substring(0, c_time.length - 1);
                    modal.find('.modal-body #c_time').val(c_time);
                    var c_size = button.parents('tr:first').find('.c_size').text();
                    c_size = c_size.split('/')[1];
                    modal.find('.modal-body #c_size').val(c_size);
                    var c_teacher = button.parents('tr:first').find('.c_teacher').attr('target');
                    modal.find('.modal-body #c_teacher option[value=' + c_teacher + ']').attr('selected', 'selected');
                } else if (recipient == '添加课程') {
                    modal.find('.modal-body input').val("");
                }
            });

            $('#b_submit').click(function () {
                recipient = $('.modal-title').text();
                if (recipient == '添加课程') {
                    $.post(
                        'course/add',
                        $('.modal-body form').serialize(),
                        function (data) {
                            if (data['code'] == 1) {
                                $('#error').removeClass('sr-only').text(data['msg']);
                            } else if (data['code'] == 0) {
                                alert(data['msg']);
                                window.location.reload();
                            }
                        }
                    );
                } else if (recipient == '编辑课程') {
                    $.post(
                        'course/update',
                        $('.modal-body form').serialize() + '&id=' + $('.modal-body form').attr('target'),
                        function (data) {
                            if (data['code'] == 1) {
                                $('#error').removeClass('sr-only').text(data['msg']);
                            } else if (data['code'] == 0) {
                                alert(data['msg']);
                                window.location.reload();
                            }
                        }
                    );
                }

            });

            $('.delete').click(function () {
                if (confirm("是否删除该课程？\n[温馨提示]删除后请通知选课学生")) {
                    var id = $(this).parents('tr').children('th:first').attr('target');
                    $.get(
                        'course/delete?id=' + id,
                        function (data) {
                            alert(data['msg']);
                            if (data['code'] == 0) {
                                window.location.reload();
                            }
                        }
                    );
                }
            });
        });
    </script>
@stop