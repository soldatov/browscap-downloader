<?php

namespace App\Entity;

use App\Collection\VersionsOfTypeCollection;
use App\Exception\BadSourceException;
use Exception;

/**
 * File data/version.json.
 * */
class VersionsOfTypes
{
    const SOURCE_DEFAULT = 0;
    const SOURCE_ORIGIN_SERVER = 1;
    const SOURCE_LOCAL = 2;

    /**
     * @var array|int[]
     */
    private static array $sources = [
        self::SOURCE_DEFAULT,
        self::SOURCE_ORIGIN_SERVER,
        self::SOURCE_LOCAL,
    ];

    /**
     * Data source for this collection
     * @var int
     */
    private int $source;

    /**
     * The entity has undergone changes that require saving.
     * @var bool
     */
    private bool $hasChanges = false;

    /**
     * @var VersionsOfTypeCollection
     */
    public VersionsOfTypeCollection $versionsOfTypeCollection;

    /**
     * VersionDataFile constructor.
     * @param int $source
     * @throws BadSourceException
     */
    public function __construct(int $source = self::SOURCE_DEFAULT)
    {
        $this->checkSource($source);

        $this->versionsOfTypeCollection = new VersionsOfTypeCollection();
        $this->source = $source;
    }

    /**
     * @return VersionOfType[]|VersionsOfTypeCollection
     */
    public function getVersionsOfTypeCollection(): VersionsOfTypeCollection
    {
        return $this->versionsOfTypeCollection;
    }

    /**
     * @param VersionOfType $versionOfType
     */
    public function addVersionOfType(VersionOfType $versionOfType): void
    {
        $this->getVersionsOfTypeCollection()->add($versionOfType);
    }

    /**
     * @param Type $type
     * @return VersionOfType
     * @throws Exception
     */
    public function getVersionByType(Type $type): VersionOfType
    {
        foreach ($this->getVersionsOfTypeCollection() as $version) {
            if ($version->getType()->getName() === $type->getName()) {
                return $version;
            }
        }

        throw new Exception('Version not found.');
    }

    /**
     * @return bool
     */
    public function isHasChanges(): bool
    {
        return $this->hasChanges;
    }

    /**
     * @param bool $hasChanges
     */
    public function setHasChanges(bool $hasChanges): void
    {
        $this->hasChanges = $hasChanges;
    }

    /**
     * @return array|int[]
     */
    public static function getSources()
    {
        return self::$sources;
    }

    /**
     * @param int $source
     * @throws BadSourceException
     */
    public function setSource(int $source): void
    {
        $this->checkSource($source);
        $this->source = $source;
    }

    /**
     * @param int $source
     * @throws BadSourceException
     */
    private function checkSource(int $source): void
    {
        if (!in_array($source, self::$sources)) {
            throw new BadSourceException($source);
        }
    }

    public function toJsonRow(): array
    {
        $row = [];

        foreach ($this->getVersionsOfTypeCollection() as $versionOfType) {
            $row[] = $versionOfType->toJsonRow();
        }

        return $row;
    }
}