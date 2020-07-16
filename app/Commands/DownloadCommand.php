<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class DownloadCommand extends AppCommand
{
    public function configure()
    {
        $this->setName('download');
        $this->setAliases(['dl']);
        $this->setDescription('Download browscap.ini file from browscap.org');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $dataPath = getenv('DATA_DIR');

        if (empty($dataPath)) {
            $output->writeln('<error>Empty DATA_DIR environment.</error>');

            return 1;
        }

        $filesystem = new Filesystem();

        if (!$filesystem->exists($dataPath)) {
            $output->writeln('<error>' . $dataPath . '</error>');
            $output->writeln('<error>Data dir not found.</error>');
            $output->writeln('The parameter is specified in the DATA_DIR environment.');

            return 1;
        }

        return 0;
    }
}