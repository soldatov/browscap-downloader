<?php

namespace App\Entity;

use DateTimeImmutable;
use Exception;

class VersionOfType
{
    /**
     * @var string
     */
    private string $version = '';

    /**
     * @var string
     */
    private string $fileHash = '';

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * @var Type
     */
    private Type $type;

    /**
     * VersionOfType constructor.
     * @param Type $type
     */
    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param DateTimeImmutable $date
     */
    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function hasDate(): bool
    {
        return !empty($this->date);
    }

    /**
     * @return string
     */
    public function getFileHash(): string
    {
        return $this->fileHash;
    }

    /**
     * @param string $fileHash
     */
    public function setFileHash(string $fileHash): void
    {
        $this->fileHash = $fileHash;
    }

    public function hasFileHash(): bool
    {
        return !empty($this->fileHash);
    }

    /**
     * @param string $date
     *
     * @throws Exception
     */
    public function setDateByString(string $date): void
    {
        $this->date = new DateTimeImmutable($date);
    }

    /**
     * @return array
     */
    public function toJsonRow(): array
    {
        return [
            'type' => $this->getType()->getName(),
            'version' => $this->getVersion(),
            'date' => $this->hasDate()? $this->getDate()->format('Y-m-d H:i:s') : '',
            'file_hash' => $this->getFileHash(),
            'file_name' => $this->hasFileHash() ? $this->getType()->getFileName() : '',
        ];
    }

    /**
     * @param string $ifEmpty
     * @return string
     */
    public function getVersionAndDate(string $ifEmpty = 'none'): string
    {
        if (empty($this->version)) {
            return $ifEmpty;
        }

        $return = $this->version;

        if (!empty($this->date)) {
            $return .= ' (' . $this->date->format('Y-m-d H:i:s') . ')';
        }

        return $return;
    }
}