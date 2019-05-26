<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TwitterCommand extends Command
{
    protected static $defaultName = 'app:twitter';

    protected function configure()
    {
        $this
            ->setDescription('CLI Twitter clone')
            ->addArgument('username', InputArgument::REQUIRED, 'The user\'s name')
            ->ignoreValidationErrors();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');

        // We need the complete command string, as Symfony doesn't support unknown options or values. The complete
        // command string contains the quoted command name, followed by the username, which we need to filter out.
        $strippedInput = array_slice(explode(' ', (string) $input), 2);
        $command = array_shift($strippedInput);

        switch ($command) {
            case null: return $this->timelineCommand($username, $output);
            case '--': return $this->postCommand($username, join(' ', $strippedInput), $output);
            case 'follows': return $this->followCommand($username, join(' ', $strippedInput), $output);
            case 'wall': return $this->wallCommand($username, $output);
            default: return $io->error('Invalid command');
        }
    }

    protected function timelineCommand(string $username, OutputInterface $output)
    {
        $input = new ArrayInput(['username' => $username]);
        $command = $this->getApplication()->find('app:twitter:timeline');

        return $command->run($input, $output);
    }

    protected function postCommand(string $username, string $message, OutputInterface $output)
    {
        $input = new ArrayInput(compact('username', 'message'));
        $command = $this->getApplication()->find('app:twitter:post');

        return $command->run($input, $output);
    }

    protected function followCommand(string $username, string $target, OutputInterface $output)
    {
        $input = new ArrayInput(compact('username', 'target'));
        $command = $this->getApplication()->find('app:twitter:follow');

        return $command->run($input, $output);
    }

    protected function wallCommand(string $username, OutputInterface $output)
    {
        $input = new ArrayInput(['username' => $username]);
        $command = $this->getApplication()->find('app:twitter:wall');

        return $command->run($input, $output);
    }
}
