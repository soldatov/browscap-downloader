<?php

namespace App\Service;

use App\Commands\Exceptions\DataPathException;
use App\Entity\VersionFsData;
use Symfony\Component\Filesystem\Filesystem;

class FsData
{
    private Filesystem $fs;
    private string $dataPath;

    public function __construct()
    {
        $this->fs = new Filesystem();

        $dataPath = getenv('DATA_DIR');

        if (empty($dataPath) || !is_string($dataPath)) {
            $ds = DIRECTORY_SEPARATOR;
            $dataPath = __DIR__ . $ds. '..' . $ds . '..' . $ds . 'data';
        }

        if (!$this->getFs()->exists($dataPath)) {
            throw new DataPathException($dataPath, 'Data dir not found.');
        }

        $this->setDataPath($dataPath);
    }

    public function getFs(): Filesystem
    {
        return $this->fs;
    }

    /**
     * @return string
     */
    public function getDataPath(): string
    {
        return $this->dataPath;
    }

    /**
     * @param string $dataPath
     */
    public function setDataPath(string $dataPath): void
    {
        $this->dataPath = $dataPath;
    }

    public function loadVersion(): VersionFsData
    {
        $filePath = $this->getDataPath() . '/version.json';

        if (!$this->getFs()->exists($filePath)) {

        }
    }
}