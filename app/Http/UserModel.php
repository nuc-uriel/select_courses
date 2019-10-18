<?php
/**
 * Created by PhpStorm.
 * User: uriel
 * Date: 2018/5/24 0024
 * Time: 16:48
 */

namespace App\Http;


use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $fillable = array('username','password', 'role', 'class', 'number');
}