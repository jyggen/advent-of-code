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
 * Day 16: Aunt Sue
 *
 * @see http://adventofcode.com/2015/day/16
 */
final class Day16 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $sues = [];
        $regex  = '/^Sue (\d+): (\w+): (\d+), (\w+): (\d+), (\w+): (\d+)$/';

        foreach ($input as $sue) {
            if (preg_match($regex, $sue, $match) !== 1) {
                throw new \RuntimeException('Unable to parse input');
            }

            $sues[$match[1]] = [
                $match[2]  => (int) $match[3],
                $match[4]  => (int) $match[5],
                $match[6]  => (int) $match[7],
            ];
        }

        $match1     = null;
        $match2     = null;
        $lookingFor = [
            'children'    => 3,
            'cats'        => 7,
            'samoyeds'    => 2,
            'pomeranians' => 3,
            'akitas'      => 0,
            'vizslas'     => 0,
            'goldfish'    => 5,
            'trees'       => 3,
            'cars'        => 2,
            'perfumes'    => 1,
        ];

        foreach ($sues as $number => $sue) {
            $isMatch = false;

            foreach ($lookingFor as $item => $quantity) {
                if (isset($sue[$item]) === false) {
                    continue;
                }

                if ($sue[$item] !== $quantity) {
                    continue 2;
                }

                $isMatch = true;
            }

            if ($isMatch === true) {
                $match1 = $number;
                break;
            }
        }

        foreach ($sues as $number => $sue) {
            $isMatch = false;

            foreach ($lookingFor as $item => $quantity) {
                if (isset($sue[$item]) === false) {
                    continue;
                }

                if ($item === 'cats' || $item === 'trees') {
                    if ($sue[$item] <= $quantity) {
                        continue 2;
                    }
                } elseif ($item === 'pomeranians' || $item === 'goldfish') {
                    if ($sue[$item] >= $quantity) {
                        continue 2;
                    }
                } elseif ($sue[$item] !== $quantity) {
                    continue 2;
                }

                $isMatch = true;
            }

            if ($isMatch === true) {
                $match2 = $number;
                break;
            }
        }

        return new ResultCollection($match1, $match2);
    }
}
