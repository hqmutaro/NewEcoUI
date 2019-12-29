<?php

namespace com\github\nitf\newecoui\form;

use com\github\nitf\newecoui\infrastructure\repository\MessageRepository;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class MenuForm implements Form
{
    const InfoButton = 0;
    const PayButton = 1;
    const SearchButton = 2;

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }

        switch ($data) {
            case self::InfoButton:
                $onBuild = function (Player $player): Form{
                    return new InfoForm($player);
                };
                $form = new BuildForm($player, $onBuild);
                $form->build();
                return;

            case self::PayButton:
                $onBuild = function (Player $player): Form{
                    return new PayForm();
                };
                $form = new BuildForm($player, $onBuild);
                $form->build();
                return;

            case self::SearchButton:
                $onBuild = function (Player $player): Form{
                    return new SearchForm(null);
                };
                $form = new BuildForm($player, $onBuild);
                $form->build();
                return;

            default:
                return;
        }
    }

    public function jsonSerialize(): array
    {
        $messageRepository = new MessageRepository();
        return [
            "type" => "form",
            "title" => TextFormat::AQUA . "Eco UI",
            "content" => "選択してください",
            "buttons" => [
                [
                    "text" => $messageRepository->getMessage("menu.info_button"),
                ],
                [
                    "text" => $messageRepository->getMessage("menu.pay_button"),
                ],
                [
                    "text" => $messageRepository->getMessage("menu.search_button"),
                ]
            ]
        ];
    }
}