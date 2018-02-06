<?php

namespace App\Providers;

use App;
use Request;
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
        // 设置当前项目信任的外层代理机IP，用于安全验证等
        Request::setTrustedProxies(explode(',', config('app.trusted_proxies')));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!App::environment('production')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
