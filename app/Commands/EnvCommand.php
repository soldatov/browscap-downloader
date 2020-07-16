<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EnvCommand extends AppCommand
{
    public function configure()
    {
        $this->setName('env');
        $this->setDescription('Print env values');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('APP_ENV=' . getenv('APP_ENV'));
        return 0;
    }
}