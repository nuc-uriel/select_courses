@extends('student.layout')
@section('title')
    个人中心
@stop
@section('center')
    <div class="container">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">个人中心</div>
            <table class="table table-bordered">
                <tr>
                    <th>姓名</th>
                    <td>{{$info->username}}</td>
                </tr>
                <tr>
                    <th>学号</th>
                    <td>{{$info->number}}</td>
                </tr>
                <tr>
                    <th>班级</th>
                    <td>{{$info->class}}</td>
                </tr>
                <tr>
                    <td colspan="2"><a class="btn btn-success btn-block" href="#" data-toggle="modal"
                                       data-target="#exampleModal">修改密码</a></td>
                </tr>
            </table>
        </div>
    </div>
    <!-- 弹出框-修改密码 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">修改密码</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert" id="error">错误信息提示</div>
                    <form>
                        <div class="form-group">
                            <label for="password" class="control-label">请输入密码:</label>
                            <input type="password" class="form-control" id="password" placeholder="请输入密码"
                                   name="password">
                        </div>
                        <div class="form-group">
                            <label for="re_password" class="control-label">请再次输入密码:</label>
                            <input type="password" class="form-control" id="re_password" placeholder="请再次输入密码"
                                   name="re_password">
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
            });

            $('#b_submit').click(function () {
                $.post(
                    'reset',
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
            });
        });
    </script>
@stop