<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/28
 * Time: 20:04
 */
namespace Lsshu\LaravelAdminWxcodeLoginExt;
use Illuminate\Http\Request;
use Auth;
use QrCode;
class Controller
{
    use StoreTrait;

    /**
     * 登录页面
     * @param Request $request
     * @param string $path
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request, $path='admin')
    {
        if ($this->guard()->check()) {
            return redirect($path);
        }
        /*获取登录字符串*/
        if (!$request->session()->exists('login_string')) {
            $string = getRandString(50);
            $this->setStore($string,0);
            $request->session()->put('login_string', $string);
        }else{
            $string = $request->session()->get('login_string');
        }
        /*生成二维码*/
        $code = QrCode::format('png')->size(500)->generate(route(config('code_login.route.name.code_auth_login','code_auth_login'),['login_string'=>$string]));
        $check_login = route(config('code_login.route.name.check_login','check_login'),['login_string'=>$string]);
        return view('code_login::login.login',compact('code','string','check_login'));
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
    /**
     * admin 登录guard
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}