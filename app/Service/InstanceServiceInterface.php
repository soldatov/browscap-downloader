<?php

namespace App\Service;

interface InstanceServiceInterface
{
    public static function getInstance(): self;
}