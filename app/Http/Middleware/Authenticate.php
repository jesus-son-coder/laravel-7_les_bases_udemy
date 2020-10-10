<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            /* Vu que nous n'avons pas encore de route "login" ... */
            //return route('login');

            /* ...nous allons changer cette route de redirection avec celle ci-dessous : */
            return route('failure');
        }
    }
}
