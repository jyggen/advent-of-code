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
use Boo\AdventOfCode\Solvers\Year2015\Day7;

/**
 * @group 2015-7
 */
final class Day7Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        $input = <<<'INPUT'
123 -> x
456 -> y
x AND y -> d
x OR y -> e
x LSHIFT 2 -> f
y RSHIFT 2 -> g
NOT x -> h
NOT y -> a
INPUT;

        return [
            [
                $input,
                new ResultCollection(65079, null),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day7();
    }
}
