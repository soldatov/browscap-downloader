<?php

namespace App\Exception;

use Throwable;

class BadFileTypeException extends \InvalidArgumentException
{
    public function __construct($type = "", $code = 0, Throwable $previous = null)
    {
        $message = "File type {$type} not allowed.";

        parent::__construct($message, $code, $previous);
    }
}