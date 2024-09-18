<?php

namespace Database\Seeders;

use App\Enums\Users\RoleNameEnum;
use App\Enums\Users\UserStatusEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdmin();
    }

    private function createAdmin(): void
    {
        $roleId = Role::where('name', '=', RoleNameEnum::ADMIN->value)
            ->first()->id;

        $user = new User();
        $user->role_id = $roleId;
        $user->name = 'superadmin';
        $user->username = 'superadmin';
        $user->password = Hash::make('password');
        $user->status = UserStatusEnum::ACTIVE->value;
        $user->save();
    }
}
