<?php

namespace App\Commands;

use App\Service\FsData;
use App\Service\ServerData;
use Symfony\Component\Console\Command\Command;

class AppCommand extends Command
{
    private FsData $fsData;

    private ServerData $serverData;

    public function __construct()
    {
        parent::__construct();

        $this->fsData = FsData::getInstance();
        $this->serverData = ServerData::getInstance();
    }

    /**
     * @return FsData
     */
    protected function getFsData(): FsData
    {
        return $this->fsData;
    }

    /**
     * @return ServerData
     */
    protected function getServerData(): ServerData
    {
        return $this->serverData;
    }


}