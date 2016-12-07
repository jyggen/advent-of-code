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
use Boo\AdventOfCode\Solvers\Year2015\Day21;

/**
 * @group 2015-21
 */
final class Day21Test extends DayTestAbstract
{
    public function exampleAnswersProvider(): array
    {
        $input = <<<'INPUT'
Hit Points: 12
Damage: 7
Armor: 2
INPUT;

        return [
            [
                $input,
                new ResultCollection(65, null),
            ],
        ];
    }

    protected function getDayClass(): SolverInterface
    {
        return new Day21();
    }
}
