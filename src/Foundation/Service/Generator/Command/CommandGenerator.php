<?php
namespace Laventure\Foundation\Service\Generator\Command;


use Laventure\Component\Console\Command\Command;
use Laventure\Foundation\Service\Generator\ClassGenerator;


/**
 * CommandGenerator
*/
class CommandGenerator extends ClassGenerator
{


    const defaultCommand = 'defaultName';
    const nameCommand    = 'name';



    /**
     * @param $commandName
     * @return string|null
    */
    public function generateCommandClass($commandName): ?string
    {
        [$commandClass, $commandProperty] = $this->makeCommandCredentials($commandName);

        $credentials = [
            'DummyNamespace'         => "App\\Console\\Commands",
            'DummyClass'             => $commandClass,
            'DummyPath'              => "app/Console/Commands",
            'CommandProperty'        => $commandProperty,
            'commandName'            => $commandName,
            'commandDescription'     => 'describe your command here...'
        ];

        return $this->generateClass($credentials);
    }






    /**
     * @param $name
     * @return string[]
    */
    protected function makeCommandCredentials($name): array
    {
        $parses          = [$name];
        $commandProperty = self::defaultCommand;

        if (Command::validateName($name)) {
            $parses = explode(':', $name);
            $commandProperty = self::nameCommand;
        }

        $commandClass = $this->resolveCommandName($parses);

        return [$commandClass, $commandProperty];
    }




    /**
     * @param array $parts
     * @return string
    */
    protected function resolveCommandName(array $parts): string
    {
        $items = [];
        foreach ($parts as $part) {
            $items[] = ucfirst($part);
        }

        return sprintf('%sCommand', implode($items));
    }




    /**
     * @inheritDoc
    */
    protected function dummyStubPath(): string
    {
        return 'command/template';
    }
}