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
use Boo\AdventOfCode\Solvers\Year2015\Day5;

/**
 * @group 2015-5
 */
final class Day5Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        return [
            [
                'ugknbfddgicrmopn',
                new ResultCollection(1, null),
            ],
            [
                'aaa',
                new ResultCollection(1, null),
            ],
            [
                'jchzalrnumimnmhp',
                new ResultCollection(0, null),
            ],
            [
                'haegwjzuvuyypxyu',
                new ResultCollection(0, null),
            ],
            [
                'dvszwmarrgswjxmb',
                new ResultCollection(0, null),
            ],
            [
                'qjhvhtzxzqqjkmpb',
                new ResultCollection(null, 1),
            ],
            [
                'xxyxx',
                new ResultCollection(null, 1),
            ],
            [
                'uurcxstgmygtbstg',
                new ResultCollection(null, 0),
            ],
            [
                'ieodomkazucvgmuy',
                new ResultCollection(null, 0),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day5();
    }
}
