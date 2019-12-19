<?php

namespace com\github\nitf\newecoui\form;

use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use pocketmine\Server;

class PayForm implements Form
{
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }

    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "CustomForm",
            "content" => [
                [
                    "type" => "dropdown",
                    "text" => "対象",
                    "options" => array_map(function (Player $player) {
                        return $player->getName();
                    }, Server::getInstance()->getOnlinePlayers()),
                    "default" => 1
                ],
                [
                    "type" => "slider",
                    "text" => "金額",
                    "min" => 1,
                    "max" => 1000000,
                    "default" => 100
                ],
            ]
        ];
    }
}