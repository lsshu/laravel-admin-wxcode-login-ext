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
use Lsshu\LaravelAdminWxcodeLoginExt\Models\AdminUser;
use Lsshu\LaravelAdminWxcodeLoginExt\Models\WechatUserInfo;
class Controller extends LoginController
{
    /**
     * 登录页面
     * @param Request $request
     * @param string $path
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function code_login(Request $request, $path='admin')
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
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
        $code = QrCode::format('png')->size(500)->generate(route(config('code_login.route.name.code_auth_login','code_auth_login'),['login_string'=>$string,'path'=>$path]));
        $check_login = route(config('code_login.route.name.check_login','check_login'),['login_string'=>$string,'path'=>$path]);
        return view('code_login::login.login',compact('code','string','check_login'));
    }
    /**
     * 检查登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function code_check_login($path='admin',$login_string)
    {
        $this->overrideConfig($path);
        if('1' == $this->getStore($login_string)){
            $openid = $this->getStore($login_string.'_id');
            //获取信息用户信息
            $wx_user = WechatUserInfo::where('openid',$openid)->first();
            // 登录操作
            $this->guard()->login($wx_user->admin_user,config("code_login.login.$path.remember",true));
            // 清除redis session
            $this->delStore($login_string);
            $this->delStore($login_string.'_id');
            // 返回
            return response()->json(['status'=>'success','text'=>'登录成功！','redirect'=>url($this->redirectPath())]);
        }else{
            return response()->json(['status'=>'error','text'=>'登录失败！']);
        }
    }
    /**
     * 授权登录
     * @param Request $request
     * @param $login_string
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function code_auth_login(Request $request,$path='admin', $login_string)
    {
        $this->overrideConfig($path);
        /*判断微信授权 是否已经登录*/
        if($this->authCheckLogin()){
            return $this->authLogin($path);
        }

        $wechatUser = WechatUserInfo::where('openid',session('wx_openid'))->first();
        if($wechatUser && $wechatUser->admin_user){
            $this->setStore($login_string,1);
            $this->setStore($login_string.'_id',session('wx_openid'));
            return view('code_login::login.code_auth_login',['title'=>'登录提示！','content'=>'登录成功！','description'=>'可以关闭此页面！']);
        } elseif ($wechatUser) {
            $redirect_url = route(config('code_login.route.name.register'),['path'=>$path]);
            return view('code_login::login.choose_or_register',['title'=>'授权提示！','content'=>'授权成功！','description'=>'请先注册账户！正在前往，稍等！','redirect_url'=>$redirect_url]);
        }
        /*授权失败 未有WechatUserInfo*/
    }

    /**
     * 默认注册页 操作
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function code_register(Request $request,$path='admin')
    {
        $this->overrideConfig($path);
        /*判断微信授权 是否已经登录*/
        if($this->authCheckLogin()){
            return $this->authLogin($path);
        }

        if ($request->isMethod('post')){
            $data = $request->only(['username','name']);
            $data['password'] = bcrypt(config("code_login.login.$path.register_default_password",''));
            $wechatUser = WechatUserInfo::where('openid',session('wx_openid'))->first();
            $res = $wechatUser->admin_user()->updateOrCreate($data);
            if($res){
                return response()->json(['status'=>'success','text'=>'注册成功！']);
            }
            return response()->json(['status'=>'error','text'=>'注册失败！']);
        }
        $redirect_url = url($this->redirectPath());
        return view('code_login::login.register',compact('redirect_url'));
    }

}