### Router


1. Map Routes
```php 

// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');



// Collect routes

$router->get('/', function () {
     echo "Home Page!";
})->name('home');


$router->get('/welcome', [FrontController::class, 'index'])
       ->name('welcome');


$router->get('/page/{id}', [PageController::class, 'show'])
       ->name('page.show');


$router->post('/login', [LoginController::class, 'index'])
       ->name('login');


$router->map(['GET', 'POST'], '/contact', 'ContactController@index', 'contact');
$router->map('GET|POST', '/posts', 'PostController@index');


$router->get('/posts/{id}', 'PostController@index');

$router->get('/posts/{id}', 'PostController@index')
->where('id', '\d+')
->name('post.index');


// Dispatch route

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);



// Print route collection
dump($router->collection());


// Print names
dump($router->collection()->getNames());


// Print routes
dump($router->getRoutes());

```


2. Route Group
```php 

// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
$router->patterns(['id'   => '\d+', 'lang' => '\w+']);



$router->get('/', function () {
    echo "Welcome";
})->name('welcome');


$attributes = [
    'prefix'      => '/admin',
    'module'      => 'Admin\\',
    'name'        => 'admin.',
    'middlewares' => []
];


$router->group($attributes, function (Router $router) {

    $router->get('/posts', [PostController::class, 'index'])->name('posts.list');
    $router->get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    $router->get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    $router->post('/posts', [PostController::class, 'store'])->name('posts.store');
    $router->get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    $router->put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    $router->delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
});


echo $router->generate('admin.posts.show', ['id' => 1]);

dd(
    $router->getRoutes(),
    $router->collection()->getNames(),
    $router->collection()->getControllers(),
    $router->collection()->getMethods()
);

```


3. Add and Remove route
```php 
$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
$router->patterns(['id'   => '\d+', 'lang' => '\w+']);
$router->middlewares([
    'guest' => \App\Http\Middlewares\GuestMiddleware::class
]);

/*
$router->get('/', function () {
    echo "Welcome";
})->name('welcome');
*/

/*
$router->api(function (Router $router) {
    $router->get('/users', [UserController::class, 'index'])->name('users.index');
    $router->get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    $router->post('/users', [UserController::class, 'store'])->name('users.store');
    $router->put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    $router->delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
*/


$router->prefix('api');


$router->group([
    'name' => 'admin.',
    'middlewares' => ['guest', TrailingSlashesMiddleware::class]
], function (Router $router) {
    $router->get('/users', [UserController::class, 'index'])->name('users.index');
    $router->get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    $router->post('/users', [UserController::class, 'store'])->name('users.store');
    $router->put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    $router->delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

$router->get('/demo', function () {
    echo "Demo";
});

dd(
    $router->getRoutes(),
    $router->collection()->getNames()
);

=====================================================================================

// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
$router->patterns(['id'   => '\d+', 'lang' => '\w+']);
$router->middlewares([
    'guest' => \App\Http\Middlewares\GuestMiddleware::class
]);

/*
$router->get('/', function () {
    echo "Welcome";
})->name('welcome');
*/

/*
$router->api(function (Router $router) {
    $router->get('/users', [UserController::class, 'index'])->name('users.index');
    $router->get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    $router->post('/users', [UserController::class, 'store'])->name('users.store');
    $router->put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    $router->delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
*/


$router->prefix('api');


$router->group([
    'name' => 'admin.',
    'middlewares' => [/*'guest',*/ TrailingSlashesMiddleware::class]
], function (Router $router) {
    $router->get('/users', [UserController::class, 'index'])->name('users.index')->middleware('guest');
    $router->get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    $router->post('/users', [UserController::class, 'store'])->name('users.store');
    $router->put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    $router->delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

$router->get('/demo', function () {
    echo "Demo";
});

dd(
    $router->getRoutes(),
    $router->collection()->getNames()
);

=======================================================================

// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
$router->patterns(['id'   => '\d+', 'lang' => '\w+']);
$router->middlewares([
    'guest' => \App\Http\Middlewares\GuestMiddleware::class
]);

/*
$router->get('/', function () {
    echo "Welcome";
})->name('welcome');
*/

/*
$router->api(function (Router $router) {
    $router->get('/users', [UserController::class, 'index'])->name('users.index');
    $router->get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    $router->post('/users', [UserController::class, 'store'])->name('users.store');
    $router->put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    $router->delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
*/


$router->prefix('api');


$router->group([
    'name' => 'admin.',
    'middlewares' => [/*'guest',*/ TrailingSlashesMiddleware::class]
], function (Router $router) {

    $router->get('/users', [UserController::class, 'index'])
           ->name('users.index')
           ->middleware('guest');

    $router->get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    $router->post('/users', [UserController::class, 'store'])->name('users.store');
    $router->put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    $router->delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

});

$router->get('/demo', function () {
    echo "Demo";
})->name('demo');


/* $router->remove('admin.users.index'); */
/* $router->remove('demo'); */


dd(
    $router->getRoutes(),
    $router->getCollection()->getNames()
);

```

4. Web Resource
```
// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
// $router->patterns(['id'   => '\d+', 'lang' => '\w+']);


// WebResource

// $router->resource('users', \App\Http\Controllers\Admin\UserController::class);

$attributes = [
   'prefix' => 'admin/',
   'module' => 'Admin\\',
   'name'   => 'admin.',
   'middlewares' => []
];

$router->group($attributes, function (Router $router) {
    $router->resources([
        'users' => \App\Http\Controllers\Admin\UserController::class
    ]);
});

/*
$router->resources([
    'users' => \App\Http\Controllers\Admin\UserController::class
]);
*/

/*
$webResource = new \Laventure\Component\Routing\Resource\WebResource('demo', 'DemoController');
dump($webResource->makeRoutes($router));
*/


$apiResource = new \Laventure\Component\Routing\Resource\ApiResource('demo', 'DemoController');
dump($apiResource->makeRoutes($router));

dd(
    // $router->getCollection()->getResources(),
    $router->getResources(),
    $router->getCollection()->getNames(),
    $router->getRoutes()
);
```


5. API Resource
```php 

// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
// $router->patterns(['id'   => '\d+', 'lang' => '\w+']);


// WebResource

// $router->resource('users', \App\Http\Controllers\Admin\UserController::class);

$attributes = [
   'prefix' => 'api',
   'name'   => 'api.',
   'middlewares' => []
];

$router->group($attributes, function (Router $router) {
    $router->apiResources([
        // 'users' => \App\Http\Controllers\Admin\UserController::class
        'users' => UserController::class
    ]);
});


dd(
    // $router->getCollection()->getResources(),
    $router->getResources(),
    $router->getCollection()->getNames(),
    $router->getRoutes()
);


================================================================================

// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
// $router->patterns(['id'   => '\d+', 'lang' => '\w+']);


// WebResource

// $router->resource('users', \App\Http\Controllers\Admin\UserController::class);

/*
$group = new \Laventure\Component\Routing\Group\RouteGroup();


$group->attributes([
    'prefix' => 'api',
    'module' => 'Api',
    'name'   => 'api.',
    'middlewares' => ['guest1', 'api1']
])->attributes([
    'prefix' => 'v1',
    'module' => 'V1',
    'name'   => 'v1.',
    'middlewares' => ['guest2', 'api2']
]);

dump($group->getPrefix(), $group->getModule(), $group->getName(), $group->getMiddlewares());
dd($group->getAttributes());
*/



$attributes = [
   'prefix' => 'v1',
   'name'   => 'api.v1.',
   'middlewares' => []
];

$router->prefix('api')->group($attributes, function (Router $router) {
    $router->apiResources([
        // 'users' => \App\Http\Controllers\Admin\UserController::class
        'users' => UserController::class
    ]);
});


dd(
    // $router->getCollection()->getResources(),
    $router->getResources(),
    $router->getCollection()->getNames(),
    $router->getRoutes()
);


// Initialize router

$router = new Router();
$router->domain('http://127.0.0.1:8000');
$router->namespace('App\\Http\\Controllers');
// $router->patterns(['id'   => '\d+', 'lang' => '\w+']);


// WebResource

// $router->resource('users', \App\Http\Controllers\Admin\UserController::class);

/*
$group = new \Laventure\Component\Routing\Group\RouteGroup();


$group->attributes([
    'prefix' => 'api',
    'module' => 'Api',
    'name'   => 'api.',
    'middlewares' => ['guest1', 'api1']
])->attributes([
    'prefix' => 'v1',
    'module' => 'V1',
    'name'   => 'v1.',
    'middlewares' => ['guest2', 'api2']
]);

dump($group->getPrefix(), $group->getModule(), $group->getName(), $group->getMiddlewares());
dd($group->getAttributes());
*/



$attributes = [
   'prefix' => 'v1',
   'name'   => 'api.v1.',
   'middlewares' => []
];

$router->prefix('api')->group($attributes, function (Router $router) {
    $router->apiResources([
        // 'users' => \App\Http\Controllers\Admin\UserController::class
        'users' => UserController::class
    ]);
});


dd(
    // $router->getCollection()->getResources(),
    $router->getResources(),
    $router->getCollection()->getNames(),
    $router->getRoutes()
);
```


6. Demo flush prefixes 
```php 
$router = new \Laventure\Component\Routing\Router();

$router->prefix('api')
       ->get('/', function () {
            return "Hello world!";
       });

$router->get('/contact', function () {
     return "Form contact";
});


$router->flushPrefixes();

$router->get('/demo', function () {
    return "demo view";
});


dd($router->getRoutes());
```