<?php
namespace Boo\AdventOfCode\WizardSimulator;

use Boo\AdventOfCode\WizardSimulator\Spells;

class PlayerTwo extends Player
{
    public function findBestSpellToCast(Boss $boss, EffectTracker $effectTracker)
    {
        $numberOfHitsLeft = ceil($boss->getHealth() / 4);
        $roundsUntilDead  = ceil($this->health / ($boss->getDamage() + 1));
        $haveManaToNuke   = ($numberOfHitsLeft * 53 <= $this->mana);

        if ($numberOfHitsLeft <= $roundsUntilDead && $haveManaToNuke === true) {
            return new Spells\MagicMissileSpell;
        }

        if ($this->recharge > 0 && $effectTracker->has(Spells\RechargeSpell::class) === false && $this->mana >= 229 && $this->mana < 402) {
            $this->recharge--;
            return new Spells\RechargeSpell;
        }

        if ($this->shield > 0 && $effectTracker->has(Spells\ShieldSpell::class) === false && $numberOfHitsLeft > $roundsUntilDead && $this->health <= ($boss->getDamage() + 1) * 3 && $this->mana >= 113) {
            $this->shield--;
            return new Spells\ShieldSpell;
        }

        if ($this->health <= $this->maxHealth - 2 && $this->drain > 0 && $effectTracker->has(Spells\ShieldSpell::class) === false && $effectTracker->has(Spells\DrainSpell::class) === false && $this->mana >= 73) {
            $this->drain--;
            return new Spells\DrainSpell;
        }

        if ($boss->getHealth() <= 8 && $this->mana >= 53) {
            return new Spells\MagicMissileSpell;
        }

        if ($effectTracker->has(Spells\PoisonSpell::class) === false && $this->mana >= 173) {
            return new Spells\PoisonSpell;
        }

        if ($this->mana >= 53) {
            return new Spells\MagicMissileSpell;
        }

        throw new OutOfManaException;
    }
}
