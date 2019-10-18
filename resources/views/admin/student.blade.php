@extends('admin.layout')
@section('title')
    学生管理
@stop
@section('center')
    <div class="container">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">学生管理</div>
            <div class="panel-body">
                <form class="form-inline" style="float: left;" action="" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="请输入查询关键字" name="keyword"
                               value="{{Request::input('keyword')}}">
                    </div>
                    <button type="submit" class="btn btn-info">查询</button>
                </form>
                <a class="btn btn-success" href="#" role="button" style="float: right;" data-toggle="modal"
                   data-target="#exampleModal" data-whatever="添加学生">添加学生</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>姓名</th>
                    <th>学号</th>
                    <th>班级</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $k => $v)
                    <tr>
                        <th scope="row" class="s_id" target="{{$v->id}}">{{$k+1}}</th>
                        <td class="s_name">{{$v->username}}</td>
                        <td class="s_number">{{$v->number}}</td>
                        <td class="s_class">{{$v->class}}</td>
                        <td class="">
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="javascript:void(0);" class="btn btn-info" data-toggle="modal"
                                   data-target="#exampleModal" data-whatever='编辑学生'>编辑</a>
                                <a href="javascript:void(0);" class="btn btn-info reset">重置密码</a>
                                <a class="btn btn-info delete" href="javascript:void(0);">删除</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pull-right">
            {!! $students->render() !!}
        </div>
    </div>
    <!-- 弹出框-添加/修改学生 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">表单</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="alert alert-danger sr-only" role="alert" id="error">错误信息提示</div>
                        <div class="form-group">
                            <label for="s_name" class="control-label">姓名:</label>
                            <input type="text" class="form-control" id="s_name" placeholder="请输入姓名" name="s_name">
                        </div>
                        <div class="form-group">
                            <label for="s_number" class="control-label">学号:</label>
                            <input type="text" class="form-control" id="s_number" placeholder="请输入学号" name="s_number">
                        </div>
                        <div class="form-group">
                            <label for="s_class" class="control-label">班级:</label>
                            <input type="text" class="form-control" id="s_class" placeholder="请输入班级" name="s_class">
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
                $('#error').addClass('sr-only');
                $('.modal-body form').attr('target', '');
                if (recipient == '编辑学生') {
                    $('.modal-body form').attr('target', button.parents('tr:first').find('.s_id').attr('target'));
                    modal.find('.modal-body #s_name').val(button.parents('tr:first').find('.s_name').text());
                    modal.find('.modal-body #s_number').val(button.parents('tr:first').find('.s_number').text());
                    modal.find('.modal-body #s_class').val(button.parents('tr:first').find('.s_class').text());
                } else if (recipient == '添加学生') {
                    modal.find('.modal-body input').val("");
                }
            });

            $('#b_submit').click(function () {
                recipient = $('.modal-title').text();
                if (recipient == '添加学生') {
                    $.post(
                        'student/add',
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
                } else if (recipient == '编辑学生') {
                    $.post(
                        'student/update',
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
                if (confirm("是否删除该学生？")) {
                    var id = $(this).parents('tr').children('th:first').attr('target');
                    $.get(
                        'student/delete?id=' + id,
                        function (data) {
                            alert(data['msg']);
                            if (data['code'] == 0) {
                                window.location.reload();
                            }
                        }
                    );
                }
            });

            $('.reset').click(function () {
                if (confirm("是否将密码重置为学号？")) {
                    var id = $(this).parents('tr').children('th:first').attr('target');
                    $.get(
                        'student/reset?id=' + id,
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