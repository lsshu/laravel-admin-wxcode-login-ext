<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/28
 * Time: 19:32
 */

return [
    'login'=>[
        'admin'=>[
            'remember'=>true, // false 值可能出现不能记住登录
            'register_default_password'=>'', //默认注册密码
        ],
    ],
    'login_type'=>'',
    'wechat_user'=>[
        'table'=>'',
        'model'=>Lsshu\LaravelAdminWxcodeLoginExt\Models\WechatUserInfo::class,
    ],
    'route'=>[
        'options'=>[
            //'prefix'=>'lsshu',
            // ...
        ],
        'name'=>[
            'login'=>'code_login',// 登录
            'register'=>'code_register',// 注册
            'auth_login'=>'code_auth_login',// 授权登录
            'check_login'=>'code_check_login',// 检查是否登录
            'authorize_callback'=>'code_authorize_callback',// 微信授权回调
        ],
        'controller'=>'Controller' // 处理登录 注册方法控制器
    ],
    'account'=>[
        'appId'=>env('ACCOUNT_APPID',''),
        'appSecret'=>env('ACCOUNT_APPSECRET',''),
    ], // 微信公众号配置
];