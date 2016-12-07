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

namespace Boo\AdventOfCode\Solvers\Year2015;

use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\SolverInterface;

/**
 * Day 17: No Such Thing as Too Much
 *
 * @see http://adventofcode.com/2015/day/17
 */
final class Day17 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);

        $test = $this->findCombinations($input, 25);
        $real = $this->findCombinations($input, 150);

        return new ResultCollection($real[0], $real[1], $test[0], $test[1]);
    }

    private function findCombinations(array $input, int $number): array
    {
        $found = [];

        foreach (array_keys($input) as $container) {
            $found = array_merge($found, $this->bruteforce([$container], $input, $number));
        }

        $lowest       = PHP_INT_MAX;
        $lowestCount  = 0;

        foreach ($found as $combination) {
            $count = count($combination);

            if ($count < $lowest) {
                $lowest      = $count;
                $lowestCount = 1;
            } elseif ($count === $lowest) {
                $lowestCount++;
            }
        }

        return [count($found), $lowestCount];
    }

    private function bruteforce(array $containerStack, array $all, int $refrigeratorSize): array
    {
        $sum = 0;
        foreach ($containerStack as $container) {
            $sum += $all[$container];
        }

        $potentialContainers = [];
        $stackSize           = count($containerStack);

        foreach ($all as $container => $size) {
            if ($container <= $containerStack[$stackSize - 1]) {
                continue;
            }

            if (in_array($container, $containerStack) === true) {
                continue;
            }

            $newSum = $sum + $size;

            if ($newSum > $refrigeratorSize) {
                continue;
            } elseif ($newSum === $refrigeratorSize) {
                $potentialContainers[] = array_merge($containerStack, [$container]);
            } elseif ($newSum < $refrigeratorSize) {
                $newStack = array_merge($containerStack, [$container]);
                $potentialContainers = array_merge($potentialContainers, $this->bruteforce($newStack, $all, $refrigeratorSize));
            }
        }

        return $potentialContainers;
    }
}
