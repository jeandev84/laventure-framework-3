### CREATE TABLE 


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
    $table->increments('id');
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
    //$table->foreign('category_id')->references('categories')->column('id');
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