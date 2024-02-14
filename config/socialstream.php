<?php

use App\Providers\RouteServiceProvider;
use JoelButcher\Socialstream\Features;
use JoelButcher\Socialstream\Providers;

return [
    'middleware' => ['web'],
    'prompt' => 'Or Login Via',
    'providers' => [
        \JoelButcher\Socialstream\Providers::google(),
        [
            'id' => 'spotify',
            'name' => 'Spple',
            'label' => 'Sign in with Spotify',
        ],
    ],
    'features' => [
        // Features::createAccountOnFirstLogin(),
        // Features::generateMissingEmails(),
        Features::rememberSession(),
        Features::providerAvatars(),
        Features::refreshOAuthTokens(),
    ],
    'home' => RouteServiceProvider::HOME,
    'redirects' => [
        'login' => RouteServiceProvider::HOME,
        'register' => RouteServiceProvider::HOME,
        'login-failed' => '/login',
        'registration-failed' => '/register',
        'provider-linked' => '/user/profile',
        'provider-link-failed' => '/user/profile',
    ]
];