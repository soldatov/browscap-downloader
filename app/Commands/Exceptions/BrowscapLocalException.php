<?php

namespace App\Commands\Exceptions;

use Throwable;

class BrowscapLocalException extends \LogicException
{
    private $fileVersion = '';

    /**
     * @return string
     */
    public function getFileVersion(): string
    {
        return $this->fileVersion;
    }

    /**
     * @param string $fileVersion
     */
    public function setFileVersion(string $fileVersion): void
    {
        $this->fileVersion = $fileVersion;
    }

    public function __construct(string $fileVersion, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->setFileVersion($fileVersion);

        if (empty($message)) {
            $message = 'File version error.';
        }

        parent::__construct($message, $code, $previous);
    }
}