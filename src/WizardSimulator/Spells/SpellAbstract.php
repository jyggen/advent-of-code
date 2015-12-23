<?php
namespace Boo\AdventOfCode\WizardSimulator\Spells;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\Player;
use Symfony\Component\Console\Output\OutputInterface;

abstract class SpellAbstract
{
    protected $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    abstract public function apply(Player $player, Boss $boss, $turns);

    abstract public function cast(Player $player, Boss $boss, EffectTracker $effects);

    abstract public function getCost();

    abstract public function getTurns();
}
