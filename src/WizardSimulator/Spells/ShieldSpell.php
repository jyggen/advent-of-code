<?php
namespace Boo\AdventOfCode\WizardSimulator\Spells;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\Player;

class ShieldSpell extends SpellAbstract
{
    public function apply(Player $player, Boss $boss, $turns)
    {
        $this->output->writeln('Shield\'s timer is now '.$turns.'.');

        if ($turns === 0) {
            $player->setArmor(0);
            $this->output->writeln('Shield wears off, decreasing armor by 7.');
        }
    }

    public function cast(Player $player, Boss $boss, EffectTracker $effects)
    {
        $this->output->writeln('Player casts Shield, increasing armor by 7.');
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
