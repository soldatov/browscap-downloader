<?php

namespace App\Service;

use App\Commands\Exceptions\DataPathException;
use App\Entity\Type;
use App\Entity\VersionOfType;
use App\Entity\VersionsOfTypes;
use App\Serializer\VersionsOfTypesSerializer;
use Exception;
use JsonException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Receiving and storing data in project files
 * */
class FsData implements InstanceServiceInterface
{
    /**
     * @var self
     */
    private static self $instance;

    /**
     * @var Filesystem
     */
    private Filesystem $fileSystem;

    /**
     * @var string
     */
    private string $dataPath;

    /**
     * @var string
     */
    private string $versionsDataFilePath;

    /**
     * @var VersionsOfTypes
     */
    private VersionsOfTypes $versionsOfTypes;

    private VersionsOfTypesSerializer $serializer;

    /**
     * FsData constructor.
     * @throws JsonException
     */
    private function __construct()
    {
        $this->fileSystem = new Filesystem();

        $dataPath = getenv('DATA_DIR');

        if (empty($dataPath) || !is_string($dataPath)) {
            $ds = DIRECTORY_SEPARATOR;
            $dataPath = __DIR__ . $ds. '..' . $ds . '..' . $ds . 'data';
        }

        if (!$this->fileSystem->exists($dataPath)) {
            throw new DataPathException($dataPath, 'Data path not found.');
        }

        $this->dataPath = $dataPath;
        $this->versionsDataFilePath = $this->dataPath . '/version.json';

        $this->versionsOfTypes = $this->loadVersionsOfTypesFromDataFile();

        $this->serializer = new VersionsOfTypesSerializer();
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Loads data from a file. If the file does not exist, return default object
     * @return VersionsOfTypes
     *
     * @throws JsonException
     */
    private function loadVersionsOfTypesFromDataFile(): VersionsOfTypes
    {
        if (!$this->fileSystem->exists($this->versionsDataFilePath)) {

            $versionsOfTypes = new VersionsOfTypes();

            foreach (Type::getTypes() as $type) {
                $versionsOfTypes->addVersionOfType(new VersionOfType(new Type($type)));
            }

            $versionsOfTypes->setHasChanges(true);

            return $versionsOfTypes;
        }

        $content = file_get_contents($this->versionsDataFilePath);

        return $this->serializer->fromJson($content);
    }

    /**
     * @param Type $type
     * @return VersionOfType
     * @throws Exception
     */
    public function getVersionOfType(Type $type): VersionOfType
    {
        return $this->versionsOfTypes->getVersionByType($type);
    }

    public function saveFile(Type $type, VersionOfType $serverVersion, $resource)
    {
        $filePath = $this->dataPath . DIRECTORY_SEPARATOR . $type->getFileName();

        $this->fileSystem->dumpFile($filePath, $resource);

        $localVersion = $this->getVersionOfType($type);

        $localVersion->setDate($serverVersion->getDate());
        $localVersion->setVersion($serverVersion->getVersion());
        $localVersion->setFileHash(md5_file($filePath));

        $json = $this->serializer->toJson($this->versionsOfTypes);

        $this->fileSystem->dumpFile($this->versionsDataFilePath, $json);
    }
}