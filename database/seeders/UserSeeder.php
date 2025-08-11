<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // daftar role sesuai Spatie
        $roles = [
            'superadmin',
            'admin',
            'kankemenag',
            'madrasah',
        ];

        // pastikan semua role ada di DB
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 1 user per role, dengan email slugified + @example.com, password di-hash, dan phone unik
        foreach ($roles as $roleName) {
            User::factory()->create([
                'name'       => ucfirst($roleName) . ' User',
                'kode_institusi'       => Str::upper(Str::random(10)),
                'email'      => Str::slug($roleName) . '@gmail.com',
                'password'   => Hash::make('secret123', [
                    'memory' => 1024,
                    'time' => 2,
                    'threads' => 2,
                    'rounds' => 12,
                ]), // ganti sesuai kebutuhan
                'phone'      => $faker->unique()->numerify('082########'),
            ])->assignRole($roleName);
        }

        // 10 user random dengan role acak, password & phone juga di-hash & unik
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create([
                'password' => Hash::make('secret123', [
                    'memory' => 1024,
                    'time' => 2,
                    'threads' => 2,
                    'rounds' => 12,
                ]),
                'phone'    => $faker->unique()->numerify('082########'),
            ]);
            $user->assignRole(Role::inRandomOrder()->first()->name);
        }
    }
}