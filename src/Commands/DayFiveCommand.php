<?php
namespace Boo\AdventOfCode\Commands;

class DayFiveCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => ['ugknbfddgicrmopn'],
            'output' => 1,
        ], [
            'input'  => ['aaa'],
            'output' => 1,
        ], [
            'input'  => ['jchzalrnumimnmhp'],
            'output' => 0,
        ], [
            'input'  => ['haegwjzuvuyypxyu'],
            'output' => 0,
        ], [
            'input'  => ['dvszwmarrgswjxmb'],
            'output' => 0,
        ],
    ];

    protected $testDataTwo = [
        [
            'input'  => ['qjhvhtzxzqqjkmpb'],
            'output' => 1,
        ], [
            'input'  => ['xxyxx'],
            'output' => 1,
        ], [
            'input'  => ['uurcxstgmygtbstg'],
            'output' => 0,
        ], [
            'input'  => ['ieodomkazucvgmuy'],
            'output' => 0,
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Doesn\'t He Have Intern-Elves For This?');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 5;
    }

    protected function perform(array &$input)
    {
        $numberOfNice      = 0;
        $numberOfExtraNice = 0;

        foreach ($input as $string) {
            if ($this->isNice($string) === true) {
                $numberOfNice++;
            }

            if ($this->isExtraNice($string) === true) {
                $numberOfExtraNice++;
            }
        }

        return [$numberOfNice, $numberOfExtraNice];
    }

    protected function isNice($string)
    {
        foreach (['ab', 'cd', 'pq', 'xy'] as $substring) {
            if (strpos($string, $substring) !== false) {
                return false;
            }
        }

        $vowels = 0;

        foreach (['a', 'e', 'i', 'o', 'u'] as $vowel) {
            $vowels += substr_count($string, $vowel);
        }

        if ($vowels < 3) {
            return false;
        }

        if (preg_match('/(.)\\1{1}/', $string) === 0) {
            return false;
        }

        return true;
    }

    protected function isExtraNice($string)
    {
        $letters   = str_split($string);
        $hasPair   = false;
        $hasRepeat = false;
        $lastKey   = count($letters) - 1;

        foreach ($letters as $key => $letter) {
            if ($key + 1 <= $lastKey && substr_count($string, $letter.$letters[$key + 1]) > 1) {
                $hasPair = true;
            }

            if ($key + 2 <= $lastKey && $letters[$key + 2] === $letter) {
                $hasRepeat = true;
            }

            if ($hasPair === true && $hasRepeat === true) {
                return true;
            }
        }

        return false;
    }
}
