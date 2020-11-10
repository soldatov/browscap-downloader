<?php

namespace App\Entity;

use DateTimeImmutable;
use Exception;

class Browscap
{
    private string $name;

    private string $version;

    private DateTimeImmutable $date;

    private string $hash;

    private Type $type;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isEmpty(): bool
    {
        return empty($this->version);
    }

    public function toArray()
    {
        return [
            'version' => $this->getVersion(),
            'date' => $this->getDate()->format(DATE_RSS),
            'hash' => $this->getHash(),
            'type' => $this->getType()->getName(),
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @throws Exception
     */
    public function setDateStr(string $date): void
    {
        $this->date = new DateTimeImmutable($date);
    }

    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): void
    {
        $this->type = $type;
    }
}