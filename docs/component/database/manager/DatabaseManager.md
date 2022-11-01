### DatabaseManager 

```php 

$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$database->setConnections([
  new \Laventure\Component\Database\Connection\FooConnection(),
  new \Laventure\Component\Database\Connection\DemoConnection()
]);

$database->setConfigurations([
    'foo'  => [
        'driver'     =>  'mysql',
        'database'   =>  'laventure',
        'host'       =>  '127.0.0.1',
        'port'       =>  '3306',
        'username'   =>  'root',
        'password'   =>  '123456',
        'collation'  =>  'utf8_unicode_ci',
        'charset'    =>  'utf8',
        'prefix'     =>  '',
        'engine'     =>  'InnoDB', // MyISAM
        'options'    => [],
    ],
    'demo' => [
        'driver'     =>  'mysql',
        'database'   =>  'laventure',
        'host'       =>  '127.0.0.1',
        'port'       =>  '3306',
        'username'   =>  'root',
        'password'   =>  '123456',
        'collation'  =>  'utf8_unicode_ci',
        'charset'    =>  'utf8',
        'prefix'     =>  '',
        'engine'     =>  'InnoDB', // MyISAM
        'options'    => [],
    ]
]);

$database->connect('mysql', [
    'driver'     =>  'mysql',
    'database'   =>  'laventure',
    'host'       =>  '127.0.0.1',
    'port'       =>  '3306',
    'username'   =>  'root',
    'password'   =>  '123456',
    'collation'  =>  'utf8_unicode_ci',
    'charset'    =>  'utf8',
    'prefix'     =>  '',
    'engine'     =>  'InnoDB', // MyISAM
    'options'    => [],
]);


dump($database->connection('mysql'));
dump($database->connection('foo'));
dump($database->connection('demo'));

dd($database);


```


2. Connection to database and use statement
```
$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$database->connect('mysql', [
    'driver'     =>  'mysql',
    'database'   =>  'laventure',
    'host'       =>  '127.0.0.1',
    'port'       =>  '3306',
    'username'   =>  'root',
    'password'   =>  '123456',
    'collation'  =>  'utf8_unicode_ci',
    'charset'    =>  'utf8',
    'prefix'     =>  '',
    'engine'     =>  'InnoDB', // MyISAM
    'options'    => [],
]);


$connection = $database->connection('mysql');

$connection->reconnect();

// FETCH ALL
$users = $connection->query('SELECT * FROM users;')->withClass(\App\Models\User::class)->fetchAll();

dd($users);

/*
create table users (id smallint unsigned auto_increment primary key, username varchar(30) not null, password varchar(30) not null);

$users = $connection->query('SELECT * FROM users;')->withClass(\App\Models\User::class)->fetchAll();

dd($users);

$user = $connection->query('SELECT * FROM users;')->withClass(\App\Models\User::class)->fetchObject();

dd($user);
*/

dd($database);

```

3. Database Manager Refactoring

```php 
<?php


use Laventure\Component\Database\Schema\BluePrint\BluePrint;

require_once __DIR__.'/../vendor/autoload.php';


$config = require (realpath(__DIR__.'/../config/params/database.php'));

/*
$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$database->connect($config['driver'], $config);

dump($database->connection());

$database->disconnect();

dump($database->connection());
*/




$manager = new \Laventure\Component\Database\ORM\Manager();

$manager->addConnection($config);


$manager->schema()->create('users', function (BluePrint $table) {
    $table->id();
    $table->string('username', 260);
    $table->string('password', 350);
    $table->boolean('active');
    $table->timestamps();
});

```