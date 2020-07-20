<?php

namespace App\Commands\Exceptions;

use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class DataPathException extends \LogicException
{
    private $dataPath = '';

    public function __construct(string $dataPath = '', $message = "", $code = 0, Throwable $previous = null)
    {
        $this->setDataPath($dataPath);

        if (empty($message)) {
            $message = 'Data path error. View DATA_PATH parameter in environment.';
        }

        parent::__construct($message, $code, $previous);
    }

    public function getDataPath(): string
    {
        return $this->dataPath;
    }

    public function setDataPath(string $dataPath): void
    {
        $this->dataPath = $dataPath;
    }

    public function loadOutput(OutputInterface $output)
    {
        if (!empty($this->dataPath)) {
            $output->writeln('Data path: ' . $this->dataPath);
        }

        $output->writeln('<error>' . $this->getMessage() . '</error>');

        $output->writeln('The parameter is specified in the DATA_DIR environment.');
    }
}