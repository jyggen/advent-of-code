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

/**
 * Day 3: Perfectly Spherical Houses in a Vacuum
 *
 * @see http://adventofcode.com/2015/day/3
 */
final class Day3 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = str_split($input);

        return new ResultCollection($this->moveSantas($input, 1), $this->moveSantas($input, 2));
    }

    private function moveSantas(array $input, int $numberOfSantas): int
    {
        // He begins by delivering a present to the house at his starting location.
        $houses = [md5('0x0') => null];
        $inputLength = count($input);

        for ($santa = 0; $santa < $numberOfSantas; $santa++) {
            // Santa is delivering presents to an infinite two-dimensional grid of houses.
            $xAxis = 0;
            $yAxis = 0;

            for ($step = $santa; $step < $inputLength; $step += $numberOfSantas) {
                // Moves are always exactly one house to the north (^), south (v), east (>), or west (<).
                switch ($input[$step]) {
                    case '^':
                        $yAxis--;
                        break;
                    case 'v':
                        $yAxis++;
                        break;
                    case '>':
                        $xAxis++;
                        break;
                    case '<':
                        $xAxis--;
                        break;
                }

                $houseId = md5($xAxis.'x'.$yAxis);

                // After each move, he delivers another present to the house at his new location.
                if (isset($houses[$houseId]) === false) {
                    $houses[$houseId] = null;
                }
            }
        }

        return count($houses);
    }
}
