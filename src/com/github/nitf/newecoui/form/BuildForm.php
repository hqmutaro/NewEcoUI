<?php

namespace com\github\nitf\newecoui\form;

use pocketmine\form\Form;
use pocketmine\Player;

class BuildForm
{
    /** @var Player $player */
    private $player;

    /** @var Form $form */
    private $form;

    public function __construct(Player $player, \Closure $onBuild)
    {
        $this->player = $player;
        $this->form = $onBuild($player);
    }

    public function build(): void
    {
        $this->player->sendForm($this->form);
    }
}