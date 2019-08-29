<h1 align="center"> laravel-admin-wxcode-login-ext </h1>

<p align="center"> laravel-admin微信扫码录.</p>


## Installing

```shell
$ composer require lsshu/laravel-admin-wxcode-login-ext
```

## Usage

### Publish resources
```shell
$ php artisan vendor:publish --provider="Lsshu\LaravelAdminWxcodeLoginExt\ServiceProvider"
```
### Migration
```shell
$ php artisan migrate
```
### Modify configuration 
##### file config/admin.php
```php
'auth' => [
    // Redirect to the specified URI when user is not authorized.
    'redirect_to' => 'code_login',
],
```
###Take Care
**After installation, administrators may need to manually modify the field “wechat_user_info_id” of the user table to “1”**

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/lsshu/laravel-admin-wxcode-login-ext/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/lsshu/laravel-admin-wxcode-login-ext/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT