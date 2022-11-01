```php 
<?php
namespace Laventure\Component\Database\Connection;

class DemoConnection implements ConnectionInterface
{

    public function getName(): string
    {
        return 'demo';
    }

    public function connect(array $credentials)
    {
        // TODO: Implement connect() method.
    }

    public function connected(): bool
    {
        // TODO: Implement connected() method.
    }

    public function reconnect()
    {
        // TODO: Implement reconnect() method.
    }

    public function disconnect()
    {
        // TODO: Implement disconnect() method.
    }
}
```