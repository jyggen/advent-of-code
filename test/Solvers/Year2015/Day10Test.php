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
use Boo\AdventOfCode\Solvers\Year2015\Day10;

/**
 * @group 2015-10
 */
final class Day10Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                '1',
                new ResultCollection('11', null),
            ],
            [
                '11',
                new ResultCollection('21', null),
            ],
            [
                '21',
                new ResultCollection('1211', null),
            ],
            [
                '1211',
                new ResultCollection('111221', null),
            ],
            [
                '111221',
                new ResultCollection('312211', null),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day10();
    }
}
