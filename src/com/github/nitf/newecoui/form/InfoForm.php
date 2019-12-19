<?php

namespace com\github\nitf\newecoui\form;

use pocketmine\form\Form;
use pocketmine\Player;

class InfoForm implements Form
{
    /** @var Player $player */
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }
    }

    public function jsonSerialize()
    {
        return [
            "type" => "form",
            "title" => "SimpleForm",
            "content" => 0, // EconomyAPIからPlayerの所持金を取得
            "buttons" => [
                [
                    "text" => "back",
                ]
            ]
        ];
    }
}