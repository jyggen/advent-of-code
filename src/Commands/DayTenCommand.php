<?php
namespace Boo\AdventOfCode\Commands;

class DayTenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => ['1'],
            'output' => '11',
        ],
        [
            'input'  => ['11'],
            'output' => '21',
        ],
        [
            'input'  => ['21'],
            'output' => '1211',
        ],
        [
            'input'  => ['1211'],
            'output' => '111221',
        ],
        [
            'input'  => ['111221'],
            'output' => '312211',
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Elves Look, Elves Say');
    }

    protected function normalizeData(array $input)
    {
        return str_split($input[0]);
    }

    protected function getDayNumber()
    {
        return 10;
    }

    protected function performTest(array &$input)
    {
        return [$this->performTask($input), null];
    }

    protected function perform(array &$input)
    {
        $partOne = null;
        $partTwo = null;

        for ($i = 0; $i < 50; $i++) {
            $input = str_split($this->performTask($input));

            if ($i === 39) {
                $partOne = count($input);
            }
        }

        $partTwo = count($input);

        return [$partOne, $partTwo];
    }

    protected function performTask(array $input)
    {
        $string     = '';
        $lastDigit  = $input[0];
        $digitCount = 0;

        foreach ($input as $number) {
            if ($lastDigit !== $number) {
                $string    .= $digitCount.$lastDigit;
                $lastDigit  = $number;
                $digitCount = 0;
            }

            $digitCount++;
        }

        $string .= $digitCount.$lastDigit;

        return $string;
    }
}
