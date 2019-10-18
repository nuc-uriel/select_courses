<?php
/**
 * Created by PhpStorm.
 * User: uriel
 * Date: 2018/5/24 0024
 * Time: 16:48
 */

namespace App\Http;


use Illuminate\Database\Eloquent\Model;

class StudentCourseModel extends Model
{
    protected $table = 'student_course';
    protected $fillable = array('user_id','course_id', 'score');
}