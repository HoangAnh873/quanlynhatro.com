<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Host; // Nếu bạn có model Host
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản Admin với role 'admin'
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
        ]);

        // Tạo tài khoản Chủ Trọ với role 'host'
        $hostUser = User::create([
            'name'     => 'Chủ Trọ',
            'email'    => 'host@example.com',
            'password' => Hash::make('123456'),
            'role'     => 'host',
        ]);

        // Nếu bạn muốn tạo thêm record cho model Host,
        // giả sử bảng hosts có trường user_id, address, phone, ...
        // Bạn có thể uncomment đoạn code dưới đây và chỉnh sửa theo bảng hosts của bạn.
        /*
        Host::create([
            'user_id' => $hostUser->id,
            'address' => 'Số 1, Đường ABC, Quận XYZ',
            'phone'   => '0123456789',
        ]);
        */
    }
}
