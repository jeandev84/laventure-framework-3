### Entity Manager 

```
$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$database->connect('mysql', $config);


/** @var PdoConnection $connection */
$connection = $database->connection('mysql');

$queryBuilder = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');


$em = new \Laventure\Component\Database\ORM\Mapper\Manager\EntityManager(
    $connection,
    new \App\Factory\EntityRepositoryFactoryExample()
);

$em->registerClass(\App\Entity\User::class);


$em->insert([
    'username' => 'admin',
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

```