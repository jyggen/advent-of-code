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
 * Day 5: Doesn't He Have Intern-Elves For This?
 *
 * @see http://adventofcode.com/2015/day/5
 */
final class Day5 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $numberOfNice = 0;
        $numberOfExtraNice = 0;

        foreach (explode("\n", $input) as $string) {
            if ($this->isNice($string) === true) {
                $numberOfNice++;
            }

            if ($this->isExtraNice($string) === true) {
                $numberOfExtraNice++;
            }
        }

        return new ResultCollection($numberOfNice, $numberOfExtraNice);
    }

    private function isNice(string $string): bool
    {
        foreach (['ab', 'cd', 'pq', 'xy'] as $substring) {
            if (strpos($string, $substring) !== false) {
                return false;
            }
        }

        $vowels = 0;

        foreach (['a', 'e', 'i', 'o', 'u'] as $vowel) {
            $vowels += substr_count($string, $vowel);
        }

        if ($vowels < 3) {
            return false;
        }

        if (preg_match('/(.)\\1{1}/', $string) === 0) {
            return false;
        }

        return true;
    }

    private function isExtraNice(string $string): bool
    {
        $letters = str_split($string);
        $hasPair = false;
        $hasRepeat = false;
        $lastKey = count($letters) - 1;

        foreach ($letters as $key => $letter) {
            if ($key + 1 <= $lastKey && substr_count($string, $letter.$letters[$key + 1]) > 1) {
                $hasPair = true;
            }

            if ($key + 2 <= $lastKey && $letters[$key + 2] === $letter) {
                $hasRepeat = true;
            }

            if ($hasPair === true && $hasRepeat === true) {
                return true;
            }
        }

        return false;
    }
}
