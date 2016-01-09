<?php
namespace Boo\AdventOfCode\WizardSimulator\Spells;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\Player;

class MagicMissileSpell extends SpellAbstract
{
    public function apply(Player $player, Boss $boss, $turns)
    {
        return;
    }

    public function cast(Player $player, Boss $boss, EffectTracker $effects)
    {
        $player->reduceMana($this->getCost());
        $boss->inflictDamage(4);
    }

    public function getCost()
    {
        return 53;
    }

    public function getTurns()
    {
        return false;
    }
}
