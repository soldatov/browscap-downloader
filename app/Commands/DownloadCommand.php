<?php

namespace App\Commands;

use App\Commands\Exceptions\BrowscapLocalException;
use App\Commands\Exceptions\DataPathException;
use App\Entity\Type;
use App\Repository\BrowscapRepository;
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
        if ($input->hasOption('type')) {
            $type = new Type($input->getOption('type'));
        } else {
            $type = new Type();
        }

        $output->writeln('Selected ' . $type->getName() . ' browscap type.');
        $versionLocal = $this->getFsData()->getVersionOfType($type);
        $versionServer = $this->getServerData()->getActualVersion();
        $output->writeln('Local cashed versions: ' . $versionLocal->getVersionAndDate());
        $output->writeln('Origin server version: ' . $versionServer->getVersionAndDate());

        if ($versionServer->getVersion() === $versionLocal->getVersion()) {
            $output->writeln('Nothing to update.');
            $output->writeln('Local cashed file: ' . $type->getFileName());
            return 0;
        }

        $this->getFsData()->saveFile($type, $versionServer, $this->getServerData()->loadVersion($type));

        $a = 1;

//        try {
//            $repo = new BrowscapRepository();
//            $browscapLocal = $repo->findFromLocal($type);
//            $output->writeln('Browscap ' . $type->getName() . ' file on local version: ' . $browscapLocal->getVersion());
//        } catch (BrowscapLocalException $e) {
//            $output->writeln('Browscap ' . $type->getName() . ' file on local not found');
//        }
//
//        $browscapServer = $this->getBrowscapServer();
//        $output->writeln('Browscap file on origin server version: ' . $browscapServer->getVersion());
//
//        if (!$this->isBrowscapNeedsUpdated($browscapLocal, $browscapServer)) {
//            $output->writeln('Nothing to update.');
//            return 0;
//        }
//
//        $output->write('Browscap ' . $type->getName() . ' file version ' . $browscapServer->getVersion() . ' loading... ');
//
//        $this->downloadBrowscap($type);
//
//        $output->writeln('Done. Downloaded file ');
//
//        try {
//            $browscapLocal = $this->getBrowscapLocal();
//            $output->writeln('Browscap app local version: ' . $browscapLocal->getVersion());
//        } catch (BrowscapLocalException $e) {
//            $output->writeln('<error>Browscap local not found</error>');
//            return 1;
//        }

        return 0;
    }
}