<?php
namespace Boo\AdventOfCode\Commands;

class DaySeventeenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => [20, 15, 10, 5, 5],
            'output' => 4,
        ],
    ];

    protected $testDataTwo = [
        [
            'input'  => [20, 15, 10, 5, 5],
            'output' => 3,
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('No Such Thing as Too Much');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 17;
    }

    protected function performTest(array &$input)
    {
        $combinations = $this->findCombinations($input, 25);
        $lowest       = PHP_INT_MAX;
        $lowestCount  = 0;

        foreach ($combinations as $combination) {
            $count = count($combination);

            if ($count < $lowest) {
                $lowest      = $count;
                $lowestCount = 1;
            } elseif ($count === $lowest) {
                $lowestCount++;
            }
        }

        return [count($combinations), $lowestCount];
    }

    protected function perform(array &$input)
    {
        $combinations = $this->findCombinations($input, 150);
        $lowest       = PHP_INT_MAX;
        $lowestCount  = 0;

        foreach ($combinations as $combination) {
            $count = count($combination);

            if ($count < $lowest) {
                $lowest      = $count;
                $lowestCount = 1;
            } elseif ($count === $lowest) {
                $lowestCount++;
            }
        }

        return [count($combinations), $lowestCount];
    }

    protected function findCombinations($input, $number)
    {
        $found = [];

        foreach ($input as $container => $size) {
            $found = array_merge($found, $this->bruteforce([$container], $input, $number));
        }

        return $found;
    }

    protected function bruteforce(array $containerStack, array $all, $refrigeratorSize)
    {
        $sum = 0;
        foreach ($containerStack as $container) {
            $sum += $all[$container];
        }

        $potentialContainers = [];
        $stackSize           = count($containerStack);

        foreach ($all as $container => $size) {
            if ($container <= $containerStack[$stackSize - 1]) {
                continue;
            }

            if (in_array($container, $containerStack) === true) {
                continue;
            }

            $newSum = $sum + $size;

            if ($newSum > $refrigeratorSize) {
                continue;
            } elseif ($newSum === $refrigeratorSize) {
                $potentialContainers[] = array_merge($containerStack, [$container]);
            } elseif ($newSum < $refrigeratorSize) {
                $newStack = array_merge($containerStack, [$container]);
                $potentialContainers = array_merge($potentialContainers, $this->bruteforce($newStack, $all, $refrigeratorSize));
            }
        }

        return $potentialContainers;
    }
}
