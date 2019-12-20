<?php


namespace com\github\nitf\newecoui\form;


use onebone\economyapi\EconomyAPI;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use pocketmine\Server;

class SearchForm implements Form
{
    /** @var Player $target */
    private $target;

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
        $i = function ($v) { return $v; };
        return [
          "type" => "custom_form",
          "title" => "CustomForm",
          "content" => [
              [
                  "type" => "label",
                  "text" => $this->target === null ? "Player: null\nMoney: null"
                      : "Player: {$this->target->getName()}\nMoney: {$i(EconomyAPI::getInstance()->myMoney($this->target))}"
              ],
              [
                  "type" => "dropdown",
                  "text" => "対象",
                  "options" => array_map(function (Player $player) {
                      return $player->getName();
                  }, Server::getInstance()->getOnlinePlayers()),
                  "default" => 1
              ],
          ]
        ];
    }
}