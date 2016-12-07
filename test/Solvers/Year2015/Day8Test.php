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
use Boo\AdventOfCode\Solvers\Year2015\Day8;

/**
 * @group 2015-8
 */
final class Day8Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                '""',
                new ResultCollection(2, 4),
            ],
            [
                '"abc"',
                new ResultCollection(2, 4),
            ],
            [
                '"aaa\"aaa"',
                new ResultCollection(3, 6),
            ],
            [
                '"\x27"',
                new ResultCollection(5, 5),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day8();
    }
}
