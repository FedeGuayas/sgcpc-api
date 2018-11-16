<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function ($user){
           Mail::to($user)->send(new UserCreated($user));
        });
        User::updated(function ($user){
            if ($user->isDirty('email')){ //solo enviar el correo si ha sido cambiado el email
                Mail::to($user)->send(new UserMailChanged($user));
            }
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
