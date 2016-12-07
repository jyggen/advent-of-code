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
 * Day 11: Corporate Policy
 *
 * @see http://adventofcode.com/2015/day/11
 */
final class Day11 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $password = $input;

        do {
            ++$password;
        } while ($this->isValidPassword($password) === false);

        $password2 = $password;

        do {
            ++$password2;
        } while ($this->isValidPassword($password2) === false);

        return new ResultCollection($password, $password2);
    }

    private function isValidPassword(string $password): bool
    {
        if (preg_match_all('/([a-z])\1{1}/', $password) < 2) {
            return false;
        }

        if (preg_match('/[i,o,l]/', $password) !== 0) {
            return false;
        }

        $password = str_split($password);
        $length   = count($password) - 2;
        $found    = false;

        for ($i = 0; $i < $length; $i++) {
            if ($password[$i+1] === chr(ord($password[$i])+1) && $password[$i+2] === chr(ord($password[$i])+2)) {
                $found = true;
                break;
            }
        }

        if ($found === false) {
            return false;
        }

        return true;
    }
}
