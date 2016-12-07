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
use Boo\AdventOfCode\Solvers\Year2015\Day12;

/**
 * @group 2015-12
 */
final class Day12Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                '[1,2,3]',
                new ResultCollection(6, 6),
            ],
            [
                '{"a":2,"b":4}',
                new ResultCollection(6, null),
            ],
            [
                '[[[3]]]',
                new ResultCollection(3, null),
            ],
            [
                '{"a":{"b":4},"c":-1}',
                new ResultCollection(3, null),
            ],
            [
                '{"a":[-1,1]}',
                new ResultCollection(0, null),
            ],
            [
                '[-1,{"a":1}]',
                new ResultCollection(0, null),
            ],
            [
                '[]',
                new ResultCollection(0, null),
            ],
            [
                '[1,{"c":"red","b":2},3]',
                new ResultCollection(null, 4),
            ],
            [
                '{"d":"red","e":[1,2,3,4],"f":5}',
                new ResultCollection(null, 0),
            ],
            [
                '[1,"red",5]',
                new ResultCollection(null, 6),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day12();
    }
}
