<?php

namespace com\github\nitf\newecoui;

use com\github\nitf\newecoui\command\EcoUICommand;
use pocketmine\plugin\PluginBase;

class NewEcoUI extends PluginBase
{
    public function onEnable(): void
    {
        $this->saveResource("Message.yml");
        // Set up DI.
        ConfigDI::setUpDI($this->getDataFolder());

        // Register command.
        $this->getServer()->getCommandMap()
            ->register("ecoui", new EcoUICommand(
            "ecoui",
            "EcoUI Command",
            "/ecoui"));
    }
}