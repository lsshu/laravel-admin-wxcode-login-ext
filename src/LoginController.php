<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/29
 * Time: 17:32
 */
namespace Lsshu\LaravelAdminWxcodeLoginExt;
use Encore\Admin\Controllers\AuthController;
class LoginController extends AuthController
{
    use StoreTrait;
    /**
     * 配置 admin 配置
     * @param $path
     */
    protected function overrideConfig($path="admin")
    {
        $config = require config("admin.extensions.multitenancy.$path");
        config(['admin' => $config]);
        config(array_dot(config('admin.auth', []), 'auth.'));
    }
}