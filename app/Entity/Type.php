<?php

namespace App\Entity;

use App\Exception\BadFileTypeException;

/**
 * Тип файла для скачики
 * */
class Type
{
    private static array $types = [
        'BrowsCapINI',
        'Full_BrowsCapINI',
        'Lite_BrowsCapINI',
        'PHP_BrowsCapINI',
        'Full_PHP_BrowsCapINI',
        'Lite_PHP_BrowsCapINI',
        'BrowsCapXML',
        'BrowsCapCSV',
        'BrowsCapJSON',
        'BrowsCapZIP',
    ];

    private static string $defaultType = 'Full_PHP_BrowsCapINI';

    private string $name;

    public function __construct(string $name = '')
    {
        if (empty($type)) {
            $name = self::getDefaultType();
        } elseif (!in_array($name, self::getTypes())) {
            throw new BadFileTypeException($name);
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function getTypes()
    {
        return self::$types;
    }

    public static function getDefaultType(): string
    {
        return self::$defaultType;
    }
}