<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public const Email = 'admin@nemsu.edu.ph';

    public const Password = 'password';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => self::Email],
            [
                'name' => 'Administrator',
                'password' => Hash::make(self::Password),
                'email_verified_at' => now(),
                'account_type' => 'admin',
            ],
        );
    }
}
