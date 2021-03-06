<?php
namespace Boo\AdventOfCode\WizardSimulator;

use Boo\AdventOfCode\WizardSimulator\Spells;

class Player
{
    protected $armor = 0;
    protected $drain = 0;
    protected $health;
    protected $mana;
    protected $manaSpent = 0;
    protected $maxHealth;
    protected $recharge = 0;
    protected $shield = 0;

    public function __construct($health, $mana, $recharge, $shield, $drain)
    {
        $this->drain     = $drain;
        $this->health    = $health;
        $this->maxHealth = $health;
        $this->mana      = $mana;
        $this->recharge  = $recharge;
        $this->shield    = $shield;
    }

    public function findBestSpellToCast(Boss $boss, EffectTracker $effectTracker)
    {
        if ($this->recharge > 0 && $effectTracker->has(Spells\RechargeSpell::class) === false && $this->mana >= 229 && $this->mana < 402) {
            $this->recharge--;
            return new Spells\RechargeSpell;
        }

        if ($this->shield > 0 && $effectTracker->has(Spells\ShieldSpell::class) === false && $this->health <= $boss->getDamage() * 3 && $this->mana >= 113) {
            $this->shield--;
            return new Spells\ShieldSpell;
        }

        if ($this->drain > 0 && $effectTracker->has(Spells\DrainSpell::class) === false && $this->mana >= 73) {
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

    public function getCurrentMana()
    {
        return $this->mana;
    }

    public function getManaSpent()
    {
        return $this->manaSpent;
    }

    public function giveHealth($value)
    {
        $this->health += $value;
    }

    public function giveMana($value)
    {
        $this->mana += $value;
    }

    public function inflictDamage($damage)
    {
        $damage        = max(1, $damage - $this->armor);
        $this->health -= $damage;

        return $damage;
    }

    public function isDead()
    {
        return $this->health <= 0;
    }

    public function reduceHealth($health)
    {
        $this->health -= $health;
    }


    public function reduceMana($mana)
    {
        $this->manaSpent += $mana;
        $this->mana      -= $mana;
    }

    public function setArmor($value)
    {
        $this->armor = $value;
    }
}
