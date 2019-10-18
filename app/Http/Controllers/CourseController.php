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
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * @function 添加课程
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_course(Request $request){
        $role = $request->session()->get('u_role');
        $validator_role = array(
            'c_name' => 'required|min:2|max:32',
            'c_score' => 'required|numeric',
            'c_class' => 'required|min:2|max:16',
            'c_time' => ['required','regex:/\d{1,2}-\d{1,2}\((一|二|三|四|五|六|日)\)/'],
            'c_size' => 'required|Integer',
        );
        if($role == 0){
            $validator_role['c_teacher'] = 'required';
        }
        $validator = Validator::make($request->all(), $validator_role, array(
            'required' => ':attribute为必填项',
            'min' => ':attribute最少为:min个字符',
            'max' => ':attribute最多为:max个字符',
            'numeric' => ':attribute必须为数字',
            'c_time.regex' => ':attribute格式错误',
            'Integer' => ':attribute必须为整数',
        ), array(
            'c_name' => '课程名称',
            'c_score' => '学分',
            'c_class' => '教室',
            'c_teacher'=>'任课老师',
            'c_time' => '上课时间',
            'c_size' => '课余量',
        ));

        if ($validator->fails()) {
            $data = array(
                'code' => 1,
                'msg' => $validator->errors()->first()
            );

        } else if($role==0 && !UserModel::where('role','=','1')->find($request->input('c_teacher'))){
            $data = array(
                'code' => 1,
                'msg' => '教师不存在'
            );
        }else{
            $old_data = $request->all();
            $data = array(
                'name' => $old_data['c_name'],
                'score' => $old_data['c_score'],
                'class' => $old_data['c_class'],
                'time' => $old_data['c_time'],
                'size' => $old_data['c_size'],
            );
            $data['teacher_id'] = $role==1?$request->session()->get('u_id'):$old_data['c_teacher'];
            $res = CourseModel::create($data);
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
     * @function 删除课程
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_course(Request $request){
        $data = array(
            'code'  =>  1,
            'msg'   =>  '删除失败！'
        );
        $role = $request->session()->get('u_role');
        if($request->has('id')){
            $id = $request->input('id');
            if(($role==1 && CourseModel::find($id)['teacher_id'] == $request->session()->get('u_id')) || $role==0){
                $res_1 = CourseModel::find($id)->delete();
                $res_2 = StudentCourseModel::where('course_id','=',$id)->delete();
                if($res_1 !== false && $res_2 !== false) {
                    $data = array(
                        'code' => 0,
                        'msg' => '删除成功！'
                    );
                }
            }else{
                $data['msg'] = '您无权操作该课程';
            }

        }
        return response()->json($data);
    }

    /**
     * @function 更新课程
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_course(Request $request){
        $role = $request->session()->get('u_role');
        $validator_role = array(
            'c_name' => 'required|min:2|max:32',
            'c_score' => 'required|numeric',
            'c_class' => 'required|min:2|max:16',
            'c_time' => ['required','regex:/\d{1,2}-\d{1,2}\((一|二|三|四|五|六|日)\)/'],
            'c_size' => 'required|Integer',
        );
        if($role == 0){
            $validator_role['c_teacher'] = 'required';
        }
        $validator = Validator::make($request->all(), $validator_role, array(
            'required' => ':attribute为必填项',
            'min' => ':attribute最少为:min个字符',
            'max' => ':attribute最多为:max个字符',
            'numeric' => ':attribute必须为数字',
            'c_time.regex' => ':attribute格式错误',
            'Integer' => ':attribute必须为整数',
        ), array(
            'c_name' => '课程名称',
            'c_score' => '学分',
            'c_class' => '教室',
            'c_teacher'=>'任课老师',
            'c_time' => '上课时间',
            'c_size' => '课余量',
        ));

        if ($validator->fails()) {
            $data = array(
                'code' => 1,
                'msg' => $validator->errors()->first()
            );

        } else if($role==0 && !UserModel::where('role','=','1')->find($request->input('c_teacher'))){
            $data = array(
                'code' => 1,
                'msg' => '教师不存在'
            );
        }else if(StudentCourseModel::where('course_id','=',$request->input('id'))->count() > $request->input('c_size')){
            $data = array(
                'code' => 1,
                'msg' => '课余量不可小于已选课学生数量'
            );
        }
        else{
            $old_data = $request->all();
            $data = array(
                'name' => $old_data['c_name'],
                'score' => $old_data['c_score'],
                'class' => $old_data['c_class'],
                'time' => $old_data['c_time'],
                'size' => $old_data['c_size'],
            );
            $data['teacher_id'] = $role==1?$request->session()->get('u_id'):$old_data['c_teacher'];
            $res = CourseModel::find($old_data['id'])->update($data);
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
     * @function 查询展示课程列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function course_list(Request $request){
        $courses = CourseModel::leftJoin('user','teacher_id','=','user.id')->leftJoin(DB::raw('(select `course_id`,COUNT(`course_id`) as num from `sc_student_course` group by `course_id`) as `sc`'), 'course_id', '=', 'course.id')->select(array('course.*', 'user.username as teacher',DB::raw('IFNULL(`num`, 0) as `num`')));
        if($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $courses->where('name', 'like', '%' . $keyword . '%');
        }
        $u_role = $request->session()->get('u_role');
        if($u_role == 1){
            $courses->where('teacher_id', '=', $request->session()->get('u_id'));
        }
        if(ends_with($request->url(), 'scr')){
            $id = $request->session()->get('u_id');
            $c_list = StudentCourseModel::where('user_id','=',$id)->pluck('course_id');
            $selected_list = [];
            foreach ($c_list as $k=>$v)
                $selected_list[] = $v;
            $courses->whereIn('course.id', $selected_list);
        }
//        dd($courses->get());
        $courses = $courses->paginate(1);
        $teachers = UserModel::where('role','=','1')->get();
        switch ($u_role){
            case 0: $view = 'admin.course';break;
            case 1: $view = 'teacher.course';break;
            case 2: $view = ends_with($request->url(), 'scr')?'student.result':'student.sc';break;
        }
        if ($request->has('keyword')){
            $courses->appends(['keyword'=>$request->input('keyword')]);
        }
        return view($view, array(
            'teachers'  =>  $teachers,
            'courses'  =>  $courses,
        ));
    }

    /**
     * @function 选课学生列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function course_student_list(Request $request){
        $role = $request->session()->get('u_role');
        if($request->has('id')){
            $id = $request->input('id');
            if(($role==1 && CourseModel::find($id)['teacher_id'] == $request->session()->get('u_id')) || $role==0){
                $students = StudentCourseModel::where('course_id','=',$id)->leftJoin('user', 'user_id','=','user.id')->select(['student_course.*', 'username', 'class', 'number'])->paginate(1);
                $students->appends(['id'=>$id]);
                return view('admin.info', array(
                    'students'  =>  $students
                ));
            }
        }
        return abort(404);
    }
}