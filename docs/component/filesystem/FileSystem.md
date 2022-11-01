### FileSystem 


```php 
/** @var FileSystem $fs */
$fs = new Laventure\Component\FileSystem\FileSystem(__DIR__.'/project');

dump($fs->file('.env')->info());
dump($fs->file('app/Models/Cart.php')->dirname());
dump($fs->file('app/Models/Cart.php')->basename());
dump($fs->file('app/Models/Cart.php')->filename());
dump($fs->file('app/Models/Cart.php')->extension());
dump($fs->file('app/Models/Cart.php')->size());
dump($fs->file('demo/index.php')->mkdir());
dump($fs->file('demo/index.php')->make());
dump($fs->resources('app/Migration/*.php'))
dump($fs->collection('app/Migration/*.php')->files())
dump($fs->collection('config/params/*.php')->loadArrays())
$c0 = $fs->collection('app/Migration/*.php')->files()[0];
dump($c0->toArray());

$c = $fs->collection('app/Migration/*.php')->files();
dd($c[0]->toArray(), $c[1]->toArray());

$c = $fs->file('config/params/database.php');

dd($c->loadArrayToJson());


$fs->file('config/params/database.php')->loadPath();

$c = $fs->collection('config/params/*.php')->loadArraysByName();

dd($c);

```