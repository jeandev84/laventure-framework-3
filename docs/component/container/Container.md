### Container 

```php 

$container = new \Laventure\Component\Container\Container();

/*
# Binding Parameter
$container->bind('username', 'jean');
dump($container->get('username'));


# Binding Singleton
$container->singleton(\App\Foo::class, new \App\Foo());

$user1 = $container->get(\App\Foo::class);
$user2 = $container->get(\App\Foo::class);

dump($user1, $user2);


# Binding Closure
$container->bind('hello', function () {
    return "Hello world!";
});


dd($container->get('hello'));


$container->singleton(\App\Bar::class, new \App\Bar());
$container->alias(Foo::class, 'demo');
dd($container->get(\App\Foo::class));


dump($container->make(Foo::class));
dump($container->make(Foo::class));
dump($container->make(Foo::class));
dump($container->make(Foo::class));
*/


dump($container->get(\App\Foo::class));


dd($container);

```


```php 
<?php

use Laventure\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';


$app = new \Laventure\Foundation\Application();

// $app->instance(\App\Bar::class, new \App\Bar());
//dump($app->get(\App\Bar::class));
//dump($app->get(\App\Bar::class));
//dump($app->get(\App\Bar::class));
//dump($app->get(\App\Bar::class));

//$app->singleton(\App\Bar::class, new \App\Bar());
//$app->singleton(\App\Foo::class, function (\App\Bar $bar) {
//    return new \App\Foo($bar);
//});

// $app->instance(\App\Foo::class, new \App\Foo(new \App\Bar()));

$app->singleton('sayHello', function (\App\Foo $foo) {
     return $foo->somethingToDay();
});


dump($app->get('sayHello'));
dump($app->get('sayHello'));
dump($app->get('sayHello'));
```