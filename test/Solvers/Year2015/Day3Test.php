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
use Boo\AdventOfCode\Solvers\Year2015\Day3;

/**
 * @group 2015-3
 */
final class Day3Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                '>',
                new ResultCollection(2, null),
            ],
            [
                '^>v<',
                new ResultCollection(4, 3),
            ],
            [
                '^v^v^v^v^v',
                new ResultCollection(2, 11),
            ],
            [
                '^>',
                new ResultCollection(null, 3),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day3();
    }
}
