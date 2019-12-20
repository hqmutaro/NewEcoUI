<?php

namespace com\github\nitf\newecoui\form;

use onebone\economyapi\EconomyAPI;
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
            $onBuild = function (Player $player): Form{
                return new MenuForm();
            };
            $form = new BuildForm($player, $onBuild);
            $form->build();
        }
    }

    public function jsonSerialize()
    {
        return [
            "type" => "form",
            "title" => "SimpleForm",
            "content" => EconomyAPI::getInstance()->myMoney($this->player),
        ];
    }
}