<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Passport::routes();
        Passport::routes(null, ['prefix' => 'api/oauth']);
        // tiempo de expiracion del token
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        // tiempo de expiracion del refresh token debe ser mayor al anterior
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

    }
}
