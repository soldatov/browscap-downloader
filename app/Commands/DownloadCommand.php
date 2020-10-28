<?php

namespace App\Commands;

use App\Commands\Exceptions\BrowscapLocalException;
use App\Commands\Exceptions\DataPathException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class DownloadCommand extends AppCommand
{
    public function configure()
    {
        $this->setName('download');
        $this->setAliases(['dl']);
        $this->addOption(
            'type',
            't',
            InputOption::VALUE_OPTIONAL,
            'Specifies browscap.ini file type.',
            'Full_PHP_BrowsCapINI'
        );
        $this->setDescription('Download browscap.ini file from browscap.org');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->getDataPath();
        } catch (DataPathException $e) {
            $e->loadOutput($output);
            return 1;
        }

        try {
            $browscapLocal = $this->getBrowscapLocal();
            $output->writeln('Browscap app local version: ' . $browscapLocal->getVersion());
        } catch (BrowscapLocalException $e) {
            $output->writeln('Browscap local not found');
        }

        $browscapServer = $this->getBrowscapServer();
        $output->writeln('Browscap origin server version: ' . $browscapServer->getVersion());

        if (!$this->isBrowscapNeedsUpdated($browscapLocal, $browscapServer)) {
            $output->writeln('Nothing to update.');
            return 0;
        }

        $output->write('Browscap load... ');

        $this->downloadBrowscap();

        $output->writeln('Done.');

        try {
            $browscapLocal = $this->getBrowscapLocal();
            $output->writeln('Browscap app local version: ' . $browscapLocal->getVersion());
        } catch (BrowscapLocalException $e) {
            $output->writeln('<error>Browscap local not found</error>');
            return 1;
        }

        return 0;
    }
}