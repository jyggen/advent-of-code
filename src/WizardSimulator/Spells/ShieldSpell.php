<?php
namespace Boo\AdventOfCode\WizardSimulator\Spells;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\Player;

class ShieldSpell extends SpellAbstract
{
    public function apply(Player $player, Boss $boss, $turns)
    {
        if ($turns === 0) {
            $player->setArmor(0);
        }
    }

    public function cast(Player $player, Boss $boss, EffectTracker $effects)
    {
        $player->reduceMana($this->getCost());
        $player->setArmor(7);
        $effects->add($this);
    }

    public function getCost()
    {
        return 113;
    }

    public function getTurns()
    {
        return 6;
    }
}
