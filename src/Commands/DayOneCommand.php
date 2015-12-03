<?php
namespace Boo\AdventOfCode\Commands;

class DayOneCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        '(())'    => 0,
        '()()'    => 0,
        '((('     => 3,
        '(()(()(' => 3,
        '))(((((' => 3,
        '())'     => -1,
        '))('     => -1,
        ')))'     => -3,
        ')())())' => -3,
    ];

    protected $testDataTwo = [
        ')'     => 1,
        '()())' => 5,
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
        $floor         = 0;
        $firstBasement = null;

        foreach ($input as $key => $step) {
            $floor = ($step === '(') ? $floor + 1 : $floor - 1;

            if ($floor === -1 && $firstBasement === null) {
                $firstBasement = $key + 1;
            }
        }

        return [$floor, $firstBasement];
    }
}
