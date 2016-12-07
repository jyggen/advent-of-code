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
use Boo\AdventOfCode\Solvers\Year2015\Day6;

/**
 * @group 2015-6
 */
final class Day6Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                'turn on 0,0 through 999,999',
                new ResultCollection(1000000, null),
            ],
            [
                'toggle 0,0 through 999,0',
                new ResultCollection(1000, null),
            ],
            [
                'turn on 499,499 through 500,500',
                new ResultCollection(4, null),
            ],
            [
                'turn on 0,0 through 0,0',
                new ResultCollection(null, 1),
            ],
            [
                'toggle 0,0 through 999,999',
                new ResultCollection(null, 2000000),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day6();
    }
}
