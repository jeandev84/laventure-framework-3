### V2 

```
<?php



require_once __DIR__.'/../vendor/autoload.php';



$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$database->connect('mysql', $config);

$connection = $database->connection('mysql');

$queryBuilder = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

dump($queryBuilder);

/*
$qb = $queryBuilder->select()
                   ->where('id = :id')
                   ->where('username = :username')
                   ->setParameters([
                       'id' => 2,
                       'username' => 'jean'
                   ]);

$qb->fetch()->all();
dd($qb->getSQL(), $qb->getParameters());
*/

$qb = $queryBuilder->insert([
    [
        'username' => 'Jean',
        'password' => '123'
    ],
    [
        'username' => 'Micha',
        'password' => '456'
    ],
    [
        'username' => 'Audrey',
        'password' => '789'
    ],
]);


/*

$qb = $queryBuilder->update([
    'username' => 'JeanUpdated!',
    'password' => '123'
])->where('id = :id')
  ->setParameter('id', 1);

dd($qb->getSQL());

$qb = $queryBuilder->delete()
                   ->where('id = :id')
                   ->setParameter('id', 1);

dd($qb->getSQL());
*/

```