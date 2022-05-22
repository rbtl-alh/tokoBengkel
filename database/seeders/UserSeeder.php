<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputan['name'] = 'Fadlur Rohman';
        $inputan['email'] = 'fadloer@gmail.com';//ganti pake emailmu
        $inputan['password'] = '123258';//passwordnya 123258
        $inputan['username'] = 'fadlur123';//passwordnya 123258       
        $inputan['role'] = 'admin';//kita akan membuat akun atau users in dengan role admin
        User::create($inputan);
    }
}
