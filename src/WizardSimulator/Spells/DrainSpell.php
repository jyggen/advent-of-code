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
        $this->output->writeln('Player casts Drain, dealing 2 damage, and healing 2 hit points.');
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
