<?php

namespace App\Collection;

use App\Entity\Version;
use Ramsey\Collection\AbstractCollection;

class VersionCollection extends AbstractCollection
{
    public function getType(): string
    {
        return Version::class;
    }
}