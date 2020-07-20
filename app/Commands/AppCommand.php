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
    private $dataPath;

    private $browscapServer;

    protected function getDataPath()
    {
        if (!is_null($this->dataPath)) {
            return $this->dataPath;
        }

        $dataPath = getenv('DATA_DIR');

        if (empty($dataPath)) {
            throw new DataPathException('', 'Empty DATA_DIR environment.');
        }

        $filesystem = new Filesystem();

        if (!$filesystem->exists($dataPath)) {
            throw new DataPathException($dataPath, 'Data dir not found.');
        }

        return $this->dataPath = $dataPath;
    }

    protected function getBrowscapServer(): Browscap
    {
        if (!is_null($this->browscapServer)) {
            return $this->browscapServer;
        }

        $client = new Client();
        $browscap = new Browscap();
        $browscap->setVersion($client->request('GET', 'http://browscap.org/version-number')->getBody()->getContents());
        $browscap->setDateStr($client->request('GET', 'http://browscap.org/version')->getBody()->getContents());
        return $this->browscapServer = $browscap;
    }

    protected function getBrowscapLocal(): Browscap
    {
        $fs = new Filesystem();
        $browscap = new Browscap();
        $dataPath = $this->getDataPath();

        if (!$fs->exists($dataPath . '/version.json')) {
            throw new BrowscapLocalException($dataPath . '/version.json', 'File not found');
        }

        if (!$fs->exists($dataPath . '/browscap.ini')) {
            throw new BrowscapLocalException($dataPath . '/browscap.ini', 'File not found');
        }

        $dataVersion = json_decode(file_get_contents($dataPath . '/version.json'), true);

        $browscap->setVersion($dataVersion['version']);
        $browscap->setDateStr($dataVersion['date']);
        $browscap->setHash($dataVersion['hash']);

        return $browscap;
    }

    protected function isBrowscapNeedsUpdated(?Browscap $local, Browscap $server): bool
    {
        if (empty($local) || $local->isEmpty()) {
            return true;
        }

        if ($local->getVersion() !== $server->getVersion()) {
            return true;
        }

        return false;
    }

    protected function downloadBrowscap()
    {
        //http://browscap.org/stream?q=Full_PHP_BrowsCapINI
        //file_put_contents("Tmpfile.zip", fopen("http://someurl/file.zip", 'r'));

        $fs = new Filesystem();

        $fs->dumpFile(
            $this->getDataPath() . '/browscap.ini',
            fopen("http://browscap.org/stream?q=Full_PHP_BrowsCapINI", 'r')
        );

        $this->getBrowscapServer()->setHash(md5_file($this->getDataPath() . '/browscap.ini'));

        $fs->dumpFile(
            $this->getDataPath() . '/version.json',
            $this->getBrowscapServer()->toJson()
        );
    }
}