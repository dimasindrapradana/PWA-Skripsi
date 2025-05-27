<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeUserWithRole extends Command
{
    protected $signature = 'make:user';
    protected $description = 'Create a user and choose the role (admin/user)';

    public function handle()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $role = $this->choice(
            'Choose role',
            ['admin', 'user'],
            1 // default to 'user'
        );

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        $this->info("User with role '{$role}' created successfully: {$email}");
    }
}
