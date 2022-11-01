### Migration 

```php 
$manager->schema()->create('users', function (BluePrint $table) {
    $table->id();
    $table->string('username', 260);
    $table->string('password', 350);
    $table->boolean('active');
    $table->timestamps();
});
```