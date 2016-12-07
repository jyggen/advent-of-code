<?php

declare(strict_types=1);

/*
 * This file is part of the Advent of Code package.
 *
 * (c) Jonas Stendahl <jonas@stendahl.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boo\AdventOfCode\Solvers\Year2015;

use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\SolverInterface;
use Symfony\Component\Console\Helper\ProgressIndicator;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Day 20: Infinite Elves and Infinite Houses
 *
 * @see http://adventofcode.com/2015/day/20
 */
final class Day20 implements SolverInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $indicator = new ProgressIndicator($this->output);

        $indicator->start('Bootstrapping...');

        $firstAnswer = $this->performOne($input, $indicator);
        $secondAnswer = $this->performTwo($input, $indicator);

        $indicator->finish('Done!');

        return new ResultCollection($firstAnswer, $secondAnswer);
    }

    private function performOne(array $input, ProgressIndicator $indicator): int
    {
        $magicNumber   = $input[0];
        $houseToCheck  = 100000;
        $increment     = 100000;
        $decrease      = 1000;
        $lowest        = PHP_INT_MAX;
        $checkedHouses = [];

        while (true) {
            if (isset($checkedHouses[$houseToCheck]) === false) {
                $presents = 0;

                for ($i = $houseToCheck; $i > 0; $i--) {
                    if ($houseToCheck % $i === 0) {
                        $presents += $i * 10;
                    }
                }

                $checkedHouses[$houseToCheck]= true;

                if ($presents >= $magicNumber) {
                    $lowest = min($lowest, $houseToCheck);
                }

                if ($lowest === PHP_INT_MAX) {
                    $houseToCheck += $increment;
                    continue;
                }
            }

            $houseToCheck -= $increment;

            if ($houseToCheck < ($magicNumber / 100) * 2) {
                $increment -= $decrease;

                if ($increment === 0) {
                    $increment = $decrease;
                    $decrease  = $decrease / 10;

                    if ($decrease === 10) {
                        $increment = 20;
                    }

                    if ($decrease === 1) {
                        break;
                    }

                    $increment -= $decrease;
                }

                $indicator->setMessage('Part 1 | Increment: '.$increment.' | Expected: 786240 | Lowest: '.$lowest);
                $indicator->advance();

                $houseToCheck = $lowest;
            }
        }

        return $lowest;
    }

    private function performTwo(array $input, ProgressIndicator $indicator): int
    {
        $magicNumber   = $input[0];
        $houseToCheck  = 100000;
        $increment     = 100000;
        $decrease      = 1000;
        $lowest        = PHP_INT_MAX;
        $checkedHouses = [];

        while (true) {
            if (isset($checkedHouses[$houseToCheck]) === false) {
                $presents = 0;

                for ($i = $houseToCheck; $i > 0; $i--) {
                    if ($i * 50 >= $houseToCheck && $houseToCheck % $i === 0) {
                        $presents += $i * 11;
                    }
                }

                $checkedHouses[$houseToCheck]= true;

                if ($presents >= $magicNumber) {
                    $lowest = min($lowest, $houseToCheck);
                }

                if ($lowest === PHP_INT_MAX) {
                    $houseToCheck += $increment;
                    continue;
                }
            }

            $houseToCheck -= $increment;

            if ($houseToCheck < ($magicNumber / 100) * 2) {
                $increment -= $decrease;

                if ($increment === 0) {
                    $increment = $decrease;
                    $decrease  = $decrease / 10;

                    if ($decrease === 10) {
                        $increment = 20;
                    }

                    if ($decrease === 1) {
                        break;
                    }

                    $increment -= $decrease;
                }

                $indicator->setMessage('Part 2 | Increment: '.$increment.' | Expected: 786240 | Lowest: '.$lowest);
                $indicator->advance();

                $houseToCheck = $lowest;
            }
        }

        return $lowest;
    }
}
