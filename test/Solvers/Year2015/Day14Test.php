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
use Boo\AdventOfCode\Solvers\Year2015\Day14;

/**
 * @group 2015-14
 */
final class Day14Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        $input = <<<'INPUT'
Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.
Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.
INPUT;

        return [
            [
                $input,
                new ResultCollection(1120, 689),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day14();
    }
}
