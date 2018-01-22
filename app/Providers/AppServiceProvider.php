<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Auth;
use Hash;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        // https://blog.petehouston.com/2017/08/31/force-http-or-https-scheme-on-laravel-automatically/
        if(env('REDIRECT_HTTPS')) {
            $url->forceScheme('https');
        }

        // https://itsolutionstuff.com/post/laravel-5-create-custom-validation-rule-exampleexample.html
        Validator::extend('passcheck', function($attribute, $value, $parameters)
        {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });

        Validator::extend('usernamecheck', function($attribute, $value, $parameters)
        {
            if (in_array($value, ['posts', 'search', 'groups', 'groups', 'post', 'home', 'follow'])) return false;
            $filter = "[^a-zA-Z0-9\-\_\.]";
            return preg_match("~" . $filter . "~iU", $value) ? false : true;
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
