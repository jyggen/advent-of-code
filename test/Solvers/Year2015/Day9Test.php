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
use Boo\AdventOfCode\Solvers\Year2015\Day9;

/**
 * @group 2015-9
 */
final class Day9Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        $input = <<<'INPUT'
London to Dublin = 464
London to Belfast = 518
Dublin to Belfast = 141
INPUT;

        return [
            [
                $input,
                new ResultCollection(605, 982),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day9();
    }
}
