<?php

namespace App\Commands;

use App\Commands\Exceptions\BrowscapLocalException;
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
            $this->getDataPath();
        } catch (DataPathException $e) {
            $e->loadOutput($output);
            return 1;
        }

        $browscapLocal = null;
        try {
            $browscapLocal = $this->getBrowscapLocal();
            $output->writeln('Browscap local version: ' . $browscapLocal->getVersion());
        } catch (BrowscapLocalException $e) {
            $output->writeln('Browscap local version: not found');
        }

        $browscapServer = $this->getBrowscapServer();
        $output->writeln('Browscap server version: ' . $browscapServer->getVersion());

        if (!$this->isBrowscapNeedsUpdated($browscapLocal, $browscapServer)) {
            $output->writeln('Nothing to update.');
            return 0;
        }

        return 0;
    }
}