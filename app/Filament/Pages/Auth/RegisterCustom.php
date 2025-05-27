<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;

class RegisterCustom extends Register
{
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(User::class, 'email')
                ->maxLength(255),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->rule(Password::default())
                ->same('passwordConfirmation'),

            TextInput::make('passwordConfirmation')
                ->label('Confirm Password')
                ->password()
                ->required(),

            ];
    }

    protected function handleRegistration(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // <--- Set default role di sini
        ]);
    }
    protected function getRedirectUrl(): string
    {
     if (Auth::user()->role === 'admin') {
        return config('filament.home_url'); // atau route admin-mu
    }

    return route('user.dashboard'); // route ke dashboard user
    }
}
