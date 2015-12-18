<?php
namespace Boo\AdventOfCode\Commands;

class DayEighteenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input' => [
                '.#.#.#',
                '...##.',
                '#....#',
                '..#...',
                '#.#..#',
                '####..',
            ],
            'output' => 4,
        ],
    ];

    protected $testDataTwo = [
        [
            'input' => [
                '.#.#.#',
                '...##.',
                '#....#',
                '..#...',
                '#.#..#',
                '####..',
            ],
            'output' => 14,
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Like a GIF For Your Yard');
    }

    protected function normalizeData(array $input)
    {
        $output = [];

        foreach ($input as $row) {
            $output[] = array_map(function ($light) {
                return (bool) str_replace(['#', '.'], ['1', '0'], $light);
            }, str_split($row));
        }

        return $output;
    }

    protected function getDayNumber()
    {
        return 18;
    }

    protected function performTest(array &$input)
    {
        return [$this->performTask($input, 4), $this->performTask($input, 4, ['0x0', '0x5', '5x0', '5x5'])];
    }

    protected function perform(array &$input)
    {
        return [$this->performTask($input, 100), $this->performTask($input, 100, ['0x0', '0x99', '99x0', '99x99'])];
    }

    protected function performTask($state, $times, $stuck = [])
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

    protected function handleLights($state, $timesLeft, $stuck = [])
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

    protected function printState($state)
    {
        echo PHP_EOL;
        foreach ($state as $lights) {
            foreach ($lights as $light) {
                if ($light === true) {
                    echo '#';
                    continue;
                }
                echo '.';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
