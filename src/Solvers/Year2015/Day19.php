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
 * Day 19: Medicine for Rudolph
 *
 * @see http://adventofcode.com/2015/day/19
 */
final class Day19 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $replacements = [];
        $string = array_pop($input);

        array_pop($input);

        foreach ($input as $row) {
            $replacement = explode(' => ', $row);
            $replacements[$replacement[1]] = $replacement[0];
        }

        foreach ($replacements as $to => $from) {
            $position = 0;
            while (($position = strpos($string, $from, $position)) !== false) {
                $length    = strlen($from);
                $prepend   = substr($string, 0, $position);
                $append    = substr($string, $position + $length);
                $newString = $prepend.$to.$append;
                $position  = $position + $length;

                $molecules[md5($newString)] = null;
            }
        }

        $totalCount = 0;

        while ($string !== 'e') {
            $regex  = '/('.implode('|', array_keys($replacements)).')/';
            $string2 = preg_replace_callback($regex, function ($match) use ($replacements) {
                return $replacements[$match[1]];
            }, $string, -1, $count);

            if ($string === $string2) {
                break;
            }

            $string = $string2;
            $totalCount += $count;
        }

        return new ResultCollection(count($molecules), $totalCount);
    }
}
