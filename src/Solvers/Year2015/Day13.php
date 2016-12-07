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

use Boo\AdventOfCode\Exceptions\SolverException;
use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\SolverInterface;

/**
 * Day 13: Knights of the Dinner Table
 *
 * @see http://adventofcode.com/2015/day/13
 */
final class Day13 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $regex = '/^([\w]+) would (gain|lose) ([\d]+) happiness units by sitting next to ([\w]+).$/';
        $stats = [];
        $people = [];

        foreach ($input as $instruction) {
            if (preg_match($regex, $instruction, $match) !== 1) {
                throw new SolverException('Unable to parse instruction');
            }

            $people[] = $match[1];
            $stats[$match[1]][$match[4]] = ($match[2] === 'gain') ? (int) $match[3] : 0 - $match[3];
        }

        $people = array_unique($people);

        foreach ($people as $person) {
            $stats['Me'][$person] = 0;
            $stats[$person]['Me'] = 0;
        }

        return new ResultCollection(
            $this->findOptimalSeating($people, $stats),
            $this->findOptimalSeating(array_merge($people, [
                'Me',
            ]), $stats)
        );
    }

    private function findOptimalSeating(array $people, array $stats): int
    {
        $numOfPeople  = count($people);
        $permutations = permutate($people);
        $highest      = 0;

        foreach ($permutations as $people) {
            $happiness   = 0;

            foreach ($people as $key => $person) {
                if ($key + 1 === $numOfPeople) {
                    $happiness += $stats[$person][$people[0]];
                    $happiness += $stats[$people[0]][$person];
                    continue;
                }

                $happiness += $stats[$person][$people[$key + 1]];
                $happiness += $stats[$people[$key + 1]][$person];
            }

            if ($happiness > $highest) {
                $highest = $happiness;
            }
        }

        return $highest;
    }
}
