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
use Boo\AdventOfCode\Solvers\Year2015\Day19;

/**
 * @group 2015-19
 */
final class Day19Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        $input = <<<'INPUT'
H => HO
H => OH
O => HH

HOH
INPUT;

        return [
            [
                $input,
                new ResultCollection(null, null),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day19();
    }
}
