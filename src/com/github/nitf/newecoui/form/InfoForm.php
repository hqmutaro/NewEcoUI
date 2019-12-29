<?php

namespace com\github\nitf\newecoui\form;

use com\github\nitf\newecoui\infrastructure\repository\MessageRepository;
use onebone\economyapi\EconomyAPI;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

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
        $onBuild = function (Player $player): Form{
            return new MenuForm();
        };
        $form = new BuildForm($player, $onBuild);
        $form->build();
    }

    public function jsonSerialize(): array
    {
        $messageRepository = new MessageRepository();
        return [
            'type' => 'custom_form',
            'title' =>  TextFormat::AQUA . $messageRepository->getMessage("menu.info_button"),
            "content" => [
                [
                    "type" => "label",
                    "text" => (string) EconomyAPI::getInstance()->myMoney($this->player)
                ],
            ]
        ];
    }
}