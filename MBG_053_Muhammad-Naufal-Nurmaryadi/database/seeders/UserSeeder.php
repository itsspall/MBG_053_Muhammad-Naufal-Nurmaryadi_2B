<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Gudang
            ['id' => 1, 'name' => 'Budi Santoso', 'email' => 'budi.gudang@mbg.id', 'role' => 'gudang', 'created_at' => '2025-09-01 08:00:00'],
            ['id' => 2, 'name' => 'Siti Aminah', 'email' => 'siti.gudang@mbg.id', 'role' => 'gudang', 'created_at' => '2025-09-01 08:05:00'],
            ['id' => 3, 'name' => 'Rahmat Hidayat', 'email' => 'rahmat.gudang@mbg.id', 'role' => 'gudang', 'created_at' => '2025-09-01 08:10:00'],
            ['id' => 4, 'name' => 'Lina Marlina', 'email' => 'lina.gudang@mbg.id', 'role' => 'gudang', 'created_at' => '2025-09-01 08:15:00'],
            ['id' => 5, 'name' => 'Anton Saputra', 'email' => 'anton.gudang@mbg.id', 'role' => 'gudang', 'created_at' => '2025-09-01 08:20:00'],
            // Dapur
            ['id' => 6, 'name' => 'Dewi Lestari', 'email' => 'dewi.dapur@mbg.id', 'role' => 'dapur', 'created_at' => '2025-09-01 08:30:00'],
            ['id' => 7, 'name' => 'Andi Pratama', 'email' => 'andi.dapur@mbg.id', 'role' => 'dapur', 'created_at' => '2025-09-01 08:35:00'],
            ['id' => 8, 'name' => 'Maria Ulfa', 'email' => 'maria.dapur@mbg.id', 'role' => 'dapur', 'created_at' => '2025-09-01 08:40:00'],
            ['id' => 9, 'name' => 'Surya Kurnia', 'email' => 'surya.dapur@mbg.id', 'role' => 'dapur', 'created_at' => '2025-09-01 08:45:00'],
            ['id' => 10, 'name' => 'Yanti Fitri', 'email' => 'yanti.dapur@mbg.id', 'role' => 'dapur', 'created_at' => '2025-09-01 08:50:00'],
        ];

        foreach ($users as $user) {
            User::create(array_merge($user, [
                'password' => Hash::make('pass123')
            ]));
        }
    }
}