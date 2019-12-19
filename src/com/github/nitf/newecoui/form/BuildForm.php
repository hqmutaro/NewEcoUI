<?php

namespace com\github\nitf\newecoui\form;

use pocketmine\form\Form;
use pocketmine\Player;

/**
 * @method onBuild(Player $player)
 */
class BuildForm
{
    /** @var Player $player */
    private $player;

    /** @var \Closure $onBuild */
    private $onBuild;

    public function __construct(Player $player, \Closure $onBuild)
    {
        $this->player = $player;
        $this->onBuild = $onBuild;
        $this->build();
    }

    public function build(): void
    {
        /** @var Form $form */
        $form = $this->onBuild($this->player);
        $this->player->sendForm($form);
    }
}