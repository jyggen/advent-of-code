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

namespace Boo\AdventOfCode\Tests;

use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\SolverInterface;
use PHPUnit\Framework\TestCase;

abstract class DayTestAbstract extends TestCase
{
    abstract public function exampleAnswersProvider(): array;

    /**
     * @dataProvider exampleAnswersProvider
     *
     * @param string           $input
     * @param ResultCollection $answers
     */
    public function testThatExampleAnswersAreCorrect(string $input, ResultCollection $answers)
    {
        $result = $this->getDayClass()($input);

        $this->assertInstanceOf(ResultCollection::class, $result);

        if ($answers->getFirstTestAnswer() !== null) {
            $this->assertSame($answers->getFirstTestAnswer(), $result->getFirstTestAnswer(), 'Invalid first answer.');
        }

        if ($answers->getSecondTestAnswer() !== null) {
            $this->assertSame($answers->getSecondTestAnswer(), $result->getSecondTestAnswer(), 'Invalid second answer.');
        }
    }

    abstract protected function getDayClass(): SolverInterface;
}
