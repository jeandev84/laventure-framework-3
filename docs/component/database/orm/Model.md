### Model 

```php 
<?php


require_once __DIR__.'/../vendor/autoload.php';



$database = new \Laventure\Component\Database\Manager\DatabaseManager();

$config = require (realpath(__DIR__.'/../config/params/database.php'));

$manager = new \Laventure\Component\Database\ORM\Manager();

$manager->addConnection($config);

/*
$manager = \Laventure\Component\Database\Manager::make();
$manager->addConnection($config);

$manager->schema()->table('users', function (BluePrint $table) {
    $table->modifyColumn('password')->type('VARCHAR', 255);
});


$colletions = [
    [
        'username' => 'michel',
        'password' => password_hash('michel', PASSWORD_DEFAULT),
    ],
    [
        'username' => 'jean',
        'password' => password_hash('jean', PASSWORD_DEFAULT),
    ],
    [
        'username' => 'veronika',
        'password' => password_hash('veronika', PASSWORD_DEFAULT),
    ],
];

$i = 1;
foreach ($colletions as $user) {
   $manager->statement(
       "INSERT INTO users (username, password) VALUES (:username{$i}, :password{$i})",
       [
           "username{$i}" => $user['username'],
           "password{$i}" => $user['password'],
       ]
   )->execute();

   $i++;
}

*/


/*
$users = $manager->statement('SELECT * FROM users')
                 //->fetchMode(PDO::FETCH_ASSOC)
                 ->mapClass(\App\Entity\User::class)
                 ->fetchAll();

dump($users);

dd($manager->getExecutedQueries());
*/


// dd($manager->table('users')->criteria(['username' => 'Jean']));

//$manager->migration()->migrate();


//
//$database->connect('mysql', $config);
//
//
///** @var PdoConnection $connection */
//$connection = $database->connection('mysql');
//
//$queryBuilder = new \Laventure\Component\Database\Query\Builder\Extension\PDO\QueryBuilder($connection, 'users');
//
//
//$em = new \Laventure\Component\Database\ORM\Mapper\Manager\EntityManager(
//    $connection,
//    new \App\Factory\EntityRepositoryFactoryExample()
//);
//
//$em->registerClass(\App\Entity\User::class);
//
///*
//$em->insert([
//    'username' => 'admin2',
//    'password' => '123'
//]);
//
//
//$em->insert([
//    [
//        'username' => 'user3',
//        'password' => '123',
//    ],
//    [
//        'username' => 'user3',
//        'password' => '321',
//    ]
//]);
//*/


// $posts = \App\Models\Post::all();
// dd($posts);

/*
$users = \App\Models\User::all();
$user = \App\Models\User::create([
    'username' => 'test',
    'password' => password_hash('test', PASSWORD_DEFAULT)
]);

dd($user, $users);

$users = \App\Models\User::all();

dd($users);

$user = \App\Models\User::where('username', 'jean')->first();

dd($user);
*/


/*
$user = \App\Models\User::create([
    'username' => 'demo',
    'password' => password_hash('test', PASSWORD_DEFAULT)
]);

dd($user);
*/

/*
SAVE CREATE NEW USER
$user = new \App\Models\User();


$user->username  = "Jeniffer";
$user->password  = password_hash('test', PASSWORD_DEFAULT);


$id = $user->save();

dd($id, $user);
*/


// UPDATE DATA

/*
$user = \App\Models\User::findOne(30);

dd();
try {

    $user = \App\Models\User::findOne(30);


} catch (Exception $e) {

    dd($e->getMessage());
}


$user->update([
    'username' => 'Jeniffer31!'
]);

dd($user);


//dd($user->delete());

dd(\App\Models\User::findOne(29));

$user = \App\Models\User::where('username', 'Jeniffer29')->one();

dd($user->delete());

dd(\App\Models\User::all());
*/
```