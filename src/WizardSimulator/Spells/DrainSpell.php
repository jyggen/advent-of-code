<?php
namespace Boo\AdventOfCode\WizardSimulator\Spells;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\Player;

class DrainSpell extends SpellAbstract
{
    public function apply(Player $player, Boss $boss, $turns)
    {
        return;
    }

    public function cast(Player $player, Boss $boss, EffectTracker $effects)
    {
        $player->reduceMana($this->getCost());
        $player->giveHealth(2);
        $boss->inflictDamage(2);
    }

    public function getCost()
    {
        return 73;
    }

    public function getTurns()
    {
        return 6;
    }
}
