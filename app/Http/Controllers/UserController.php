<?php
/**
 * Created by PhpStorm.
 * User: uriel
 * Date: 2018/5/24 0024
 * Time: 10:49
 */

namespace App\Http\Controllers;


use App\Http\CourseModel;
use App\Http\StudentCourseModel;
use App\Http\UserModel;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * @function 添加教师信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_teacher(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            't_name' => 'required|min:2|max:32',
            't_number' => 'required|min:5|max:16',
            't_class' => 'required|min:2|max:16',
        ), array(
            'required' => ':attribute为必填项',
            'min' => ':attribute最少为:min个字符',
            'max' => ':attribute最多为:max个字符',
        ), array(
            't_name' => '姓名',
            't_number' => '工号',
            't_class' => '单位',
        ));
        if ($validator->fails()) {
            $data = array(
                'code' => 1,
                'msg' => $validator->errors()->first()
            );

        } else {
            $old_data = $request->all();
            $data = array(
                'username' => $old_data['t_name'],
                'password' => md5($old_data['t_number']),
                'number' => $old_data['t_number'],
                'class' => $old_data['t_class'],
                'role' => 1,
            );
            $res = UserModel::create($data);
            if ($res->wasRecentlyCreated) {
                $data = array(
                    'code' => 0,
                    'msg' => "添加成功！"
                );
            } else {
                $data = array(
                    'code' => 1,
                    'msg' => "添加失败！"
                );
            }
        }
        return response()->json($data);
    }

    /**
     * @function 删除教师信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_teacher(Request $request)
    {
        $data = array(
            'code'  =>  1,
            'msg'   =>  '删除失败！'
        );
        if($request->has('id')){
            $id = $request->input('id');
            $course_count = CourseModel::where('teacher_id', '=', $id)->count();
            if($course_count != 0){
                $data = array(
                    'code'  =>  1,
                    'msg'   =>  '该教师有课程在选课表中，请先核对选课表'
                );
            }else{
                $res = UserModel::find($id)->delete();
                if($res) {
                    $data = array(
                        'code' => 0,
                        'msg' => '删除成功！'
                    );
                }
            }
        }
        return response()->json($data);
    }

    /**
     * @function 更新教师信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_teacher(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            't_name' => 'required|min:2|max:32',
            't_number' => 'required|min:5|max:16',
            't_class' => 'required|min:2|max:16',
        ), array(
            'required' => ':attribute为必填项',
            'min' => ':attribute最少为:min个字符',
            'max' => ':attribute最多为:max个字符',
        ), array(
            't_name' => '姓名',
            't_number' => '工号',
            't_class' => '单位',
        ));
        if ($validator->fails()) {
            $data = array(
                'code' => 1,
                'msg' => $validator->errors()->first()
            );

        } else {
            $old_data = $request->all();
            $data = array(
                'username' => $old_data['t_name'],
                'password' => md5($old_data['t_number']),
                'number' => $old_data['t_number'],
                'class' => $old_data['t_class'],
                'role' => 1,
            );
            $res = UserModel::where('id', '=', $old_data['id'])->where('role', '=', 1)->update($data);
            if ($res) {
                $data = array(
                    'code' => 0,
                    'msg' => "修改成功！"
                );
            } else {
                $data = array(
                    'code' => 1,
                    'msg' => "修改失败！"
                );
            }
        }
        return response()->json($data);
    }

    /**
     * @function 查询显示教师信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teacher_list(Request $request)
    {
        $teachers = UserModel::where('role', '=', '1');
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $teachers->where('username', 'like', '%' . $keyword . '%');
        }
        $teachers = $teachers->paginate(1);
        if ($request->has('keyword')){
            $teachers->appends(['keyword'=>$request->input('keyword')]);
        }
        return view('admin.teacher', array(
            'teachers' => $teachers,
        ));
    }

    /**
     * @function 添加学生信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_student(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            's_name' => 'required|min:2|max:32',
            's_number' => 'required|min:5|max:16',
            's_class' => 'required|min:2|max:16',
        ), array(
            'required' => ':attribute为必填项',
            'min' => ':attribute最少为:min个字符',
            'max' => ':attribute最多为:max个字符',
        ), array(
            's_name' => '姓名',
            's_number' => '学号',
            's_class' => '班级',
        ));
        if ($validator->fails()) {
            $data = array(
                'code' => 1,
                'msg' => $validator->errors()->first()
            );

        } else {
            $old_data = $request->all();
            $data = array(
                'username' => $old_data['s_name'],
                'password' => md5($old_data['s_number']),
                'number' => $old_data['s_number'],
                'class' => $old_data['s_class'],
                'role' => 2,
            );
            $res = UserModel::create($data);
            if ($res->wasRecentlyCreated) {
                $data = array(
                    'code' => 0,
                    'msg' => "添加成功！"
                );
            } else {
                $data = array(
                    'code' => 1,
                    'msg' => "添加失败！"
                );
            }
        }
        return response()->json($data);
    }

    /**
     * @function 删除学生信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_student(Request $request)
    {
        $data = array(
            'code'  =>  1,
            'msg'   =>  '删除失败！'
        );
        if($request->has('id')){
            $id = $request->input('id');
            $res_1 = UserModel::find($id)->delete();
            $res_2 = StudentCourseModel::where('user_id','=',$id)->delete();
            if($res_1 !== false && $res_2 !== false) {
                $data = array(
                    'code' => 0,
                    'msg' => '删除成功！'
                );
            }
        }
        return response()->json($data);
    }

    /**
     * @function 修改学生信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_student(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            's_name' => 'required|min:2|max:32',
            's_number' => 'required|min:5|max:16',
            's_class' => 'required|min:2|max:16',
        ), array(
            'required' => ':attribute为必填项',
            'min' => ':attribute最少为:min个字符',
            'max' => ':attribute最多为:max个字符',
        ), array(
            's_name' => '姓名',
            's_number' => '学号',
            's_class' => '班级',
        ));
        if ($validator->fails()) {
            $data = array(
                'code' => 1,
                'msg' => $validator->errors()->first()
            );

        } else {
            $old_data = $request->all();
            $data = array(
                'username' => $old_data['s_name'],
                'password' => md5($old_data['s_number']),
                'number' => $old_data['s_number'],
                'class' => $old_data['s_class'],
                'role' => 2,
            );
            $res = UserModel::where('id', '=', $old_data['id'])->where('role', '=', 2)->update($data);
            if ($res) {
                $data = array(
                    'code' => 0,
                    'msg' => "修改成功！"
                );
            } else {
                $data = array(
                    'code' => 1,
                    'msg' => "修改失败！"
                );
            }
        }
        return response()->json($data);
    }

    /**
     * @function 查询显示学生信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function student_list(Request $request)
    {
        $students = UserModel::where('role', '=', '2');
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $students->where('username', 'like', '%' . $keyword . '%');
        }
        $students = $students->paginate(1);
        if ($request->has('keyword')){
            $students->appends(['keyword'=>$request->input('keyword')]);
        }
        return view('admin.student', array(
            'students' => $students,
        ));
    }

    /**
     * @function 重置或修改密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset_password(Request $request)
    {
        if($request->isMethod('post')){
            $id = $request->session()->get('u_id');
            $validator = Validator::make($request->all(), array(
                'password' => 'required|min:5|max:16',
                're_password' => 'required|min:5|max:16',
            ), array(
                'required' => ':attribute为必填项',
                'min' => ':attribute最少为:min个字符',
                'max' => ':attribute最多为:max个字符',
            ), array(
                'password' => '密码',
                're_password' => '密码',
            ));
            if ($validator->fails()) {
                $data = array(
                    'code' => 1,
                    'msg' => $validator->errors()->first()
                );
            }else if($request->input('password') != $request->input('re_password')){
                $data = array(
                    'code' => 1,
                    'msg' => '两次密码输入不一致'
                );
            }else{
                $password = $request->input('password');
            }
        }else{
            $id = $request->input('id');
            $password = UserModel::find($id)['number'];
        }
        if(!isset($data)){
            $res = UserModel::find($id)->update(array('password'=>md5($password)));
            if($res){
                $data = array(
                    'code' => 0,
                    'msg' => '修改成功！'
                );
            }else{
                $data = array(
                    'code' => 1,
                    'msg' => '修改失败！'
                );
            }
        }
        return response()->json($data);
    }

    /**
     * @function 用户中心展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function center(Request $request){
        $role = $request->session()->get('u_role');
        $id = $request->session()->get('u_id');
        $info = UserModel::find($id);
        if($role == 1){
            return view('teacher.center', array('info'=>$info));
        }else if($role == 2){
            return view('student.center', array('info'=>$info));
        }
    }

    /**
     * @function 学生选课
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function select_course(Request $request)
    {
        $u_id = $request->session()->get('u_id');
        $c_id = $request->input('id');
        if(StudentCourseModel::where('user_id','=',$u_id)->where('course_id','=',$c_id)->count() != 0){
            $data = array(
                'code'  =>  1,
                'msg'   =>  '不能重复选择已选课程！'
            );
        }else if(StudentCourseModel::where('course_id','=',$c_id)->count() == CourseModel::find($c_id)['size']){
            $data = array(
                'code'  =>  1,
                'msg'   =>  '课程已满！'
            );
        }else{
            $res = StudentCourseModel::create(array('user_id'=>$u_id,'course_id'=>$c_id));
            if ($res->wasRecentlyCreated) {
                $data = array(
                    'code' => 0,
                    'msg' => "选课成功！"
                );
            } else {
                $data = array(
                    'code' => 1,
                    'msg' => "选课失败！"
                );
            }
        }
        return response()->json($data);
    }

    /**
     * @function 学生退课
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function un_select_course(Request $request)
    {
        $u_id = $request->session()->get('u_id');
        $c_id = $request->input('id');
        $res = StudentCourseModel::where('user_id','=',$u_id)->where('course_id','=',$c_id)->delete();
        if ($res) {
            $data = array(
                'code' => 0,
                'msg' => "退课成功！"
            );
        } else {
            $data = array(
                'code' => 1,
                'msg' => "退课失败！"
            );
        }
        return response()->json($data);
    }
}