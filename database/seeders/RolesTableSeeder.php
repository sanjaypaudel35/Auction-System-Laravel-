<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Enums\RolesEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RolesEnum::getAllValues();
        foreach ($roles as $role) {
            $seedRole = [
                "name" => Str::slug($role, ' '),
                "slug" => $role
            ];
            Role::factory()->create($seedRole);
        }
    }
}
