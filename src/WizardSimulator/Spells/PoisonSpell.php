<?php
namespace Boo\AdventOfCode\WizardSimulator\Spells;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\Player;

class PoisonSpell extends SpellAbstract
{
    public function apply(Player $player, Boss $boss, $turns)
    {
        $boss->inflictDamage(3);

        if ($boss->isDead()) {
            return;
        }
    }

    public function cast(Player $player, Boss $boss, EffectTracker $effects)
    {
        $player->reduceMana($this->getCost());
        $effects->add($this);
    }

    public function getCost()
    {
        return 173;
    }

    public function getTurns()
    {
        return 6;
    }
}
