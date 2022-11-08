<?php

namespace Database\Factories;

use AuthModel\Models\User;
use Illuminate\Support\Str;

class UserFactory
{
    public function create($attribute = null, $user = null)
    {
        $user = $user ?? app()->make('user');
        $faker = \Faker\Factory::create();
        $attributes = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        if (is_array($attribute)) {
            $attributes = $attributes + $attribute;
        }
        $user->update($attributes);
        return $user;
    }
}
