<?php

namespace App\Service;

use App\Entity\Type;
use App\Entity\VersionOfType;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Retrieving data from the original server http://browscap.org
 * */
class ServerData implements InstanceServiceInterface
{
    /**
     * @var self
     */
    private static self $instance;

    /**
     * @var Client
     */
    private Client $client;

    private VersionOfType $actualVersion;

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * ServerData constructor.
     */
    private function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://browscap.org']);
    }

    /**
     * @return VersionOfType
     * @throws GuzzleException
     * @throws Exception
     */
    public function getActualVersion(): VersionOfType
    {
        if (!empty($this->actualVersion)) {
            return $this->actualVersion;
        }

        $version = new VersionOfType(new Type());

        $version->setVersion(($this->client->get('/version-number'))->getBody()->getContents());
        $version->setDateByString(($this->client->get('/version'))->getBody()->getContents());

        return $this->actualVersion = $version;
    }

    /**
     * @param Type $type
     * @return false|resource
     */
    public function loadVersion(Type $type)
    {
        return fopen('http://browscap.org/stream?q=' . $type->getName(), 'r');
    }
}