<?php

namespace Database\Factories;

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            [
                'name' => "administrator",
                'email' => "aution@gmail.com",
                'email_verified_at' => now(),
                "password" => Hash::make("password"),
                "role_id" => Role::where("slug", RolesEnum::SUPER_ADMIN->value)->first()->id,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "sanjay",
                'email' => "jaysanpaudel35@gmail.com",
                'email_verified_at' => now(),
                "password" => Hash::make("password"),
                "role_id" => Role::where("slug", RolesEnum::CUSTOMER->value)->first()->id,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "master",
                'email' => "mastera@gmail.com",
                'email_verified_at' => now(),
                "password" => Hash::make("password"),
                "role_id" => Role::where("slug", RolesEnum::MASTER_ADMIN->value)->first()->id,
                'remember_token' => Str::random(10),
            ],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
