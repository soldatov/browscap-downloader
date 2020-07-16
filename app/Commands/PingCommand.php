<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PingCommand extends AppCommand
{
    public function configure()
    {
        $this->setName('ping');
        $this->setDescription('Ping command for hello word.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('pong');
        return 0;
    }
}