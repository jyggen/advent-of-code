<?php
namespace Boo\AdventOfCode\Commands;

class DayEightCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => ['""'],
            'output' => 2,
        ],
        [
            'input'  => ['"abc"'],
            'output' => 2,
        ],
        [
            'input'  => ['"aaa\"aaa"'],
            'output' => 3,
        ],
        [
            'input'  => ['"\x27"'],
            'output' => 5,
        ],
    ];

    protected $testDataTwo = [
        [
            'input'  => ['""'],
            'output' => 4,
        ],
        [
            'input'  => ['"abc"'],
            'output' => 4,
        ],
        [
            'input'  => ['"aaa\"aaa"'],
            'output' => 6,
        ],
        [
            'input'  => ['"\x27"'],
            'output' => 5,
        ],
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
