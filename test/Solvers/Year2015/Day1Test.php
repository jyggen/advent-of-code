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

namespace Boo\AdventOfCode\Tests\Solvers\Year2015;

use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\Tests\DayTestAbstract;
use Boo\AdventOfCode\SolverInterface;
use Boo\AdventOfCode\Solvers\Year2015\Day1;

/**
 * @group 2015-1
 */
final class Day1Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                '(())',
                new ResultCollection(0, null),
            ], [
                '()()',
                new ResultCollection(0, null),
            ], [
                '(((',
                new ResultCollection(3, null),

            ], [
                '(()(()(',
                new ResultCollection(3, null),
            ], [
                '))(((((',
                new ResultCollection(3, null),
            ], [
                '())',
                new ResultCollection(-1, null),
            ], [
                '))(',
                new ResultCollection(-1, null),
            ], [
                ')))',
                new ResultCollection(-3, null),
            ], [
                ')())())',
                new ResultCollection(-3, null),
            ],
            [
                ')',
                new ResultCollection(null, 1),
            ],
            [
                '()())',
                new ResultCollection(null, 5),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day1();
    }
}
