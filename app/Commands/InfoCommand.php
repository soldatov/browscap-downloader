<?php

namespace App\Commands;

use App\Commands\Exceptions\BrowscapLocalException;
use App\Commands\Exceptions\DataPathException;
use App\Entity\Type;
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
        $output->writeln('Local cashed versions:');

        foreach (Type::getTypes() as $type) {
            $type = new Type($type);
            $version = $this->getFsData()->getVersionOfType($type);
            $output->writeln('  ' . $type->getName() . ': ' . $version->getVersionAndDate());
        }

        $output->writeln('Origin server version: ' . $this->getServerData()->getActualVersion()->getVersionAndDate());

        return 0;
    }
}