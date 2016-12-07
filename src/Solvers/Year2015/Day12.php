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
 * Day 12: JSAbacusFramework.io
 *
 * @see http://adventofcode.com/2015/day/12
 */
final class Day12 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        return new ResultCollection(
            $this->sumArray(json_decode($input, true)),
            $this->sumArray(json_decode($input, true), 'red')
        );
    }

    private function sumArray(array $input, string $ignore = null): int
    {
        $input  = $this->flatten($input, $ignore);
        $number = 0;

        foreach ($input as $value) {
            $number += $value;
        }

        return $number;
    }

    private function flatten(array $input, string $ignore = null): array
    {
        $values = [];

        foreach ($input as $key => $value) {
            if (is_array($value) === true) {
                $values = array_merge($values, $this->flatten($value, $ignore));
                continue;
            }

            if (gettype($key) !== 'integer' && $value === $ignore) {
                return [];
            }

            $values[] = $value;
        }

        return $values;
    }
}
