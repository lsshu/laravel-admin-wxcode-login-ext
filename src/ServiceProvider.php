<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/28
 * Time: 19:20
 */
namespace Lsshu\LaravelAdminWxcodeLoginExt;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Routing\Router;
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     */
    public function boot(Router $router)
    {
        $this->registerRoute($router);
        $this->loadViewsFrom(__DIR__.'/resources/views/vendor/code_login', 'code_login');
        $this->publishes([
            __DIR__.'/configs/code_login.php' => config_path('code_login.php')
        ], 'code-login-configs');
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations')
        ], 'code-login-migrations');
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views'),
        ], 'code-login-resources');
    }

    /**
     * Register routes.
     *
     * @param $router
     */
    protected function registerRoute($router)
    {
        if (!$this->app->routesAreCached()) {
            $router->group(array_merge(['namespace' => __NAMESPACE__], config('code_login.route.options', [])), function ($router) {
                $name = config('code_login.route.name');
                $controller = config('code_login.route.controller') ?? 'Controller';
                $login = $name['login'] ?? 'login';
                $register = $name['register'] ?? 'register';
                $code_auth_login = $name['code_auth_login'] ?? 'code_auth_login';
                $check_login = $name['check_login'] ?? 'check_login';

                $router->get('{path}/'.$login,$controller.'@'.$login)->name($login);
                $router->get('{path}/'.$register,$controller.'@'.$register)->name($register);
                $router->get('{path}/'.$code_auth_login.'/{login_string}', $controller.'@'.$code_auth_login)->name($code_auth_login);
                $router->get('{path}/'.$check_login.'/{login_string}', $controller.'@'.$check_login)->name($check_login);

            });
        }
    }
}