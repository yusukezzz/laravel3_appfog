# appfog 向け laravel 3.2.14

appfog ですぐに使えるように設定ファイル等を考慮した laravel です
設定すべきファイルは下記の通り

-   paths.php

    production(appfog で作成したアプリ) のホスト名

-   application/config/production/application.php

    本番向けの key を設定
    Logentries 向けの severity 等を設定

-   application/config/production/database.php

    af tunnel の結果で migration 出来るようにしておくといいと思います

-   application/libraries/logentries.php

    appfog で logentries のアドオンを有効にしていると以下の様なLogクラスの出力を自動的に送信します
    priority は syslog 準拠です。
    Log::debug('This is just a log message');
    Log::info('This is just a log message');
    Log::notice('This is just a log message');
    Log::warn('This is just a log message');
    Log::error('This is just a log message');
    Log::err('This is just a log message');
    Log::critical('This is just a log message');
    Log::crit('This is just a log message');
    Log::alert('This is just a log message');
    Log::emergency('This is just a log message');
    Log::emerg('This is just a log message');

以下、オリジナルの readme

# [Laravel](http://laravel.com) - A PHP Framework For Web Artisans

Laravel is a clean and classy framework for PHP web development. Freeing you
from spaghetti code, Laravel helps you create wonderful applications using
simple, expressive syntax. Development should be a creative experience that you
enjoy, not something that is painful. Enjoy the fresh air.

[Official Website & Documentation](http://laravel.com)

## Feature Overview

- Simple routing using Closures or controllers.
- Views and templating.
- Driver based session and cache handling.
- Database abstraction with query builder.
- Authentication.
- Migrations.
- PHPUnit Integration.
- A lot more.

## A Few Examples

### Hello World:

```php
<?php

Route::get('/', function()
{
	return "Hello World!";
});
```

### Passing Data To Views:

```php
<?php

Route::get('user/(:num)', function($id)
{
	$user = DB::table('users')->find($id);

	return View::make('profile')->with('user', $user);
});
```

### Redirecting & Flashing Data To The Session:

```php
<?php

return Redirect::to('profile')->with('message', 'Welcome Back!');
```

## Contributing to Laravel

Contributions are encouraged and welcome; however, please review the Developer
Certificate of Origin in the "license.txt" file included in the repository. All
commits must be signed off using the `-s` switch.

```bash
git commit -s -m "this commit will be signed off automatically!"
```

## License

Laravel is open-sourced software licensed under the MIT License.
