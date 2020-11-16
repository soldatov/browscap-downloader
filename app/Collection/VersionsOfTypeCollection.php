<?php

namespace App\Collection;

use App\Entity\VersionOfType;
use Ramsey\Collection\AbstractCollection;

class VersionsOfTypeCollection extends AbstractCollection
{
    public function getType(): string
    {
        return VersionOfType::class;
    }
}