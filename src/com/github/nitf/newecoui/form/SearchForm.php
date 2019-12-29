<?php

namespace com\github\nitf\newecoui\form;

use com\github\nitf\newecoui\infrastructure\repository\MessageRepository;
use onebone\economyapi\EconomyAPI;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class SearchForm implements Form
{
    /** @var ?Player $target */
    private $target;

    /** @var Player[] $players */
    private $players;

    public function __construct(?Player $target)
    {
        $this->target = $target;
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
        $this->target = Server::getInstance()->getPlayer($this->players[$data[1]]);

        $onBuild = function (Player $player): Form{
            return new SearchForm($this->target);
        };
        $form = new BuildForm($player, $onBuild);
        $form->build();
    }

    public function jsonSerialize(): array
    {
        $messageRepository = new MessageRepository();
        $i = function ($v) { return $v; };
        return [
          "type" => "custom_form",
          "title" => TextFormat::AQUA . $messageRepository->getMessage("menu.search_button"),
          "content" => [
              [
                  "type" => "label",
                  "text" => $this->target === null
                      ? "Player: null\nMoney: null"
                      : "Player: {$this->target->getName()}
                      \nMoney: {$i(EconomyAPI::getInstance()->myMoney($this->target))}"
              ],
              [
                  "type" => "dropdown",
                  "text" => TextFormat::BLUE . "対象",
                  "options" => $this->players,
                  "default" => 0
              ],
          ]
        ];
    }
}