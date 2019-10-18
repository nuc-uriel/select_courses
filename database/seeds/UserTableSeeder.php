<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert(array(
            array(
                'username'  =>  'admin',
                'password'   =>  md5('admin'),
                'role'   =>  0,
                'created_at'    =>  date("Y-m-d H:i:s"),
                'updated_at'    =>  date("Y-m-d H:i:s"),
            )
        ));
    }
}
