<?php
namespace Boo\AdventOfCode\WizardSimulator;

class Boss
{
    protected $damage;
    protected $health;

    public function __construct($health, $damage)
    {
        $this->damage = $damage;
        $this->health = $health;
    }

    public function attack(Player $player)
    {
        $player->inflictDamage($this->damage);
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function inflictDamage($damage)
    {
        $this->health -= $damage;

        return $damage;
    }

    public function isDead()
    {
        return $this->health <= 0;
    }
}
