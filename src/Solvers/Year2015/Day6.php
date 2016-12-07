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

use Boo\AdventOfCode\Exceptions\SolverException;
use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\SolverInterface;

/**
 * Day 6: Probably a Fire Hazard
 *
 * @see http://adventofcode.com/2015/day/6
 */
final class Day6 implements SolverInterface
{
    const INSTRUCTION_REGEX = '/(^turn off|turn on|toggle) ([\d]{1,3}),([\d]{1,3}) through ([\d]{1,3}),([\d]{1,3})$/';

    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);

        return new ResultCollection($this->handleLights($input), $this->handleLightsBetter($input));
    }

    private function handleLights(array $input): int
    {
        $lightArray = array_pad([], 1000, array_pad([], 1000, false));

        foreach ($input as $instruction) {
            if (preg_match(self::INSTRUCTION_REGEX, $instruction, $lights) !== 1) {
                throw new SolverException('Unable to parse instructions');
            }

            $valueToSet = null;

            switch ($lights[1]) {
                case 'turn off':
                    $valueToSet = 0;
                    break;
                case 'turn on':
                    $valueToSet = 1;
                    break;
            }

            for ($i = $lights[2]; $i <= $lights[4]; $i++) {
                for ($j = $lights[3]; $j <= $lights[5]; $j++) {
                    $lightArray[$i][$j] = ($valueToSet === null) ? !$lightArray[$i][$j] :$valueToSet;
                }
            }
        }

        $numberOfLights = 0;

        foreach ($lightArray as $lights) {
            foreach ($lights as $value) {
                $numberOfLights += $value;
            }
        }

        return $numberOfLights;
    }

    private function handleLightsBetter(array $input): int
    {
        $lightArray = array_pad([], 1000, array_pad([], 1000, 0));

        foreach ($input as $instruction) {
            if (preg_match(self::INSTRUCTION_REGEX, $instruction, $lights) !== 1) {
                throw new SolverException('Unable to parse instructions');
            }

            $valueToSet = null;

            switch ($lights[1]) {
                case 'turn off':
                    $valueToSet = -1;
                    break;
                case 'turn on':
                    $valueToSet = 1;
                    break;
                case 'toggle':
                    $valueToSet = 2;
                    break;
            }

            for ($i = $lights[2]; $i <= $lights[4]; $i++) {
                for ($j = $lights[3]; $j <= $lights[5]; $j++) {
                    $lightArray[$i][$j] = max(0, $lightArray[$i][$j] + $valueToSet);
                }
            }
        }

        $brightness = 0;

        foreach ($lightArray as $lights) {
            foreach ($lights as $value) {
                $brightness += $value;
            }
        }

        return $brightness;
    }
}
