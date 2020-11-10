<?php

namespace App\Repository;

use App\Entity\Browscap;
use App\Entity\Type;
use Symfony\Component\Filesystem\Filesystem;

class BrowscapRepository
{
    public function findFromOrigin(): Browscap
    {

    }

    public function findFromLocal(Type $type): Browscap
    {

    }
}