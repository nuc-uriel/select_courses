@extends("common.layout")
@section('title')
    登录
@stop
@section('center')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">登录</div>
            <div class="panel-body">
                @if(count($errors)!=0)
                <div class="alert alert-danger" role="alert" >{{$errors->first()}}</div>
                @endif
                <form class="form-horizontal" method="post" action="">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="username" class="col-sm-2 col-md-offset-2 col-sm-offset-1 control-label">用户名</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" class="form-control" id="username" placeholder="请输入用户名" autofocus="true" name="username" value="{{ old('username') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 col-md-offset-2 col-sm-offset-1 control-label">密码</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="password" class="form-control" id="password" placeholder="请输入密码" name="password" value="{{ old('password') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-sm-2 col-md-offset-2 col-sm-offset-1 control-label">角色</label>
                        <div class="col-sm-8 col-md-6">
                            <select class="form-control" name="role" id="role">
                                <option value="2" {{ old('role')==2?'selected':'' }}>学生</option>
                                <option value="1" {{ old('role')==1?'selected':'' }}>教师</option>
                                <option value="0" {{ old('role')==0?'selected':'' }}>管理员</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="captcha" class="col-sm-2 col-md-offset-2 col-sm-offset-1 control-label">验证码</label>
                        <div class="col-sm-8 col-md-6">
                            <div class="input-group">
                                <input type="text" name="captcha" class="form-control" id="captcha" placeholder="请输入验证码">
                                <span class="input-group-addon" style="padding: 0px;"><img src="/captcha" style="height: 32px;cursor: pointer;" onclick="$(this).attr('src', '/captcha?'+Math.random())" title="看不清？点击更换"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-md-7 col-md-offset-3 col-sm-offset-2">
                            <input type="submit" class="btn btn-primary btn-block" value="登录">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop