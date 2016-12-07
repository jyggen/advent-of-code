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
use Boo\AdventOfCode\Solvers\Year2015\Day18;

/**
 * @group 2015-18
 */
final class Day18Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        $input = <<<'INPUT'
.#.#.#
...##.
#....#
..#...
#.#..#
####..
INPUT;

        return [
            [
                $input,
                new ResultCollection(4, 14),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day18();
    }
}
