<?php

namespace Database\Seeders;

use App\Enums\Users\RoleNameEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'name' => RoleNameEnum::ADMIN->value,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('roles')
            ->insertOrIgnore($roles);
    }
}
