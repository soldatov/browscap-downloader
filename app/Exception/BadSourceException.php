<?php

namespace App\Exception;

use App\Entity\VersionOfType;
use Throwable;

class BadSourceException extends \RuntimeException
{
    public function __construct($source, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(
            'Set bad source %s. Source must be %s.',
            $source,
            implode(', ', VersionOfType::getSources())
        );


        parent::__construct($message, $code, $previous);
    }
}