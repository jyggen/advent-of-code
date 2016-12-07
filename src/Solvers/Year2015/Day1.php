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
 * Day 1: Not Quite Lisp
 *
 * @see http://adventofcode.com/2015/day/1
 */
final class Day1 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $start = microtime(true);

        // He starts on the ground floor (floor 0) ..
        $floor = 0;
        $firstBasement = null;

        // .. and then follows the instructions one character at a time.
        foreach (str_split($input) as $key => $step) {
            // An opening parenthesis, (, means he should go up one floor,
            // and a closing parenthesis, ), means he should go down one floor.
            $floor = ($step === '(') ? $floor + 1 : $floor - 1;

            // Find the position of the first character that
            // causes him to enter the basement (floor -1).
            if ($floor === -1 && $firstBasement === null) {
                $firstBasement = $key + 1;
            }
        }

        $stop = microtime(true) - $start;

        echo ($stop*1000).PHP_EOL;

        // $floor: To what floor do the instructions take Santa?
        // $firstBasement: What is the position of the character that
        //                 causes Santa to first enter the basement?
        return new ResultCollection($floor, $firstBasement);
    }
}
