<?php
namespace Boo\AdventOfCode\Commands;

class DayTwentyThreeCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => [
                'inc a',
                'jio a, +2',
                'tpl a',
                'inc a',
            ],
            'output' => 2,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Opening the Turing Lock');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 23;
    }

    protected function performTest(array &$input)
    {
        return [$this->performTask($input)['a'], null];
    }

    protected function perform(array &$input)
    {
        return [$this->performTask($input)['b'], $this->performTask($input, ['a' => 1])['b']];
    }

    protected function performTask(array &$input, $registers = [])
    {
        $numOfInput = count($input);

        for ($i = 0; $i < $numOfInput; $i++) {
            if (preg_match('/^inc ([a-z])$/', $input[$i], $match) === 1) {
                if (isset($registers[$match[1]]) === false) {
                    $registers[$match[1]] = 0;
                }

                $registers[$match[1]]++;
                continue;
            } elseif (preg_match('/^jio ([a-z]), ([+-])([\d]+)$/', $input[$i], $match) === 1) {
                if (isset($registers[$match[1]]) === false) {
                    $registers[$match[1]] = 0;
                }

                if ($registers[$match[1]] === 1) {
                    if ($match[2] === '-') {
                        $i = $i - $match[3] + 1;
                    } elseif ($match[2] === '+') {
                        $i = $i + $match[3] - 1;
                    }
                }
                continue;
            } elseif (preg_match('/^tpl ([a-z])$/', $input[$i], $match) === 1) {
                if (isset($registers[$match[1]]) === false) {
                    $registers[$match[1]] = 0;
                }

                $registers[$match[1]] = $registers[$match[1]] * 3;
                continue;
            } elseif (preg_match('/^jmp ([+-])([\d]+)$/', $input[$i], $match) === 1) {
                if ($match[1] === '-') {
                    $i = $i - ($match[2] + 1);
                } elseif ($match[1] === '+') {
                    $i = $i + ($match[2] - 1);
                }
                continue;
            } elseif (preg_match('/^jie ([a-z]), ([+-])([\d]+)$/', $input[$i], $match) === 1) {
                if (isset($registers[$match[1]]) === false) {
                    $registers[$match[1]] = 0;
                }

                if ($registers[$match[1]] % 2 === 0) {
                    if ($match[2] === '-') {
                        $i = $i - ($match[3] + 1);
                    } elseif ($match[2] === '+') {
                        $i = $i + ($match[3] - 1);
                    }
                }
                continue;
            } elseif (preg_match('/^hlf ([a-z])$/', $input[$i], $match) === 1) {
                if (isset($registers[$match[1]]) === false) {
                    $registers[$match[1]] = 0;
                }

                $registers[$match[1]] = $registers[$match[1]] / 2;
                continue;
            }
        }

        return $registers;
    }
}
