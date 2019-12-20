<?php

namespace com\github\nitf\newecoui\form;

use onebone\economyapi\EconomyAPI;
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
        /** @var string $targetName */
        $targetName = $data[0];
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
            $targetPlayer
        ], $player->getName()));

        $targetPlayer->sendMessage($economyAPI->getMessage("money-paid", [
            $player->getName(),
            $moneyAmount
        ], $player->getName()));
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
                    "max" => 10000, // 数値を大きくしすぎると対象値に合わせづらくなる
                    "default" => 100
                ],
            ]
        ];
    }
}