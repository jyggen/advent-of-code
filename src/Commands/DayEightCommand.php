<?php
namespace Boo\AdventOfCode\Commands;

class DayEightCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        '""'         => 2,
        '"abc"'      => 2,
        '"aaa\"aaa"' => 3,
        '"\x27"'     => 5,
    ];

    protected $testDataTwo = [
        '""'         => 4,
        '"abc"'      => 4,
        '"aaa\"aaa"' => 6,
        '"\x27"'     => 5,
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Matchsticks');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 8;
    }

    protected function perform(array &$input)
    {
        $literalSize = 0;
        $memorySize  = 0;
        $newSize     = 0;

        foreach ($input as $string) {
            $literalString = trim($string);
            $newString     = '"'.addslashes($literalString).'"';

            eval('$memoryString = '.$literalString.';');

            $literalSize += mb_strlen($literalString);
            $memorySize  += mb_strlen($memoryString, '8bit');
            $newSize     += mb_strlen($newString);
        }

            return [$literalSize - $memorySize, $newSize - $literalSize];
    }
}
