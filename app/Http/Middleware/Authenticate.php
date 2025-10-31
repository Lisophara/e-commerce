<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;

class Authenticate extends FilamentAuthenticate
{
    protected function authenticate($request, array $guards): void
    {
        parent::authenticate($request, $guards);
        auth()->user()->update([
            'last_login_at' => now(),
        ]);
    }
}
