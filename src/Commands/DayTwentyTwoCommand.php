<?php
namespace Boo\AdventOfCode\Commands;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\OutOfManaException;
use Boo\AdventOfCode\WizardSimulator\Player;
use Boo\AdventOfCode\WizardSimulator\PlayerTwo;
use Boo\AdventOfCode\WizardSimulator\Spells;

class DayTwentyTwoCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => [
                'Hit Points: 13',
                'Damage: 8',
            ],
            'output' => 226,
        ],
        [
            'input'  => [
                'Hit Points: 14',
                'Damage: 8',
            ],
            'output' => 641,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Wizard Simulator 20XX');
    }

    protected function normalizeData(array $input)
    {
        $stats = [];

        foreach ($input as $stat) {
            list($stat, $value) = explode(': ', $stat);
            $stats[$stat]       = $value;
        }

        return $stats;
    }

    protected function getDayNumber()
    {
        return 22;
    }

    protected function performTest(array &$input)
    {
        return [$this->simulateBattle(10, 250, $input), null];
    }

    protected function perform(array &$input)
    {
        return [$this->simulateBattle(50, 500, $input), $this->simulateHarderBattle(50, 500, $input)];
    }

    protected function simulateBattle($health, $mana, $bossStats)
    {

        $numberOfRecharge = 0;
        $numberOfShield   = 0;
        $numberOfDrain    = 0;
        $iterations       = 0;

        while (true) {
            $iterations++;

            $player  = new Player($health, $mana, $numberOfRecharge, $numberOfShield, $numberOfDrain, $this->output);
            $boss    = new Boss($bossStats['Hit Points'], $bossStats['Damage'], $this->output);
            $effects = new EffectTracker($player, $boss);
            $spells  = [];

            try {
                while (true) {
                    $effects->apply();

                    if ($boss->isDead()) {
                        break;
                    }

                    $spell    = $player->findBestSpellToCast($boss, $effects);
                    $spells[] = get_class($spell);

                    $spell->cast($player, $boss, $effects);
                    $effects->apply();

                    if ($boss->isDead()) {
                        break;
                    }

                    $boss->attack($player);

                    if ($player->isDead()) {
                        break;
                    }
                }
            } catch (OutOfManaException $e) {
                $numberOfRecharge++;
                continue;
            }

            if ($boss->isDead()) {
                break;
            }

            if ($effects->has(Spells\ShieldSpell::class)) {
                $numberOfDrain++;
            } else {
                $numberOfShield++;
            }
        }

        return $player->getManaSpent();
    }

    protected function simulateHarderBattle($health, $mana, $bossStats)
    {

        $numberOfRecharge = 0;
        $numberOfShield   = 0;
        $numberOfDrain    = 0;
        $iterations       = 0;
        $shieldFailed     = true;

        while (true) {
            $iterations++;

            $player  = new PlayerTwo($health, $mana, $numberOfRecharge, $numberOfShield, $numberOfDrain, $this->output);
            $boss    = new Boss($bossStats['Hit Points'], $bossStats['Damage'], $this->output);
            $effects = new EffectTracker($player, $boss);
            $spells  = [];

            try {
                while (true) {
                    $player->reduceHealth(1);

                    if ($player->isDead()) {
                        break;
                    }

                    $effects->apply();

                    if ($boss->isDead()) {
                        break;
                    }

                    $spell    = $player->findBestSpellToCast($boss, $effects);
                    $spells[] = get_class($spell);

                    $spell->cast($player, $boss, $effects);
                    $effects->apply();

                    if ($boss->isDead()) {
                        break;
                    }

                    $boss->attack($player);

                    if ($player->isDead()) {
                        break;
                    }
                }
            } catch (OutOfManaException $e) {
                $numberOfRecharge++;
                continue;
            }

            if ($boss->isDead()) {
                break;
            }

            if ($shieldFailed === false) {
                $numberOfDrain++;
                $shieldFailed = true;
            } else {
                $numberOfShield++;
                $shieldFailed = false;
            }

            $numberOfRecharge = 0;
        }

        return $player->getManaSpent();
    }
}
