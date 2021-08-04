<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User2 instance or null. You're free to obtain
        // the User2 instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('authorization')) {
                $token = UserToken::where('token',$request->header('authorization'))->first();
                if (!$token){
                    abort(401, $request->header('authorization'));
                }
                return User::where('id', $token->user_id)->first();
            }else{
                abort(401, 'Unauthorized action.');
            }
        });
    }
}
