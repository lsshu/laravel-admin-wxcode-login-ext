<h1 align="center"> laravel-admin-wxcode-login-ext </h1>

<p align="center"> laravel-admin微信扫码录.</p>


## 安装

```shell
$ composer require lsshu/laravel-admin-wxcode-login-ext
```

### 发布资源
```shell
$ php artisan vendor:publish --provider="Lsshu\LaravelAdminWxcodeLoginExt\ServiceProvider"
```
### 数据迁移
```shell
$ php artisan migrate
```
### 修改配置 
打开文件 `config/admin.php`
```php
'auth' => [
    // 如果配置文件config/code_login.php `route.options.prefix` 配置了，请在下面设置相应值
    'redirect_to' => 'code_login', // {prefix}/code_login
],
```
打开文件 `.env` 添加相应微信公众号配置
```php
ACCOUNT_APPID=
ACCOUNT_APPSECRET=
```
###特别注意

**安装完成后，管理员可能需要手动将用户表（如：admin_user）的“wechat_user_info_id”字段修改为“1”**

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/lsshu/laravel-admin-wxcode-login-ext/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/lsshu/laravel-admin-wxcode-login-ext/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT