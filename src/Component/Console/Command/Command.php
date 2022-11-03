<?php
namespace Laventure\Component\Console\Command;

use Laventure\Component\Console\Command\Contract\CommandInterface;
use Laventure\Component\Console\Command\Exception\CommandException;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Input\InputArgument;
use Laventure\Component\Console\Input\InputDefinition;
use Laventure\Component\Console\Input\InputOption;
use Laventure\Component\Console\Output\Contract\OutputInterface;



/**
 * Command
*/
class Command implements CommandInterface
{

    const SUCCESS  = 0;
    const FAILURE  = 1;
    const INVALID  = 2;
    const INFO     = 4;




    /**
     * Default name of command
     *
     * @var string
    */
    protected $defaultName;




    /**
     * Name of command
     *
     * @var string
    */
    protected $name;




    /**
     * Command description
     *
     * @var array|string
    */
    protected $description;





    /**
     * Help command name
     *
     * @var string
    */
    protected $help = '';





    /**
     * Input definition
     *
     * @var InputDefinition
    */
    protected $inputs;





    /**
     * Command constructor
     *
     * @param $name
    */
    public function __construct($name = null)
    {
         $this->inputs  = new InputDefinition();

         if ($name) {
             $this->name($name);
         }

         $this->configure();
    }





    /**
     * Set command default name
     *
     * @param string $name
     * @return $this
    */
    public function defaultName(string $name): self
    {
         $this->defaultName = $name;

         return $this;
    }





    /**
     * @return string|null
    */
    public function getDefaultName(): ?string
    {
         return $this->defaultName;
    }






    /**
     * Set command name
     *
     * @param string $name
     * @return $this
    */
    public function name(string $name): self
    {
         if (! self::validateName($name)) {
             return $this->defaultName($name);
         }

         $this->name = $name;

         return $this;
    }




    /**
     * @param $description
     * @return $this
    */
    public function description($description): self
    {
         $this->description = $description;

         return $this;
    }






    /**
     * Set command help name
     *
     * @param string $name
     * @return $this
    */
    public function help(string $name): self
    {
         $this->help = $name;

         return $this;
    }





    /**
     * @inheritDoc
    */
    public function getName(): string
    {
         if (self::validateName($this->name)) {
              return $this->name;
         }

         if (! $this->defaultName) {
              $this->createCommandException([
                  "Unable command default name inside class : ". get_called_class(),
                  "Look at your command name may be is not valid also."
              ]);
         }

         return $this->defaultName;
    }






    /**
     * Return command description
     *
     * @return string
    */
    public function getDescription(): string
    {
         if (is_array($this->description)) {
              return join(PHP_EOL, $this->description);
         }

         return (string) $this->description;
    }





    /**
     * Return command help name
     *
     * @return string
    */
    public function getHelp(): string
    {
          return (string) $this->help;
    }





    /**
     * Add new input argument
     *
     * @param string $name
     * @param $description
     * @param string|null $default
     * @param array $rules
     * @return $this
    */
    public function addArgument(string $name, $description, string $default = null, array $rules = []): self
    {
           $this->inputs->addArgument(new InputArgument($name, $description, $default, $rules));

           return $this;
    }







    /**
     * Return input bag
     *
     * @return InputDefinition
    */
    public function getInputBag(): InputDefinition
    {
         return $this->inputs;
    }






    /**
     * Add new input option
     *
     * @param $name
     * @param $description
     * @param $shortcut
     * @param null $default
     * @param array $rules
     * @return $this
    */
    public function addOption($name, $description, $shortcut = null, $default = null, array $rules = []): self
    {
          $this->inputs->addOption(new InputOption($name, $description, $shortcut, $default, $rules));

          return $this;
    }






    /**
     * @inheritDoc
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->createCommandException("You must to return command status inside : ". get_called_class() . "::execute");
    }






    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function run(InputInterface $input, OutputInterface $output): int
    {
         if ($input->hasFlag('h') || $input->hasFlag('help')) {
             $output->write($this->help);
             return Command::INFO;
         }

         if (! $this->inputs->validate($input)) {
             foreach ($this->inputs->getErrors() as $errorMessage) {
                $output->writeln($errorMessage);
             }
             return Command::INVALID;
         }

        return $this->execute($input, $output);
    }





    /**
     * @param $message
     * @return mixed
    */
    public function createCommandException($message)
    {
        $message = is_array($message) ? join(".\n", $message) : $message;

        return (function () use ($message) {
            throw new CommandException($message);
        })();
    }




    /**
     * @param $name
     * @return bool
    */
    public static function validateName($name): bool
    {
        return ! is_null($name) && stripos($name, ':') !== false;
    }





    /**
     * Configure command
     *
     * @return void
    */
    protected function configure() {}
}