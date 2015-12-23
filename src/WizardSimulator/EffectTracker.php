<?php
namespace Boo\AdventOfCode\WizardSimulator;

use Boo\AdventOfCode\WizardSimulator\Spells\SpellAbstract;

class EffectTracker
{
    protected $boss;
    protected $effects = [];
    protected $player;

    public function __construct(Player $player, Boss $boss)
    {
        $this->boss   = $boss;
        $this->player = $player;
    }

    public function add(SpellAbstract $spell)
    {
        $this->effects[get_class($spell)] = [
            'spell' => $spell,
            'turns' => $spell->getTurns(),
        ];
    }

    public function has($spell) {
        return isset($this->effects[$spell]);
    }

    public function apply()
    {
        foreach ($this->effects as $key => $effect) {
            $this->effects[$key]['turns']--;
            $effect['spell']->apply($this->player, $this->boss, $this->effects[$key]['turns']);

            if ($this->effects[$key]['turns'] === 0) {
                unset($this->effects[$key]);
            }
        }
    }
}
