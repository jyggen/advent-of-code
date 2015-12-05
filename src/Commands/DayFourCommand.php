<?php
namespace Boo\AdventOfCode\Commands;

class DayFourCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        'abcdef'  => 609043,
        'pqrstuv' => 1048970,
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('The Ideal Stocking Stuffer');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 4;
    }

    protected function perform(array &$input)
    {
        return [$this->findHash($input[0], 5), $this->findHash($input[0], 6)];
    }

    protected function findHash($key, $zeros)
    {
        $hash    = '';
        $number  = 0;
        $zeroStr = str_repeat('0', $zeros);

        while (substr($hash, 0, $zeros) !== $zeroStr) {
            $number++;

            $hash = md5($key.$number);
        }

        return $number;
    }
}
