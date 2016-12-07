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
use Boo\AdventOfCode\Solvers\Year2015\Day11;

/**
 * @group 2015-11
 */
final class Day11Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                'abcdefgh',
                new ResultCollection('abcdffaa', null),
            ],
            [
                'ghijklmn',
                new ResultCollection('ghjaabcc', null),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day11();
    }
}
