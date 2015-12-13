<?php
namespace Boo\AdventOfCode\Commands;

class DayOneCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => ['(())'],
            'output' => 0,
        ], [
            'input'  => ['()()'],
            'output' => 0,
        ], [
            'input'  => ['((('],
            'output' => 3,

        ], [
            'input'  => ['(()(()('],
            'output' => 3,
        ], [
            'input'  => ['))((((('],
            'output' => 3,
        ], [
            'input'  => ['())'],
            'output' => -1,
        ], [
            'input'  => ['))('],
            'output' => -1,
        ], [
            'input'  => [')))'],
            'output' => -3,
        ], [
            'input'  => [')())())'],
            'output' => -3,
        ],
    ];

    protected $testDataTwo = [
        [
            'input'  => [')'],
            'output' => 1,
        ], [
            'input'  => ['()())'],
            'output' => 5,
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Not Quite Lisp');
    }

    protected function normalizeData(array $input)
    {
        return str_split($input[0], 1);
    }

    protected function getDayNumber()
    {
        return 1;
    }

    protected function perform(array &$input)
    {
        // He starts on the ground floor (floor 0) ..
        $floor         = 0;
        $firstBasement = null;

        // .. and then follows the instructions one character at a time.
        foreach ($input as $key => $step) {
            // An opening parenthesis, (, means he should go up one floor,
            // and a closing parenthesis, ), means he should go down one floor.
            $floor = ($step === '(') ? $floor + 1 : $floor - 1;

            // Find the position of the first character that
            // causes him to enter the basement (floor -1).
            if ($floor === -1 && $firstBasement === null) {
                $firstBasement = $key + 1;
            }
        }

        // 0 => To what floor do the instructions take Santa?
        // 1 => What is the position of the character that causes Santa to first enter the basement?
        return [$floor, $firstBasement];
    }
}
