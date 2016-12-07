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
 * Day 4: The Ideal Stocking Stuffer
 *
 * @see http://adventofcode.com/2015/day/4
 */
final class Day4 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        return new ResultCollection($this->findHash($input, 5), $this->findHash($input, 6));
    }

    private function findHash(string $key, int $zeros): int
    {
        $number = 0;
        $zeroStr = str_repeat('0', $zeros);

        while (substr(md5($key.$number), 0, $zeros) !== $zeroStr) {
            ++$number;
        }

        return $number;
    }
}
