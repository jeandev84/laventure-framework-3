### Schema


1. Create and Update Table
```php 
$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$database->connect('mysql', $config);


/** @var PdoConnection $connection */
$connection = $database->connection('mysql');

$queryBuilder = new \Laventure\Component\Database\Query\Builder\Extension\PDO\QueryBuilder($connection, 'users');


$em = new \Laventure\Component\Database\ORM\Mapper\Manager\EntityManager(
    $connection,
    new \App\Factory\EntityRepositoryFactoryExample()
);

$em->registerClass(\App\Entity\User::class);

/*
$em->insert([
    'username' => 'admin2',
    'password' => '123'
]);


$em->insert([
    [
        'username' => 'user3',
        'password' => '123',
    ],
    [
        'username' => 'user3',
        'password' => '321',
    ]
]);
*/

$schema = new \Laventure\Component\Database\Schema\Schema($connection);

/*
$schema->create('posts', function (BluePrint $table) {

    // columns
    $table->increments('id'); // $table->id();
    $table->string('title', 260);
    $table->text('description');
    $table->timestamps();
    // $table->bigInteger('user_id')->unsigned();

    // Tres important d' avoir les meme cle de references avec la cle primary
    $table->smallInteger('user_id')->unsigned()->nullable(); // ->unsigned();
    // $table->index(['user_id']);

    // unique
    $table->unique(['user_id']);
    $table->index(['title']);

    // foreign keys
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade')
          ->onUpdate('cascade');

    //$table->integer('category_id');
    //$table->foreign('category_id')->references('id')->on('categories');
});

*/



$schema->table('posts', function (BluePrint $table) {
     $table->string('image', 350);
     $table->boolean('featured');
     $table->datetime('published_at');
});
```


2. Modify and Drop a column 
```php 


$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$database->connect('mysql', $config);


/** @var PdoConnection $connection */
$connection = $database->connection('mysql');

$queryBuilder = new \Laventure\Component\Database\Query\Builder\Extension\PDO\QueryBuilder($connection, 'users');


$em = new \Laventure\Component\Database\ORM\Mapper\Manager\EntityManager(
    $connection,
    new \App\Factory\EntityRepositoryFactoryExample()
);

$em->registerClass(\App\Entity\User::class);

/*
$em->insert([
    'username' => 'admin2',
    'password' => '123'
]);


$em->insert([
    [
        'username' => 'user3',
        'password' => '123',
    ],
    [
        'username' => 'user3',
        'password' => '321',
    ]
]);
*/

$schema = new \Laventure\Component\Database\Schema\Schema($connection);



$schema->create('posts', function (BluePrint $table) {

    // columns
    $table->increments('id'); // $table->id();
    $table->string('title', 260);
    $table->text('description');
    $table->timestamps();
    // $table->bigInteger('user_id')->unsigned();

    // Tres important d' avoir les meme cle de references avec la cle primary
    $table->smallInteger('user_id')->unsigned()->nullable(); // ->unsigned();
    // $table->index(['user_id']);

    // unique
    $table->unique(['user_id']);
    $table->index(['title']);

    // foreign keys
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade')
          ->onUpdate('cascade');

    //$table->integer('category_id');
    //$table->foreign('category_id')->references('id')->on('categories');
});




$schema->table('posts', function (BluePrint $table) {
     $table->string('image', 350);
     $table->boolean('featured');
     $table->datetime('published_at');
     $table->string('demo', 200);
     // $table->dropColumn('demo');
     $table->modifyColumn('title')->type('VARCHAR', 360);
     // $table->modifyColumn('demo')->type('TEXT')->nullable();
});

```

3. Rename Column 
```php 

$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$database->connect('mysql', $config);


/** @var PdoConnection $connection */
$connection = $database->connection('mysql');

$queryBuilder = new \Laventure\Component\Database\Query\Builder\Extension\PDO\QueryBuilder($connection, 'users');


$em = new \Laventure\Component\Database\ORM\Mapper\Manager\EntityManager(
    $connection,
    new \App\Factory\EntityRepositoryFactoryExample()
);

$em->registerClass(\App\Entity\User::class);

/*
$em->insert([
    'username' => 'admin2',
    'password' => '123'
]);


$em->insert([
    [
        'username' => 'user3',
        'password' => '123',
    ],
    [
        'username' => 'user3',
        'password' => '321',
    ]
]);
*/

$schema = new \Laventure\Component\Database\Schema\Schema($connection);



$schema->create('posts', function (BluePrint $table) {

    // columns
    $table->increments('id'); // $table->id();
    $table->string('title', 260);
    $table->text('description');
    $table->timestamps();
    // $table->bigInteger('user_id')->unsigned();

    // Tres important d' avoir les meme cle de references avec la cle primary
    $table->smallInteger('user_id')->unsigned()->nullable(); // ->unsigned();
    // $table->index(['user_id']);

    // unique
    $table->unique(['user_id']);
    $table->index(['title']);

    // foreign keys
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade')
          ->onUpdate('cascade');

    //$table->integer('category_id');
    //$table->foreign('category_id')->references('id')->on('categories');
});




$schema->table('posts', function (BluePrint $table) {
     $table->string('image', 350);
     $table->boolean('featured');
     $table->datetime('published_at');
     $table->string('demo', 200);
     // $table->dropColumn('demo');
     $table->modifyColumn('title')->type('VARCHAR', 360);
     // $table->modifyColumn('demo')->type('TEXT')->nullable();
    $table->renameColumn('demo', 'published');
});

```


4. Schema Table
```php 
<?php


use Laventure\Component\Database\Connection\Extension\PDO\PdoConnection;
use Laventure\Component\Database\Schema\BluePrint\BluePrint;

require_once __DIR__.'/../vendor/autoload.php';



$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$database->connect('mysql', $config);


/** @var PdoConnection $connection */
$connection = $database->connection('mysql');

$queryBuilder = new \Laventure\Component\Database\Query\Builder\Extension\PDO\QueryBuilder($connection, 'users');


$em = new \Laventure\Component\Database\ORM\Mapper\Manager\EntityManager(
    $connection,
    new \App\Factory\EntityRepositoryFactoryExample()
);

$em->registerClass(\App\Entity\User::class);

/*
$em->insert([
    'username' => 'admin2',
    'password' => '123'
]);


$em->insert([
    [
        'username' => 'user3',
        'password' => '123',
    ],
    [
        'username' => 'user3',
        'password' => '321',
    ]
]);
*/

$schema = new \Laventure\Component\Database\Schema\Schema($connection);



$schema->create('posts', function (BluePrint $table) {

    // columns
    $table->increments('id'); // $table->id();
    $table->string('title', 260);
    $table->text('description');
    $table->timestamps();
    // $table->bigInteger('user_id')->unsigned();

    // Tres important d' avoir les meme cle de references avec la cle primary
    $table->smallInteger('user_id')->unsigned()->nullable(); // ->unsigned();
    // $table->index(['user_id']);

    // unique
    $table->unique(['user_id']);
    $table->index(['title']);

    // foreign keys
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade')
          ->onUpdate('cascade');

    //$table->integer('category_id');
    //$table->foreign('category_id')->references('id')->on('categories');
});




$schema->table('posts', function (BluePrint $table) {
     $table->string('image', 350);
     $table->boolean('featured');
     $table->datetime('published_at');
     $table->string('demo', 200);
     $table->modifyColumn('title')->type('VARCHAR', 360);
     // $table->modifyColumn('demo')->type('TEXT')->nullable();
     // $table->renameColumn('demo', 'published');
     //$table->modifyColumn('published')->type('BOOLEAN');
});



$migrator = new \Laventure\Component\Database\Migration\Migrator($connection);

/*
$migrator->install();
$migrator->getOldMigrations();
*/

$migrator->addMigrations([
    new \App\Migration\Version20221011(),
    new \App\Migration\Version20221012(),
]);


// $migrator->install();
// $migrator->migrate();

// $migrator->rollback();
// $migrator->reset();
```