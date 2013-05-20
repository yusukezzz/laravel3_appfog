<?php
// PRODUCTION

// もし migration を appfog の mysql に対して実行したい場合は、
// af tunnel コマンドの結果で下記設定を埋めて下さい。
// appfog は ssh ログインは出来ませんので、ローカルからVPN接続して mysql を叩きます。
//
// Starting tunnel to YOUR_SERVICE_NAME on port 10000.
// 1: none
// 2: mysql
// 3: mysqldump
// Which client would you like to start?:
// このような表示になったら、1を入力してそのままにして下記3つの設定を埋めます。
//
// 保存したら別のtunnelを実行しているのとは別のターミナルを立ち上げ、下記コマンドを実行します。
// cd YOUR_APP_DIR
// php artisan migrate:install --env=production
// php artisan migrate --env=production
// 以上で migration は完了です。
$mysql_dbname = '';
$mysql_user = '';
$mysql_password = '';
// af tunnel で接続中は 127.0.0.1:10000 が appfog の mysql を向きます。
$mysql_host = '127.0.0.1';
$mysql_port = '10000';

$redis_host = null;
$redis_port = null;
$redis_password = null;

// for appfog config
$services_json = getenv('VCAP_SERVICES');
if ($services_json !== false) {
    $services = json_decode($services_json, true);
    $config_mysql = null;
    $config_redis = null;
    foreach ($services as $name => $service) {
        if (0 === stripos($name, 'mysql')) {
            $config_mysql = $service[0]['credentials'];
            continue;
        }
        if (0 === stripos($name, 'redis')) {
            $config_redis = $service[0]['credentials'];
            continue;
        }
    }
    is_null($config_mysql) && die('MySQL service information not found.');
    $mysql_host = $config_mysql["hostname"];
    $mysql_port = $config_mysql["port"];
    $mysql_dbname = $config_mysql["name"];
    $mysql_user = $config_mysql["user"];
    $mysql_password = $config_mysql["password"];
    is_null($config_redis) && die('Redis service information not found.');
    $redis_host = $config_redis["hostname"];
    $redis_port = $config_redis["port"];
    $redis_password = $config_redis["password"];
}

return array(

    /*
    |--------------------------------------------------------------------------
    | Database Query Logging
    |--------------------------------------------------------------------------
    |
    | By default, the SQL, bindings, and execution time are logged in an array
    | for you to review. They can be retrieved via the DB::profile() method.
    | However, in some situations, you may want to disable logging for
    | ultra high-volume database work. You can do so here.
    |
    */

    'profile' => false,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection
    |--------------------------------------------------------------------------
    |
    | The name of your default database connection. This connection will be used
    | as the default for all database operations unless a different name is
    | given when performing said operation. This connection name should be
    | listed in the array of connections below.
    |
    */

    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | All of the database connections used by your application. Many of your
    | applications will no doubt only use one connection; however, you have
    | the freedom to specify as many connections as you can handle.
    |
    | All database work in Laravel is done through the PHP's PDO facilities,
    | so make sure you have the PDO drivers for your particular database of
    | choice installed on your machine.
    |
    */

    'connections' => array(
        'mysql' => array(
            'driver' => 'mysql',
            'host' => $mysql_host,
            'database' => $mysql_dbname,
            'username' => $mysql_user,
            'password' => $mysql_password,
            'charset' => 'utf8',
            'prefix' => '',
            'port' => $mysql_port,
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store. However, it
    | provides a richer set of commands than a typical key-value store such as
    | APC or memcached. All the cool kids are using it.
    |
    | To get the scoop on Redis, check out: http://redis.io
    |
    */

    'redis' => array(
        'default' => array(
            'host' => $redis_host,
            'port' => $redis_port,
            'password' => $redis_password,
            'database' => 0
        ),
    ),

);
