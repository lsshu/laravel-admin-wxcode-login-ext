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
        $this->publishes([
            __DIR__.'/resources/assets' => public_path('vendor/code-login')
        ], 'code-login-assets');
    }

    /**
     * Register routes.
     *
     * @param $router
     */
    protected function registerRoute($router)
    {
        if (!$this->app->routesAreCached()) {
            $router->group(array_merge(['namespace' => __NAMESPACE__,'middleware' => 'web',], config('code_login.route.options', [])), function ($router) {
                $name = config('code_login.route.name');
                $controller = config('code_login.route.controller') ?? 'Controller';
                $login = $name['login'] ?? 'code_login';
                $register = $name['register'] ?? 'code_register';
                $code_auth_login = $name['auth_login'] ?? 'code_auth_login';
                $check_login = $name['check_login'] ?? 'code_check_login';
                $authorize_callback = $name['authorize_callback'] ?? 'code_authorize_callback';

                $router->get('{path}/'.$login,$controller.'@'.$login)->name($login); // 登录
                $router->get('{path}/'.$register,$controller.'@'.$register)->name($register); // 注册页面
                $router->post('{path}/'.$register,$controller.'@'.$register)->name($register); // 注册操作
                $router->get('{path}/'.$code_auth_login.'/{login_string}', $controller.'@'.$code_auth_login)->name($code_auth_login); // 授权登录
                $router->get('{path}/'.$check_login.'/{login_string}', $controller.'@'.$check_login)->name($check_login); // 检查是否登录
                $router->get('{path}/'.$authorize_callback, $controller.'@'.$authorize_callback)->name($authorize_callback); // 微信授权回调
            });
        }
    }
}