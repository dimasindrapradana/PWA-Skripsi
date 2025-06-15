<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class LoginCustom extends Login
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'name';

        if (Auth::attempt([$field => $data['login'], 'password' => $data['password']], $data['remember'] ?? false)) {
            session()->regenerate();

            return app(LoginResponse::class);
        }

        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                     ->schema([
                         TextInput::make('login')
                             ->label('Nama / Email')
                             ->required()
                             ->autofocus(),
                         TextInput::make('password')
                             ->label('Password')
                             ->password()
                             ->required(),
                     ])
                     ->statePath('data')
            ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // setelah login, balik ke /admin (Dashboard Filament)
        return url(config('filament.panels.admin.path'));
    }

    public static function registerNavigationItems(): array
    {
        return [];
    }
}
