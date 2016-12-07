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
use Boo\AdventOfCode\Solvers\Year2015\Day2;

/**
 * @group 2015-2
 */
final class Day2Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                '2x3x4',
                new ResultCollection(58, 34),
            ], [
                '1x1x10',
                new ResultCollection(43, 14),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day2();
    }
}