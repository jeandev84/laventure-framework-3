### QueryBuilder 


1. Select Builder
```php 

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


$connection = $database->connection('mysql'); /* dump($connection); */

$queryBuilder = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

/* dump($queryBuilder); */

$qb = $queryBuilder->select(['id', 'username', 'password']);

$users = $qb = $qb->from('users')
                  ->getQuery()
                  ->map(\App\Models\User::class)
                  ->fetchAll();

dump($users);

$user = $queryBuilder->select(['id', 'username', 'password'])->where('id = :id')
                     ->setParameter('id', 1)
                     ->getQuery()
                     ->map(\App\Models\User::class)
                     ->fetchOne();


dd($user);

```


2. Insert Record
```php 

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


$connection = $database->connection('mysql'); /* dump($connection); */

$queryBuilder = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');


/*
dump($queryBuilder);

$qb = $queryBuilder->select(['id', 'username', 'password']);

$users = $qb = $qb->from('users')
                  ->getQuery()
                  ->map(\App\Models\User::class)
                  ->fetchAll();

dump($users);

$user = $queryBuilder->select(['id', 'username', 'password'])->where('id = :id')
                     ->setParameter('id', 1)
                     ->getQuery()
                     ->map(\App\Models\User::class)
                     ->fetchOne();


dd($user);

*/


$qb = $queryBuilder->insert([
    [
        'username' => 'demo35',
        'password' => 'demo35'
    ],
    [
        'username' => 'demo38',
        'password' => 'demo38'
    ],
]);


// $qb->execute();

// dump($qb->getParameters());
// dd($qb->getSQL());


$users = $queryBuilder->select(['*'])
                      ->getQuery()
                      ->map(\App\Models\User::class)
                      ->fetchAll();

dd($users);


// INSERT INTO users (username, password) VALUES (:username, :password);


//$qb = $queryBuilder->insert([
//    'username' => 'demo38',
//    'password' => password_hash('demo38', PASSWORD_DEFAULT)
//]);


dd($qb->getSQL());

// dd($qb->getQuery()->execute());

/*
dd($qb = $queryBuilder->select(['*'])
                     ->getQuery()
                     ->map(\App\Models\User::class)
                     ->fetchAll()
);
*/

```


3. Update Record 
```php 


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


$connection = $database->connection('mysql'); /* dump($connection); */

$queryBuilder = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');


$qb = $queryBuilder->update([
    'username' => 'micha61222',
    'password' => '!!!secret37'
])
->where('id=:id')
->setParameter('id', 2)
->getQuery()->execute();

dd($queryBuilder->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchAll());


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


$connection = $database->connection('mysql'); /* dump($connection); */

$queryBuilder = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

/*
$qb = $queryBuilder->update([
    'username' => 'micha61222',
    'password' => '!!!secret37'
])
->where('id=:id')
->setParameter('id', 2)
->getSQL();

dd($qb);
*/


$qb = $queryBuilder->update([
    'username' => 'test',
    'password' => 'test_pwd!'
])
->where('id=:id')
->setParameter('id', 3)
->getQuery()->execute();

dd($queryBuilder->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchAll());




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


$connection = $database->connection('mysql'); /* dump($connection); */


$queryBuilder1 = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');


//$qb1 = $queryBuilder1->insert([
//    'username' => 'user1',
//    'password' => '123'
//])->getSQL();
//
//
//dd($qb1);



$queryBuilder2 = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

$qb2 = $queryBuilder2->insert([
   [
       'username' => 'user1',
       'password' => '123'
   ],
   [
        'username' => 'user2',
        'password' => '324'
   ],
])->getSQL();

dd($qb2);

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


$connection = $database->connection('mysql'); /* dump($connection); */


$queryBuilder1 = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');


//$qb1 = $queryBuilder1->insert([
//    'username' => 'last record',
//    'password' => 'jawddwe!'
//])->execute();
//
//
//dd($qb1);



$queryBuilder2 = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

//$qb2 = $queryBuilder2->insert([
//   [
//       'username' => 'user1',
//       'password' => '123'
//   ],
//   [
//        'username' => 'user2',
//        'password' => '324'
//   ],
//])->execute();


$users = $queryBuilder2->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchAll();
// $users = $queryBuilder2->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchColumn();

dd($users);



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


$connection = $database->connection('mysql'); /* dump($connection); */


$queryBuilder1 = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');


//$qb1 = $queryBuilder1->insert([
//    'username' => 'last record',
//    'password' => 'jawddwe!'
//])->execute();
//
//
//dd($qb1);



$queryBuilder2 = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

//$qb2 = $queryBuilder2->insert([
//   [
//       'username' => 'user1',
//       'password' => '123'
//   ],
//   [
//        'username' => 'user2',
//        'password' => '324'
//   ],
//])->execute();


$users = $queryBuilder2->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchAll();
// $users = $queryBuilder2->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchColumn();

dd($users);

```


4. Delete Record 
```php 
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


$connection = $database->connection('mysql'); /* dump($connection); */


$qb = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

dump($qb->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchAll());

$sql = $qb->delete()
    ->where('id = :id')
    ->setParameter('id', 11)
    ->execute()
;

//dd($sql);

dd($qb->select(['*'])->getQuery()->map(\App\Models\User::class)->fetchAll());
```


5. Insertion data and multi insertions

```php 


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


$connection = $database->connection('mysql'); /* dump($connection); */


$qb = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');


$sql = $qb->insert([
    'username' => 'test0',
    'password' => 'secret0',
])->execute();

dd($sql);

//
//$qb = $qb->insert([
//   [
//       'username' => 'test1',
//       'password' => 'secret1'
//   ],
//   [
//       'username' => 'test2',
//       'password' => 'secret2',
//   ]
//])->execute(); // ->execute();
//
//dd($qb);


```

6. Update 
```php 


$sql = $qb->update([
    'username' => 'JC',
    'password' => '123'
])
->where('id = :id')
->setParameter('id', 8)
->execute();

$users = $qb->select(["*"])->getQuery()->map(\App\Models\User::class)->fetchAll();

dd($users);

================================================================

$sql = $qb->delete()
->where('id IN (:ids)')
->setParameter('ids', '('. implode(',', [1, 2, 3, 4, 5, 6]) .')')
->getSQL();

dd($sql);

$users = $qb->select(["*"])->getQuery()->map(\App\Models\User::class)->fetchAll();

dd($users);
```


Refactoring && Code Views
```php 




$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$database->connect('mysql', $config);

$connection = $database->connection('mysql'); /* dump($connection); */


$qb = new \Laventure\Component\Database\Query\QueryBuilder($connection, 'users');

/*
$search = 'Awesome';

$sql = $qb->select(['*'])
          ->where('id = :id')
          ->where('username = :username')
          ->where('name LIKE :name')
          ->whereLike('title', '%'. $search .'%')
          ->andWhere('foo1 = :foo1')
          ->andWhere('foo2 = :foo2')
          ->orWhere('test1 = :test1')
          ->notWhere('test2 = :test2')
          ->getSQL();

dd($sql);



$sql1 = $qb->insert([
    [
        'username' => 'Lucy',
        'password' => '122'
    ],
    [
        'username' => 'Michel',
        'password' => '2016'
    ]
])->getSQL();


dd($sql1);


$sql2 = $qb->insert([
    'username' => 'Marie',
    'password' => '123'
])->execute();

dd($sql2);
*/


$users = $qb->select(["*"])->mapClass(\App\Models\User::class)->fetchAll();

dd($users);

/*
$sql = $qb->update([
 'username' => 'Updddd',
 'password' => '2022'
])->where('id = :id')
  ->setParameter('id', 2)
  ->execute();

dd($sql);

*/

```


Others test
```
$sql2 = $qb->select(['*'])
    ->where('id = :id')
    ->andWhere('foo = :foo')
    ->orWhere('bar = :bar')
    ->notWhere('username = :username')
    ->setParameters([
        'id' => 1,
        'foo' => 'test'
    ])
    ->getSQL()
;

dump($sql2);


$sql3 = $em->makeQB()
          ->select(["*"])
          //->where('p = :p')
          //->andWhere('b = :b')
          ->andWhere("id = :id")
          ->setParameter('id', 3)
          //->orWhere("username = :username")
          ->getQuery()
          ->getOneOrNullResult()
;
```