<?php

namespace com\github\nitf\newecoui;

use pocketmine\utils\Config;

class ConfigDI
{
    /** @var Config $message */
    private static $message;

    public static function setUpDI(string $path): void
    {
        self::$message = new Config($path . "Message.yml", Config::YAML);
    }

    public static function message(): Config
    {
        return self::$message;
    }
}