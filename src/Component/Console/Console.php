<?php
namespace Laventure\Component\Console;

use Closure;
use Exception;
use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Command\Contract\ListableCommandInterface;
use Laventure\Component\Console\Command\Defaults\HelpCommand;
use Laventure\Component\Console\Command\Defaults\ListCommand;
use Laventure\Component\Console\Command\ShellCommand;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Logger\ConsoleLogger;
use Laventure\Component\Console\Output\Contract\OutputInterface;
use Laventure\Component\Console\Output\Style\ConsoleStyle;


/**
 * Console
*/
class Console implements ConsoleInterface
{

     /**
      * Collect commands
      *
      * @var Command[]
     */
     protected $commands = [];




     /**
      * @var Command|ListableCommandInterface
     */
     protected $defaultCommand;




     /**
      * @var ConsoleStyle
     */
     protected $style;




     /**
      * @var ConsoleLogger
     */
     protected $logger;




     /**
      * Console constructor.
     */
     public function __construct()
     {
          $this->defaultCommand(new ListCommand());
          $this->addCommands([new HelpCommand()]);
          $this->style  = new ConsoleStyle();
          $this->logger = new ConsoleLogger($this);
     }




     /**
      * @return ConsoleStyle
     */
     public function getStyle(): ConsoleStyle
     {
         return $this->style;
     }






     /**
      * Configure command
      *
      * @param $name
      * @param Closure $configure
      * @param string|null $description
      * @return Command
     */
     public function command($name, Closure $configure, string $description = null): Command
     {
            $command = new Command($name);
            $configure($command);
            $command->description($description);
            $this->addCommand($command);

            return $command;
     }




     /**
      * @return ShellCommand
     */
     public function shell(): ShellCommand
     {
          return new ShellCommand();
     }





     /**
      * @param ListCommand $command
      * @return $this
     */
     public function defaultCommand(ListCommand $command): self
     {
          $this->defaultCommand = $command;

          return $this;
     }




     /**
      * @return Command[]
     */
     public function getCommands(): array
     {
          return $this->commands;
     }





     /**
      * Add commands
      *
      * @param Command[] $commands
      * @return $this
     */
     public function addCommands(array $commands): self
     {
          foreach ($commands as $command) {
              $this->addCommand($command);
          }

          return $this;
     }




     /**
      * @param Command $command
      * @return $this
     */
     public function addCommand(Command $command): self
     {
         $this->commands[$command->getName()] = $command;

         return $this;
     }





     /**
      * Determine if the given name exist in collection commands
      *
      * @param $name
      * @return bool
     */
     public function hasCommand($name): bool
     {
          return isset($this->commands[$name]);
     }




     /**
      * Return Command
      *
      * @param $name
      * @return Command
     */
     public function getCommand($name): Command
     {
          if ($this->unavailableCommand($name)) {
               $this->defaultCommand->setCommands($this->getCommands());
               return $this->defaultCommand;
          }


          return $this->commands[$name];
     }





     /**
      * Run execution command
      *
      * @param InputInterface $input
      * @param OutputInterface $output
      * @return int
     */
     public function run(InputInterface $input, OutputInterface $output): int
     {
            $command = $this->getCommand($input->getFirstArgument());

            $status = $command->run($input, $output);

            print($output);

            return $status;
     }




     /**
      * Print message
      *
      * @param $message
      * @return void
     */
     public function print($message)
     {
          print($message);
     }






     /**
      * @param InputInterface $input
      * @param $status
      * @return void
     */
     public function terminate(InputInterface $input, $status)
     {
           return [
               Command::SUCCESS => null,
               Command::INFO    => null,
               Command::FAILURE => null,
               Command::INVALID => null
           ][$status] ?? exit($status);
     }





     /**
      * @param Exception $e
      * @return mixed|null
     */
     public function log(Exception $e)
     {
          return $this->logger->log($e);
     }





     /**
      * @param $name
      * @return bool
     */
     private function unavailableCommand($name): bool
     {
         $default = $this->defaultCommand->getName();

         return ! $this->hasCommand($name) || $default == $name;
     }
}