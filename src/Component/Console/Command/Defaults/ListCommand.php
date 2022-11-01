<?php
namespace Laventure\Component\Console\Command\Defaults;

use Laventure\Component\Console\Command\Command;
use Laventure\Component\Console\Command\Contract\ListableCommandInterface;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Output\Contract\OutputInterface;


/**
 * ListCommand
*/
class ListCommand extends Command implements ListableCommandInterface
{


    /**
     * @var Command[]
    */
    protected $commands = [];




    /**
     * @inheritdoc
    */
    public function __construct()
    {
         parent::__construct('list');
    }




    /**
     * @inheritdoc
    */
    public function setCommands(array $commands): array
    {
         return $this->commands = $commands;
    }




    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write($this->listCommands());

        return Command::SUCCESS;
    }





    /**
     * @return string
    */
    public function listCommands(): string
    {
        $output[] = "List Commands\n";
        $output[] = "==================================================";
        $output[] = "\n";

        $defaultCommands = [];
        $namedCommands   = [];

        foreach ($this->commands as $command) {
            if ($command->getDefaultName()) {
                $defaultCommands[] = $command->getDefaultName();
            } elseif($name = $command->getName()) {
                $groupName = explode(':', $name, 2)[0];
                $namedCommands[$groupName][] = $command->getName() ."\n";
            }
        }


        if ($defaultCommands) {
             $output[] = join("\n", $defaultCommands) . "\n";
        }

        if ($namedCommands) {
            foreach ($namedCommands as $name => $commands) {
                $output[] = $name ."\n";
                foreach ($commands as $command) {
                    $output[] = " ". $command;
                }
            }
        }

        return join($output);
    }




    public function listCommandsTest(): string
    {
        echo "List Commands\n".__METHOD__."\n";

        $commandInfos = [];

        foreach ($this->commands as $command) {
            if ($command->getDefaultName()) {
                $commandInfos['defaults'][] = $command->getDefaultName();
            } elseif($command->getName()) {
                $commandInfos['names'][] = $command->getName();
            }
        }

        dd($commandInfos);
    }
}