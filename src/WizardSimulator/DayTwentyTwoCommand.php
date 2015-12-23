<?php
namespace Boo\AdventOfCode\Commands;

use Boo\AdventOfCode\WizardSimulator\Boss;
use Boo\AdventOfCode\WizardSimulator\EffectTracker;
use Boo\AdventOfCode\WizardSimulator\OutOfManaException;
use Boo\AdventOfCode\WizardSimulator\Player;
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
            $this->output->writeln('--------------------------------------------------------------------------------');
            $iterations++;

            $player  = new Player($health, $mana, $numberOfRecharge, $numberOfShield, $numberOfDrain, $this->output);
            $boss    = new Boss($bossStats['Hit Points'], $bossStats['Damage'], $this->output);
            $effects = new EffectTracker($player, $boss);
            $spells  = [];

            try {
                while (true) {
                    $this->output->writeln('-- Player turn --');
                    $player->printInfoLine();
                    $boss->printInfoLine();

                    $effects->apply();

                    if ($boss->isDead()) {
                        break;
                    }

                    $spell    = $player->findBestSpellToCast($boss, $effects);
                    $spells[] = get_class($spell);
                    $spell->cast($player, $boss, $effects);

                    $this->output->writeln('');
                    $this->output->writeln('-- Boss turn --');
                    $player->printInfoLine();
                    $boss->printInfoLine();

                    $effects->apply();

                    if ($boss->isDead()) {
                        break;
                    }

                    $boss->attack($player);

                    if ($player->isDead()) {
                        break;
                    }

                    $this->output->writeln('');
                }
            } catch (OutOfManaException $e) {
                $numberOfRecharge++;
                $this->output->writeln('OUT OF MANA :(');
                continue;
            }

            if ($boss->isDead()) {
                break;
            }

            if ($effects->has(Spells\ShieldSpell::class)) {
                $numberOfDrain++;
                $this->output->writeln('MORE DRAIN!');
            } else {
                $numberOfShield++;
                $this->output->writeln('MORE SHIELD!');
            }
        }

        $this->output->writeln($numberOfRecharge);
        $this->output->writeln($numberOfShield);
        $this->output->writeln($numberOfDrain);

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
            $this->output->writeln('--------------------------------------------------------------------------------');
            $iterations++;

            $player  = new Player($health, $mana, $numberOfRecharge, $numberOfShield, $numberOfDrain, $this->output);
            $boss    = new Boss($bossStats['Hit Points'], $bossStats['Damage'], $this->output);
            $effects = new EffectTracker($player, $boss);
            $spells  = [];

            try {
                while (true) {
                    $this->output->writeln('-- Player turn --');
                    $player->printInfoLine();
                    $boss->printInfoLine();

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

                    $this->output->writeln('');
                    $this->output->writeln('-- Boss turn --');
                    $player->printInfoLine();
                    $boss->printInfoLine();

                    $effects->apply();

                    if ($boss->isDead()) {
                        break;
                    }

                    $boss->attack($player);

                    if ($player->isDead()) {
                        break;
                    }

                    $this->output->writeln('');
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

        $this->output->writeln($numberOfRecharge);
        $this->output->writeln($numberOfShield);
        $this->output->writeln($numberOfDrain);
        var_dump($spells);

        return $player->getManaSpent();
    }
}
