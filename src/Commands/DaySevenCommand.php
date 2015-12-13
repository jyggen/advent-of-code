<?php
namespace Boo\AdventOfCode\Commands;

class DaySevenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input' => [
                '123 -> x',
                '456 -> y',
                'x AND y -> d',
                'x OR y -> e',
                'x LSHIFT 2 -> f',
                'y RSHIFT 2 -> g',
                'NOT x -> h',
                'NOT y -> a',
            ],
            'output' => 65079,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Some Assembly Required');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 7;
    }

    protected function perform(array &$input)
    {
        $wires  = $this->performInstructions($input);
        $wires2 = $this->performInstructions($input, ['b' => $wires['a']]);


        return [$wires['a'], $wires2['a']];
    }

    protected function performInstructions(array $instructions, $override = [])
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

    protected function setWire(array &$wires, $wire, $value, $override)
    {
        $wires[$wire] = (isset($override[$wire]) === true) ? $override[$wire] : $value;
    }
}
