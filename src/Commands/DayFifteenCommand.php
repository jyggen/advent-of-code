<?php
namespace Boo\AdventOfCode\Commands;

class DayFifteenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input' => [
                'Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8',
                'Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3',
            ],
            'output' => 62842880,
        ],
    ];

    protected $testDataTwo = [
        [
            'input' => [
                'Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8',
                'Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3',
            ],
            'output' => 57600000,
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Science for Hungry People');
    }

    protected function normalizeData(array $input)
    {
        $output = [];
        $regex  = '/^([\w]+): ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+), ([a-z]+) ([\d-]+)$/';

        foreach ($input as $ingredient) {
            if (preg_match($regex, $ingredient, $match) !== 1) {
                throw new \RuntimeException('Unable to parse input');
            }

            $output[] = [
                'stats' => [
                    $match[2]  => (int) $match[3],
                    $match[4]  => (int) $match[5],
                    $match[6]  => (int) $match[7],
                    $match[8]  => (int) $match[9],
                ],
                $match[10] => (int) $match[11],
            ];
        }

        return $output;
    }

    protected function getDayNumber()
    {
        return 15;
    }

    protected function perform(array &$input)
    {
        $possibilities = $this->generate(count($input), 0, 100);
        $bestResult    = 0;
        $bestMeal      = 0;

        foreach ($possibilities as $numbers) {
            $stats    = [];
            $calories = 0;

            foreach (array_keys($input[0]['stats']) as $stat) {
                $current = 0;
                foreach ($numbers as $key => $number) {
                    $current += $input[$key]['stats'][$stat] * $number;
                }

                $stats[] = max(0, $current);
            }

            foreach ($numbers as $key => $number) {
                $calories += $input[$key]['calories'] * $number;
            }

            $sum = array_reduce($stats, function ($carry, $item) {
                return $carry * $item;
            }, 1);

            $bestResult = max($bestResult, $sum);

            if ($calories === 500) {
                $bestMeal = max($bestMeal, $sum);
            }
        }

        return [$bestResult, $bestMeal];
    }

    protected function generate($i, $sum, $goal, array $result = [])
    {
        if ($i === 1) {
            $result[0] = $goal - $sum;
            return $result;
        }

        $returnArray = [];

        for ($j = 0; $j < $goal - $sum; $j++) {
            $result[$i - 1] = $j;
            $return         = $this->generate($i - 1, $sum + $j, $goal, $result);

            if ($i === 2) {
                $returnArray[] = $return;
                continue;
            }

            $returnArray = array_merge($returnArray, $return);
        }

        return $returnArray;
    }
}
