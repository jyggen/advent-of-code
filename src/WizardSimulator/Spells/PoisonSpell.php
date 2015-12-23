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
            $this->output->writeln('Poison deals 3 damage. This kills the boss, and the player wins.');
            return;
        }

        $this->output->writeln('Poison deals 3 damage; its timer is now '.$turns.'.');
    }

    public function cast(Player $player, Boss $boss, EffectTracker $effects)
    {
        $this->output->writeln('Player casts Poison.');
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
