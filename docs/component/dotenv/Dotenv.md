### Dotenv

```php 

$dotenv = new Dotenv(__DIR__.'/../');

$dotenv->load();

echo getenv('APP_URL');

```