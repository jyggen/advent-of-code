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

namespace Boo\AdventOfCode;

interface SolverInterface
{
    /**
     * Solves the puzzle!
     *
     * @param string $input
     *
     * @return ResultCollection
     */
    public function __invoke(string $input): ResultCollection;
}
