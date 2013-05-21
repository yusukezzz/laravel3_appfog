<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Application Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the encryption and cookie classes to generate secure
    | encrypted strings and hashes. It is extremely important that this key
    | remains secret and it should not be shared with anyone. Make it about 32
    | characters of random gibberish.
    |
    */

    'key' => 'YourProductionSecretKeyGoesHere!',

    /*
    |--------------------------------------------------------------------------
    | Profiler Toolbar
    |--------------------------------------------------------------------------
    |
    | Laravel includes a beautiful profiler toolbar that gives you a heads
    | up display of the queries and logs performed by your application.
    | This is wonderful for development, but, of course, you should
    | disable the toolbar for production applications.
    |
    */

    'profiler' => false,

    /*
    |--------------------------------------------------------------------------
    | Logentries config for appfog
    |--------------------------------------------------------------------------
    | appfog では通常のアプリケーションログを参照できない（デプロイの度に消える）ので、
    | Logentries という SIaaS を使います
    | 詳細は下記公式ドキュメントをお読み下さい
    | https://docs.appfog.com/add-ons/logentries
    |
    | laravel3_appfog では production の時だけ laravel.log イベントのリスナーを設定し、
    | Laravel の Log でログ出力があったら Logentries に流しこむようにしてみました
    | severity で指定したプライオリティ以上のものだけ出力します（syslog 準拠）
    | 参考： http://www.php.net/manual/ja/function.syslog.php
    */

    'use_logentries' => true,
    'logentries' => array(
        'token'      => getenv('LOGENTRIES_TOKEN'),
        'persistent' => true,
        'use_ssl'    => true,
        'severity'   => LOG_DEBUG,
    ),

);
