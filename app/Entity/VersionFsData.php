<?php

namespace App\Entity;

use App\Collection\VersionCollection;

/**
 * File data/version.json.
 * */
class VersionFsData
{
    /**
     * @var VersionCollection
     */
    public VersionCollection $versions;

    /**
     * VersionDataFile constructor.
     */
    public function __construct()
    {
        $this->versions = new VersionCollection();
    }

    /**
     * @return VersionCollection
     */
    public function getVersions(): VersionCollection
    {
        return $this->versions;
    }

    /**
     * @param Version $version
     */
    public function addVersion(Version $version): void
    {

    }
}