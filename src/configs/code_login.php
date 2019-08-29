<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/28
 * Time: 19:32
 */

return [
    'route'=>[
        'options'=>[

        ],
        'name'=>[
            'login'=>'code_login',// 登录
            'register'=>'code_register',// 注册
            'auth_login'=>'code_auth_login',// 授权登录
            'check_login'=>'code_check_login',// 检查是否登录
            'authorize_callback'=>'code_authorize_callback',// 微信授权回调
        ],
        'controller'=>'Controller'
    ]
];