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

    private static array $file = [
        'BrowsCapINI' => 'browscap.ini',
        'Full_BrowsCapINI' => 'full_asp_browscap.ini',
        'Lite_BrowsCapINI' => 'lite_asp_browscap.ini',
        'PHP_BrowsCapINI' => 'php_browscap.ini',
        'Full_PHP_BrowsCapINI' => 'full_php_browscap.ini',
        'Lite_PHP_BrowsCapINI' => 'lite_php_browscap.ini',
        'BrowsCapXML' => 'browscap.xml',
        'BrowsCapCSV' => 'browscap.csv',
        'BrowsCapJSON' => 'browscap.json',
        'BrowsCapZIP' => 'browscap.zip',
    ];

    private static string $defaultType = 'Full_PHP_BrowsCapINI';

    private string $name;

    public function __construct(string $name = '')
    {
        if (empty($name)) {
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

    public function getFileName(): string
    {
        return self::$file[$this->name];
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