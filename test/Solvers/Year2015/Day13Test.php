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
use Boo\AdventOfCode\Solvers\Year2015\Day13;

/**
 * @group 2015-13
 */
final class Day13Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        $input = <<<'INPUT'
Alice would gain 54 happiness units by sitting next to Bob.
Alice would lose 79 happiness units by sitting next to Carol.
Alice would lose 2 happiness units by sitting next to David.
Bob would gain 83 happiness units by sitting next to Alice.
Bob would lose 7 happiness units by sitting next to Carol.
Bob would lose 63 happiness units by sitting next to David.
Carol would lose 62 happiness units by sitting next to Alice.
Carol would gain 60 happiness units by sitting next to Bob.
Carol would gain 55 happiness units by sitting next to David.
David would gain 46 happiness units by sitting next to Alice.
David would lose 7 happiness units by sitting next to Bob.
David would gain 41 happiness units by sitting next to Carol.
INPUT;

        return [
            [
                $input,
                new ResultCollection(330, null),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day13();
    }
}
