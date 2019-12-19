<?php

namespace com\github\nitf\newecoui\command;

use com\github\nitf\newecoui\form\MenuForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;

class EcoUICommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$sender instanceof Player) {
            return false;
        }
        if ($commandLabel === "ecoui") {
            $sender->sendForm(new MenuForm());
            return true;
        }
        return false;
    }
}