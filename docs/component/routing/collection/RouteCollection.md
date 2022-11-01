### Route Collection 

```php 

$collection = new RouteCollection();

$collection->addRoutes([
    (new Route(['GET'], '/', 'FrontController@index'))->name('home'),
    (new Route(['GET'], '/about-us', 'FrontController@aboutUs'))->name('aboutUs'),
    (new Route(['GET'], '/blog', 'FrontController@blog'))->name('blog'),
    (new Route(['GET', 'POST'], '/contact', 'FrontController@contact'))->name('contact'),
]);


$collection->addRoute(
  (new Route(['GET'], '/posts', 'PostController@list'))->name('post.list')
);


$collection->addRoute(
  (new Route(['GET'], '/posts/{id}', 'PostController@show'))->name('post.show')
);


$collection->addRoute(
  (new Route(['POST'], '/posts', 'PostController@create'))->name('post.create')
);

$collection->addRoute(
  (new Route(['PUT'], '/posts/{id}', 'PostController@update'))->name('post.update')
);


$collection->addRoute(
  (new Route(['DELETE'], '/posts/{id}', 'PostController@destroy'))->name('post.destroy')
);


$collection->addRoute(
    (new Route(['GET'], '/page', [PageController::class, 'index']))->name('demo')
);


dump(
    $collection->getRouteByName('demo'),
    $collection->getRouteByController(PageController::class),
    $collection->getRoutesByMethod('PUT')
);

dd(
    $collection->getNames(),
    $collection->getMethods(),
    $collection->getControllers(),
    $collection->getRoutes()
);
```