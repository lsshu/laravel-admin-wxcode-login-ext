<?php

namespace Lsshu\LaravelAdminWxcodeLoginExt\Models;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class WechatUserInfo extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['openid','nickname','sex','language','city','province','country','headimgurl'];

    const SEX = '0';
    const SEX_MALE = '1';
    const SEX_WOMAN = '2';
    public static $sexMap=[
        self::SEX =>'未知',
        self::SEX_MALE =>'男',
        self::SEX_WOMAN =>'女',
    ];
    /**
     * 后台用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin_user()
    {
        $relatedModel = config('admin.database.users_model',AdminUser::class);
        return $this->hasOne($relatedModel,'wechat_user_info_id');
    }
}