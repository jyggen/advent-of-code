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
 * Day 18: Like a GIF For Your Yard
 *
 * @see http://adventofcode.com/2015/day/18
 */
final class Day18 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $lights = [];

        foreach ($input as $row) {
            $lights[] = array_map(function ($light) {
                return (bool) str_replace(['#', '.'], ['1', '0'], $light);
            }, str_split($row));
        }

        return new ResultCollection(
            $this->calculateState($lights, 100),
            $this->calculateState($lights, 100, ['0x0', '0x99', '99x0', '99x99']),
            $this->calculateState($lights, 4),
            $this->calculateState($lights, 4, ['0x0', '0x5', '5x0', '5x5'])
        );
    }

    private function calculateState(array $state, int $times, array $stuck = []): int
    {
        foreach ($state as $row => $lights) {
            foreach ($lights as $column => $light) {
                foreach ($stuck as $position) {
                    if ($row.'x'.$column === $position) {
                        $state[$row][$column] = true;
                    }
                }
            }
        }

        $lightsArray   = $this->handleLights($state, $times, $stuck);
        $lightsEnabled = 0;

        foreach ($lightsArray as $row) {
            foreach ($row as $light) {
                if ($light === true) {
                    $lightsEnabled++;
                }
            }
        }

        return $lightsEnabled;
    }

    private function handleLights(array $state, int $timesLeft, array $stuck = []): array
    {
        $newState = $state;
        $length   = count($state) - 1;

        foreach ($newState as $row => $lights) {
            foreach ($lights as $column => $light) {
                $neighbors = 0;

                foreach ($stuck as $position) {
                    if ($row.'x'.$column === $position) {
                        $newState[$row][$column] = true;
                        continue 2;
                    }
                }

                // Top
                if ($row > 0 && $state[$row - 1][$column] === true) {
                    $neighbors++;
                }

                // Top Right
                if ($row > 0 &&$column < $length && $state[$row - 1][$column + 1] === true) {
                    $neighbors++;
                }

                // Right
                if ($column < $length && $state[$row][$column + 1] === true) {
                    $neighbors++;
                }

                // Bottom Right
                if ($column < $length && $row < $length && $state[$row + 1][$column + 1] === true) {
                    $neighbors++;
                }

                // Bottom
                if ($row < $length && $state[$row + 1][$column] === true) {
                    $neighbors++;
                }

                // Bottom Left
                if ($row < $length && $column > 0 && $state[$row + 1][$column - 1] === true) {
                    $neighbors++;
                }

                // Left
                if ($column > 0 && $state[$row][$column - 1] === true) {
                    $neighbors++;
                }

                // Top Left
                if ($column > 0 && $row > 0 && $state[$row - 1][$column - 1] === true) {
                    $neighbors++;
                }

                if ($light === true && ($neighbors === 2 || $neighbors === 3)) {
                    continue;
                } elseif ($light === false && $neighbors === 3) {
                    $newState[$row][$column] = true;
                    continue;
                }

                $newState[$row][$column] = false;
            }
        }

        $timesLeft--;

        if ($timesLeft === 0) {
            return $newState;
        }

        return $this->handleLights($newState, $timesLeft, $stuck);
    }
}
