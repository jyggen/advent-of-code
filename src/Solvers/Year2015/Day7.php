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
 * Day 7: Some Assembly Required
 *
 * @see http://adventofcode.com/2015/day/7
 */
final class Day7 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $wires  = $this->performInstructions($input);
        $wires2 = $this->performInstructions($input, ['b' => $wires['a']]);

        return new ResultCollection($wires['a'], $wires2['a']);
    }

    private function performInstructions(array $instructions, array $override = []): array
    {
        $wires = $override;

        while (empty($instructions) === false) {
            foreach ($instructions as $key => $operation) {
                if (preg_match('/^(\d{1,5}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    $this->setWire($wires, $match[2], (int) $match[1], $override);
                } elseif (preg_match('/^([a-z]{1,2}) AND ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false || isset($wires[$match[2]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] & $wires[$match[2]], $override);
                } elseif (preg_match('/^([a-z]{1,2}) OR ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false || isset($wires[$match[2]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] | $wires[$match[2]], $override);
                } elseif (preg_match('/^([a-z]{1,2}) LSHIFT (\d{1,5}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] << $match[2], $override);
                } elseif (preg_match('/^([a-z]{1,2}) RSHIFT (\d{1,5}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $wires[$match[1]] >> $match[2], $override);
                } elseif (preg_match('/^NOT ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[2], 65536 + ~$wires[$match[1]], $override);
                } elseif (preg_match('/^(\d{1,5}) AND ([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[2]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[3], $match[1] & $wires[$match[2]], $override);
                } elseif (preg_match('/^([a-z]{1,2}) -> ([a-z]{1,2})$/', $operation, $match) === 1) {
                    if (isset($wires[$match[1]]) === false) {
                        continue;
                    }

                    $this->setWire($wires, $match[2], $wires[$match[1]], $override);
                }

                unset($instructions[$key]);
            }
        }

        return $wires;
    }

    private function setWire(array &$wires, string $wire, int $value, array $override)
    {
        $wires[$wire] = (isset($override[$wire]) === true) ? $override[$wire] : $value;
    }
}
