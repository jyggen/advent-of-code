<?php
namespace Boo\AdventOfCode\WizardSimulator\Spells;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\Player;

class RechargeSpell extends SpellAbstract
{
    public function apply(Player $player, Boss $boss, $turns)
    {
        $this->output->writeln('Recharge provides 101 mana; its timer is now '.$turns.'.');
        $player->giveMana(101);
    }

    public function cast(Player $player, Boss $boss, EffectTracker $effects)
    {
        $this->output->writeln('Player casts Recharge.');
        $player->reduceMana($this->getCost());
        $effects->add($this);
    }

    public function getCost()
    {
        return 229;
    }

    public function getTurns()
    {
        return 5;
    }
}
