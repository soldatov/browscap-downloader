<?php

namespace App\Entity;

class Browscap
{
    private $version;

    private $date;

    private $hash;

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDateStr(string $date): void
    {
        $this->date = new \DateTime($date);
    }

    public function setDate(\DateTime $date): void
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

    public function setHashByFile(string $path)
    {
        $this->hash = md5_file($path);
    }
}