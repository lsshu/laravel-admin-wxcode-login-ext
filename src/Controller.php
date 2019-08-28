<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/28
 * Time: 20:04
 */
namespace Lsshu\LaravelAdminWxcodeLoginExt;
use Illuminate\Http\Request;
class Controller
{
    /**
     * 登录页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        return view('code_login::login.login');
    }
    /**
     * 检查登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkLogin($login_string)
    {
        dump("checkLogin");
    }
    /**
     * @param Request $request
     * @param $login_string
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function codeAuthLogin(Request $request, $login_string)
    {
        dump("codeAuthLogin");
    }

    /**
     * 默认注册页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        return view('code_login::login.register');
    }
}