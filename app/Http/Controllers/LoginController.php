<?php
/**
 * Created by PhpStorm.
 * User: uriel
 * Date: 2018/5/23 0023
 * Time: 17:38
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * @function 登录
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),array(
                'username' => 'required|min:2|max:32',
                'password' => 'required|min:5|max:16',
                'role' => 'required|integer|in:0,1,2',
                'captcha' => 'required|captcha'
            ), array(
                'required' => ':attribute为必填项',
                'min' => ':attribute最少为:min个字符',
                'max' => ':attribute最多为:max个字符',
                'integer' => ':attribute不存在',
                'in' => ':attribute不存在',
                'captcha' => ':attribute错误',
            ), array(
                'username' => '用户名',
                'password' => '密码',
                'role' => '角色',
                'captcha' => '验证码',
            ));
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $res = DB::table('user')->where('username',$request->get('username'))->where('password',md5($request->get('password')))->where('role',$request->get('role'))->get();
            if(count($res) == 0){
                return redirect()->back()->withErrors('用户名或密码错误')->withInput();
            }else{
                Session::put(array(
                    'u_id'  =>  $res[0]->id,
                    'u_name'  =>  $res[0]->username,
                    'u_role'  =>  $res[0]->role,
                ));
            }
            switch ($res[0]->role){
                case 0:
                    return redirect()->action('UserController@teacher_list');
                    break;
                case 1:
                    return redirect('/teacher/');
                    break;
                case 2:
                    return redirect('/student/');
                    break;
            }
        }
        return view("index");
    }

    /***
     * @function 返回验证码
     * @param Request $request
     * @return mixed
     */
    public function captcha(Request $request)
    {
        return captcha();
    }

    /**
     * @function 退出
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}