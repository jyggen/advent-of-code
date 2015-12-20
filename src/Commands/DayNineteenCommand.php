<?php
namespace Boo\AdventOfCode\Commands;

class DayNineteenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input' => [
                'H => HO',
                'H => OH',
                'O => HH',
                '',
                'HOH',
            ],
            'output' => 4,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected $lowest = PHP_INT_MAX;

    protected $deadends = [];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Medicine for Rudolph');
    }

    protected function normalizeData(array $input)
    {
        $replacements = [];
        $string       = array_pop($input);

        array_pop($input);

        foreach ($input as $row) {
            $replacement                   = explode(' => ', $row);
            $replacements[$replacement[1]] = $replacement[0];
        }

        return [$string, $replacements];
    }

    protected function getDayNumber()
    {
        return 19;
    }

    protected function performTest(array &$input)
    {
        $string       = $input[0];
        $replacements = $input[1];
        $molecules    = [];

        foreach ($replacements as $to => $from) {
            $position = 0;
            while (($position = strpos($string, $from, $position)) !== false) {
                $length    = strlen($from);
                $prepend   = substr($string, 0, $position);
                $append    = substr($string, $position + $length);
                $newString = $prepend.$to.$append;
                $position  = $position + $length;

                $molecules[md5($newString)] = null;
            }
        }

        return [count($molecules), null];
    }

    protected function perform(array &$input)
    {
        $string       = $input[0];
        $replacements = $input[1];
        $molecules    = [];

        foreach ($replacements as $to => $from) {
            $position = 0;
            while (($position = strpos($string, $from, $position)) !== false) {
                $length    = strlen($from);
                $prepend   = substr($string, 0, $position);
                $append    = substr($string, $position + $length);
                $newString = $prepend.$to.$append;
                $position  = $position + $length;

                $molecules[md5($newString)] = null;
            }
        }

        $totalCount = 0;

        while ($string !== 'e') {
            $regex  = '/('.implode('|', array_keys($replacements)).')/';
            $string = preg_replace_callback($regex, function($match) use ($replacements) {
                return $replacements[$match[1]];
            }, $string, -1, $count);

            $totalCount += $count;
        }

        return [count($molecules), $totalCount];
    }
}
