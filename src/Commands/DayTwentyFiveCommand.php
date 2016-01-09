<?php
namespace Boo\AdventOfCode\Commands;

class DayTwentyFiveCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => ['To continue, please consult the code grid in the manual.  Enter the code at row 3, column 3.'],
            'output' => 1601130,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Let It Snow');
    }

    protected function normalizeData(array $input)
    {
        if (preg_match('/row ([\d]+), column ([\d]+)/', $input[0], $match) !== 1) {
            throw new \RuntimeException('Unable to parse input');
        }

        return [
            (int) $match[1],
            (int) $match[2],
        ];
    }

    protected function getDayNumber()
    {
        return 25;
    }

    protected function perform(array &$input)
    {
        $addition   = 1;
        $codeNumber = 1;

        for ($i = 1; $i < $input[0]; $i++) {
            $codeNumber += $addition;
            $addition++;
        }

        $addition = 1 + $input[0];

        for ($i = 1; $i < $input[1]; $i++) {
            $codeNumber += $addition;
            $addition++;
        }

        $value = 20151125;

        for ($i = 1; $i < $codeNumber; $i++) {
            $value = ($value * 252533) % 33554393;
        }

        return [$value, null];
    }
}
