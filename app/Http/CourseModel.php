<?php
/**
 * Created by PhpStorm.
 * User: uriel
 * Date: 2018/5/24 0024
 * Time: 16:48
 */

namespace App\Http;


use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model
{
    protected $table = 'course';
    protected $fillable = array('teacher_id','name', 'score', 'class', 'time', 'size');
}