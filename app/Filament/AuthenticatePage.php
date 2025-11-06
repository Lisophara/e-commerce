<?php

namespace App\Filament;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;

class AuthenticatePage extends Login
{
    public function authenticate(): ?LoginResponse
    {
        // Login data
        $data = $this->form->getState();
        $response = parent::authenticate();

        if ($response instanceof LoginResponse) {
            auth()->user()->update([
                'last_login_at' => now(),
            ]);
        }
        return $response;
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::auth/pages/login.form.email.label'))
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }
}
