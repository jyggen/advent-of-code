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
 * Day 10: Elves Look, Elves Say
 *
 * @see http://adventofcode.com/2015/day/10
 */
final class Day10 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = str_split($input);
        $partOne = null;
        $testOne = null;
        $partTwo = null;

        for ($i = 1; $i <= 50; $i++) {
            $string = '';
            $lastDigit = $input[0];
            $digitCount = 0;

            foreach ($input as $number) {
                if ($lastDigit !== $number) {
                    $string .= $digitCount.$lastDigit;
                    $lastDigit = $number;
                    $digitCount = 0;
                }

                ++$digitCount;
            }

            $string .= $digitCount.$lastDigit;

            if ($i === 1) {
                $testOne = $string;
            }

            $input = str_split($string);

            if ($i === 40) {
                $partOne = count($input);
            }
        }

        $partTwo = count($input);

        return new ResultCollection($partOne, $partTwo, $testOne);
    }
}
