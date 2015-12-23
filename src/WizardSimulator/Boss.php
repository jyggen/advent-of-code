<?php
namespace Boo\AdventOfCode\WizardSimulator;

use Symfony\Component\Console\Output\OutputInterface;

class Boss
{
    protected $damage;
    protected $health;
    protected $output;

    public function __construct($health, $damage, OutputInterface $output)
    {
        $this->damage = $damage;
        $this->health = $health;
        $this->output = $output;
    }

    public function attack(Player $player)
    {
        $this->output->writeln('Boss attacks for '.$player->inflictDamage($this->damage).' damage.');
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

    public function printInfoLine()
    {
        $this->output->writeln('- Boss has '.$this->health.' hit points');
    }
}
