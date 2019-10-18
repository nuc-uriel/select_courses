@extends('admin.layout')
@section('title')
    教师管理
@stop
@section('center')
    <div class="container">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">教师管理</div>
            <div class="panel-body">
                <form class="form-inline" style="float: left;" action="" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="请输入查询关键字" name="keyword"
                               value="{{Request::input('keyword')}}">
                    </div>
                    <button type="submit" class="btn btn-info">查询</button>
                </form>
                <a class="btn btn-success" href="javascript:void(0);" role="button" style="float: right;"
                   data-toggle="modal" data-target="#exampleModal" data-whatever="添加教师">添加教师</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>姓名</th>
                    <th>工号</th>
                    <th>单位</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teachers as $k => $v)
                    <tr>
                        <th scope="row" class="t_id" target="{{$v->id}}">{{$k+1}}</th>
                        <td class="t_name">{{$v->username}}</td>
                        <td class="t_number">{{$v->number}}</td>
                        <td class="t_class">{{$v->class}}</td>
                        <td class="">
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="javascript:void(0);" class="btn btn-info" data-toggle="modal"
                                   data-target="#exampleModal" data-whatever='编辑教师'>编辑</a>
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
            {!! $teachers->render() !!}
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
                    <form action="" method="post">
                        <div class="alert alert-danger sr-only" role="alert" id="error">错误信息提示</div>
                        <div class="form-group">
                            <label for="t_name" class="control-label">姓名:</label>
                            <input type="text" class="form-control" name="t_name" id="t_name" placeholder="请输入姓名">
                        </div>
                        <div class="form-group">
                            <label for="t_number" class="control-label">工号:</label>
                            <input type="text" class="form-control" id="t_number" name="t_number" placeholder="请输入工号">
                        </div>
                        <div class="form-group">
                            <label for="t_class" class="control-label">单位:</label>
                            <input type="text" class="form-control" id="t_class" name="t_class" placeholder="请输入单位">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="b_close">关闭</button>
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
                if (recipient == '编辑教师') {
                    $('.modal-body form').attr('target', button.parents('tr:first').find('.t_id').attr('target'));
                    modal.find('.modal-body #t_name').val(button.parents('tr:first').find('.t_name').text());
                    modal.find('.modal-body #t_number').val(button.parents('tr:first').find('.t_number').text());
                    modal.find('.modal-body #t_class').val(button.parents('tr:first').find('.t_class').text());
                } else if (recipient == '添加教师') {
                    modal.find('.modal-body input').val("");
                }
            });

            $('#b_submit').click(function () {
                recipient = $('.modal-title').text();
                if (recipient == '添加教师') {
                    $.post(
                        'teacher/add',
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
                } else if (recipient == '编辑教师') {
                    $.post(
                        'teacher/update',
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
                if (confirm("是否删除该教师？")) {
                    var id = $(this).parents('tr').children('th:first').attr('target');
                    $.get(
                        'teacher/delete?id=' + id,
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
                if (confirm("是否将密码重置为工号？")) {
                    var id = $(this).parents('tr').children('th:first').attr('target');
                    $.get(
                        'teacher/reset?id=' + id,
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