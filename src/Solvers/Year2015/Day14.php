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
 * Day 14: Reindeer Olympics
 *
 * @see http://adventofcode.com/2015/day/14
 */
final class Day14 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $reindeers = [];
        $regex = '/^([\w]+) can fly ([\d]+) km\/s for ([\d]+) seconds, but then must rest for ([\d]+) seconds.$/';

        foreach ($input as $reindeer) {
            if (preg_match($regex, $reindeer, $match) !== 1) {
                throw new \RuntimeException('Unable to parse input');
            }

            $reindeers[] = [
                'name'    => $match[1],
                'speed'   => (int) $match[2],
                'stamina' => (int) $match[3],
                'rest'    => (int) $match[4],
            ];
        }

        $reindeerTracker = [];

        for ($i = 1; $i <= 2503; $i++) {
            foreach ($reindeers as $reindeer) {
                if ($i === 1) {
                    $reindeerTracker[$reindeer['name']] = [
                        'mode'     => 'fly',
                        'distance' => 0,
                        'counter'  => $reindeer['stamina'],
                        'points'   => 0,
                    ];
                }

                if ($reindeerTracker[$reindeer['name']]['mode'] === 'fly') {
                    $reindeerTracker[$reindeer['name']]['distance'] += $reindeer['speed'];
                }

                $reindeerTracker[$reindeer['name']]['counter']--;

                if ($reindeerTracker[$reindeer['name']]['counter'] === 0) {
                    if ($reindeerTracker[$reindeer['name']]['mode'] === 'fly') {
                        $reindeerTracker[$reindeer['name']]['mode']    = 'rest';
                        $reindeerTracker[$reindeer['name']]['counter'] = $reindeer['rest'];
                    } else {
                        $reindeerTracker[$reindeer['name']]['mode']    = 'fly';
                        $reindeerTracker[$reindeer['name']]['counter'] = $reindeer['stamina'];
                    }
                }
            }

            $longest = null;

            foreach ($reindeerTracker as $reindeer) {
                $longest = max($longest, $reindeer['distance']);
            }

            foreach ($reindeerTracker as $key => $reindeer) {
                if ($reindeer['distance'] === $longest) {
                    $reindeerTracker[$key]['points']++;
                }
            }

            if ($i === 1000) {
                $testResult = $this->calculateResults($reindeerTracker);
            }
        }

        $endResult = $this->calculateResults($reindeerTracker);

        return new ResultCollection($endResult[0], $endResult[1], $testResult[0], $testResult[1]);
    }

    private function calculateResults(array $reindeerTracker): array
    {
        $longestDistance = 0;

        foreach ($reindeerTracker as $reindeer) {
            $longestDistance = max($longestDistance, $reindeer['distance']);
        }

        $highestPoints = 0;

        foreach ($reindeerTracker as $reindeer) {
            $highestPoints = max($highestPoints, $reindeer['points']);
        }

        return [$longestDistance, $highestPoints];
    }
}
