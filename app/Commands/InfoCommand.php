<?php

namespace App\Commands;

use App\Commands\Exceptions\DataPathException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class InfoCommand extends AppCommand
{
    public function configure()
    {
        $this->setName('info');
        $this->setDescription('Informing about the local and server current version.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $dataPath = $this->getDataPath();
        } catch (DataPathException $e) {
            $e->loadOutput($output);
            return 1;
        }

        return 0;
    }
}