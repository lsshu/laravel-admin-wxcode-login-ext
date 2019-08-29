<?php

namespace Lsshu\LaravelAdminWxcodeLoginExt\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class AdminUser extends \Encore\Admin\Auth\Database\Administrator
{
    use Notifiable;
    protected $fillable = ['username', 'name'];

    /**
     * 微信信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wechat_user()
    {
        return $this->belongsTo(WechatUserInfo::class, 'wechat_user_info_id');
    }
    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar)) {
            return $avatar;
        }

        $disk = config('admin.upload.disk');

        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }
        
        $default = config('admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';

        return $this->wechat_user->headimgurl ?? admin_asset($default);
    }
}
