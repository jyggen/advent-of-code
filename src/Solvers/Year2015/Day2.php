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
 * Day 2: I Was Told There Would Be No Math
 *
 * @see http://adventofcode.com/2015/day/2
 */
final class Day2 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $gifts = array_map(function ($gift) {
            list($length, $width, $height) = explode('x', $gift);

            return [
                (int) $length,
                (int) $width,
                (int) $height,
            ];
        }, explode("\n", trim($input)));

        $paperSize = 0;
        $ribbonLength = 0;

        // They have a list of the dimensions (length l, width w, and height h) of each present.
        foreach ($gifts as $gift) {
            sort($gift);

            $sides = [
                $gift[0] * $gift[1],
                $gift[1] * $gift[2],
                $gift[2] * $gift[0],
            ];

            // Find the surface area of the box.
            $paperSize += $sides[0] * 2 + $sides[1] * 2 + $sides[2] * 2;

            // The elves also need a little extra paper for
            // each present: the area of the smallest side.
            $paperSize += $sides[0];

            // The ribbon required to wrap a present is the shortest distance
            // around its sides, or the smallest perimeter of any one face.
            $ribbonLength += $gift[0] * 2 + $gift[1] * 2;

            // Each present also requires a bow made out of ribbon as well; the feet of ribbon
            // required for the perfect bow is equal to the cubic feet of volume of the present.
            $ribbonLength += $gift[0] * $gift[1] * $gift[2];
        }

        // $paperSize: How many total square feet of wrapping paper should they order?
        // $ribbonLength: How many total feet of ribbon should they order?
        return new ResultCollection($paperSize, $ribbonLength);
    }
}
