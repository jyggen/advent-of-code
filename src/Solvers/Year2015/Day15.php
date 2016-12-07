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
 * Day 15: Science for Hungry People
 *
 * @see http://adventofcode.com/2015/day/15
 */
final class Day15 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $ingredients = [];
        $regex  = '/^([\w]+): ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+)$/';

        foreach ($input as $ingredient) {
            if (preg_match($regex, $ingredient, $match) !== 1) {
                throw new \RuntimeException('Unable to parse input');
            }

            $ingredients[] = [
                'stats' => [
                    $match[2]  => (int) $match[3],
                    $match[4]  => (int) $match[5],
                    $match[6]  => (int) $match[7],
                    $match[8]  => (int) $match[9],
                ],
                $match[10] => (int) $match[11],
            ];
        }

        $possibilities = $this->generate(count($ingredients), 0, 100);
        $bestResult    = 0;
        $bestMeal      = 0;

        foreach ($possibilities as $numbers) {
            $stats    = [];
            $calories = 0;

            foreach (array_keys($ingredients[0]['stats']) as $stat) {
                $current = 0;
                foreach ($numbers as $key => $number) {
                    $current += $ingredients[$key]['stats'][$stat] * $number;
                }

                $stats[] = max(0, $current);
            }

            foreach ($numbers as $key => $number) {
                $calories += $ingredients[$key]['calories'] * $number;
            }

            $sum = array_reduce($stats, function ($carry, $item) {
                return $carry * $item;
            }, 1);

            $bestResult = max($bestResult, $sum);

            if ($calories === 500) {
                $bestMeal = max($bestMeal, $sum);
            }
        }

        return new ResultCollection($bestResult, $bestMeal);
    }

    private function generate($i, $sum, $goal, array $result = [])
    {
        if ($i === 1) {
            $result[0] = $goal - $sum;
            return $result;
        }

        $returnArray = [];

        for ($j = 0; $j < $goal - $sum; $j++) {
            $result[$i - 1] = $j;
            $return         = $this->generate($i - 1, $sum + $j, $goal, $result);

            if ($i === 2) {
                $returnArray[] = $return;
                continue;
            }

            $returnArray = array_merge($returnArray, $return);
        }

        return $returnArray;
    }
}
