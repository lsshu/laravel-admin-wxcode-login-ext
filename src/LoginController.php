<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/29
 * Time: 17:32
 */
namespace Lsshu\LaravelAdminWxcodeLoginExt;
use Encore\Admin\Controllers\AuthController;
use Lsshu\LaravelAdminWxcodeLoginExt\Models\WechatUserInfo;
use Illuminate\Http\Request;
use Lsshu\Wechat\Service;
class LoginController extends AuthController
{
    use StoreTrait;
    /**
     * 配置 admin 配置
     * @param $path
     */
    protected function overrideConfig($path="admin")
    {
        if($path!="admin"){
            $config = require config("admin.extensions.multitenancy.$path");
            config(['admin' => $config]);
            config(array_dot(config('admin.auth', []), 'auth.'));
        }
    }

    protected function authLogin($path = 'admin')
    {
        $config = config('code_login.account',[]);
        $account = Service::account($config);
        if( !session()->has('wx_openid') ){
            /*记录当前地址*/
            session(['wx_current_url'=>url()->full()]);
            // 未登录
            $redirect =$account->getAuthorizeBaseInfo(
                route(config('code_login.route.name.authorize_callback','code_authorize_callback'),['path'=>$path]),
                (isset($this->weLoginType) && $this->weLoginType ==='snsapi_userinfo')?'snsapi_userinfo':'snsapi_base'
            );
            return redirect($redirect);
        }
        return true;
    }

    protected function authCheckLogin()
    {
        return ! session()->has('wx_openid');
    }

    /**
     * 微信基本登录回调
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function code_authorize_callback(Request $request)
    {
        $config = config('code_login.account',[]);
        $account = Service::account($config);
        $data = $request->all();
        /*获取openid*/
        $result = $account->getAuthorizeUserOpenId($data['code']);
        if($result['scope'] == 'snsapi_userinfo'){
            $result = $account->getAuthorizeUserInfoByAccessToken($result);
            session(['wx_openid'=>$result['user']['openid'],'wx_user'=>$result['user']]);
            try{
                WechatUserInfo::updateOrCreate(['openid'=>$result['user']['openid']],$result['user']);
            }catch (Exception $exception){}
        }else{
            /*保存登录信息*/
            session(['wx_openid'=>$result['openid']]);
        }
        /*返回登录前页面*/
        $current_url = session('wx_current_url');
        return redirect($current_url);
    }
}