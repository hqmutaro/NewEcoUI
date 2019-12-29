<?php

namespace com\github\nitf\newecoui\form;

use com\github\nitf\newecoui\infrastructure\repository\MessageRepository;
use onebone\economyapi\EconomyAPI;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class PayForm implements Form
{
    /** @var Player[] $players */
    private $players;

    public function __construct()
    {
        $this->players = array_values(array_map(function (Player $player) {
            return $player->getName();
        }, Server::getInstance()->getOnlinePlayers()));
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            $onBuild = function (Player $player): Form{
                return new MenuForm();
            };
            $form = new BuildForm($player, $onBuild);
            $form->build();
            return;
        }
        /** @var string $targetName */
        $targetName = $this->players[$data[0]];
        /** @var int $moneyAmount */
        $moneyAmount = $data[1];

        /** @var Player $targetPlayer */
        $targetPlayer = Server::getInstance()->getPlayer($targetName);

        $economyAPI = EconomyAPI::getInstance();

        $reduce = $economyAPI->reduceMoney($player, $moneyAmount);
        if ($reduce === EconomyAPI::RET_INVALID) {
            $player->sendMessage("残高が足りません");
            return;
        }

        $economyAPI->addMoney($targetPlayer, $moneyAmount); // 対象にMoneyを追加して支払い完了

        // EconomyAPIで指定したフォーマットでメッセージを送信
        $player->sendMessage($economyAPI->getMessage("pay-success", [
            $moneyAmount,
            $targetPlayer->getName()
        ], $player->getName()));

        $targetPlayer->sendMessage($economyAPI->getMessage("money-paid", [
            $player->getName(),
            $moneyAmount
        ], $player->getName()));
    }

    public function jsonSerialize(): array
    {
        $messageRepository = new MessageRepository();
        return [
            "type" => "custom_form",
            "title" => TextFormat::AQUA . $messageRepository->getMessage("menu.pay_button"),
            "content" => [
                [
                    "type" => "dropdown",
                    "text" => TextFormat::BLUE . "対象",
                    "options" => $this->players,
                    "default" => 0
                ],
                [
                    "type" => "slider",
                    "text" => TextFormat::BLUE . "金額",
                    "min" => 1,
                    "max" => 1000, // 数値を大きくしすぎると対象値に合わせづらくなる
                    "default" => 0
                ],
            ]
        ];
    }
}