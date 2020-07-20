<?php

namespace App\Commands;

use App\Commands\Exceptions\DataPathException;
use App\Commands\Exceptions\BrowscapLocalException;
use App\Entity\Browscap;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class AppCommand extends Command
{
    protected function getDataPath()
    {
        $dataPath = getenv('DATA_DIR');

        if (empty($dataPath)) {
            throw new DataPathException('', 'Empty DATA_DIR environment.');
        }

        $filesystem = new Filesystem();

        if (!$filesystem->exists($dataPath)) {
            throw new DataPathException($dataPath, 'Data dir not found.');
        }

        return $dataPath;
    }

    protected function getBrowscapServer(): Browscap
    {
        $client = new Client();
        $browscap = new Browscap();
        $browscap->setVersion($client->request('GET', 'http://browscap.org/version-number')->getBody()->getContents());
        $browscap->setDateStr($client->request('GET', 'http://browscap.org/version')->getBody()->getContents());
        return $browscap;
    }

    protected function getBrowscapLocal(): Browscap
    {
        $fs = new Filesystem();
        $browscap = new Browscap();
        $dataPath = $this->getDataPath();

        if (!$fs->exists($dataPath . '/version.json')) {
            throw new BrowscapLocalException($dataPath . '/version.json', 'File not found');
        }

        if (!$fs->exists($dataPath . 'browscap.ini')) {
            throw new BrowscapLocalException($dataPath . '/browscap.ini', 'File not found');
        }

        $dataVersion = json_decode(file_get_contents($dataPath . '/version.json'));

        $browscap->setVersion($dataVersion['version']);
        $browscap->setDateStr($dataVersion['date']);
        $browscap->setHash($dataVersion['hash']);

        return $browscap;
    }
}