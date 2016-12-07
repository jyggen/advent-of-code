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
 * Day 8: Matchsticks
 *
 * @see http://adventofcode.com/2015/day/8
 */
final class Day8 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $literalSize = 0;
        $memorySize = 0;
        $newSize = 0;

        foreach ($input as $string) {
            $literalString = trim($string);
            $newString = '"'.addslashes($literalString).'"';

            // Cheating! :D
            eval('$memoryString = '.$literalString.';');

            $literalSize += mb_strlen($literalString);
            $memorySize += mb_strlen($memoryString, '8bit');
            $newSize += mb_strlen($newString);
        }

        return new ResultCollection($literalSize - $memorySize, $newSize - $literalSize);
    }
}
