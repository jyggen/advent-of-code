<?php
namespace Boo\AdventOfCode\Commands;

class DaySixteenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Aunt Sue');
    }

    protected function normalizeData(array $input)
    {
        $output = [];
        $regex  = '/^Sue (\d+): (\w+): (\d+), (\w+): (\d+), (\w+): (\d+)$/';

        foreach ($input as $sue) {
            if (preg_match($regex, $sue, $match) !== 1) {
                throw new \RuntimeException('Unable to parse input');
            }

            $output[$match[1]] = [
                $match[2]  => (int) $match[3],
                $match[4]  => (int) $match[5],
                $match[6]  => (int) $match[7],
            ];
        }

        return $output;
    }

    protected function getDayNumber()
    {
        return 16;
    }

    protected function perform(array &$input)
    {
        $match1     = null;
        $match2     = null;
        $lookingFor = [
            'children'    => 3,
            'cats'        => 7,
            'samoyeds'    => 2,
            'pomeranians' => 3,
            'akitas'      => 0,
            'vizslas'     => 0,
            'goldfish'    => 5,
            'trees'       => 3,
            'cars'        => 2,
            'perfumes'    => 1,
        ];

        foreach ($input as $number => $sue) {
            $isMatch = false;

            foreach ($lookingFor as $item => $quantity) {
                if (isset($sue[$item]) === false) {
                    continue;
                }

                if ($sue[$item] !== $quantity) {
                    continue 2;
                }

                $isMatch = true;
            }

            if ($isMatch === true) {
                $match1 = $number;
                break;
            }
        }

        foreach ($input as $number => $sue) {
            $isMatch = false;

            foreach ($lookingFor as $item => $quantity) {
                if (isset($sue[$item]) === false) {
                    continue;
                }

                if ($item === 'cats' || $item === 'trees') {
                    if ($sue[$item] <= $quantity) {
                        continue 2;
                    }
                } elseif ($item === 'pomeranians' || $item === 'goldfish') {
                    if ($sue[$item] >= $quantity) {
                        continue 2;
                    }
                } elseif ($sue[$item] !== $quantity) {
                    continue 2;
                }

                $isMatch = true;
            }

            if ($isMatch === true) {
                $match2 = $number;
                break;
            }
        }

        return [$match1, $match2];
    }

}
