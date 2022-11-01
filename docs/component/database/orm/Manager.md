### Manager 

```php 

<?php

use Laventure\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';


$credentials = require (realpath(__DIR__.'/../config/params/database.php'));

$manager = new \Laventure\Component\Database\ORM\Manager();

$manager->addConnection($credentials);



/*
\Laventure\Component\Database\ORM\Manager::getInstance();
dd($manager->connection()->showDatabases());
dd($manager->connection()->createDatabase());
dd($manager->schema()->showTables());
dd($manager->connection()->dropDatabase());
*/




```