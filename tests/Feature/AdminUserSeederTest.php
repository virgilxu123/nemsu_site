<?php

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Support\Facades\Hash;

test('admin user seeder creates an admin account', function () {
    $this->seed(AdminUserSeeder::class);

    $admin = User::query()
        ->where('email', AdminUserSeeder::Email)
        ->firstOrFail();

    expect($admin->name)->toBe('Administrator')
        ->and($admin->account_type)->toBe('admin')
        ->and($admin->email_verified_at)->not->toBeNull()
        ->and(Hash::check(AdminUserSeeder::Password, $admin->password))->toBeTrue();
});

test('admin user seeder is idempotent', function () {
    User::factory()->create([
        'name' => 'Existing Admin',
        'email' => AdminUserSeeder::Email,
        'account_type' => 'contributor',
    ]);

    $this->seed(AdminUserSeeder::class);
    $this->seed(AdminUserSeeder::class);

    expect(User::query()->where('email', AdminUserSeeder::Email)->count())->toBe(1)
        ->and(User::query()->where('email', AdminUserSeeder::Email)->first()?->account_type)->toBe('admin');
});
